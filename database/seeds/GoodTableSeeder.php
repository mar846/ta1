<?php

use Illuminate\Database\Seeder;

class GoodTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $good = array([
        'name' => 'Solar Panel 200Wp',
        'qty' => 0,
        'unit_id' => rand(1,3),
        ],[
        'name' => 'Inverter 1 KW',
        'qty' => 0,
        'unit_id' => rand(1,3),
        ],[
        'name' => 'PV Combiner',
        'qty' => 0,
        'unit_id' => rand(1,3),
        ],[
        'name' => 'Sun Logger',
        'qty' => 0,
        'unit_id' => rand(1,3),
        ],[
        'name' => 'Panel AC PDB',
        'qty' => 0,
        'unit_id' => rand(1,3),
        ],[
        'name' => 'Panel Metering',
        'qty' => 0,
        'unit_id' => rand(1,3),
        ],[
        'name' => 'Kabel PV Fleksible 4 mm',
        'qty' => 0,
        'unit_id' => rand(1,3),
        ]);
      foreach ($good as $key => $value) {
        App\Good::create($value);
      }
    }
}
