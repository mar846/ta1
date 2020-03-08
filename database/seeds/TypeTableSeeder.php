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
        ['name' => 'PV Combiner'],
        ['name' => 'Sun Logger'],
      );
      foreach ($type as $key => $value) {
        App\Type::create($type[$key]);
      }
    }
}
