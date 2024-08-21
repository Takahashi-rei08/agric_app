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

class CalendarController extends Controller
{
    // カレンダー表示
    public function show(){
        return view("calendars.calendarindex");
    }
    
    // 新規予定追加
    public function add_schedule(Request $request, Schedule $schedule){
        // バリデーション（scedulesテーブルの中でNULLを許容していないものをrequired）
        $request->validate([
            'event_title' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'event_color' => 'required',
        ]);

        // 登録処理
        $schedule->user_id = $request->user()->id;
        $schedule->event_title = $request->input('event_title');
        $schedule->event_body = $request->input('event_body');
        $schedule->start_date = $request->input('start_date');
        $schedule->end_date = date("Y-m-d", strtotime("{$request->input('end_date')} +1 day")); // FullCalendarが登録する終了日は仕様で1日ずれるので、その修正を行っている
        $schedule->event_color = $request->input('event_color');
        $schedule->event_border_color = $request->input('event_color');
        $schedule->save();
        
        // カレンダー表示画面にリダイレクトする
        return redirect(route("show"));
    }
    
    public function get_schedule(Request $request, Schedule $schedule){
        // バリデーション
        $request->validate([
            'start_date' => 'required|integer',
            'end_date' => 'required|integer'
        ]);

        // 現在カレンダーが表示している日付の期間
        $start_date = date('Y-m-d', $request->input('start_date') / 1000); // 日付変換（JSのタイムスタンプはミリ秒なので秒に変換）
        $end_date = date('Y-m-d', $request->input('end_date') / 1000);

        // 予定取得処理（これがaxiosのresponse.dataに入る）
        return $schedule->query()
            // DBから取得する際にFullCalendarの形式にカラム名を変更する
            ->select(
                'id',
                'event_title as title',
                'event_body as description',
                'start_date as start',
                'end_date as end',
                'event_color as backgroundColor',
                'event_border_color as borderColor'
            )
            // 表示されているカレンダーのeventのみをDBから検索して表示
            ->where('end_date', '>', $start_date)
            ->where('start_date', '<', $end_date) // AND条件
            ->get();
    }
    
    public function test(){
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
        $datas = json_decode($response->getBody(), true);
        dump(config('services.resas.key'));
        dd($datas);
    }
}
