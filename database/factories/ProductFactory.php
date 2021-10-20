<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Product;
use App\User;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {

    $name   =   [
        'Bayam', 'Kacang Ijo', 'Lodeh', 'Tomat', 'Buncis',
        'Andewi', 'Asam Jawa', 'Bawang', 'Brokoli', 'Daun Seledri',
        'Sawi', 'Wortel', 'Tomat', 'Jagung', 'Sinkong', 'Kangkung'
    ];

    $harga  =   [
        2000, 5000, 10000, 12000, 15000, 20000
    ];

    $locations = [
        '0.642232|122.82399699999999',
        '0.642132|122.82399699999999',
        '0.592232|122.82399699999999',
        '0.672232|122.82399699999999',
        '0.642232|122.82389699999999',
        '0.643418|122.84399699999999'
    ];

    $user   =   factory(User::class)->create();

    return [
        'name'  =>  $name[rand(0, count($name) - 1)],
        'price' =>  $harga[rand(0, count($harga) - 1)],
        'user_id'  =>  $user->id,
        'description'   =>  $faker->sentence,
        'stock' =>  rand(0, 30),
        'location' => $locations[rand(0, count($locations) - 1)],
        'image' =>  $faker->imageUrl(),
    ];
});
