<?php

use Illuminate\Database\Seeder;

class AddressTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $faker = Faker\Factory::create('id_ID');
      for ($i=0; $i < 7; $i++) {
        App\Address::create([
          'company_id' => rand(1,4),
          'name' => 'primary',
          'address' => $faker->address,
          'phone' => $faker->phoneNumber,
        ]);
      }
    }
}
