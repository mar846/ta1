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
      $user = array([
        'name' => 'admin',
        'email' => 'admin@admin.com',
        'password' => '$2y$10$Qw499iYixpzYzxvpsg5uuOAun6jNIlAZcV6S/TXXBYgR.42CBz.CG',
        'role_id' => '1'
      ],[
        'name' => 'surveyor',
        'email' => 'surveyor@surveyor.com',
        'password' => '$2y$10$Qw499iYixpzYzxvpsg5uuOAun6jNIlAZcV6S/TXXBYgR.42CBz.CG',
        'role_id' => '2'
      ],[
        'name' => 'surveyorSPV',
        'email' => 'surveyorSPV@surveyorSPV.com',
        'password' => '$2y$10$Qw499iYixpzYzxvpsg5uuOAun6jNIlAZcV6S/TXXBYgR.42CBz.CG',
        'role_id' => '3'
      ],[
        'name' => 'designer',
        'email' => 'designer@designer.com',
        'password' => '$2y$10$Qw499iYixpzYzxvpsg5uuOAun6jNIlAZcV6S/TXXBYgR.42CBz.CG',
        'role_id' => '4'
      ],[
        'name' => 'designerSPV',
        'email' => 'designerSPV@designerSPV.com',
        'password' => '$2y$10$Qw499iYixpzYzxvpsg5uuOAun6jNIlAZcV6S/TXXBYgR.42CBz.CG',
        'role_id' => '5'
      ],[
        'name' => 'sales',
        'email' => 'sales@sales.com',
        'password' => '$2y$10$Qw499iYixpzYzxvpsg5uuOAun6jNIlAZcV6S/TXXBYgR.42CBz.CG',
        'role_id' => '6'
      ],[
        'name' => 'salesSPV',
        'email' => 'salesSPV@salesSPV.com',
        'password' => '$2y$10$Qw499iYixpzYzxvpsg5uuOAun6jNIlAZcV6S/TXXBYgR.42CBz.CG',
        'role_id' => '7'
      ],[
        'name' => 'purchasing',
        'email' => 'purchasing@purchasing.com',
        'password' => '$2y$10$Qw499iYixpzYzxvpsg5uuOAun6jNIlAZcV6S/TXXBYgR.42CBz.CG',
        'role_id' => '8'
      ],[
        'name' => 'purchasingSPV',
        'email' => 'purchasingSPV@purchasingSPV.com',
        'password' => '$2y$10$Qw499iYixpzYzxvpsg5uuOAun6jNIlAZcV6S/TXXBYgR.42CBz.CG',
        'role_id' => '9'
      ],[
        'name' => 'projectManager',
        'email' => 'projectManager@projectManager.com',
        'password' => '$2y$10$Qw499iYixpzYzxvpsg5uuOAun6jNIlAZcV6S/TXXBYgR.42CBz.CG',
        'role_id' => '10'
      ]);
      for ($i=0; $i < 9 ; $i++) {
        App\User::create($user[$i]);
      }
    }
}
