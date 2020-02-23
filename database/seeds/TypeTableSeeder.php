<?php

use Illuminate\Database\Seeder;

class TypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $type = array(
        ['name' => 'Panel'],
        ['name' => 'Inverter'],
        ['name' => 'Kabel'],
        ['name' => 'Panel Meter'],
        ['name' => 'Trafo'],
        ['name' => 'Jasa'],
      );
      for ($i=0; $i < 6; $i++) {
        App\Type::create($type[$i]);
      }
    }
}
