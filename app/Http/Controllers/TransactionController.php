<?php

namespace App\Http\Controllers;

use App\Checkout;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function finish(Request $request)
    {
        $order_id           =   $request->order_id;
        $status_code        =   $request->status_code;
        $transaction_status =   $request->transaction_status;

        $checkout   =   Checkout::where('order_id', $order_id)->first();

        // $checkout_status    =   $checkout->status;

        dd($_POST, $request, $checkout);
    }

    public function fail(Request $request)
    {
        $order_id           =   $request->order_id;
        $status_code        =   $request->status_code;
        $transaction_status =   $request->transaction_status;

        dd($_POST, $request);
    }

    public function error(Request $request)
    {
        $order_id           =   $request->order_id;
        $status_code        =   $request->status_code;
        $transaction_status =   $request->transaction_status;

        dd($_POST, $request);
    }

    public function notification()
    {
        \Midtrans\Config::$isProduction = false;
        \Midtrans\Config::$serverKey = config('app.midtrans.server_key');
        $notif = new \Midtrans\Notification();

        $transaction = $notif->transaction_status;
        $type = $notif->payment_type;
        $order_id = $notif->order_id;
        $fraud = $notif->fraud_status;

        if ($transaction == 'capture') {
            // For credit card transaction, we need to check whether transaction is challenge by FDS or not
            if ($type == 'credit_card') {
                if ($fraud == 'challenge') {
                    // TODO set payment status in merchant's database to 'Challenge by FDS'
                    // TODO merchant should decide whether this transaction is authorized or not in MAP
                    echo "Transaction order_id: " . $order_id . " is challenged by FDS";
                } else {
                    // TODO set payment status in merchant's database to 'Success'
                    echo "Transaction order_id: " . $order_id . " successfully captured using " . $type;
                }
            }
        } else if ($transaction == 'settlement') {
            // TODO set payment status in merchant's database to 'Settlement'
            echo "Transaction order_id: " . $order_id . " successfully transfered using " . $type;
        } else if ($transaction == 'pending') {
            // TODO set payment status in merchant's database to 'Pending'
            echo "Waiting customer to finish transaction order_id: " . $order_id . " using " . $type;
        } else if ($transaction == 'deny') {
            // TODO set payment status in merchant's database to 'Denied'
            echo "Payment using " . $type . " for transaction order_id: " . $order_id . " is denied.";
        } else if ($transaction == 'expire') {
            // TODO set payment status in merchant's database to 'expire'
            echo "Payment using " . $type . " for transaction order_id: " . $order_id . " is expired.";
        } else if ($transaction == 'cancel') {
            // TODO set payment status in merchant's database to 'Denied'
            echo "Payment using " . $type . " for transaction order_id: " . $order_id . " is canceled.";
        }
    }
}
