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
      App\Project::create([
        'name' => 'PLTS Grid 1MWp '.$faker->company,
        'location' => $faker->state,
        'company_id' => '1',
        'user_id' => '1',
      ]);
    }
}
