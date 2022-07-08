<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        \DB::table('posts')->insert([
            [
                'id' => 1,
                'score' =>  "Let it [Am]be, let it [C/G]be, let it [F]be, let it [C]be
            [C]Whisper words of [G]wisdom, let it [F]be [C/E] [Dm] [C]",
                'song_id' => 1,
                'artist_id' => 1,
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'score' => "load[Am] up on guns",
                'song_id' => 2,
                'artist_id' => 2,
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'score' => "load up on guns and",
                'song_id' => 2,
                'artist_id' => 2,
                'user_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 4,
                'score' => "load up on guns and",
                'song_id' => 3,
                'artist_id' => 3,
                'user_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
        ]);
    }
}
