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
                'score' =>  "  F       Em7          A7              Dm     Dm/C
                            Yesterday,  all my troubles seemed so far away
                            Bb       C7                    F            F/E Dm   G7       Bb F F
                            Now it looks as though they're here to stay, oh I believe in yesterday
                             F        Em7      A7             Dm         Dm/C
                            Suddenly, I'm not half the man I used to be
                            Bb         C7             F        F/E Dm   G7       Bb F F
                             There's a shadow hanging over me, oh yesterday came suddenly
                            Em7 A7   Dm  Dm/C Bb         Gm         C        F
                            Why she  had to   go I don't know, she wouldn't say
                            Em7 A7   Dm  Dm/C  Bb           Gm        C     F
                            I   said something wrong, now I long for yesterday
                            F       Em7         A7           Dm          Dm/C
                            Yesterday, love was such an easy game to play
                            Bb      C7             F          F/E Dm   G7      Bb F F
                             Now I need a place to hide away, oh I believe in yesterday
                            Em7 A7   Dm  Dm/C Bb           Gm        C       F
                             Why she  had to   go I don't know, she wouldn't say
                            Em7 A7   Dm  Dm/C  Bb           Gm        C     F
                            I   said something wrong, now I long for yesterday
                             F        Em7        A7           Dm           Dm/C
                            Yesterday, love was such an easy game to play
                            Bb      C7             F          F/E Dm   G7      Bb F F
                             Now I need a place to hide away, oh I believe in yesterday
                             Dm    G7    Bb F  F
                            mm mm mm mm mm mm mmmmmmmmm",
                'song_id' => 1,
                'user_id' => 1,
                'artist_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'score' => "load up on guns",
                'song_id' => 2,
                'user_id' => 1,
                'artist_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'score' => "load up on guns and",
                'song_id' => 2,
                'user_id' => 2,
                'artist_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
