<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
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
        $role_admin = Role::where('name', 'adminsys')->first();
        $user = new User();
        $user->name = 'DEV';
        $user->email = 'dev@osesach';
        $user->password = bcrypt('secret');
        $user->person_id=1;
        $user->role_id=1;
        $user->save();
        $user->roles()->attach($role_admin);
    }
}
