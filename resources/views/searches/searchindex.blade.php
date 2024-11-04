<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Search</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    </head>
    
    <x-app-layout>
        <x-slot name="header">
            検索
        </x-slot>
        <body class='conditions'>
            <form method="GET" action="{{ route('searched_post') }}">
            @csrf
            
                <!-- Prefecture -->
                <select name='prefecture_id' id='prefecture'>
                    <option selected value=''>-- 都道府県を選択 --</option>
                    @foreach($pref_datas as $pref_data)
                        <option  value='{{ $pref_data["prefCode"] }},{{ $pref_data["prefName"] }}'>{{ $pref_data["prefName"] }}</option>
                    @endforeach
                </select>
                
                <!-- actionの選択 -->
                <select name='action_id' id='action'>
                    <option selected value=''>-- 作業を選択 --</option>
                    @foreach($actions as $action)
                        <option  value='{{ $action["id"] }}'>{{ $action["name"] }}</option>
                    @endforeach
                </select>
                
                <!-- plantの選択 -->
                <select name='plant_id' id='select_plant' onChange="add_variety()">
                    <option selected value=''>-- 植物を選択 --</option>
                    @foreach($plants as $plant)
                        <option  value='{{ $plant["id"] }}'>{{ $plant["name"] }}</option>
                    @endforeach
                </select>
                
                <!-- plant_varietyの選択 -->
                <select name='plantVariety_id' id='select_plant_variety'>
                    <option disabled selected value=''>-- 植物を選択してください --</option>
                </select>
                    
                <input type="submit" value="検索"/>
            </form>
        </body>
        
        <script>
            function add_variety(){
                const select_plant_variety = document.getElementById("select_plant_variety");
                
                let plantVarieties_data = @json($plantVarieties);
                select_plant_variety.disabled = null;
                //元のselectを消す
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
        </script>
    </x-app-layout>
</html>

<style>
    select {
        display: block;
        width: 80%;
        max-width: 300px;
        margin: 10px auto;
        padding: 8px;
        font-size: 16px;
        border: 1px solid gray;
        box-sizing: border-box;
    }
    
    /* ボタンのスタイル */
    input[type="submit"] {
        display: block;
        width: 80%;
        max-width: 400px;
        margin: 20px auto;
        padding: 10px;
        font-size: 16px;
        color: white;
        background-color: green;
        border: 2px solid black;
        border-radius: 4px;
        cursor: pointer;
    }
</style>
