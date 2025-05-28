<?php

namespace App\Services;

use Midtrans\Config;
use Midtrans\CoreApi;
use Midtrans\Snap;

class MidtransService
{
    public function __construct()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    public function createTransaction($orderId, $grossAmount, $customerDetails)
    {
        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $grossAmount,
            ],
            'customer_details' => $customerDetails
        ];

        return Snap::getSnapToken($params);
    }

    public function createRedirectTransaction($orderId, $grossAmount, $customerDetails)
    {
        $params = [
            'payment_type' => 'bank_transfer', // atau ganti ke echannel / qris / credit_card
            'transaction_details' => [
                'order_id'     => $orderId,
                'gross_amount' => $grossAmount,
            ],
            'customer_details' => $customerDetails,
        ];

        $result = CoreApi::charge($params);

        return $result; // akan mengandung redirect_url jika applicable
    }
}
