<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionsDemoSeeder extends Seeder
{
    /**
     * Create the initial roles and permissions.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'edit-events']);
        Permission::create(['name' => 'delete-events']);
        Permission::create(['name' => 'publish-events']);
        Permission::create(['name' => 'unpublish-events']);

        // create roles and assign existing permissions
        $role1 = Role::create(['name' => 'writer']);
        $role1->givePermissionTo('edit-events');
        $role1->givePermissionTo('delete-events');

        $role2 = Role::create(['name' => 'admin']);
        $role2->givePermissionTo('publish-events');
        $role2->givePermissionTo('unpublish-events');

        $role3 = Role::create(['name' => 'super-admin']);
        // gets all permissions via Gate::before rule; see AuthServiceProvider

        // create demo users
        $user = User::factory()->create([
                                                        'name' => 'Example User',
                                                        'email' => 'test@example.com',
                                                        'group_id' => 1,
                                                        'color' => '#FFFFFF',
                                                    ]);
        $user->assignRole($role1);

        $user = User::factory()->create([
                                                        'name' => 'Example Admin User',
                                                        'email' => 'admin@example.com',
                                                        'group_id' => 1,
                                                        'color' => '#FFFFFF',
                                                    ]);
        $user->assignRole($role2);

        $user = User::factory()->create([
                                                        'name' => 'Example Super-Admin User',
                                                        'email' => 'superadmin@example.com',
                                                        'color' => '#FFFFFF',
                                                    ]);
        $user->assignRole($role3);
    }
}
