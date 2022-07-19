<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SongsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('songs')->insert([
            [
                'title' => 'Heidenroslein',
                'artist_id' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'title' => 'O cessate di piagarmi',
                'artist_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Heidenroslein',
                'artist_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Son tutta duolo',
                'artist_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
        ]);
    }
}
