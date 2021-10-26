<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Checkout;
use Faker\Generator as Faker;

$factory->define(Checkout::class, function (Faker $faker) {
    return [
        'product_id'    =>  null,
        'pembeli_id'    =>  null,
        'penjual_id'    =>  null,
        'nama_pembeli'  =>  $faker->name,
        'first_name'    =>  $faker->firstName,
        'last_name'     =>  $faker->lastName,
        'alamat_tujuan' =>  $faker->address,
        'nomor_telp'    =>  $faker->phoneNumber,
        'lat_lon'       =>  '0.641936|122.823061',
        'catatan'       =>  $faker->sentence,
        'harga_produk'  =>  rand(1000, 10000),
        'total_transaksi' => rand(10000, 100000),
        'qty'           =>  rand(1, 10),
        'postal_code'   =>  $faker->postcode,
        'city'          =>  $faker->city,
        'email'         =>  $faker->email,
        'onkir'         =>  $faker->numberBetween(1000, 5000),
        'status'        =>  0,
    ];
});
