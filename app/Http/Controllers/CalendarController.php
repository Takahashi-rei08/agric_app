<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Action;
use App\Models\Calendar;
use App\Models\Comment;
use App\Models\Location;
use App\Models\Plant;
use App\Models\PlantVariety;
use App\Models\Plant_City;
use App\Models\PlantVariety_City;
use App\Models\Post;
use App\Models\Schedule;
use App\Models\User;

class CalendarController extends Controller
{
    // カレンダー表示
    public function show(Action $action, Plant $plant, PlantVariety $plant_variety, Schedule $schedule){
        return view("calendars.calendarindex")->with([
            'actions' => $action->orderBy('name')->get(),
            'plants' => $plant->orderBy('name')->get(),
            'plantVarieties' => $plant_variety->orderBy('name')->get(),
            'schedules' => $schedule->orderBy('id')->get(),
        ]);
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
        $input = $request['schedule'];
        $input += ['user_id' => $request->user()->id];
        $input += ['event_title' => $request->input('event_title')];
        $input += ['event_body' => $request->input('event_body')];
        $input += ['start_date' => $request->input('start_date')];
        $input += ['end_date' => date("Y-m-d", strtotime("{$request->input('end_date')} +1 day"))]; // FullCalendarが登録する終了日は仕様で1日ずれるので、その修正を行っている
        $input += ['event_color' => $request->input('event_color')];
        $input += ['event_border_color' => $request->input('event_color')];
        
        $schedule->fill($input)->save();
        
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
                'event_border_color as borderColor',
            )
            // 表示されているカレンダーのeventのみをDBから検索して表示
            ->where('end_date', '>', $start_date)
            ->where('start_date', '<', $end_date) // AND条件
            ->get();
    }
    
    public function update(Request $request, Schedule $schedule){
        $input = new Schedule();

        $input->event_title = $request->input('event_title');
        $input->event_body = $request->input('event_body');
        $input->start_date = $request->input('start_date');
        $input->end_date = date("Y-m-d", strtotime("{$request->input('end_date')} +1 day"));
        $input->event_color = $request->input('event_color');
        $input->event_border_color = $request->input('event_color');
        $input->plant_id = $request->input('plant_id');
        $input->plantVariety_id = $request->input('plantVariety_id');
        $input->action_id = $request->input('action_id');

        // 更新する予定をDBから探し（find）、内容が変更していたらupdated_timeを変更（fill）して、DBに保存する（save）
        $schedule->find($request->input('id'))->fill($input->attributesToArray())->save(); // fill()の中身はArray型が必要だが、$inputのままではコレクションが返ってきてしまうため、Array型に変換

        // カレンダー表示画面にリダイレクトする
        return redirect(route("show"));
    }
    
    // 予定の削除
    public function delete(Request $request, Schedule $schedule){
        // 削除する予定をDBから探し（find）、DBから物理削除する（delete）
        $schedule->find($request->input('id'))->delete();

        // カレンダー表示画面にリダイレクトする
        return redirect(route("show"));
    }
}
