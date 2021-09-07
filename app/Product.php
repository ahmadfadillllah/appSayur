<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'product';

    protected $fillable = [
        'user_id',
        'name',
        'price',
        'description',
        'stock',
        'image'
    ];

    public function getImage()
    {
        return asset('img/'.$this->image);
    }
}
