# Pesawise Payment Integration Setup

## The Problem

Pesawise sends webhooks to your `callbackUrl` in this order:
1. **POST request** - Contains payment status data (SUCCESS/FAILED)
2. **GET request** - User redirect when they click "Continue"

Your local `.test` domain (e.g., `sheffieldafrica_ecommerce.test`) is only accessible on your machine. Pesawise's servers cannot reach it to send the POST webhook.

## Solution for Local Development

Use **ngrok** or **Laravel Herd's Expose** to create a public URL that tunnels to your local server.

### Option 1: Using ngrok (Recommended)

1. **Install ngrok**
   ```bash
   # Download from https://ngrok.com/download
   # Or use chocolatey on Windows:
   choco install ngrok
   ```

2. **Start ngrok tunnel**
   ```bash
   ngrok http https://sheffieldafrica_ecommerce.test
   ```

3. **Copy the HTTPS URL** (e.g., `https://abc123.ngrok.io`)

4. **Add to your .env**
   ```env
   PESAWISE_CALLBACK_BASE_URL=https://abc123.ngrok.io
   ```

5. **Test a payment** - Pesawise will now be able to send webhooks to your local machine!

### Option 2: Using Laravel Herd Expose

1. **Open Herd** and find your site
2. **Click "Share"** or use expose command
3. **Copy the public URL**
4. **Add to .env** as shown above

## Solution for Production

1. **Deploy to a public server** (e.g., DigitalOcean, AWS, Vercel)

2. **Remove or leave empty** in production .env:
   ```env
   PESAWISE_CALLBACK_BASE_URL=
   ```
   
   The system will automatically use your `APP_URL` when this is empty.

## How It Works

The `callbackUrl` parameter in Pesawise receives BOTH:
- POST webhook with payment data
- GET redirect for user

Our controller (`PaymentCallbackController@handleSuccess`) detects the request method:
- `POST` → Process webhook, update order status
- `GET` → Redirect user to success page

## Testing

1. **Check logs** after payment:
   ```bash
   tail -f storage/logs/laravel.log
   ```

2. **Look for**:
   - `=== PAYMENT CALLBACK RECEIVED ===` (both POST and GET)
   - `=== POST WEBHOOK PROCESSING ===` (payment data)
   - `=== USER REDIRECT PROCESSING ===` (user clicks Continue)

3. **Verify POST webhook data**:
   ```json
   {
     "status": "SUCCESS",
     "orderId": "01KHM50XXX1T82FQ6D5VJ8FP6E",
     "externalId": "ORD-RSYD0MFSC0",
     "amount": 474839
   }
   ```

## Troubleshooting

### POST webhook not received?
- Check ngrok is running: `ngrok http https://sheffieldafrica_ecommerce.test`
- Verify `PESAWISE_CALLBACK_BASE_URL` in .env
- Check ngrok dashboard: http://127.0.0.1:4040 (shows all requests)
- Ensure CSRF exception is set (already configured)

### GET redirect works but POST doesn't?
- This means Pesawise can't reach your server
- You MUST use ngrok/expose for local development
- Or deploy to a public server

### Both requests received but payment not updating?
- Check `storage/logs/laravel.log` for errors
- Verify `externalId` matches your order reference
- Check database: `orders` table `payment_status` column

## Routes

```php
// Handles BOTH POST and GET
Route::match(['get', 'post'], 'payment/callback/success', [PaymentCallbackController::class, 'handleSuccess']);
Route::match(['get', 'post'], 'payment/callback/cancel', [PaymentCallbackController::class, 'handleCancel']);
```

## CSRF Protection

Already configured in `app/Http/Middleware/VerifyCsrfToken.php`:
```php
protected $except = [
    'payment/callback/success',
    'payment/callback/cancel',
];
```
