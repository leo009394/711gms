<?php

use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->insert([
            'id' => 1,
            'name' => 'list-user',
            'display_name' =>'list-user',
            'description' => '',
        ]);

        DB::table('permissions')->insert([
            'id' => 2,
            'name' => 'create-user',
            'display_name' =>'create-user',
            'description' => '',
        ]);

        DB::table('permissions')->insert([
            'id' => 3,
            'name' => 'show-user',
            'display_name' =>'show-user',
            'description' => '',
        ]);

        DB::table('permissions')->insert([
            'id' => 4,
            'name' => 'update-user',
            'display_name' =>'list-user',
            'description' => '',
        ]);

        DB::table('permissions')->insert([
            'id' => 5,
            'name' => 'list-store',
            'display_name' =>'list-user',
            'description' => '',
        ]);

        DB::table('permissions')->insert([
            'id' => 6,
            'name' => 'create-store',
            'display_name' =>'create-user',
            'description' => '',
        ]);

        DB::table('permissions')->insert([
            'id' => 7,
            'name' => 'show-user',
            'display_name' =>'show-user',
            'description' => '',
        ]);

        DB::table('permissions')->insert([
            'id' => 8,
            'name' => 'update-user',
            'display_name' =>'list-user',
            'description' => '',
        ]);

    }
}
