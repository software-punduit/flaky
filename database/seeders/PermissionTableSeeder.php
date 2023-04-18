<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @return void
     */
    public function run():void
    {
        //Define the roles and permissions

        $seeds = [
            User::ADMIN => [
                'users.create.*',
                'users.view.*',
            ],
            User::SUPER_ADMIN => [
               
            ],
            User::RESTUARANT_OWNER => [
                'restuarant-staff.*',
            ],
            User::RESTUARANT_STAFF => [
            ],
            User::CUSTOMERS => [
                'restuarant.*',
            ],
        ];
        //Populate the database roles
        //and permissions

        foreach ($seeds as $roleName => $permissionNames) {
            $role = Role::firstOrCreate([
             'name' => $roleName  
            ]);

            foreach ($permissionNames as $permissionName) {
                Permission::firstOrCreate([
                    'name' => $permissionName
                ]);
            }
            $role->syncPermissions($permissionNames);
        }
    }
}
