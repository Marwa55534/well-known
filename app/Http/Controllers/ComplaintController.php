<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;
use App\Models\Complaint;
use Illuminate\Http\Request;
use App\Models\Attachment;
use App\Models\Payment;
use App\Services\PaymobPaymentService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ComplaintController extends Controller
{
    // public function store(Request $request , PaymobPaymentService $paymob)  {

    //     $request->validate([
    //         'title' => 'required|string|max:255',
    //         'description' => 'required|string',
    //         'files.*' => 'file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048', 
    //     ]);

    //      $complaint = Complaint::create($request->only('title', 'description'));

    //     if ($request->hasFile('files')) {
    //         foreach ($request->file('files') as $file) {
    //             $path = $file->store('complaints', 'public');
    //             Attachment::create([
    //                 'complaint_id' => $complaint->id,
    //                 'file_path' => $path
    //             ]);
    //         }
    //     }
    //     // return $this->formatResponse($complaint, 'complaint created successfully', true, 201);

   
    //     // Step 1: Authenticate
    // $authToken = $paymob->authenticate();

    // // Step 2: Create Order
    // $amount = 100; // or dynamically assign amount
    // $orderId = $paymob->createOrder($authToken, $amount, $complaint->id);

    // // Step 3: Get Payment Key
    // $paymentToken = $paymob->getPaymentKey($authToken, $amount, $orderId);

    // // Step 4: Save to DB
    // Payment::create([
    //     'complaint_id' => $complaint->id,
    //     'payment_token' => $paymentToken,
    //     'amount' => $amount,
    //     'status' => 'pending',
    // ]);

    // // Step 5: Redirect to iframe
    // return redirect()->away($paymob->getIframeUrl($paymentToken));
    // }


    // git
    // public function store(Request $request, PaymobPaymentService $paymob)
    // {
    //     $request->validate([
    //         'title' => 'required|string|max:255',
    //         'description' => 'required|string',
    //         'files' => 'array|max:5',
    //         'files.*' => 'file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048',
    //         'amount' => 'required|numeric|min:1',
    //     ]);

    //     DB::beginTransaction();
    //     try {
    //         $complaint = Complaint::create($request->only('title', 'description'));

    //         if ($request->hasFile('files')) {
    //             foreach ($request->file('files') as $file) {
    //                 $path = $file->store('complaints', 'public');
    //                 Attachment::create([
    //                     'complaint_id' => $complaint->id,
    //                     'file_path' => $path,
    //                 ]);
    //             }
    //         }

    //         $authToken = $paymob->authenticate();
    //         $amount = $request->input('amount');
    //         $orderId = $paymob->createOrder($authToken, $amount, $complaint->id);
    //         $paymentToken = $paymob->getPaymentKey($authToken, $amount, $orderId);

    //         Payment::create([
    //             'complaint_id' => $complaint->id,
    //             'payment_token' => $paymentToken,
    //             'amount' => $amount,
    //             'status' => 'pending',
    //         ]);

    //         DB::commit();

    //         if ($request->expectsJson()) {
    //             return response()->json(['payment_url' => $paymob->getIframeUrl($paymentToken)], 200);
    //         }

    //         return redirect()->away($paymob->getIframeUrl($paymentToken));
    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         return response()->json(['error' => 'Failed to process complaint or payment: ' . $e->getMessage()], 500);
    //     }
    // }

    // public function handleWebhook(Request $request)
    // {
    //     $data = $request->all();
    //     if ($data['obj']['success']) {
    //         Payment::where('payment_token', $data['obj']['payment_key'])
    //             ->update(['status' => 'completed']);
    //     } else {
    //         Payment::where('payment_token', $data['obj']['payment_key'])
    //             ->update(['status' => 'failed']);
    //     }
    //     return response()->json(['status' => 'success']);
    // }

    
// public function store(Request $request, PaymobPaymentService $paymob)
// {
//     $request->validate([
//         'title' => 'required|string|max:255',
//         'description' => 'required|string',
//         'files' => 'array|max:5',
//         'files.*' => 'file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048',
//         'amount' => 'required|numeric|min:1',
//     ]);

//     DB::beginTransaction();

//     try {
//         $complaint = Complaint::create($request->only('title', 'description'));

//         if ($request->hasFile('files')) {
//             foreach ($request->file('files') as $file) {
//                 $path = $file->store('complaints', 'public');
//                 Attachment::create([
//                     'complaint_id' => $complaint->id,
//                     'file_path' => $path,
//                 ]);
//             }
//         }

//         // Paymob Integration
//         $authToken = $paymob->getToken();
//         $order = $paymob->createOrder($authToken, $request->amount, 'complaint_'.$complaint->id); 
//         $paymentToken = $paymob->generatePaymentKey($authToken, $request->amount, $order['id']);

//         DB::commit();

//         // Redirect to iframe
//         $iframeId = config('paymob.iframe_id');
//         $paymentUrl = "https://accept.paymob.com/api/acceptance/iframes/{$iframeId}?payment_token={$paymentToken}";

//         return redirect($paymentUrl);

//     } catch (\Exception $e) {
//         DB::rollBack();
//         return back()->with('error', 'حدث خطأ أثناء إنشاء الشكوى أو عملية الدفع.');
//     }
// }

public function store(Request $request, PaymobPaymentService $paymob)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'files' => 'array|max:5',
        'files.*' => 'file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048',
        'amount' => 'required|numeric|min:1',
    ]);

    DB::beginTransaction();

    try {
        $complaint = Complaint::create($request->only('title', 'description','amount'));

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $path = $file->store('complaints', 'public');
                Attachment::create([
                    'complaint_id' => $complaint->id,
                    'file_path' => $path,
                ]);
            }
        }

        // Paymob Integration
        $authToken = $paymob->getToken();
        $order = $paymob->createOrder($authToken, $request->amount, 'complaint_'.$complaint->id); 
        $paymentToken = $paymob->generatePaymentKey($authToken, $request->amount, $order['id']);

        $complaint->update([
            'payment_order_id' => $order['id'],
            'payment_token' => $paymentToken,
        ]);
        DB::commit();

        $iframeId = config('paymob.iframe_id');
        $paymentUrl = "https://accept.paymob.com/api/acceptance/iframes/{$iframeId}?payment_token={$paymentToken}";

        return response()->json([
            'payment_url' => $paymentUrl,
            'message' => 'تم إنشاء الشكوى بنجاح. برجاء التوجه إلى رابط الدفع.',
            'complaint_id' => $complaint->id,
        ], 201);

    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json([
            'error' => 'حدث خطأ أثناء إنشاء الشكوى أو عملية الدفع.',
            'details' => $e->getMessage()
        ], 500);
    }
}

public function callback(Request $request)
{
    Log::info('Callback Data:', $request->all());

    if ($request->has('success') && $request->input('success') == 'true') {
        $complaint = Complaint::where('payment_order_id', $request->input('merchant_order_id'))->first();

        if ($complaint && !$complaint->is_paid) {
        $complaint->update(['is_paid' => 1]);

        return response()->json(['message' => 'Payment recorded'], 200);
    }

        return response()->json(['message' => 'Complaint not found'], 404);
    }

    return response()->json(['message' => 'Payment failed'], 400);
}

}
