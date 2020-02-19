<?php

use Illuminate\Database\Seeder;

class ProjectTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $faker = Faker\Factory::create('id_ID');
      for ($i=0; $i < 4; $i++) {
        $capacity = rand(1,5);
        $unit = (rand(0,1) == 0)?'MW':'KW';
        App\Project::create([
          'name' => 'PLTS Grid '.$capacity.' '.$unit.'p '.$faker->company,
          'location' => $faker->state,
          'capacity' => $capacity,
          'unit' => $unit,
          'company_id' => $i+1,
          'user_id' => '1',
        ]);
      }
    }
}
