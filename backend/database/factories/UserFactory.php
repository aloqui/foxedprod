<?php

use Faker\Generator as Faker;

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

$factory->define(App\User::class, function (Faker $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
        'confirmed' => false,
        'username' => $faker->unique()->safeEmail,
    ];
});


$factory->define(App\Reply::class, function ($faker) {
    return[
        'thread_id' => function (){
            return factory('App\Thread')->create()->id;
        },
        'user_id' => function (){
            return factory('App\User')->create()->id;
        },
        'body' => $faker->paragraph
    ];
});

$factory->define(App\Thread::class, function($faker) {
    return [
        'user_id' => function() {
            return factory('App\User')->create()->id;
        },
        'channel_id' => function () {
            return factory('App\Channel')->create()->id;
        },
        'title' => $faker->sentence,
        'body' => $faker->paragraph
    ];
});
$factory->define(App\Classroom::class, function($faker) {
    return [
        'user_id' => function() {
            return factory('App\User')->create()->id;
        },

        'name' => $faker->sentence,
        'body' => $faker->paragraph
    ];
});

$factory->define(App\Activity::class, function ($faker) {
    return[
        'classroom_id' => function (){
            return factory('App\Classroom')->create()->id;
        },
        'user_id' => function (){
            return factory('App\User')->create()->id;
        },
        'body' => $faker->paragraph
    ];
});
$factory->define(App\Reply::class, function ($faker) {
    return[
        'user_id' => function (){
            return factory('App\User')->create()->id;
        },
        'body' => $faker->paragraph
    ];
});

$factory->define(App\Score::class, function ($faker) {
    return[
        'activity_id' => function (){
            return factory('App\Activity')->create()->id;
        },
        'user_id' => function (){
            return factory('App\User')->create()->id;
        },
        'body' => $faker->paragraph
    ];
});
$factory->define(App\UserGroup::class, function ($faker) {
    return[
        'class_id' => function (){
            return factory('App\Activity')->create()->id;
        },
        'user_id' => function (){
            return factory('App\User')->create()->id;
        },
        'body' => $faker->paragraph
    ];
});
$factory->define(App\Channel::class, function($faker) {
    $name = $faker->word;
    return [
        'user_id' => function (){
            return factory('App\User')->create()->id;
        },
        'name' => $name,
        'slug' => $name,
        'user_id' => function (){
            return factory('App\User')->create()->id;
        }
    ];
});
$factory->define(\Illuminate\Notifications\DatabaseNotification::class, function($faker) {
    return [
        'id' => \Ramsey\Uuid\Uuid::uuid4()->toString(),
        'type' => 'App\Notifications\ThreadWasUpdated',
        'notifiable_id' => function() {
            return auth()->id() ?: factory('App\User')->create()->id;
        },
        'notifiable_type' => 'App\User',
        'data' => ['foo' => 'bar']
    ];
});