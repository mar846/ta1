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
      $type = array(['name' => 'Panel'],['name' => 'Inverter'] );
      for ($i=0; $i < 2; $i++) {
        App\Type::create($type[$i]);
      }
    }
}
