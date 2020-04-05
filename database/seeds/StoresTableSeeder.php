<?php

use Illuminate\Database\Seeder;
use Ramsey\Uuid\Uuid;

class StoresTableSeeder extends Seeder
{
    /**
     * @throws Exception
     */
    public function run()
    {
        DB::table('stores')->insert([
            'id' => 1,
            'uuid' => Uuid::uuid4()->toString(),
            'name' => 'Tokyo',
            'phone' => '00000000',
            'address' => 'Tokyo',
            'owner_id' => 1
        ]);

        DB::table('stores')->insert([
            'id' => 2,
            'uuid' => Uuid::uuid4()->toString(),
            'name' => 'Osaka',
            'phone' => '00000001',
            'address' => 'Osaka',
            'owner_id' => 2
        ]);
    }
}
