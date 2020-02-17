<?php

use Illuminate\Database\Seeder;

class UnitTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $unit = ['unit','pce','m'];
      for ($i=0; $i < 3; $i++) {
        App\Unit::create([
          'name' => $unit[$i],
        ]);
      }
    }
}
