<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ArtistsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('artists')->insert([
            [
                'id' => 1,
                'name' => 'Franz Schubert',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 2,
                'name' => 'Alessandro Scarlatti',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'name' => 'Heinrich Werner',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
