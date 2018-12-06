<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    $faker->addProvider(new Faker\Provider\ro_RO\Address($faker));

    return [
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('123123'),
        'telefon' => $faker->numerify('+40 ### ### ###'),
        'nume' => $faker->firstName . ' ' . $faker->lastName,
        'adresa' => $faker->address
    ];
});

$factory->define(App\DonationOffer::class, function (Faker\Generator $faker) {

    $publish_date = $faker->dateTimeBetween('-10 years', 'now');

    $due_date = $faker->dateTimeBetween($publish_date, '+10 years');

    return [
        'data_publicare' => $publish_date,
        'data_limita' => $due_date,
        'descriere' => $faker->paragraph(random_int(1, 3)),
        'titlu' => $faker->word,
        'nr_bucati' => $faker->boolean(50) ? $faker->numberBetween(1, 100) : null,
        'greutate' => $faker->boolean(50) ? $faker->randomFloat(2, 0.01, 10000) : null,
        'user_id' => App\User::all()->random()->id,
        'fulfilled' => $faker->boolean(50)
    ];
});

$factory->define(App\DonationRequest::class, function (Faker\Generator $faker) {

    $publish_date = $faker->dateTimeBetween('-10 years', 'now');

    $due_date = $faker->dateTimeBetween($publish_date, '+10 years');

    return [
        'data_publicare' => $publish_date,
        'data_limita' => $due_date,
        'descriere' => $faker->paragraph(random_int(1, 3)),
        'titlu' => $faker->word,
        'user_id' => App\User::all()->random()->id,
        'fulfilled' => $faker->boolean(50)
    ];
});