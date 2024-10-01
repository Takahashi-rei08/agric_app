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
            投稿の編集
        </x-slot>
        <body>
            <h1 class="title">編集</h1>
            <div class="content">
                <form action=="../../../../post/{{ $post->id }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class='post__title'>
                        <h2>タイトル</h2>
                        <input type='text' name='post[title]' value="{{ $post->title }}">
                    </div>
                    <div class='post__body'>
                        <h2>内容</h2>
                        <input type='text' name='post[body]' value="{{ $post->body }}">
                    </div>
                    <div class="image">
                        <h2>画像投稿</h2>
                        @if($post->image)
                            <img src="{{ $post->image }}" class='image'>
                        @endif
                        <input type="file" name="image">
                    </div>
                    <div class="calendars">
                        <button type="button" id="add_calendar" onClick='change_hidden()'>カレンダーに追加</button>
                        <div class="calendar" id='calendar_day' hidden>
                            <label for="start_date">開始日時</label>
                            <input id="new-start_date" class="input-date" type="date" name="post[start_date]" value="{{ $post->start_date }}" />
                            <label for="end_date">終了日時</label>
                            <input id="new-end_date" class="input-date" type="date" name="post[end_date]" value="{{ $post->end_date }}" />
                            <label for="event_color">背景色</label>
                            <select id="new-event_color" name="post[event_color]" value="{{ $post->event_color }}">
                                <option value="blue" selected>青</option>
                                <option value="green">緑</option>
                            </select>
                        </div>
                    </div>
                    <input type="submit" value="保存">
                </form>
            </div>
        </body>
        
        <script>
            function change_hidden(){
                const calendar = document.getElementById("calendar_day");
                calendar.hidden = false;
            }
        </script>
    </x-app-layout>
</html>
