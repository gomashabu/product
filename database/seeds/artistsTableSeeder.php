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
                'name' => 'Franz Schubert',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Alessandro Scarlatti',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Heinrich Werner',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
