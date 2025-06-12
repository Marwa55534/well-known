<?php

namespace App\Services;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PaymobPaymentService 
{
    /**
     * Create a new class instance.
     */
     protected $apiKey;
    protected $integrationId;
    protected $iframeId;

    public function __construct()
    {
        $this->apiKey = config('services.paymob.api_key');
        $this->integrationId = config('services.paymob.integration_id');
        $this->iframeId = config('services.paymob.iframe_id');
    }



//     public function authenticate()
// {
//     $response = Http::post('https://accept.paymob.com/api/auth/tokens', [
//         'api_key' => $this->apiKey
//     ]);
//     return $response['token'];
// }

public function authenticate()
{
    $response = Http::post('https://accept.paymob.com/api/auth/tokens', [
        'api_key' => $this->apiKey
    ]);
    Log::info('Paymob authentication response', $response->json());
    if ($response->failed() || !isset($response['token'])) {
        throw new \Exception('Failed to authenticate with Paymob');
    }
    return $response['token'];
}

    public function createOrder($token, $amount, $complaintId)
    {
        $response = Http::post('https://accept.paymob.com/api/ecommerce/orders', [
            'auth_token' => $token,
            'delivery_needed' => false,
            'amount_cents' => $amount * 100, // Paymob requires amount in cents
            'items' => [],
            'merchant_order_id' => $complaintId,
        ]);

        return $response['id'];
    }

    public function getPaymentKey($token, $amount, $orderId)
    {
        $response = Http::post('https://accept.paymob.com/api/acceptance/payment_keys', [
            'auth_token' => $token,
            'amount_cents' => $amount * 100,
            'expiration' => 3600,
            'order_id' => $orderId,
            'billing_data' => [
                "apartment" => "NA",
                "email" => "customer@example.com",
                "floor" => "NA",
                "first_name" => "Client",
                "street" => "NA",
                "building" => "NA",
                "phone_number" => "+201000000000",
                "shipping_method" => "NA",
                "postal_code" => "NA",
                "city" => "NA",
                "country" => "NA",
                "last_name" => "Example",
                "state" => "NA"
            ],
            'currency' => 'EGP',
            'integration_id' => $this->integrationId
        ]);

        return $response['token'];
    }

    public function getIframeUrl($paymentToken)
    {
        return "https://accept.paymob.com/api/acceptance/iframes/{$this->iframeId}?payment_token={$paymentToken}";
    }


}
