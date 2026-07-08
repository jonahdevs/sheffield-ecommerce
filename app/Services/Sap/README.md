# SAP Integration

Syncs paid orders to the SAP Business One middleware, which posts an invoice and
returns a KRA **CU (Control Unit) number** used to generate the tax receipt.

The flow is two-phase and resilient: an invoice is created immediately, then the
CU number arrives asynchronously — preferably via webhook, with a polling job as
a safety net so a lost webhook never leaves an order un-validated.

---

## Lifecycle

```
Order paid ──► markConfirmed()
                 │  (only if SAP enabled + auto-sync on)
                 ▼
        SyncOrderToSapJob            [queue: sap]
        POST /api/invoice/create
                 │  stores sap_doc_entry
                 ▼
        status = AWAITING_CU ──────────────────────────┐
                 │                                      │
      RecoverSapInvoiceJob (delayed)          SAP webhook: cu_number
      POST /api/invoice/validate/{docEntry}   POST /api/webhooks/sap
                 │                                      │
                 └──────────────► CU number ◄──────────┘
                                     │
                                     ▼
                          status = COMPLETED
                          KraReceiptService.generate()
```

Whichever path returns the CU number first wins; the other becomes a no-op
(`RecoverSapInvoiceJob` exits early if the webhook already completed, and the
webhook handler is idempotent on duplicate CU numbers).

### Sync statuses — `App\Enums\SapSyncStatus`

| Status        | Meaning                                                        |
|---------------|----------------------------------------------------------------|
| `PENDING`     | Paid, job not yet dispatched                                   |
| `SYNCING`     | `SyncOrderToSapJob` running — `POST /api/invoice/create`       |
| `AWAITING_CU` | Invoice created in SAP, waiting for the KRA CU number          |
| `COMPLETED`   | CU number received and receipt generated (terminal)           |
| `FAILED`      | Exhausted all retries — staff alerted (terminal)              |
| `RETURNED`    | SAP notified us the order was returned (terminal)             |

---

## Components

### This folder (`app/Services/Sap`)

| Class                       | Responsibility                                                                 |
|-----------------------------|--------------------------------------------------------------------------------|
| `SapIntegrationService`     | Orchestrates the two API calls (`syncOrder`, `validateInvoice`); writes `sap_sync_logs`; redacts secrets before logging. |
| `SapClient`                 | Thin `Http` wrapper — auth header, SSL, timeout; maps failures to `SapApiException`. |
| `SapConfig`                 | Resolves config, preferring admin-editable `IntegrationSettings` over `config/sap.php`. |
| `SapWebhookHandler`         | Verifies the webhook secret and dispatches CU-number / return events.          |
| `KraReceiptService`         | Generates the KRA tax receipt once a CU number is stored.                      |
| `SapApiException`           | Carries HTTP status + endpoint; `isRetryable()` drives retry vs. hard-fail.    |
| `DTOs/SapOrderPayload`      | Builds the invoice-create payload from an `Order` (see **Payload** below).      |
| `ValueObjects/SapSyncResult`, `SapValidationResult` | Typed return values from the two API phases.          |

### Related (outside this folder)

| Type          | Class                                                                 |
|---------------|-----------------------------------------------------------------------|
| Jobs          | `App\Jobs\SyncOrderToSapJob`, `RecoverSapInvoiceJob` (both on the `sap` queue), `ProcessSapProductSync` |
| Trigger       | `App\Models\Order::markConfirmed()` dispatches the sync                |
| HTTP in       | `App\Http\Controllers\Integrations\SapWebhookController` (`POST /api/webhooks/sap`), `SapSyncController` (`POST /api/products/sync`) |
| Middleware    | `App\Http\Middleware\VerifySapSecret`                                  |
| Command       | `php artisan sap:resync` (`App\Console\Commands\SapResyncCommand`)     |
| Model         | `App\Models\SapSyncLog` — audit trail of every request/response       |
| Notification  | `App\Notifications\SapSyncFailedNotification`                          |
| Admin UI      | `pages::admin.sap-sync` (live monitor, `admin.sap-sync` broadcast channel) |

---

## Payload — `SapOrderPayload::fromOrder()`

Three top-level blocks:

```jsonc
{
  "credit_guard_response": { /* payment details, gateway-aware */ },
  "customer": { /* name, email, address, phone, notes, timestamps */ },
  "order": {
    "Orderid": 296,                 // numeric — SAP types this as Int64
    "reference": "SHF-2026-00296",  // human-facing order number
    "payment_status": "Paid",
    "cart": { "debit_total_price": 11040, "lines": [ /* … */ ] }
  }
}
```

### `credit_guard_response` is gateway-aware

The keys are SAP's legacy Credit Guard (card gateway) contract and stay stable,
but the values are populated from **whichever gateway settled the payment**:

- **`uid`** — settlement reference SAP reconciles the receipt against. Prefers the
  M-Pesa/mobile-money receipt when present, else the gateway's own reference
  (Paystack reference → Stripe charge/intent).
- **`cgUid`** — the gateway's internal transaction id (Paystack `payload.id`,
  Stripe charge id, M-Pesa `checkout_request_id`).
- **Card fields** (`cardBrand`, `cardNo` [last-4], `cardExpiration` [`MMYY`],
  `creditCardToken`) — filled only for card rails (Paystack `channel = card`, or
  Stripe). Mobile-money / bank-transfer leave them empty.
- **`numberOfPayments`** — `"1"` when settled, `"0"` when there is no successful payment.

> ⚠️ `Orderid` **must** stay numeric — SAP's deserializer rejects the whole payload
> with an `Int64` conversion error otherwise. The order reference travels in
> `reference`.

### Redaction

`SapIntegrationService::redactPayload()` masks only `creditCardToken` and
`personalId` before writing to `sap_sync_logs`. Everything else stays readable so
syncs can be audited. **The payload sent over the wire is un-redacted** — inspect
it in Telescope → **HTTP Client** (`/telescope/client-requests`).

---

## Configuration

Values resolve from `IntegrationSettings` (admin UI) first, then `config/sap.php`
(env fallback). See `SapConfig`.

| Setting / env                 | Purpose                                            |
|-------------------------------|----------------------------------------------------|
| `SAP_BASE_URL`                | Middleware base URL (default `http://localhost:85`)|
| `SAP_API_KEY`                 | Sent as `x-api-key` on every request               |
| `SAP_WEBHOOK_SECRET`          | Verifies inbound webhook (`X-SAP-Secret`); empty = skip check |
| `KRA_BUSINESS_PIN`            | Business PIN for KRA                                |
| `SAP_VERIFY_SSL`              | TLS verification (default `true`)                  |
| `SAP_RECOVERY_DELAY_MINUTES`  | Delay before `RecoverSapInvoiceJob` polls          |
| `sap_enabled` (setting)       | Master switch — no sync dispatched when off        |
| `sap_auto_sync_orders` (setting) | Auto-dispatch sync on order confirmation        |

---

## Retries & failures

- **`SyncOrderToSapJob`** — 3 tries, backoff `60/300/900s`.
- **`RecoverSapInvoiceJob`** — 2 tries, backoff `300/900s`, 4-min HTTP timeout.
- **`SapApiException::isRetryable()`** — retries connection failures (status `0`),
  `429`, and all `5xx`. Client `4xx` errors fail immediately (retrying won't help).
- On permanent failure, order → `FAILED` and staff receive `SapSyncFailedNotification`.
- If Phase 1 already created the invoice, `SyncOrderToSapJob::failed()` does **not**
  mark the order `FAILED` — it lets `RecoverSapInvoiceJob` own the final outcome.

---

## Running & troubleshooting

The `sap` queue is separate from `default`. A plain `queue:work` will **not**
process SAP jobs.

```bash
# Process both queues (sap prioritised)
php artisan queue:work --queue=sap,default

# Re-trigger a sync manually
php artisan sap:resync SHF-2026-00296   # by id or order number
php artisan sap:resync --failed         # all FAILED orders
php artisan sap:resync --stuck          # SYNCING/AWAITING_CU older than 1h
```

In production the scheduler runs a worker automatically
(`routes/console.php`: `queue:work --queue=default,sap …`), so the scheduler
(`schedule:work` / cron) must be running.

**Common gotchas**

- *Job runs but nothing in Telescope HTTP Client?* You're on the **Requests** tab
  (incoming). Outgoing SAP calls are under **HTTP Client**.
- *Every re-sync shows FAIL with "Invoice already created"?* SAP already has that
  invoice — currently treated as a hard failure. (Idempotent handling is a known
  TODO.)
- *Code change not taking effect?* `queue:work` caches code in memory — restart
  the worker after edits.

---

## Tests

`tests/Feature/SapOrderSyncTest.php` covers the payload DTO (per-gateway
`credit_guard_response`, `Orderid`/`reference`), redaction, job lifecycle, and the
resync command. Webhook and monitor coverage live in `SapSyncTest.php`,
`SapSyncMonitorTest.php`, and `SapOrderSyncTest.php`.

```bash
php artisan test --compact --filter=Sap
```

---

## Appendix — Example payloads

The values below are what actually goes over the wire (Telescope → **HTTP Client**).
The `customer` and `order` blocks are identical every time; only
`credit_guard_response` changes with the gateway/channel. Paystack is the active
gateway (card / M-Pesa / Airtel / Pesalink); direct M-Pesa and Stripe are dormant
fallbacks.

### Full payload — Paystack **Card**

```json
{
  "credit_guard_response": {
    "authNumber": "",
    "cardBrand": "visa",
    "cardExpiration": "0929",
    "cardId": "",
    "cardNo": "4242",
    "cgUid": "3216549870",
    "creditCardToken": "AUTH_abc123xyz",
    "numberOfPayments": "1",
    "personalId": "",
    "uid": "SHF-2026-00296-ABCDEFGH"
  },
  "customer": {
    "created_at": "2026-07-06T11:23:30.000000Z",
    "email": "customer@sheffieldafrica.com",
    "full_address": "Westlands, 14 Muthangari Drive",
    "full_name": "Anita Wanjiru",
    "mobile_phone": "+254 712 345 678",
    "note": null,
    "updated_at": "2026-07-06T11:23:30.000000Z"
  },
  "order": {
    "Orderid": 296,
    "reference": "SHF-2026-00296",
    "name": "Anita Wanjiru",
    "phone": "+254 712 345 678",
    "payment_status": "Paid",
    "cart": {
      "debit_total_price": 11040,
      "lines": [
        {
          "code": "IMG/TCW/00520",
          "item_id": 618,
          "line_item_id": 708,
          "price": 11040,
          "quantity": 1,
          "linetotal": 1104000
        }
      ]
    }
  }
}
```

> `price` / `debit_total_price` are whole KES; `linetotal` is in **cents**
> (`line_total_cents`). `Orderid` must stay numeric (SAP `Int64`); the human
> reference is in `reference`.

For the rest, only `credit_guard_response` differs — the `customer` / `order`
blocks are unchanged.

### Paystack **M-Pesa** (mobile money)

```json
{
  "credit_guard_response": {
    "authNumber": "",
    "cardBrand": "",
    "cardExpiration": "",
    "cardId": "",
    "cardNo": "",
    "cgUid": "3216549999",
    "creditCardToken": "",
    "numberOfPayments": "1",
    "personalId": "",
    "uid": "QGH7XY8Z9A"
  }
}
```
`uid` = the M-Pesa network receipt (preferred over the gateway ref for mobile
money); `cgUid` = the Paystack transaction id. Card fields stay empty. If Paystack
didn't surface a receipt, `uid` falls back to the Paystack reference.

### Paystack **Airtel Money**

```json
{
  "credit_guard_response": {
    "authNumber": "",
    "cardBrand": "",
    "cardExpiration": "",
    "cardId": "",
    "cardNo": "",
    "cgUid": "3216550055",
    "creditCardToken": "",
    "numberOfPayments": "1",
    "personalId": "",
    "uid": "SHF-2026-00297-JKLMNOPQ"
  }
}
```
Same shape as M-Pesa. Airtel settles through Paystack's `mobile_money` channel;
`uid` uses the network receipt when present, otherwise the Paystack reference.

### Paystack **Pesalink** (bank transfer)

```json
{
  "credit_guard_response": {
    "authNumber": "",
    "cardBrand": "",
    "cardExpiration": "",
    "cardId": "",
    "cardNo": "",
    "cgUid": "3216550111",
    "creditCardToken": "",
    "numberOfPayments": "1",
    "personalId": "",
    "uid": "SHF-2026-00298-RSTUVWXY"
  }
}
```
No receipt for a bank transfer, so `uid` = the Paystack reference.

### Direct **M-Pesa (Daraja)** — dormant fallback

```json
{
  "credit_guard_response": {
    "authNumber": "",
    "cardBrand": "",
    "cardExpiration": "",
    "cardId": "",
    "cardNo": "",
    "cgUid": "ws_CO_08072026093500123",
    "creditCardToken": "",
    "numberOfPayments": "1",
    "personalId": "",
    "uid": "MPE123456789"
  }
}
```
`uid` = the M-Pesa receipt; `cgUid` = the STK `checkout_request_id`.

### **Stripe** — dormant fallback

```json
{
  "credit_guard_response": {
    "authNumber": "",
    "cardBrand": "mastercard",
    "cardExpiration": "",
    "cardId": "",
    "cardNo": "4444",
    "cgUid": "ch_3QabcXYZ",
    "creditCardToken": "pi_3QabcXYZ",
    "numberOfPayments": "1",
    "personalId": "",
    "uid": "ch_3QabcXYZ"
  }
}
```
Treated as a card. `creditCardToken` = payment intent, `cgUid` / `uid` = charge id.
`cardExpiration` stays empty (Stripe expiry isn't recorded).

### **No successful payment** (unpaid / failed)

```json
{
  "credit_guard_response": {
    "authNumber": "",
    "cardBrand": "",
    "cardExpiration": "",
    "cardId": "",
    "cardNo": "",
    "cgUid": "",
    "creditCardToken": "",
    "numberOfPayments": "0",
    "personalId": "",
    "uid": ""
  }
}
```
Everything empty, `numberOfPayments` = `"0"`.

> In the `sap_sync_logs` audit copy, `creditCardToken` and `personalId` are
> replaced with `"[redacted]"`. The payload sent to SAP is un-redacted (shown above).
