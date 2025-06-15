<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Document;
use App\Models\ExtractFile;
use Illuminate\Support\Facades\DB;
use App\Services\PaymobPaymentService;
use Illuminate\Support\Facades\Log;

class DocumentController extends Controller
{
     public function store(Request $request, PaymobPaymentService $paymob)
    {
        $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
            'files.*' => 'nullable|file|mimes:jpg,png,pdf,doc,docx,zip|max:2048',
            'amount' => 'required|numeric|min:1',
        ]);
        DB::beginTransaction();

        try {

        $document = Document::create($request->only('title', 'description','amount'));

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $path = $file->store('extracts', 'public');
                ExtractFile::create([
                    'document_id' => $document->id,
                    'file_path' => $path
                ]);
            }
        }

        // return $this->formatResponse($document, 'document created successfully', true, 201);

        // Paymob
        $authToken = $paymob->getToken();
        $order = $paymob->createOrder($authToken, $request->amount, 'document_'.$document->id); 
        $paymentToken = $paymob->generatePaymentKey($authToken, $request->amount, $order['id']);

        $document->update([
            'payment_order_id' => $order['id'],
            'payment_token' => $paymentToken,
        ]);

        DB::commit();

        $iframeId = config('paymob.iframe_id');
        $paymentUrl = "https://accept.paymob.com/api/acceptance/iframes/{$iframeId}?payment_token={$paymentToken}";

        return response()->json([
            'payment_url' => $paymentUrl,
            'message' => 'تم إنشاء الوثيقة بنجاح. برجاء التوجه إلى رابط الدفع.',
            'document_id' => $document->id,
        ], 201);

    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json([
            'error' => 'حدث خطأ أثناء إنشاء الوثيقة أو عملية الدفع.',
            'details' => $e->getMessage()
        ], 500);
    }
}
       
public function callback(Request $request)
{
    Log::info('Document Payment Callback:', $request->all());

    if ($request->has('success') && $request->input('success') == 'true') {
        $document = Document::where('payment_order_id', $request->input('merchant_order_id'))->first();

        if ($document) {
            $document->is_paid = 1;
            $document->save();

            return response()->json(['message' => 'تم تسجيل الدفع بنجاح'], 200);
        }

        return response()->json(['message' => 'الوثيقة غير موجودة'], 404);
    }

    return response()->json(['message' => 'فشل الدفع'], 400);
}

    
}
