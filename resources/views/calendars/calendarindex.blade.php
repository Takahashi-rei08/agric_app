<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>FullCalendar</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    
    <x-app-layout>
        <x-slot name="header">
            カレンダー
        </x-slot>
        <body class='calendars'>
            <h1>カレンダー</h1>
            <div id='calendar'></div><!-- divタグ内にカレンダーを表示 -->
            
            <!-- カレンダー新規追加モーダル -->
            <div id="modal-add" class="modal">
                <div class="modal-contents">
                    <form method="POST" action="{{ route('add_schedule') }}">
                        @csrf
                        <input id="new-id" type="hidden" name="id" value="" />
                        <label for="event_title">タイトル</label>
                        <input id="new-event_title" class="input-title" type="text" name="event_title" value="" />
                        <label for="start_date">開始日時</label>
                        <input id="new-start_date" class="input-date" type="date" name="start_date" value="" />
                        <label for="end_date">終了日時</label>
                        <input id="new-end_date" class="input-date" type="date" name="end_date" value="" />
                        <label for="event_body" style="display: block">内容</label>
                        <textarea id="new-event_body" name="event_body" rows="3" value=""></textarea>
                        <label for="event_color">背景色</label>
                        <select id="new-event_color" name="event_color">
                            <option value="blue" selected>青</option>
                            <option value="green">緑</option>
                        </select>
                        
                        <!-- actionの選択 -->
                        <select name='schedule[action_id]' id='select_action'>
                            <option selected value=''>作業を選択</option>
                            @foreach($actions as $action)
                                <option  value='{{ $action["id"] }}'>{{ $action["name"] }}</option>
                            @endforeach
                        </select>
                        
                        <!-- action選択肢の追加 -->
                        <div class='action_botton'>
                            <button type="button" id='add-action' onClick='add_action()'>新たな作業の追加</button>
                        </div>
                            
                        <!-- plantの選択 -->
                        <select name='schedule[plant_id]' id='select_plant' onChange="add_variety()">
                            <option disabled selected value=''>植物を選択</option>
                            @foreach($plants as $plant)
                                <option  value='{{ $plant["id"] }}'>{{ $plant["name"] }}</option>
                            @endforeach
                        </select>
                        
                        <!-- plant選択肢の追加 -->
                        <div class='plant_botton'>
                            <button type="button" id='add-plant' onClick='add_plant()'>新たな植物の追加</button>
                        </div>
                        
                        <!-- plant_varietyの選択 -->
                        <select name='schedule[plantVariety_id]' id='select_plant_variety'>
                            <option disabled selected value=''>植物を選択してください</option>
                        </select>
                        
                        <!-- plantVariety選択肢の追加 -->
                        <div class='plantVariety_botton'>
                            <button type='button' id='add-plant_variety' onClick="add_plant_variety()" hidden>新たな品種の追加</button>
                        </div>
                        
                        <button type="button" onclick="closeAddModal()">キャンセル</button>
                        <button type="submit">決定</button>
                    </form>
                </div>
            </div>
            <!-- カレンダー編集モーダル -->
            <div id="modal-update" class="modal">
                <a id='schedule_datas' value='{{ $schedules }}' hidden></a>
                <a id='plantVarieties_datas' value='{{ $plantVarieties }}' hidden></a>
                <div class="modal-contents">
                    <form method="POST" action="{{ route('update') }}" >
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="id" name="id" value="" />
                        <label for="event_title">タイトル</label>
                        <input class="input-title" type="text" id="event_title" name="event_title" value="" />
                        <label for="start_date">開始日時</label>
                        <input class="input-date" type="date" id="start_date" name="start_date" value="" />
                        <label for="end_date">終了日時</label>
                        <input class="input-date" type="date" id="end_date" name="end_date" value="" />
                        <label for="event_body" style="display: block">内容</label>
                        <textarea id="event_body" name="event_body" rows="3" value=""></textarea>
                        <label for="event_color">背景色</label>
                        <select id="event_color" name="event_color">
                            <option value="blue">青</option>
                            <option value="green">緑</option>
                        </select>
                        <!-- actionの選択 -->
                        <select name='action_id' id='select_action2'>
                            <option selected value=''>作業を選択</option>
                            @foreach($actions as $action)
                                <option  value='{{ $action["id"] }}'>{{ $action["name"] }}</option>
                            @endforeach
                        </select>
                        
                        <!-- action選択肢の追加 -->
                        <div class='action_botton'>
                            <button type="button" id='add-action' onClick='add_action()'>新たな作業の追加</button>
                        </div>
                            
                        <!-- plantの選択 -->
                        <select name='plant_id' id='select_plant2' onChange="add_variety2()">
                            <option disabled selected value=''>植物を選択</option>
                            @foreach($plants as $plant)
                                <option  value='{{ $plant["id"] }}'>{{ $plant["name"] }}</option>
                            @endforeach
                        </select>
                        
                        <!-- plant選択肢の追加 -->
                        <div class='plant_botton'>
                            <button type="button" id='add-plant2' onClick='add_plant()'>新たな植物の追加</button>
                        </div>
                        
                        <!-- plant_varietyの選択 -->
                        <select name='plantVariety_id' id='select_plant_variety2'>
                            <option disabled selected value=''>植物を選択してください</option>
                        </select>
                        
                        <!-- plantVariety選択肢の追加 -->
                        <div class='plantVariety_botton'>
                            <button type='button' id='add-plant_variety2' onClick="add_plant_variety2()" hidden>新たな品種の追加</button>
                        </div>
                        
                        <button type="button" onclick="closeUpdateModal()">キャンセル</button>
                        <button type="submit">決定</button>
                    </form>
                    <form id="delete-form" method="post" action="{{ route('delete') }}">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" id="delete-id" name="id" value="" />
                        <button class="delete" type="button" onclick="deleteEvent()">削除</button>
                    </form>
                </div>
            </div>
        </body>
        
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
            function add_variety2(){
                const select_plant_variety = document.getElementById("select_plant_variety2");
                const botton_plant_variety = document.getElementById("add-plant_variety2");
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
                var select_plant  = document.getElementById("select_plant2");
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
            
            function add_plant_variety2(){
                let select_plant = document.getElementById('select_plant2');
                let plant_id = select_plant.value;
                console.log(plant_id);
                window.location.href = '../../plant/'+plant_id;
            }
        </script>
    </x-app-layout>
</html>

<style scoped>
/* 予定の上ではカーソルがポインターになる */
.fc-event-title-container{
    cursor: pointer;
}

/* モーダルのオーバーレイ */
.modal{
    display: none; /* モーダル開くとflexに変更（ここの切り替えでモーダルの表示非表示をコントロール） */
    justify-content: center;
    align-items: center;
    position: absolute;
    z-index: 10; /* カレンダーの曜日表示がz-index=2のため、それ以上にする必要あり */
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    height: 100%;
    width: 100%;
    background-color: rgba(0,0,0,0.5);
}
/* モーダル */
.modal-contents{
    background-color: white;
    height: 700px;
    width: 600px;
    padding: 20px;
}

/* 以下モーダル内要素のデザイン調整 */
input{
    padding: 2px;
    border: 1px solid black;
    border-radius: 5px;
}
.input-title{
    display: block;
    width: 80%;
    margin: 0 0 20px;
}
.input-date{
    width: 27%;
    margin: 0 5px 20px 0;
}
textarea{
    display: block;
    width: 80%;
    margin: 0 0 20px;
    padding: 2px;
    border: 1px solid black;
    border-radius: 5px;
    resize: none;
}
select{
    display: block;
    width: 40%;
    margin: 0 0 10px;
    padding: 2px;
    border: 1px solid black;
    border-radius: 5px;
}
#new-event_color{
    margin: 0 0 20px;
}
#add-action, #add-plant{
    display: block;
    margin: 0 0 20px;
    padding: 2px;
    color: grey;
    border: 1px solid black;
    border-radius: 5px;
    border-color: grey;
}
#add-plant_variety{
    margin: 0 0 20px;
    padding: 2px;
    color: grey;
    border: 1px solid black;
    border-radius: 5px;
    border-color: grey;
</style>
