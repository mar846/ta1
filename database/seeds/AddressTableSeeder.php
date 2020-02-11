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
      App\Address::create([
        'company_id' => '1',
        'name' => 'primary',
        'address' => $faker->address,
        'phone' => $faker->phoneNumber,
      ]);
    }
}
