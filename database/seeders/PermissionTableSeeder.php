<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
           'homepage',        
           'role-list','role-create','role-edit','role-delete',                   
           'env-list','env-create','env-edit','env-delete',           
           'hosting-type-list','hosting-type-create','hosting-type-edit','hosting-type-delete',                   
           'team-list','team-create','team-edit','team-delete', 
           'user-list','user-create','user-edit','user-delete',                   
           'hosting-list','hosting-create','hosting-edit','hosting-delete', 
           'app-list','app-create','app-edit','app-delete',                   
           'service-list','service-create','service-edit','service-delete', 
           'service-version-list','service-version-create','service-version-edit','service-version-delete',                   
           'service-version-dep-list','service-version-dep-create','service-version-dep-edit','service-version-dep-delete', 
           'app-instance-list','app-instance-create','app-instance-edit','app-instance-delete',                       
           'app-instance-dep-list','app-instance-dep-create','app-instance-dep-edit','app-instance-dep-delete',                              
        ];
   
        foreach ($permissions as $permission) {
             Permission::create(['name' => $permission]);
        }
    }
}
