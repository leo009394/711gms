<?php

use Illuminate\Database\Seeder;
use \Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class UsersTableSeeder extends Seeder
{
    /**
     * @throws Exception
     */
    public function run()
    {
        DB::table('users')->insert([
            'id' => 1,
            'uuid' => Uuid::uuid4()->toString(),
            'first_name' => 'Gms 711',
            'last_name' => 'Admin',
            'local_first_name' => 'Gms 711',
            'local_last_name' => 'Admin',
            'email' =>'a@a.com',
            'password' => bcrypt('711L0v3r!'),
        ]);

        DB::table('users')->insert([
            'id' => 2,
            'uuid' => Uuid::uuid4()->toString(),
            'first_name' => 'Gms 711',
            'last_name' => 'Owner',
            'local_first_name' => 'Gms 711',
            'local_last_name' => 'Owner',
            'email' =>'o@a.com',
            'password' => bcrypt('711L0v3r!'),
        ]);

        DB::table('users')->insert([
            'id' => 3,
            'uuid' => Uuid::uuid4()->toString(),
            'first_name' => 'Gms 711',
            'last_name' => 'employee',
            'local_first_name' => 'Gms 711',
            'local_last_name' => 'employee',
            'email' =>'e@a.com',
            'password' => bcrypt('711L0v3r!'),
        ]);
    }
}
