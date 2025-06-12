<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;
use App\Models\Complaint;
use Illuminate\Http\Request;
use App\Models\Attachment;
use App\Models\Payment;
use App\Services\PaymobPaymentService;
use Illuminate\Support\Facades\DB;

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
            $complaint = Complaint::create($request->only('title', 'description'));

            if ($request->hasFile('files')) {
                foreach ($request->file('files') as $file) {
                    $path = $file->store('complaints', 'public');
                    Attachment::create([
                        'complaint_id' => $complaint->id,
                        'file_path' => $path,
                    ]);
                }
            }

            $authToken = $paymob->authenticate();
            $amount = $request->input('amount');
            $orderId = $paymob->createOrder($authToken, $amount, $complaint->id);
            $paymentToken = $paymob->getPaymentKey($authToken, $amount, $orderId);

            Payment::create([
                'complaint_id' => $complaint->id,
                'payment_token' => $paymentToken,
                'amount' => $amount,
                'status' => 'pending',
            ]);

            DB::commit();

            if ($request->expectsJson()) {
                return response()->json(['payment_url' => $paymob->getIframeUrl($paymentToken)], 200);
            }

            return redirect()->away($paymob->getIframeUrl($paymentToken));
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to process complaint or payment: ' . $e->getMessage()], 500);
        }
    }

    public function handleWebhook(Request $request)
    {
        $data = $request->all();
        if ($data['obj']['success']) {
            Payment::where('payment_token', $data['obj']['payment_key'])
                ->update(['status' => 'completed']);
        } else {
            Payment::where('payment_token', $data['obj']['payment_key'])
                ->update(['status' => 'failed']);
        }
        return response()->json(['status' => 'success']);
    }

}
