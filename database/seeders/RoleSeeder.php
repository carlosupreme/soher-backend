<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = Role::create(['name' => 'admin']);
        $worker = Role::create(['name' => 'worker']);
        $client = Role::create(['name' => 'client']);

        // As a Worker I can view a list of works assigned,
        // view each work,
        // and rate the clients I worked with
        Permission::create(['name' => 'work.assignedIndex'])->assignRole($worker);
        Permission::create(['name' => 'work.assigned'])->assignRole($worker);
        Permission::create(['name' => 'client.rate'])->assignRole($worker);

        //As a Client I can create, edit, archive and view a single work,
        // view a list of all my created works
        // and rate the workers I worked with
        Permission::create(['name' => 'work.create'])->assignRole($client);
        Permission::create(['name' => 'work.edit'])->assignRole($client);
        Permission::create(['name' => 'work.archive'])->assignRole($client);
        Permission::create(['name' => 'work.show'])->assignRole($client);
        Permission::create(['name' => 'work.myworks'])->assignRole($client);
        Permission::create(['name' => 'worker.rate'])->assignRole($client);

        // As an Admin I can CRUD Users,
        // View a list of all works,
        // View work details, block or delete a work
        // assign a worker to a work
        Permission::create(['name' => 'work.index'])->assignRole($admin);
        Permission::create(['name' => 'work.delete'])->assignRole($admin);
        Permission::create(['name' => 'work.details'])->assignRole($admin);

        Permission::create(['name' => 'work.assign'])->assignRole($admin);

        Permission::create(['name' => 'user.index'])->assignRole($admin);
        Permission::create(['name' => 'user.create'])->assignRole($admin);
        Permission::create(['name' => 'user.edit'])->assignRole($admin);
        Permission::create(['name' => 'user.delete'])->assignRole($admin);
    }
}
