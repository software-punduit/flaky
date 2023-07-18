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
    public function run(): void
    {
        //Define the roles and permissions

        $seeds = [
            User::SUPER_ADMIN => [
                'users.create,update,view,activate,deactivate',
                'restaurants.view,update,activate,deactivate'
            ],
            User::ADMIN => [
                'users.create,view',
                'restaurants.view,update,activate,deactivate'
            ],
            User::RESTUARANT_OWNER => [
                'restaurant-staff.create,update,view,activate,deactivate',
                'table.create,update,view',
                'menu.create,update,view'
            ],
            User::RESTUARANT_STAFF => [
                'table.view',
                'menu.view'
            ],
            User::CUSTOMERS => [
                'restaurants.create,update,view,activate,deactivate',
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
