<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(PostsTableSeeder::class);
        $this->call(ArtistsTableSeeder::class);
        $this->call(SongsTableSeeder::class);
        $this->call(CommentsTableSeeder::class);
        $this->call(ClaimsTableSeeder::class);
        $this->call(LikesTableSeeder::class);
    }
}