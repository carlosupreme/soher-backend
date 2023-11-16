<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\Work;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(RoleSeeder::class);
        User::create([
            'name' => env('ADMIN_USER'),
            'phone' => env('ADMIN_PHONE'),
            'email' => env('ADMIN_EMAIL'),
            'password' => env('ADMIN_PASSWORD')
        ])->syncRoles(Role::pluck('id')->toArray());
        Work::factory(3)->create();
    }
}
