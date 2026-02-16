# Test Pesawise Webhook Locally
# This simulates what Pesawise sends

$url = "https://sheffieldafrica_ecommerce.test/payment/callback/success"

# If using ngrok, replace with your ngrok URL:
# $url = "https://abc123.ngrok.io/payment/callback/success"

$body = @{
    status = "SUCCESS"
    orderId = "01KHM50XXX1T82FQ6D5VJ8FP6E"
    externalId = "ORD-TEST123"
    amount = 100000
} | ConvertTo-Json

Write-Host "Testing POST webhook to: $url" -ForegroundColor Yellow
Write-Host "Body: $body" -ForegroundColor Cyan

try {
    $response = Invoke-WebRequest -Uri $url -Method POST -Body $body -ContentType "application/json" -UseBasicParsing
    Write-Host "`nSuccess! Status: $($response.StatusCode)" -ForegroundColor Green
    Write-Host "Response: $($response.Content)" -ForegroundColor Green
} catch {
    Write-Host "`nError: $($_.Exception.Message)" -ForegroundColor Red
}

Write-Host "`nCheck your Laravel logs: storage/logs/laravel.log" -ForegroundColor Yellow
