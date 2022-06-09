<?php

namespace App\Http\Controllers;

use App\Post;
use App\User;
use App\Artist;
use App\Song;
use Illuminate\Http\Request;

class PostController extends Controller
{
      public function home(Post $post, Artist $artist, Song $song)
    {
        return view('home')->with(['posts' => $post->getNewByLimit(), 'artists' => $artist->get(), 'songs' => $song->get()]);
    }
}
