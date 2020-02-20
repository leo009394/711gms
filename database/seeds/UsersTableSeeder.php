<?php

use Illuminate\Database\Seeder;
use \Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
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
            'name' => 'Gms 711 Admin',
            'email' =>'a@a.com',
            'password' => bcrypt('711L0v3r!'),
        ]);

        DB::table('users')->insert([
            'id' => 2,
            'name' => 'Gms 711 Owner',
            'email' =>'o@a.com',
            'password' => bcrypt('711L0v3r!'),
        ]);

        DB::table('users')->insert([
            'id' => 3,
            'name' => 'Gms 711 Owner',
            'email' =>'e@a.com',
            'password' => bcrypt('711L0v3r!'),
        ]);
    }
}
