<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class MidtransCallbackController extends Controller
{
    public function handleCallback(Request $request)
    {
        $serverKey = config('midtrans.server_key');
        $signatureKey = hash('sha512',
            $request->input('order_id') .
            $request->input('status_code') .
            $request->input('gross_amount') .
            $serverKey
        );

        if ($signatureKey !== $request->input('signature_key')) {
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        $transaction = Transaction::where('midtrans_order_id', $request->input('order_id'))->first();

        if (!$transaction) {
            return response()->json(['message' => 'Transaction not found'], 404);
        }

        $midtransStatus = $request->input('transaction_status');
        $paymentType = $request->input('payment_type');

        $transaction->midtrans_status = $midtransStatus;
        $transaction->midtrans_payment_type = $paymentType ?? null;

        switch ($midtransStatus) {
            case 'settlement':
                $transaction->status = 'paid';
                break;
            case 'pending':
                $transaction->status = 'pending';
                break;
            case 'deny':
            case 'cancel':
            case 'failure':
                $transaction->status = 'cancelled';
                break;
            case 'expire':
                $transaction->status = 'expired';
                break;
            default:
                $transaction->status = 'pending';
                break;
        }

        $transaction->save();

        return response()->json(['message' => 'Callback processed']);
    }
}
