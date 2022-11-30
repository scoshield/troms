<?php

namespace Database\Seeders\Auth;

use App\Domains\Auth\Models\Permission;
use App\Domains\Auth\Models\Role;
use App\Domains\Auth\Models\User;
use Database\Seeders\Traits\DisableForeignKeys;
use Illuminate\Database\Seeder;

/**
 * Class PermissionRoleTableSeeder.
 */
class PermissionRoleSeeder extends Seeder
{
    use DisableForeignKeys;

    /**
     * Run the database seed.
     */
    public function run()
    {
        $this->disableForeignKeys();

        $admin = Role::updateOrCreate([
            'id' => 1,
            'type' => User::TYPE_ADMIN,
            'name' => 'Administrator',
        ]);

        $hbu = Role::updateOrCreate([
            'id' => 3,
            'type' => User::TYPE_ADMIN,
            'name' => 'HBU',
        ]);

        $hod = Role::updateOrCreate([
            'id' => 4,
            'type' => User::TYPE_ADMIN,
            'name' => 'HOD',
        ]);

        $transporter = Role::updateOrCreate([
            'id' => 5,
            'type' => User::TYPE_ADMIN,
            'name' => 'Transport Manager',
        ]);

        $ops = Role::updateOrCreate([
            'id' => 6,
            'type' => User::TYPE_ADMIN,
            'name' => 'OPs Control',
        ]);

        $com = Role::updateOrCreate([
            'id' => 7,
            'type' => User::TYPE_ADMIN,
            'name' => 'COM',
        ]);

        // Non Grouped Permissions
        Permission::updateOrCreate([
            'type' => User::TYPE_ADMIN,
            'name' => 'admin.access.dashboard',
            'description' => 'Access and view dashboard',
        ]);

        $users = Permission::updateOrCreate([
            'type' => User::TYPE_ADMIN,
            'name' => 'admin.access.user',
            'description' => 'All User Permissions',
        ]);


        $users->children()->saveMany([
            new Permission([
                'type' => User::TYPE_ADMIN,
                'name' => 'admin.access.user.list',
                'description' => 'View Users',
            ]),
            new Permission([
                'type' => User::TYPE_ADMIN,
                'name' => 'admin.access.user.deactivate',
                'description' => 'Deactivate Users',
                'sort' => 2,
            ]),
            new Permission([
                'type' => User::TYPE_ADMIN,
                'name' => 'admin.access.user.reactivate',
                'description' => 'Reactivate Users',
                'sort' => 3,
            ]),
            new Permission([
                'type' => User::TYPE_ADMIN,
                'name' => 'admin.access.user.clear-session',
                'description' => 'Clear User Sessions',
                'sort' => 4,
            ]),
            new Permission([
                'type' => User::TYPE_ADMIN,
                'name' => 'admin.access.user.impersonate',
                'description' => 'Impersonate Users',
                'sort' => 5,
            ]),
            new Permission([
                'type' => User::TYPE_ADMIN,
                'name' => 'admin.access.user.change-password',
                'description' => 'Change User Passwords',
                'sort' => 6,
            ]),
        ]);

        $rcns = Permission::updateOrCreate([
            'type' => User::TYPE_ADMIN,
            "name" => "admin.access.rcns",
            'description' => "Access and view all rcns"
        ]);

        $rcns->children()->saveMany([
            new Permission([
                'type' => User::TYPE_ADMIN,
                'name' => 'admin.access.user',
                'description' => 'All User Permissions',
            ]),

            new Permission([
                'type' => User::TYPE_ADMIN,
                'name' => 'admin.access.rcns.list',
                'description' => 'View all rcns',
            ]),


            new Permission([
                'type' => User::TYPE_ADMIN,
                'name' => 'admin.access.rcns.create',
                'description' => 'Create manual rcn',
                'sort' => 2,
            ]),
            new Permission([
                'type' => User::TYPE_ADMIN,
                'name' => 'admin.access.rcns.attach_invoice',
                'description' => 'Attach invoice to rcn',
                'sort' => 3,
            ]),
            new Permission([
                'type' => User::TYPE_ADMIN,
                'name' => 'admin.access.rcns.upload_rcn',
                'description' => 'Upload rcns',
                'sort' => 4,
            ]),
            new Permission([
                'type' => User::TYPE_ADMIN,
                'name' => 'admin.access.rcns.approve_rcn',
                'description' => 'Approve rcn',
                'sort' => 5,
            ]),
            new Permission([
                'type' => User::TYPE_ADMIN,
                'name' => 'admin.access.rcns.add_recovery_invoice',
                'description' => 'Attach recovery invoice',
                'sort' => 5,
            ]),
            new Permission([
                'type' => User::TYPE_ADMIN,
                'name' => 'admin.access.rcns.invoices',
                'description' => 'View invoices',
                'sort' => 5,
            ]),
            new Permission([
                'type' => User::TYPE_ADMIN,
                'name' => 'admin.access.rcns.recovery_invoices',
                'description' => 'View recovery invoices',
                'sort' => 5,
            ])
        ]);

        $this->enableForeignKeys();
    }
}
