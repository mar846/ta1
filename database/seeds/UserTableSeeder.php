<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\User::create([
          'name' => 'admin',
          'email' => 'admin@admin.com',
          'password' => '$2y$10$Qw499iYixpzYzxvpsg5uuOAun6jNIlAZcV6S/TXXBYgR.42CBz.CG',
          'role' => 'Admin',
        ]);
    }
}
