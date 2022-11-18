<?php

namespace Database\Seeders;

use App\Models\Role;
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
        $role = new Role();
        $role->name = 'adminsys';
        $role->description = 'Administrador Sys';
        $role->save();
        $role = new Role();
        $role->name = 'admin';
        $role->description = 'Administrador';
        $role->save();
        $role = new Role();
        $role->name = 'agente';
        $role->description = 'Agente';
        $role->save();
        $role = new Role();
        $role->name = 'supervisor';
        $role->description = 'Supervisor';
        $role->save();
    }

}
