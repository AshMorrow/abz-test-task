<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Employees;
use Faker\Generator as Faker;

$factory->define(Employees::class, function (Faker $faker) {
    $admin_user = App\User::first();
    $position = App\Position::inRandomOrder()->first();

    return [
        'name' => $faker->name,
        'phone' => $faker->unique()->tollFreePhoneNumber,
        'email' => $faker->unique()->safeEmail,
        'salary' => $faker->randomFloat($nbMaxDecimals = 3, $min = 0, $max = 500,000),
        'position_id' => $position,
        'admin_updated_id' => $admin_user,
        'admin_created_id' => $admin_user
    ];
});

$factory->afterCreating(Employees::class, function($employees) {
    // bad and slow design... but work for me
    $employees->head_id = App\Employees::where('id', '!=', $employees->id)->inRandomOrder()->first()->id;
    $employees->save();
});
