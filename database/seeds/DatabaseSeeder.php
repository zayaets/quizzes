<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
//        $this->call(QuestionsTableSeeder::class);

        factory(\App\User::class, 2)->create()->each(function ($u) {
        $u->questions()->saveMany(factory(\App\Question::class, 3)->create()->each(function ($q) {
            $q->answers()->saveMany(factory(\App\Answer::class, 4)->create());
        }));
    });
    }
}
