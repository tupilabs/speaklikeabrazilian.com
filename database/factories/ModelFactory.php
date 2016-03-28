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

$factory->define(SLBR\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});

$factory->define(SLBR\Models\Expression::class, function (Faker\Generator $faker) {
    $word = $faker->unique()->word;
    return [
        'text' => $word,
        'char' => strtoupper($word[0]),
        'contributor' => $faker->name
    ];
});

$factory->define(SLBR\Models\Definition::class, function (Faker\Generator $faker) {
    return [
        'expression_id' => 1,
        'description' => $faker->realText(50) . ' [testing]',
        'example' => $faker->realText(25) . ' [testing]',
        'tags' => sprintf('%s, %s', $faker->word, $faker->word),
        'status' => 2,
        'email' => $faker->email,
        'contributor' => $faker->name,
        'language_id' => 1,
        'user_ip' => $faker->ipv4
    ];
});

$factory->define(SLBR\Models\Media::class, function (Faker\Generator $faker) {
    $url = '';
    $type = '';
    if ((bool)random_int(0, 1))
    {
        $url = 'http://i.imgur.com/D1J7DRu.gif';
        $type = 'image/gif';
    }
    else
    {
        $url = 'http://www.youtube.com/watch?v=Zma5l0_2HAY';
        $type = 'video/youtube';
    }
    return [
        'url' => $url,
        'reason' => $faker->realText(35),
        'email' => $faker->email,
        'status' => $faker->numberBetween(1,2),
        'content_type' => $type,
        'contributor' => $faker->name,
        'definition_id' => 1,
        'user_ip' => $faker->ipv4
    ];
});

$factory->define(SLBR\Models\Rating::class, function (Faker\Generator $faker) {
    return [
        'user_ip' => $faker->ipv4,
        'rating' => array_rand(array(1, -1)),
        'definition_id' => 1
    ];
});
