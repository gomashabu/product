<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        \DB::table('users')->insert([
            [
                'id' => 1,
                'name' => 'asdf',
                'email' => 'asdf@gmail.com',
                'email_verified_at' => now(),
                'password' => bcrypt('asdf@gmail.com'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'name' => 'zxcv',
                'email' => 'zxcv@gmail.com',
                'email_verified_at' => now(),
                'password' => bcrypt('zxcv@gmail.com'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
