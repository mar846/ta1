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
      // $faker = Faker\Factory::create('id_ID');
      // for ($i=0; $i < 4; $i++) {
        $company = App\Company::create([
          'name' => 'KA Bandung Battery',
          'type'=> 'supplier',
        ]);
      // }
    }
}
