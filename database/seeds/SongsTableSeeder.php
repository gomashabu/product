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
                'id' => 1,
                'title' => 'Heidenroslein',
                'artist_id' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 2,
                'title' => 'O cessate di piagarmi',
                'artist_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'title' => 'Heidenroslein',
                'artist_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 4,
                'title' => 'Son tutta duolo',
                'artist_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
        ]);
    }
}
