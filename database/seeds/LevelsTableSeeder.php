<?php

use Illuminate\Database\Seeder;

class LevelsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('levels')->insert([
          ['name' => 'Low', 'color' => '#229A43'],
          ['name' => 'Medium', 'color' => '#FECC0C'],
          ['name' => 'High', 'color' => '#C50000'],
        ]);
    }
}
