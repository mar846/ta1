<?php

use Illuminate\Database\Seeder;

class CompanyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $faker = Faker\Factory::create();
      for ($i=0; $i < 21; $i++) {
        $rand = rand(0,1);
        $kind = ($rand == 0)?'supplier':'customer';
        $company = App\Company::create([
          'name' => $faker->company,
          'type'=> $kind,
        ]);
        for ($d=0; $d < 2 ; $d++) {
          $type = ($d == 0)?'home':'office';
          $address = App\Address::create([
            'company_id' => $company->id,
            'name' => $type,
            'address' => $faker->address,
            'phone' => $faker->randomNumber($nbDigits = NULL, $strict = false),
          ]);
        }
      }
    }
}
