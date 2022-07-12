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
                'score_type' => "Lyrics with chords",
                'lyrics_with_chords' =>  "Let it [Am]be, let it [C/G]be, let it [F]be, let it [C]be
            [C]Whisper words of [G]wisdom, let it [F]be [C/E] [Dm] [C]",
                'flat_score' => '',
                'song_id' => 1,
                'artist_id' => 1,
                'user_id' => 1,
                'key' => 'C',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'score_type' => "Lyrics with chords",
                'lyrics_with_chords' => "load[Am] up on guns",
                'flat_score' => '',
                'song_id' => 2,
                'artist_id' => 2,
                'user_id' => 1,
                'key' => 'C',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'score_type' => "Lyrics with chords",
                'lyrics_with_chords' => "load up on guns and",
                'flat_score' => '',
                'song_id' => 2,
                'artist_id' => 2,
                'user_id' => 2,
                'key' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 4,
                'score_type' => "Lyrics with chords",
                'lyrics_with_chords' => "load up on guns and",
                'flat_score' => '',
                'song_id' => 3,
                'artist_id' => 3,
                'user_id' => 2,
                'key' => 'C',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 5,
                'score_type' => "Flat score",
                'lyrics_with_chords' => "",
                'flat_score' => '<iframe src="https://flat.io/embed/62ad7723aa96a10013152fe7?_l=true&sharingKey=ed9970f42ffd7c64e2c85809e001408b3b30f2efba2fedbbb492ed6fe02e6fbcb33c4cddc816e87165f8184d838a89027d850e22ab852f0a8ef33e699065723b" height="450" width="750" frameBorder="0" allowfullscreen></iframe>
<div style="font-size: 11px; color: #3981FF;line-break: anywhere;word-break: normal;overflow: hidden;white-space: nowrap;text-overflow: ellipsis; font-family: Inter, Helvetica Neue, Helvetica, Arial, sans-serif,sans-serif;margin-top: 4px">View on <a href="https://flat.io" target="_blank" style="color: #3981FF; text-decoration: none;" title="Music notation software">Flat</a>: <a href="https://flat.io/score/62ad7723aa96a10013152fe7?sharingKey=ed9970f42ffd7c64e2c85809e001408b3b30f2efba2fedbbb492ed6fe02e6fbcb33c4cddc816e87165f8184d838a89027d850e22ab852f0a8ef33e699065723b" target="_blank" style="color: #3981FF; text-decoration: none;">Son tutta duolo</a></div>',
                'song_id' => 4,
                'artist_id' => 4,
                'user_id' => 2,
                'key' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]
            
        ]);
    }
}
