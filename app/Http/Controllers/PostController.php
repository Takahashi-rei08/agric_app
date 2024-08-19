<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Action;
use App\Models\Calendar;
use App\Models\Comment;
use App\Models\Location;
use App\Models\Plant;
use App\Models\Plant_Location;
use App\Models\Post;
use App\Models\Schedule;
use App\Models\User;

class PostController extends Controller
{
    public function postindex(Post $post){
        return view('posts.postindex')->with(['posts' => $post->getPaginateByLimit(5)]);
    }
    
    public function add_post(){
        return view('posts.add_post');
    }
}
