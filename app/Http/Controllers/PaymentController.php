<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    // public function handleCallback(Request $request)
    // {
    //     $data = $request->all();

    //     // Get HMAC sent by Paymob
    //     $hmacFromPaymob = $request->input('hmac');

    //     // Step 1: Sort parameters alphabetically (excluding hmac)
    //     $fields = [
    //         'amount_cents',
    //         'created_at',
    //         'currency',
    //         'error_occured',
    //         'has_parent_transaction',
    //         'id',
    //         'integration_id',
    //         'is_3d_secure',
    //         'is_auth',
    //         'is_capture',
    //         'is_refunded',
    //         'is_standalone_payment',
    //         'is_voided',
    //         'order',
    //         'owner',
    //         'pending',
    //         'source_data_pan',
    //         'source_data_sub_type',
    //         'source_data_type',
    //         'success'
    //     ];

    //     $concatenatedString = '';
    //     foreach ($fields as $field) {
    //         $value = data_get($data, $field, '');
    //         $concatenatedString .= $value;
    //     }

    //     // Step 2: Get your HMAC secret from Paymob dashboard
    //     $yourHmacSecret = env('PAYMOB_HMAC_SECRET');

    //     // Step 3: Generate your own HMAC from the concatenated string
    //     $generatedHmac = hash_hmac('sha512', $concatenatedString, $yourHmacSecret);

    //     // Step 4: Compare
    //     if (hash_equals($generatedHmac, $hmacFromPaymob)) {
    //         // ✅ HMAC is valid — process the payment

    //         if ($data['success'] == true) {
    //             // Mark order/complaint/document as paid
    //             // مثلاً:
    //             // Complaint::where('payment_order_id', $data['order'])->update(['is_paid' => true]);

    //             Log::info('✅ Payment success and verified.', $data);
    //         } else {
    //             Log::warning('⚠️ Payment failed but verified.', $data);
    //         }

    //         return response()->json(['message' => 'callback processed'], 200);
    //     }

    //     // ❌ HMAC invalid — reject the request
    //     Log::error('❌ Invalid HMAC - potential fraud.', [
    //         'received_hmac' => $hmacFromPaymob,
    //         'generated_hmac' => $generatedHmac
    //     ]);

    //     return response()->json(['message' => 'invalid hmac'], 403);
    // }


}
