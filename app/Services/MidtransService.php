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
            'transaction_details' => [
                'order_id'     => $orderId,
                'gross_amount' => $grossAmount,
            ],
            'customer_details' => $customerDetails,

            'enabled_payments' => ['bank_transfer', 'gopay'], // contoh
            'vtweb' => []
        ];

        try {
        $vtwebUrl = \Midtrans\Snap::createTransaction($params)->redirect_url;
            return (object)['redirect_url' => $vtwebUrl];
        } catch (\Exception $e) {
            throw new \Exception('Midtrans API error: ' . $e->getMessage());
        }
    }
}
