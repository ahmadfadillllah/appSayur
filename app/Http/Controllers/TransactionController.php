<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Order;
use App\Product;
use App\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Midtrans\Config;

class TransactionController extends Controller
{

    public function productPay($id, $snap_token)
    {
        $user           =   (object) auth()->user();

        $transaction    =   Transaction::find($id);

        $order          =   $transaction->order;

        $data   =   [
            'transaction'   =>  $transaction,
            'carts'         =>  $user->cart,
            'order'         =>  $order,
            'products'      =>  array_values(json_decode($order->products)),
            'snap_token'    =>  $snap_token,
        ];

        return view('Dashboard.product-pay', $data);
    }

    /**
     *  Fungsi untuk melakukan checkout produk
     *
     *  @param  \Illuminate\Http\Request    $request
     *  @return mixed
     */
    public function checkout(Request $request)
    {
        if (!auth()->check()) return redirect()->back();

        $this->validateCheckout();

        $user       =   (object) auth()->user();

        // alamat dan data pengiriman produk
        $shipping_address   = [
            'first_name'    =>  $request->first_name,
            'last_name'     =>  $request->last_name,
            'postal_code'   =>  $request->postal_code,
            'nomor_telp'    =>  $request->nomor_telp,
            'city'          =>  $request->city,
            'alamat_tujuan' =>  $request->alamat,
            'email'         =>  $request->email,
        ];

        $carts      =   $user->cart;
        $products   =   [];

        foreach ($carts as $cart) {
            $products_['name']   =   $cart->name;
            $products_['price']  =   $cart->price;
            $products_['qty']    =   $cart->quantity;
            $products_['id']     =   $cart->product_id;
            $products_['image']  =   $cart->product->getImage();
            $products_['stock']  =   $cart->product->stock;

            $products[] =   $products_;
        }

        $order_data =   [
            'products'  =>  json_encode($products),
            'price'     =>  $request->total_harga,
            'quantity'  =>  $request->qty,
            'onkir'     =>  $request->onkir,
            'catatan'   =>  $request->note,
        ];

        $order   =   $user->order()->create($order_data);

        // data transaksi
        $transaction_data   =   [
            'order_id'      =>  $order->id,
            'status_code'   =>  0,
            'status'        =>  'unfinish',
            'user_id'       =>  $user->id,
            'lat_lon'       =>  $request->lat_lon,
            'expired_at'    =>  now()->addDay(),
            'total_transaksi' =>  $request->total_harga,
            'metode_pembayaran' => null,
        ];

        $transaction    =   Transaction::create(array_merge($shipping_address, $transaction_data));

        $snapToken      =   $this->midtrans($transaction, $order);

        return redirect()->route('product.pay', [$transaction->id, $snapToken]);
    }

    /**
     *  Fungsi untuk menangkap hasil transaksi dari midtrans
     *
     *  @param  \Illuminate\Http\Request    $request
     */
    public function transactionRedirectionResult(Request $request)
    {
        $order_id           =   $request->order_id;
        $status_code        =   $request->status_code;
        $transaction_status =   $request->transaction_status;

        $checkout   =   Transaction::where('order_id', $order_id)->first();

        // $checkout_status    =   $checkout->status;

        dd($_POST, $request, $checkout);
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

        Log::info("Transaction status {$transaction} : order id {$order_id}");

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


    private function midtrans(Transaction $transaction, Order $order)
    {
        $request    =   request();

        // Set your Merchant Server Key
        Config::$serverKey = config('app.midtrans.server_key');
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        Config::$isProduction = false;
        // Set sanitization on (default)
        Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        Config::$is3ds = true;

        $user       =   (object) auth()->user();

        $transaction_details['order_id']     =   $order->id;
        $transaction_details['gross_amount'] =   $request->total_harga;

        $billing_address    =   [
            "first_name"    =>  $user->name,
            "last_name"     =>  "",
            "email"         =>  $user->email,
            "phone"         =>  $user->nomor_telp,
            "address"       =>  $user->alamat,
            "city"          =>  $user->kota,
            "postal_code"   =>  $user->postal_code,
            "country_code"  =>  "IDN"
        ];

        $shipping_address   =   [
            'first_name'    =>  $request->first_name,
            'last_name'     =>  $request->last_name,
            'postal_code'   =>  $request->postal_code,
            'phone'         =>  $request->nomor_telp,
            'city'          =>  $request->city,
            'address'       =>  $request->alamat,
            'email'         =>  $request->email,
            "country_code"  =>  "IDN"
        ];

        $costumer_details =   [
            'first_name'    =>  $request->first_name,
            'last_name'     =>  $request->last_name,
            'email'         =>  $user->email,
            'phone'         =>  $request->nomor_telp,
            "billing_address"   =>  $billing_address,
            "shipping_address"  =>  $shipping_address,
        ];

        $items  =   $user->cart()->get(['id', 'name', 'price', 'quantity'])->toArray();

        $items  =   array_merge($items, [
            [
                'id'    =>  $this->randId('0NK1R'),
                'name'  =>  'Onkos kirim',
                'price' =>  $order->onkir,
                'quantity'  =>  1,
            ]
        ]);

        $params = [
            'transaction_details'   =>  $transaction_details,
            'customer_details'      =>  $costumer_details,
            'item_details'          =>  $items,
        ];

        return \Midtrans\Snap::getSnapToken($params);
    }

    private function validateCheckout()
    {
        request()->validate([
            'email'         =>  ['required', 'email'],
            'first_name'    =>  ['required', 'min:3', 'max:20'],
            'last_name'     =>  ['required', 'min:3', 'max:20'],
            'nomor_telp'    =>  ['required', 'min:4', 'max:20'],
            'city'          =>  ['required', 'min:2', 'max:20'],
            'postal_code'   =>  ['required', 'min:2', 'max:10'],
            'lat_lon'       =>  ['required'],
            'note'          =>  ['nullable'],
            'alamat'        =>  ['required', 'string'],
            'qty'           =>  ['required', 'integer'],
            'onkir'         =>  ['required', 'integer'],
            'total_harga'   =>  ['required', 'integer'],
        ]);
    }

    private function randId(string $suffix): string
    {
        $words = ['a', 'b', 'ct', 'pl', 'd', 'f', 'x', 'k', 'p', 'z', 'xc', 'r', 'ot', 'qx', 'ws'];
        return strtoupper($words[rand(0, count($words) - 1)] . rand(0, 9) . "$suffix");
    }
}
