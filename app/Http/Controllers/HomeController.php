<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Action;
use App\Models\Calendar;
use App\Models\Comment;
use App\Models\City;
use App\Models\Plant;
use App\Models\PlantVariety;
use App\Models\Plant_City;
use App\Models\PlantVariety_City;
use App\Models\Post;
use App\Models\Schedule;
use App\Models\User;

class HomeController extends Controller
{
    public function homeindex(Post $post, User $user){
        return view('homes.homeindex')->with([
            'posts' => $post->orderBy('created_at', 'DESC')->paginate(10),
        ]);
    }
}
