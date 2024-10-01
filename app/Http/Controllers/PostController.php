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
        $post = Post::where('user_id', Auth::user()->id)->orderBy('created_at', 'DESC')->paginate(10);
        return view('posts.postindex')->with(['posts' => $post]);
    }
    
    public function detail(Post $post){
        return view('posts.detail')->with(['post' => $post]);
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
        $input += ['end_date' => date("Y-m-d", strtotime("{$request->input('end_date')} +1 day"))]; // FullCalendarが登録する終了日は仕様で1日ずれる
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
    
    public function edit(Post $post, Action $action, Plant $plant, PlantVariety $plant_variety){
        return view('posts.edit')->with([
            'post' => $post,
            'actions' => $action->orderBy('name')->get(),
            'plants' => $plant->orderBy('name')->get(),
            'plantVarieties' => $plant_variety->orderBy('name')->get(),
        ]);
    }
    
    public function update(Request $request, Post $post){
        $input = $request['post'];
        //画像データをcloudinalyに送信し、URLを取得
        if($request->file('image')){
            $image_url = Cloudinary::upload($request->file("image")->getRealPath())->getSecurePath();
            $input +=  ['image' => $image_url];
        }
        $post->fill($input)->save();
        
        return redirect('/post/'.$post->id);
    }
    
    public function delete(Post $post) {
        $post->delete();
        return redirect('/post');
    }

    
    public function add_action(){
        return view('insertDB.insertAction');
    }
    
    public function store_action(Request $request){
        if (is_null(Action::where('name', $request['action'])->first())){
            $input = ['name' => $request['action']];
            $post = Action::create($input)->save();
        }
        
        $post = Post::where('user_id', AUTH::user()->id)->orderBy('created_at', 'DESC')->paginate(10);
        return view('posts.postindex')->with(['posts' => $post]);
    }
    
    public function add_plant(){
        return view('insertDB.insertPlant');
    }
    
    public function store_plant(Request $request){
        if (is_null(Plant::where('name', $request['plant'])->first())){
            $input = ['name' => $request['plant']];
            $post = Plant::create($input)->save();
        }
        
        $post = Post::where('user_id', AUTH::user()->id)->orderBy('created_at', 'DESC')->paginate(10);
        return view('posts.postindex')->with(['posts' => $post]);
    }
    
    public function add_plant_variety($plant_code){
        $plant_data = Plant::find($plant_code);
        return view('insertDB.insertPlantVariety')->with(['plant'=>$plant_data]);
    }
    
    public function store_plant_variety(Request $request, Plant $plant){
        if (is_null(PlantVariety::where([
            ['name', '=', $request['plantVariety']],
            ['plant_id', '=', $request['plant_id']]
            ])->first())){
            $input = [
                'name' => $request['plantVariety'],
                'plant_id' => $request['plant_id'],
                ];
            $post = PlantVariety::create($input)->save();
        }
        $post = Post::where('user_id', AUTH::user()->id)->orderBy('created_at', 'DESC')->paginate(10);
        return view('posts.postindex')->with(['posts' => $post]);
    }
}
