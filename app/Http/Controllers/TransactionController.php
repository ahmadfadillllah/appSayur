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
            'status'        =>  'processing',
            'user_id'       =>  $user->id,
            'lat_lon'       =>  $request->lat_lon,
            'expired_at'    =>  now()->addDay(),
            'total_transaksi' =>  $request->total_harga,
            'metode_pembayaran' => null,
        ];

        $transaction    =   Transaction::create(array_merge($shipping_address, $transaction_data));

        $snapToken      =   $this->midtrans($transaction, $order);

        Cart::all()->delete();

        return redirect()->route('product.pay', [$transaction->id, $snapToken]);
    }

    /**
     *  Fungsi untuk menangkap hasil transaksi dari midtrans
     *
     *  @param  \Illuminate\Http\Request    $request
     */
    public function transactionRedirectionResult(Request $request)
    {
        $json_data          =   base64_decode($request->order_id);
        $data               =   json_decode($json_data);
        $status_trf         =   $request->status_trs;
        $transaction_status =   $request->transaction_status;

        $transaction    =   Transaction::where('order_id', $data['order_id'])->first();

        $status_code    =   0;

        switch ($transaction_status) {
            case 'pending':
                $status_code = 0;
            case 'authorize':
                $status_code = 0;
                break;
            case 'deny':
                $status_code = 2;
            case 'expire':
                $status_code = 2;
            case 'cancel':
                $status_code = 2;
                break;
            case 'capture':
                $status_code = 3;
            case 'settlement':
                $status_code = 3;
                break;
            case 'refund':
                $status_code = 4;
            case 'partial_refund':
                $status_code = 4;
                break;
        }

        $transaction->update([
            'status'        =>  $transaction_status,
            'status_code'   =>  $status_code,
        ]);

        if ($status_trf === 'finish') {
            $msg = 'Transaksi sedang diproses, silahkan tunggu beberapa saat dan lakukan refresh pada halaman';
        } else if ($status_trf === 'unfinish') {
            $msg = 'Transaksi tidak dapat diselesaikan!';
        } else {
            $msg = 'Transaksi gagal!';
        }

        return redirect()->route('transactions')->with('info', $msg);
    }

    public function transactions()
    {
        $user   =   (object) auth()->user();

        return view('Dashboard.transactions', [
            'user'  =>  $user,
            'transactions' => $user->transactions,
        ]);
    }

    public function notification()
    {
        try {
            \Midtrans\Config::$isProduction = false;
            \Midtrans\Config::$serverKey = config('app.midtrans.server_key');

            $notif = new \Midtrans\Notification();

            $json_data          =   base64_decode($notif->order_id);
            $data               =   json_decode($json_data);

            $transaction    =   $notif->transaction_status;
            $type           =   $notif->payment_type;
            $order_id       =   $data['order_id'];
            $fraud_status   =   $notif->fraud_status;
            $gross_amount   =   $notif->gross_amount;
            $currency       =   $notif->currency;
            $currency       =   $notif->currency;
            $approval_code  =   $notif->approval_code;
            $bank           =   $notif->bank;
            $eci            =   $notif->eci;
            $va_number      =   json_encode($notif->va_numbers ?? []);
            $store          =   $notif->store;
            $masked_card    =   $notif->masked_card;

            $data   =   [
                'fraud_status'  =>  $fraud_status,
                'gross_amount'  =>  $gross_amount,
                'currency'      =>  $currency,
                'bank'          =>  $bank,
                'va_number'     =>  $va_number,
                'store'         =>  $store,
                'masked_card'   =>  $masked_card,
                'eci'           =>  $eci,
                'approval_code' =>  $approval_code,
                'status'        =>  $transaction,
                'metode_pembayaran' => $type,
            ];

            if ($transaction == 'capture') {
                $data['status_code']    =   3;
            } else if ($transaction == 'settlement') {
                $data['status_code']    =   3;
            } else if ($transaction == 'pending') {
                $data['status_code']    =   1;
            } else if ($transaction == 'deny') {
                $data['status_code']    =   2;
            } else if ($transaction == 'expire') {
                $data['status_code']    =   2;
            } else if ($transaction == 'cancel') {
                $data['status_code']    =   2;
            }

            $transaction    =   Transaction::where('order_id', $order_id)->first();

            $transaction->update($data);

            Log::info('Transaksi selesai dengan status: ' . $transaction);
        } catch (\Throwable $th) {
            Log::info('Transaksi gagal dengan error: ' . $th->getMessage() . " at " . get_class($th));
            throw $th;
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

        $order_id   =   [
            'order_id'  =>  $order->id,
            'created_at' => time(),
        ];

        $transaction_details['order_id']     =  base64_encode(json_encode($order_id))        ;
        $transaction_details['gross_amount'] =  $request->total_harga;

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
