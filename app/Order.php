<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'product';

    protected $fillable = [
        'customer_id',
        'product_id',
        'price',
        'quantity',
    ];
}
