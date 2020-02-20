<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            'id' => 1,
            'name' => 'Admin',
            'display_name' =>'Gms 711 Admin',
            'description' => '',
        ]);

        DB::table('roles')->insert([
            'id' => 2,
            'name' => 'Owner',
            'display_name' =>'Gms 711 Owner',
            'description' => '',
        ]);

        DB::table('roles')->insert([
            'id' => 3,
            'name' => 'employee',
            'display_name' =>'Gms 711 employee',
            'description' => '',
        ]);
    }
}
