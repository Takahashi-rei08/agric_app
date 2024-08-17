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

class SearchController extends Controller
{
    public function searchindex(){
        return view('searches.searchindex');
    }
}
