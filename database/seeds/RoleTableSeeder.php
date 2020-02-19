<?php

use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $role = array([
        'name' => 'Admin'
      ],[
        'name' => 'Surveyor'
      ],[
        'name' => 'SurveyorSPV'
      ],[
        'name' => 'Designer'
      ],[
        'name' => 'DesignerSPV'
      ],[
        'name' => 'Sale'
      ],[
        'name' => 'SaleSPV'
      ],[
        'name' => 'Purchasing'
      ],[
        'name' => 'PurchasingSPV'
      ],[
        'name' => 'ProjectManager'
      ]);
      for ($i=0; $i < 10; $i++) {
        App\Role::create($role[$i]);
      }
    }
}
