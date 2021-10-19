<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Product;
use App\User;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    // 'user_id',
    // 'name',
    // 'price',
    // 'description',
    // 'stock',
    // 'location',
    // 'image'

    $name   =   [
        'Bayam', 'Kacang Ijo',
        'Andewi', 'Asam Jawa', 'Bawang', 'Brokoli',
        'Sawi', 'Wortel', 'Tomat', 'Kailan', 'Sinkong'
    ];

    $harga  =   [
        2000, 5000, 10000, 12000, 15000, 20000
    ];

    $user   =   factory(User::class)->create();

    return [
        'name'  =>  $name[rand(0, count($name) - 1)],
        'price' =>  $harga[rand(0, count($harga) - 1)],
        'user_id'  =>  $user->id,
        'description'   =>  $faker->sentence,
        'stock' =>  rand(0, 30),
        'location' => '0.642232|122.82399699999999',
        'image' =>  $faker->imageUrl(),
    ];
});
