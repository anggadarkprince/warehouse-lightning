<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::firstOrCreate(
            ['permission' => Permission::ROLE_VIEW],
            ['description' => 'View user role data', 'module' => 'user-access', 'feature' => 'role']
        );
        Permission::firstOrCreate(
            ['permission' => Permission::ROLE_CREATE],
            ['description' => 'Create user role data', 'module' => 'user-access', 'feature' => 'role']
        );
        Permission::firstOrCreate(
            ['permission' => Permission::ROLE_EDIT],
            ['description' => 'Edit user role data', 'module' => 'user-access', 'feature' => 'role']
        );
        Permission::firstOrCreate(
            ['permission' => Permission::ROLE_DELETE],
            ['description' => 'Delete user role data', 'module' => 'user-access', 'feature' => 'role']
        );

        Permission::firstOrCreate(
            ['permission' => Permission::USER_VIEW],
            ['description' => 'View user account data', 'module' => 'user-access', 'feature' => 'user']
        );
        Permission::firstOrCreate(
            ['permission' => Permission::USER_CREATE],
            ['description' => 'Create user account data', 'module' => 'user-access', 'feature' => 'user']
        );
        Permission::firstOrCreate(
            ['permission' => Permission::USER_EDIT],
            ['description' => 'Edit user account data', 'module' => 'user-access', 'feature' => 'user']
        );
        Permission::firstOrCreate(
            ['permission' => Permission::USER_DELETE],
            ['description' => 'Delete user account data', 'module' => 'user-access', 'feature' => 'user']
        );

        Permission::firstOrCreate(
            ['permission' => Permission::ACCOUNT_EDIT],
            ['description' => 'Edit account data', 'module' => 'preferences', 'feature' => 'account']
        );
        Permission::firstOrCreate(
            ['permission' => Permission::SETTING_EDIT],
            ['description' => 'Delete order data', 'module' => 'preferences', 'feature' => 'setting']
        );

    }
}
