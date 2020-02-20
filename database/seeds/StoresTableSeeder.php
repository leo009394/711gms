<?php

use Illuminate\Database\Seeder;

class StoresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'id' => 1,
            'name' => 'Tokyo',
            'phone' => '00000000',
            'address' => 'Tokyo',
            'owner_id' => 1
        ]);

        DB::table('users')->insert([
            'id' => 2,
            'name' => 'Osaka',
            'phone' => '00000001',
            'address' => 'Osaka',
            'owner_id' => 2
        ]);
    }
}
