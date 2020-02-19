<?php

use Illuminate\Database\Seeder;

class CriteriaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $criteria = array([
        'name' => 'Capacity',
        'weight' => '3',
      ],[
        'name' => 'Price',
        'weight' => '4',
      ],[
        'name' => 'Qty',
        'weight' => '4',
      ]);
      for ($i=0; $i < 3; $i++) {
        App\Criteria::create($criteria[$i]);
      }
    }
}
