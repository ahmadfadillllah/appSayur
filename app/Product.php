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
        'location',
        'image'
    ];

    public function getImage()
    {
        if($this->isImageURL()) {
            return $this->image;
        }

        return asset('img/' . $this->image);
    }

    /**
     *  Metode untuk mengecek apakah gambar produk itu berupa url atau tidak
     *
     *  @return bool
     */
    private function isImageURL(): bool
    {
        $url    =   $this->image;

        // Remove all illegal characters from a url
        $url = filter_var($url, FILTER_SANITIZE_URL);

        // Validate url
        return (filter_var($url, FILTER_VALIDATE_URL) !== false) ? true : false;
    }
}
