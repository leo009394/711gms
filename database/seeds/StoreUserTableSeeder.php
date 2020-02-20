<?php

use Illuminate\Database\Seeder;

class StoreUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('role_user')->insert([
            'user_id' => 2,
            'store_id' => 1,
        ]);

        DB::table('role_user')->insert([
            'user_id' => 3,
            'store_id' => 1,
        ]);

        DB::table('role_user')->insert([
            'user_id' => 2,
            'store_id' => 2,
        ]);
    }
}
