<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function finish(Request $request) {
        $order_id           =   $request->order_id;
        $status_code        =   $request->status_code;
        $transaction_status =   $request->transaction_status;

        dd($_POST, $request);
    }

    public function fail(Request $request) {
        $order_id           =   $request->order_id;
        $status_code        =   $request->status_code;
        $transaction_status =   $request->transaction_status;

        dd($_POST, $request);
    }

    public function error(Request $request) {
        $order_id           =   $request->order_id;
        $status_code        =   $request->status_code;
        $transaction_status =   $request->transaction_status;

        dd($_POST, $request);
    }
}
