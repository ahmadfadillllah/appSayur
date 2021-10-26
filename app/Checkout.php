<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Checkout extends Model
{
    protected $guarded = [];

    public function product() {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
