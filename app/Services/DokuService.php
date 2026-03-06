<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class DokuService
{
    protected $clientId;
    protected $secretKey;
    protected $isProduction;
    protected $baseUrl;

    public function __construct()
    {
        $this->clientId = env('DOKU_CLIENT_ID', 'your_sandbox_client_id');
        $this->secretKey = env('DOKU_SECRET_KEY', 'your_sandbox_secret_key');
        $this->isProduction = env('DOKU_IS_PRODUCTION', false);
        $this->baseUrl = $this->isProduction 
            ? 'https://api.doku.com' 
            : 'https://api-sandbox.doku.com';
    }

    public function createPaymentUrl(array $orderData)
    {
        $requestId = (string) Str::uuid();
        $targetPath = '/checkout/v1/payment';
        $timestamp = gmdate("Y-m-d\TH:i:s\Z");

        $body = [
            'order' => [
                'invoice_number' => $orderData['invoice_number'],
                'amount' => $orderData['amount'],
                'callback_url' => route('doku.redirect', ['invoice_number' => $orderData['invoice_number']]),
            ],
            'payment' => [
                'payment_due_date' => 60 // 60 minutes
            ],
            'customer' => [
                'id' => (string) $orderData['user_id'],
                'name' => $orderData['user_name'],
                'email' => $orderData['user_email'],
            ]
        ];

        $jsonBody = json_encode($body);
        $digest = base64_encode(hash('sha256', $jsonBody, true));
        $signature = $this->generateSignature($this->clientId, $requestId, $timestamp, $targetPath, $digest, $this->secretKey);

        $response = Http::withHeaders([
            'Client-Id' => $this->clientId,
            'Request-Id' => $requestId,
            'Request-Timestamp' => $timestamp,
            'Signature' => $signature,
            'Content-Type' => 'application/json'
        ])->post($this->baseUrl . $targetPath, $body);

        if ($response->successful()) {
            return $response->json();
        }

        throw new Exception("Doku Payment Error: " . $response->body());
    }

    protected function generateSignature($clientId, $requestId, $timestamp, $targetPath, $digest, $secretKey)
    {
        $componentSignature = "Client-Id:" . $clientId . "\n" .
            "Request-Id:" . $requestId . "\n" .
            "Request-Timestamp:" . $timestamp . "\n" .
            "Request-Target:" . $targetPath . "\n" .
            "Digest:" . $digest;

        $signature = base64_encode(hash_hmac('sha256', $componentSignature, $secretKey, true));
        return "HMACSHA256=" . $signature;
    }
}
