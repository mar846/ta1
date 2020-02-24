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
      // for ($i=0; $i < 7; $i++) {
        App\Address::create([
          'company_id' => 1,
          'name' => 'billTo',
          'address' => 'Raya Genteng Lt. 2 Blok W No. 8, Surabaya',
          'phone' => '0812 2231 2328',
        ]);
      // }
    }
}
