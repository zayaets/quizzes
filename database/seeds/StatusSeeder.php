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
            [
                'title' => 'Published',
                'slug' => 'published'
            ],
            [
                'title' => 'Draft',
                'slug' => 'draft'
            ],
            [
                'title' => 'Awaiting approval',
                'slug' => 'awaiting_approval'
            ],
            [
                'title' => 'Rejected',
                'slug' => 'rejected'
            ],
            [
                'title' => 'Hidden',
                'slug' => 'hidden'
            ],

        ]);
    }
}
