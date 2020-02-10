<?php

use Illuminate\Database\Seeder;

class ChecklistTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $faker = Faker\Factory::create();
      for ($i=0; $i < 10; $i++) {
        App\Checklist::create([
          'user_id' => '1',
          'question' => $faker->randomLetter,
        ]);
      }
    }
}
