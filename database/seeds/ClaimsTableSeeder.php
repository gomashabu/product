<?php

use Illuminate\Database\Seeder;

class ClaimsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('claims')->insert([
            [
                'claim' => "AmではなくAm7では？",
                'row_number' => '2',
                'post_id' => 1,
                'user_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'claim' => "歌詞が間違ってる",
                'row_number' => '1',
                'post_id' => 1,
                'user_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'claim' => "コードの切り替わるタイミングが違う",
                'row_number' => '2',
                'post_id' => 1,
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
        ]);
    }
}
