$payload = [  
 'credit_guard_response' => [
'authNumber' => '',
'cardBrand' => '',
'cardExpiration' => '',
'cardId' => '',
'cardNo' => '',
'cgUid' => '',
'creditCardToken' => '',
'numberOfPayments' => '0',
'personalId' => '',
'uid' => '',
],
'customer' => [
'created_at' => '2026-01-29T09:50:04Z',
'email' => 'Amonbgrush@abc.com',
'full_address' => 'Adresss 1234',
'full_name' => 'ABCSS',
'mobile_phone' => '0544961453',
'note' => null,
'updated_at' => '2026-01-29T11:20:12Z',
],
'order' => [
'cart' => [
'debit_total_price' => 549,
'lines' => [
[
'code' => 'FAB/SPE/00468',
'item_id' => 8813071,
'line_item_id' => 164693573,
'price' => 449,
'quantity' => 100,
'linetotal' => 44900,
],
[
'code' => 'IMG/REF/00044',
'item_id' => 8813071,
'line_item_id' => 164693573,
'price' => 1000,
'quantity' => 3,
'linetotal' => 1000,
],
],
],
'Orderid' => 19685762,
'name' => 'Test Customer',
'payment_status' => 'Paid',
'phone' => '0544961453',
],
];

$response = \Illuminate\Support\Facades\Http::withOptions(['verify' => false])->timeout(30)->withHeaders(['x-api-key' => ''])->post('http://41.90.242.177:85/api/invoice/create', $payload);

echo "Status: " . $response->status() . "\n";
echo "Body: " . $response->body() . "\n";
