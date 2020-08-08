<?php
require_once 'vendor/autoload.php';

$faker = Faker\Factory::create('id_ID'); // create a French faker
$now = Carbon\Carbon::now();

$out = "INSERT INTO `users` (`name`, `email`, `password`, `telpon`, `level`, `token`, `created_at`, `updated_at`) VALUES ";
$values = [];
for ($i = 0; $i < 50; $i++) {
    $val = [
        $faker->username,
        $faker->email,
        password_hash('12345678', PASSWORD_BCRYPT),
        $faker->e164PhoneNumber,
        $faker->randomElement(['bendahara', 'admin']),
        null,
        $now,
        $now
    ];

    $values[] = "('" . implode("', '", $val) . "')";
}

$out .= implode(", ", $values);

echo ($out);