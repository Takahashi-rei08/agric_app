<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Post</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    </head>
    
    <x-app-layout>
        <x-slot name="header">
            新規投稿
        </x-slot>
            <form action="{{ route('store_post') }}" method='POST' enctype="multipart/form-data">
                @csrf
                
                <!-- titleの入力 -->
                <div class='title'>
                    <h2>タイトル</h2>
                    <input type="text" name="post[title]" placdholder="タイトル">
                </div>
                
                <!-- bodyの入力 -->
                <div class='body'>
                    <h2>内容</h2>
                    <input type="text" name="post[body]" placdholder="内容">
                </div>
                
                <!-- 画像fileの投稿 -->
                <div class="image">
                    <h2>画像投稿</h2>
                    <input type="file" name="image">
                </div>
                
                <!-- カレンダーに追加 -->
                <div class="calendars">
                    <button type="button" id="add_calendar" onClick='change_hidden()'>カレンダーに追加</button>
                    <div class="calendar" id='calendar_day' hidden>
                        <label for="start_date">開始日時</label>
                        <input id="new-start_date" class="input-date" type="date" name="post[start_date]" value="" />
                        <label for="end_date">終了日時</label>
                        <input id="new-end_date" class="input-date" type="date" name="post[end_date]" value="" />
                        <label for="event_color">背景色</label>
                        <select id="new-event_color" name="post[event_color]">
                            <option value="blue" selected>青</option>
                            <option value="green">緑</option>
                        </select>
                    </div>
                </div>
                
                <!-- actionの選択 -->
                <select name='post[action_id]' id='select_action'>
                    <option selected value=''>-- 作業を選択 --</option>
                    @foreach($actions as $action)
                        <option  value='{{ $action["action_id"] }}'>{{ $action["name"] }}</option>
                    @endforeach
                </select>
                
                <!-- action選択肢の追加 -->
                <div class='action_botton'>
                    <button type="button" id='add-action' onClick='add_action()'>新たな作業の追加</button>
                </div>
                    
                <!-- plantの選択 -->
                <select name='post[plant_id]' id='select_plant' onChange="add_variety()">
                    <option disabled selected value=''>-- 植物を選択 --</option>
                    @foreach($plants as $plant)
                        <option  value='{{ $plant["id"] }}'>{{ $plant["name"] }}</option>
                    @endforeach
                </select>
                
                <!-- plant選択肢の追加 -->
                <div class='plant_botton'>
                    <button type="button" id='add-plant' onClick='add_plant()'>新たな植物の追加</button>
                </div>
                
                <!-- plant_varietyの選択 -->
                <select name='post[plantVariety_id]' id='select_plant_variety'>
                    <option disabled selected value=''>-- 植物を選択してください --</option>
                </select>
                
                <!-- plantVariety選択肢の追加 -->
                <div class='plantVariety_botton'>
                    <button type='button' id='add-plant_variety' onClick="add_plant_variety()" hidden>新たな品種の追加</button>
                </div>
                    
                <input type="submit" value="投稿"/>
            </form>
        
        <div class="footer">
            <a href="/post">戻る</a>
        </div>
        <script>
            
            
            function add_variety(){
                const select_plant_variety = document.getElementById("select_plant_variety");
                const botton_plant_variety = document.getElementById("add-plant_variety");
                //bottonの表示
                botton_plant_variety.hidden = false;
                
                let plantVarieties_data = @json($plantVarieties);
                select_plant_variety.disabled = null;
                while(select_plant_variety.lastElementChild){
                    select_plant_variety.removeChild(select_plant_variety.lastChild);
                }
                var option = document.createElement("option");
                option.text = "品種を選択";
                option.value = '';
                select_plant_variety.appendChild(option);
                var select_plant  = document.getElementById("select_plant");
                for(let i = 0; i < plantVarieties_data.length; ++i){
                    if(plantVarieties_data[i]["plant_id"] == select_plant.value){
                        var option = document.createElement("option");
                        option.value = plantVarieties_data[i]["id"];
                        option.text = plantVarieties_data[i]["name"];
                        select_plant_variety.appendChild(option);
                    }
                }
                
            }
            
            function add_action(){
                window.location.href = '../../action';
            }
            
            function add_plant(){
                window.location.href = '../../plant';
            }
            
            function add_plant_variety(){
                let select_plant = document.getElementById('select_plant');
                let plant_id = select_plant.value;
                console.log(plant_id);
                window.location.href = '../../plant/'+plant_id;
            }
            
            function change_hidden(){
                const calendar = document.getElementById("calendar_day");
                calendar.hidden = false;
            }
        </script>
    </x-app-layout>
</html>


