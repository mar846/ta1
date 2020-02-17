<?php

use Illuminate\Database\Seeder;
use App\Unit;

class UnitTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $unit = array(['name' => 'unit'],['name' => 'pce'],['name' => 'm']);
      for ($i=0; $i < 3; $i++) {
        App\Unit::create($unit[$i]);
      }
    }
}
