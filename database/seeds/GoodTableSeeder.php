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
        'price' => rand(1,5).rand(5,8).rand(3,6),
        'capacity' => '200',
        'type' => 'Panel',
        ],[
        'name' => 'Solar Panel 250Wp',
        'qty' => 0,
        'unit_id' => rand(1,3),
        'price' => rand(1,5).rand(5,8).rand(3,6),
        'capacity' => '250',
        'type' => 'Panel',
        ],[
        'name' => 'Solar Panel 280Wp',
        'qty' => 0,
        'unit_id' => rand(1,3),
        'price' => rand(1,5).rand(5,8).rand(3,6),
        'capacity' => '280',
        'type' => 'Panel',
        ],[
        'name' => 'Solar Panel 300Wp',
        'qty' => 0,
        'unit_id' => rand(1,3),
        'price' => rand(1,5).rand(5,8).rand(3,6),
        'capacity' => '300',
        'type' => 'Panel',
        ],[
        'name' => 'Inverter 1 KW',
        'qty' => 0,
        'unit_id' => rand(1,3),
        'price' => rand(1,5).rand(5,8).rand(3,6).rand(1,5).rand(1,8),
        'capacity' => '1000',
        ],[
        'name' => 'PV Combiner',
        'qty' => 0,
        'unit_id' => rand(1,3),
        'price' => rand(1,5).rand(5,8).rand(3,6).'0000',
        ],[
        'name' => 'Sun Logger',
        'qty' => 0,
        'unit_id' => rand(1,3),
        'price' => rand(1,5).rand(5,8).rand(3,6).'0000',
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
