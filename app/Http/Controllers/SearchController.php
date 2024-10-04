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

class SearchController extends Controller
{
    public function searchindex(Action $action, Plant $plant, PlantVariety $plant_variety){
        // 都道府県のデータを取得
        $client = new \GuzzleHttp\Client();
        
        $url = 'https://opendata.resas-portal.go.jp/api/v1/';
        
        $response = $client->request(
            'GET',
            $url."prefectures",
            array(
                "headers" => array(
                "X-API-KEY" => config('services.resas.key'),
                )
            )
        );
        $pref_datas = json_decode($response->getBody(), true)['result'];
        
        return view('searches.searchindex')->with([
            'pref_datas' => $pref_datas,
            'actions' => $action->orderBy('name')->get(),
            'plants' => $plant->orderBy('name')->get(),
            'plantVarieties' => $plant_variety->orderBy('name')->get(),
        ]);
    }
    
    public function searched_post(Request $request, Post $post){
        $request->validate([
            'prefecture_id' => 'nullable|string|max:255',
        ]);
        
        $query = Post::query();
        // 入力された検索条件に基づいてクエリを絞り込む
        if ($request->has('prefecture_id') && $request->prefecture_id != '') {
            $query->whereHas('user.city', function($subQuery) use ($request) {
                $subQuery->where('prefecture_id', $request->prefecture_id);
            });
        }

        if ($request->has('action_id') && $request->action_id != '') {
            $query->where('action_id', $request->action_id);
        }

        if ($request->has('plant_id') && $request->plant_id != '') {
            $query->where('plant_id', $request->plant_id);
        }
        
        if ($request->has('plantVariety_id') && $request->plantVariety_id != '') {
            $query->where('plantVariety_id', $request->plantVariety_id);
        }
        // 絞り込んだ結果をぺ時ネーション
        $posts = $query->paginate(10);

        // 結果を返す
        return view('searches.searchedpost')->with(['posts' => $posts]);
    }
}
