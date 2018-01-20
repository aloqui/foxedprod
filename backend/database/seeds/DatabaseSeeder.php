<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        factory(\App\User::class, 10) -> create();
        // $forums = factory(\App\Forum::class,20) -> create();
        // $forums->each(function ($forum) {
        //     factory('App\Reply',5)->create(['forum_id' => $forum -> id]);
        // });
        $threads = factory(\App\Thread::class, 20)-> create();
        $threads->each(function ($thread) {
            factory('App\Reply',5)->create(['thread_id' => $thread -> id]);
        });

      
    }
}
