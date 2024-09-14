<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\support\Facades\Auth;
use Cloudinary;
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

class PostController extends Controller
{
    public function postindex(){
        $post = Post::where('user_id', Auth::user()->id)->orderBy('updated_at', 'DESC')->paginate(10);
        return view('posts.postindex')->with(['posts' => $post]);
    }
    
    public function create(Action $action, Plant $plant, PlantVariety $plant_variety){
        return view('posts.create')->with([
            'actions' => $action->orderBy('name')->get(),
            'plants' => $plant->orderBy('name')->get(),
            'plantVarieties' => $plant_variety->orderBy('name')->get(),
        ]);
    }
    
    public function store(Request $request){
        $input = $request['post'];
        $input += ['user_id' => Auth::id()];
        
        //画像データをcloudinalyに送信し、URLを取得
        if($request->file('image')){
            $image_url = Cloudinary::upload($request->file('image')->getRealPath())->getSecurePath();
            $input +=  ['image' => $image_url];
        }
        
        $post = Post::create($input)->save();
        
        $post = Post::where('user_id', AUTH::user()->id)->orderBy('updated_at', 'DESC')->paginate(10);
        return view('posts.postindex')->with(['posts' => $post]);
    }
    
    public function edit(Request $request){
        
        
    }
    
    public function update(Request $request){
        
        
    }
    
    public function add_action(){
        return view('insertDB.insertAction');
    }
    
    public function store_action(Request $request){
        if (is_null(Action::where('name', $request['action']['name'])->first())){
            $input = $request['action'];
            $post = Action::create($input)->save();
        }
        
        $post = Post::where('user_id', AUTH::user()->id)->orderBy('updated_at', 'DESC')->paginate(10);
        return view('posts.postindex')->with(['posts' => $post]);
    }
    
    public function add_plant(){
        return view('insertDB.insertPlant');
    }
    
    public function store_plant(Request $request){
        if (is_null(Action::where('name', $request['plant']['name'])->first())){
            $input = $request['plant'];
            $post = Plant::create($input)->save();
        }
        
        $post = Post::where('user_id', AUTH::user()->id)->orderBy('updated_at', 'DESC')->paginate(10);
        return view('posts.postindex')->with(['posts' => $post]);
    }
    
    public function add_plant_variety($plant_code){
        $plant_data = Plant::find($plant_code);
        return view('insertDB.insertPlantVariety')->with(['plant'=>$plant_data]);
    }
    
    public function store_plant_variety(Request $request){
        if (is_null(Action::where([
            'name', '=', $request['plant']['name'],
            'plant_id', '=', $request['plant']['plant_id'],
            ])->first())){
            $input = $request['plantVariety'];
            $post = PlantVariety::create($input)->save();
        }
        $post = Post::where('user_id', AUTH::user()->id)->orderBy('updated_at', 'DESC')->paginate(10);
        return view('posts.postindex')->with(['posts' => $post]);
    }
}
