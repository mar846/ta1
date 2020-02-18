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
        'role' => 'Admin'
      ],[
        'name' => 'surveyor',
        'email' => 'surveyor@surveyor.com',
        'password' => '$2y$10$Qw499iYixpzYzxvpsg5uuOAun6jNIlAZcV6S/TXXBYgR.42CBz.CG',
        'role' => 'Surveyor'
      ],[
        'name' => 'surveyorSPV',
        'email' => 'surveyorSPV@surveyorSPV.com',
        'password' => '$2y$10$Qw499iYixpzYzxvpsg5uuOAun6jNIlAZcV6S/TXXBYgR.42CBz.CG',
        'role' => 'SurveyorSPV'
      ],[
        'name' => 'designer',
        'email' => 'designer@designer.com',
        'password' => '$2y$10$Qw499iYixpzYzxvpsg5uuOAun6jNIlAZcV6S/TXXBYgR.42CBz.CG',
        'role' => 'Designer'
      ],[
        'name' => 'designerSPV',
        'email' => 'designerSPV@designerSPV.com',
        'password' => '$2y$10$Qw499iYixpzYzxvpsg5uuOAun6jNIlAZcV6S/TXXBYgR.42CBz.CG',
        'role' => 'DesignerSPV'
      ],[
        'name' => 'sales',
        'email' => 'sales@sales.com',
        'password' => '$2y$10$Qw499iYixpzYzxvpsg5uuOAun6jNIlAZcV6S/TXXBYgR.42CBz.CG',
        'role' => 'Sale'
      ],[
        'name' => 'salesSPV',
        'email' => 'salesSPV@salesSPV.com',
        'password' => '$2y$10$Qw499iYixpzYzxvpsg5uuOAun6jNIlAZcV6S/TXXBYgR.42CBz.CG',
        'role' => 'SaleSPV'
      ],[
        'name' => 'purchasing',
        'email' => 'purchasing@purchasing.com',
        'password' => '$2y$10$Qw499iYixpzYzxvpsg5uuOAun6jNIlAZcV6S/TXXBYgR.42CBz.CG',
        'role' => 'Purchasing'
      ],[
        'name' => 'purchasingSPV',
        'email' => 'purchasingSPV@purchasingSPV.com',
        'password' => '$2y$10$Qw499iYixpzYzxvpsg5uuOAun6jNIlAZcV6S/TXXBYgR.42CBz.CG',
        'role' => 'PurchasingSPV'
      ],[
        'name' => 'projectManager',
        'email' => 'projectManager@projectManager.com',
        'password' => '$2y$10$Qw499iYixpzYzxvpsg5uuOAun6jNIlAZcV6S/TXXBYgR.42CBz.CG',
        'role' => 'ProjectManager'
      ]);
      for ($i=0; $i < 9 ; $i++) {
        App\User::create($user[$i]);
      }
    }
}
