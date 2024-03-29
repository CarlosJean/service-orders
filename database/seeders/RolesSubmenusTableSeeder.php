<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesSubmenusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        //Administrador de sistema
        DB::table('role_submenu')->insert([
            'role_id' => 1,
            'submenu_id' => 1,
        ]);
        DB::table('role_submenu')->insert([
            'role_id' => 1,
            'submenu_id' => 2,
        ]);
        DB::table('role_submenu')->insert([
            'role_id' => 1,
            'submenu_id' => 3,
        ]);

        DB::table('role_submenu')->insert([
            'role_id' => 1,
            'submenu_id' => 7,
        ]);
        DB::table('role_submenu')->insert([
            'role_id' => 1,
            'submenu_id' => 8,
        ]);
        DB::table('role_submenu')->insert([
            'role_id' => 1,
            'submenu_id' => 10,
        ]);
        DB::table('role_submenu')->insert([
            'role_id' => 1,
            'submenu_id' => 11,
        ]);
        DB::table('role_submenu')->insert([
            'role_id' => 1,
            'submenu_id' => 12,
        ]);
        DB::table('role_submenu')->insert([
            'role_id' => 1,
            'submenu_id' => 4,
        ]);
        DB::table('role_submenu')->insert([
            'role_id' => 1,
            'submenu_id' => 16,
        ]);

        //Supervisor
        DB::table('role_submenu')->insert([
            'role_id' => 2,
            'submenu_id' => 1,
        ]);
        DB::table('role_submenu')->insert([
            'role_id' => 2,
            'submenu_id' => 4,
        ]);
        DB::table('role_submenu')->insert([
            'role_id' => 2,
            'submenu_id' => 6,
        ]);
        DB::table('role_submenu')->insert([
            'role_id' => 2,
            'submenu_id' => 11,
        ]);
        DB::table('role_submenu')->insert([
            'role_id' => 2,
            'submenu_id' => 13,
        ]);

        DB::table('role_submenu')->insert([
            'role_id' => 2,
            'submenu_id' => 16,
        ]);

        //Gerente
        DB::table('role_submenu')->insert([
            'role_id' => 3,
            'submenu_id' => 1,
        ]);
        DB::table('role_submenu')->insert([
            'role_id' => 3,
            'submenu_id' => 4,
        ]);
        DB::table('role_submenu')->insert([
            'role_id' => 3,
            'submenu_id' => 6,
        ]);
        DB::table('role_submenu')->insert([
            'role_id' => 3,
            'submenu_id' => 11,
        ]);
        DB::table('role_submenu')->insert([
            'role_id' => 3,
            'submenu_id' => 13,
        ]);
        DB::table('role_submenu')->insert([
            'role_id' => 3,
            'submenu_id' => 16,
        ]);
        
        //Supervisor/Gerente de cualquier departamento
        DB::table('role_submenu')->insert([
            'role_id' => 4,
            'submenu_id' => 1,
        ]);
        DB::table('role_submenu')->insert([
            'role_id' => 4,
            'submenu_id' => 13,
        ]);
        DB::table('role_submenu')->insert([
            'role_id' => 5,
            'submenu_id' => 1,
        ]);
        DB::table('role_submenu')->insert([
            'role_id' => 5,
            'submenu_id' => 13,
        ]);

        //Técnico
        DB::table('role_submenu')->insert([
            'role_id' => 6,
            'submenu_id' => 1,
        ]);
        DB::table('role_submenu')->insert([
            'role_id' => 6,
            'submenu_id' => 13,
        ]);

        //Operador almacén
        DB::table('role_submenu')->insert([
            'role_id' => 7,
            'submenu_id' => 1,
        ]);
        DB::table('role_submenu')->insert([
            'role_id' => 7,
            'submenu_id' => 5,
        ]);
        DB::table('role_submenu')->insert([
            'role_id' => 7,
            'submenu_id' => 6,
        ]);
        DB::table('role_submenu')->insert([
            'role_id' => 7,
            'submenu_id' => 7,
        ]);
        DB::table('role_submenu')->insert([
            'role_id' => 7,
            'submenu_id' => 8,
        ]);
        DB::table('role_submenu')->insert([
            'role_id' => 7,
            'submenu_id' => 9,
        ]);
        DB::table('role_submenu')->insert([
            'role_id' => 7,
            'submenu_id' => 10,
        ]);
        DB::table('role_submenu')->insert([
            'role_id' => 7,
            'submenu_id' => 14,
        ]);
        DB::table('role_submenu')->insert([
            'role_id' => 7,
            'submenu_id' => 15,
        ]);

        DB::table('role_submenu')->insert([
            'role_id' => 7,
            'submenu_id' => 16,
        ]);

        
    }
}
