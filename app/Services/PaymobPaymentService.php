<?php

namespace App\Services;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PaymobPaymentService 
{
//     /**
//      * Create a new class instance.
//      */
//      protected $apiKey;
//     protected $integrationId;
//     protected $iframeId;

//     public function __construct()
//     {
//         $this->apiKey = config('services.paymob.api_key');
//         $this->integrationId = config('services.paymob.integration_id');
//         $this->iframeId = config('services.paymob.iframe_id');
//     }



// //     public function authenticate()
// // {
// //     $response = Http::post('https://accept.paymob.com/api/auth/tokens', [
// //         'api_key' => $this->apiKey
// //     ]);
// //     return $response['token'];
// // }

// public function authenticate()
// {
//     $response = Http::post('https://accept.paymob.com/api/auth/tokens', [
//         'api_key' => $this->apiKey
//     ]);
//     Log::info('Paymob authentication response', $response->json());
//     if ($response->failed() || !isset($response['token'])) {
//         throw new \Exception('Failed to authenticate with Paymob');
//     }
//     return $response['token'];
// }

//     public function createOrder($token, $amount, $complaintId)
//     {
//         $response = Http::post('https://accept.paymob.com/api/ecommerce/orders', [
//             'auth_token' => $token,
//             'delivery_needed' => false,
//             'amount_cents' => $amount * 100, // Paymob requires amount in cents
//             'items' => [],
//             'merchant_order_id' => $complaintId,
//         ]);

//         return $response['id'];
//     }

//     public function getPaymentKey($token, $amount, $orderId)
//     {
//         $response = Http::post('https://accept.paymob.com/api/acceptance/payment_keys', [
//             'auth_token' => $token,
//             'amount_cents' => $amount * 100,
//             'expiration' => 3600,
//             'order_id' => $orderId,
//             'billing_data' => [
//                 "apartment" => "NA",
//                 "email" => "customer@example.com",
//                 "floor" => "NA",
//                 "first_name" => "Client",
//                 "street" => "NA",
//                 "building" => "NA",
//                 "phone_number" => "+201000000000",
//                 "shipping_method" => "NA",
//                 "postal_code" => "NA",
//                 "city" => "NA",
//                 "country" => "NA",
//                 "last_name" => "Example",
//                 "state" => "NA"
//             ],
//             'currency' => 'EGP',
//             'integration_id' => $this->integrationId
//         ]);

//         return $response['token'];
//     }

//     public function getIframeUrl($paymentToken)
//     {
//         return "https://accept.paymob.com/api/acceptance/iframes/{$this->iframeId}?payment_token={$paymentToken}";
//     }




    public function getToken()
    {
         $apiKey = config('paymob.api_key');

    if (!$apiKey) {
        throw new \Exception('api_key غير موجود في الإعدادات.');
    }
        $response = Http::post('https://accept.paymob.com/api/auth/tokens', [
            'api_key' => config('paymob.api_key'),
        ]);

        //  if ($response->successful()) {
        // return $response->json()['token'];
        // if ($response->successful() && isset($response->json()['token'])) {
        // return $response->json()['token'];
         if ($response->successful() && isset($response->json()['token'])) {
        return $response->json()['token'];
    }
    throw new \Exception('فشل في الحصول على Auth Token: ' . $response->body());

    }

   
   public function createOrder($authToken, $amount)
{
    // $orderId = 'complaint_' . uniqid(); // أو أي قيمة فريدة
    //   $orderId = 'complaint_' . Str::uuid(); 
    $orderId = 'complaint_'. now()->timestamp . '_' . rand(1000,9999);


    $response = Http::post('https://accept.paymob.com/api/ecommerce/orders', [
        'auth_token' => $authToken,
        'delivery_needed' => false,
        'amount_cents' => $amount * 100,
        'currency' => 'EGP',
        'merchant_order_id' => $orderId, // لازم يكون فريد
        'items' => [],
    ]);
    // dd($response->json());

    return $response->json(); // هيرجع فيهم order id الحقيقي بتاع Paymob
}

   
    public function generatePaymentKey($authToken, $amount, $orderId)
    {
        $response = Http::post('https://accept.paymob.com/api/acceptance/payment_keys', [
            'auth_token' => $authToken,
            'amount_cents' => $amount * 100,
            'expiration' => 3600,
            'order_id' => $orderId,
            'billing_data' => [
                "apartment" => "NA", "email" => "test@example.com", "floor" => "NA",
                "first_name" => "Test", "street" => "NA", "building" => "NA", "phone_number" => "01000000000",
                "shipping_method" => "NA", "postal_code" => "NA", "city" => "Cairo",
                "country" => "EG", "last_name" => "User", "state" => "NA"
            ],
            'currency' => "EGP",
            'integration_id' => config('paymob.integration_id'),
        ]);

        return $response->json()['token'];
    }

}
