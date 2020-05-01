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

        /*factory(\App\User::class, 2)->create()->each(function ($u) {
            $u->questions()->saveMany(factory(\App\Question::class, 3)->create()->each(function ($q) {
                $q->answers()->saveMany(factory(\App\Answer::class, 4)->create());
            }));
        });*/

        $adminRole = factory(\App\Role::class)->states('admin')->create();
        $userRole = factory(\App\Role::class)->states('user')->create();


        $admin = factory(\App\User::class)->create();
        $admin->roles()->attach($adminRole);

        $users = factory(\App\User::class, 20)->create();

        $users->each(function ($user) use ($userRole) {
            $user->roles()->attach($userRole);
        });

        $questions = factory(\App\Question::class, 10)->create([
            'user_id' => $users->random(1)->pluck('id')[0]
        ])->each(function ($q) use ($users) {
            $q->answers()->saveMany(factory(\App\Answer::class, 4)->create());
        });

    }
}
