<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Reglas;
use Faker\Generator as Faker;
use Faker\Provider\Uuid;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(Reglas::class, function (Faker $faker) {

    return [
        'name' => 'Cumpleaños',
        'cod' => 'HB',
        'descripcion'=> 'Se podra hacer kudos a este tablero en la fecha de cumpleaños'
    ];
});
