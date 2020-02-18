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
        App\Project::create([
          'name' => 'PLTS Grid '.rand(1,5).'MWp '.$faker->company,
          'location' => $faker->state,
          'company_id' => $i+1,
          'user_id' => '1',
        ]);
      }
    }
}
