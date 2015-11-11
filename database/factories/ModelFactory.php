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

$factory->define(App\Email::class, function (Faker\Generator $faker) {
  return ['email' => $faker->email];
});

$factory->defineAs(App\Email::class, 'invite', function ($faker) use ($factory) {
  $email = $factory->raw(App\Email::class);
  return array_merge($email, ['key' => $faker->uuid]);
});

$factory->define(App\Contact::class, function (Faker\Generator $faker) {
  return ['email' => $faker->email, 'message' => $faker->paragraph];
});

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'company_name' => $faker->company,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});

$factory->defineAs(App\User::class, 'admin', function ($faker) use ($factory) {
  $user = $factory->raw(App\User::class);
  return array_merge($user, ['is_admin' => true]);
});

$factory->define(App\Client::class, function (Faker\Generator $faker) {
  return ['name' => $faker->company, 'email' => $faker->email];
});

$factory->define(App\Invoice::class, function (Faker\Generator $faker) {
  return [
    'number' => $faker->randomNumber(2),
    'description' => $faker->paragraph,
    'due_date' => $faker->dateTimeBetween('now', '+1 year')->format('Y-m-d'),
    'sent_date' => $faker->date,
    'published' => true
  ];
});

$factory->defineAs(App\Invoice::class, 'stub', function ($faker) use ($factory) {
  $invoice = $factory->raw(App\Invoice::class);
  return array_diff_key($invoice, array_flip(['sent_date', 'published']));
});

$factory->define(App\LineItem::class, function (Faker\Generator $faker) {
  return [
    'description' => $faker->sentence,
    'quantity' => $faker->randomNumber,
    'unit_price' => $faker->randomNumber(2)
  ];
});

$factory->define(App\TaxItem::class, function (Faker\Generator $faker) {
  return [
    'description' => $faker->word,
    'percentage' => $faker->randomNumber(1)
  ];
});
