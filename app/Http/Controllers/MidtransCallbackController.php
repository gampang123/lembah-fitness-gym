<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Services\MembershipActivationService;
use Illuminate\Http\Request;

class MidtransCallbackController extends Controller
{
    public function handleCallback(Request $request)
    {
        $serverKey = config('midtrans.server_key');

        $formattedGrossAmount = number_format($request->input('gross_amount'), 2, '.', '');

        $signatureKey = hash('sha512',
            $request->input('order_id') .
            $request->input('status_code') .
            $formattedGrossAmount .
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
        if ($paymentType) {
            $transaction->midtrans_payment_type = $paymentType;
        }

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

        if ($transaction->status === 'paid') {
            (new MembershipActivationService())->approve($transaction);
        }

        return response()->json(['message' => 'Callback processed']);
    }
}
