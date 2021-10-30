<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'order';

    protected $fillable = [
        'price',
        'quantity',
        'onkir',
        'catatan',
        'products'
    ];

    public function transaction()
    {
        return $this->hasOne(Transaction::class, 'order_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
