<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RoleTableSeeder::class);
        $this->call(UserTableSeeder::class);
        $this->call(ChecklistTableSeeder::class);
        $this->call(CompanyTableSeeder::class);
        $this->call(AddressTableSeeder::class);
        // $this->call(ProjectTableSeeder::class);
        $this->call(UnitTableSeeder::class);
        $this->call(TypeTableSeeder::class);
        // $this->call(GoodTableSeeder::class);
        $this->call(CriteriaTableSeeder::class);
    }
}
