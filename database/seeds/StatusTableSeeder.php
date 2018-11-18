<?php

use Illuminate\Database\Seeder;

class StatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('statuses')->insert([
          ['name' => 'Created'],
          ['name' => 'Open'],
          ['name' => 'In progress'],
          ['name' => 'Stopped'],
          ['name' => 'Closed'],
        ]);
    }
}
