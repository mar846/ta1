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
      $faker = Faker\Factory::create('id_ID');
      for ($i=0; $i < 10 ; $i++) {
        App\Good::create([
          'name' => $faker->randomLetter,
          'qty' => 0,
          'unit_id' => rand(1,3),
        ]);
      }
    }
}
