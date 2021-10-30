<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $guarded = [];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function pembeli()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
