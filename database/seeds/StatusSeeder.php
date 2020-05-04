<?php

use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statuses = \Illuminate\Support\Facades\DB::table('statuses')->insert([
            ['title' => 'published'],
            ['title' => 'draft'],
            ['title' => 'awaiting_approval'],
            ['title' => 'declined']
        ]);
    }
}
