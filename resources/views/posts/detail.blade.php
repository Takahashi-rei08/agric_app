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
            投稿詳細
        </x-slot>
        <body>
            <div class='mypost'>
                <p id='titleLabel'>タイトル</p>
                <h2 id='postTitle'>{{ $post->title }}</h2>
                <div class='plants'>
                    <p class='action'>作業：{{ optional($post->action)->name ? optional($post->action)->name : '未設定' }}</p>
                    <p class='plant'>作物：{{ optional($post->plant)->name ? optional($post->plant)->name : '未設定' }}</p>
                    <p class='plantVariety'>品種：{{ optional($post->plantVariety)->name ? optional($post->plantVariety)->name : '未設定' }}</p>
                </div>
                @if($post->image)
                    <img src="{{ $post->image }}" class='image'>
                @endif
                <p class='body'>{{ $post->body ? $post->body : '未設定' }}</p>
                <p class='start_date'>開始日 : {{ $post->start_date ? $post->start_date : '未設定' }}</p>
                <p class='end_date'>終了日 : {{ $post->end_date ? $post->end_date : '未設定' }}</p>
                <p class='event_color'>イベントカラー : {{ $post->event_color ? $post->event_color : '未設定' }}</p>
                <div class="button-group">
                    <a id='edit' href="/post/{{ $post->id }}/edit"><!--投稿の編集-->
                        編集
                    </a>
                    <form action="/post/{{ $post->id }}/delete" id="form_{{ $post->id }}" method="post">
                        @csrf
                        @method('DELETE')
                        <button id='delete' type="button" onclick="deletePost({{ $post->id }})">削除</button>
                    </form>
                </div>

            </div>
            <div class="footer">
                <a id='return' href='/post'>戻る</a>
            </div>
        </body>
        <script>
            function deletePost(id) {
                'use strict'
                if (confirm('削除すると復元できません。\n本当に削除しますか？')) {
                    document.getElementById(`form_${id}`).submit();
                }
            }
        </script>

    </x-app-layout>
</html>

<style>
    .mypost{
        margin: 15px 0;
        padding: 12px;
    }
    #titleLabel{
        font-size: 15px;
    }
    #postTitle{
        font-size: 25px;
    }
    .plants{
        font-size: 15px;
    }
    .body{
        font-size: 15px;
    }
    #edit{
        display: inline-block;
        background-color: green;
        color: white;
        font-size: 15px;
        padding: 8px 15px;
        border: none;
        border-radius: 5px;
        text-decoration: none;
        margin-top: 10px;
    }
    #delete{
        display: inline-block;
        background-color: red;
        color: white;
        font-size: 15px;
        padding: 8px 15px;
        border: none;
        border-radius: 5px;
        text-decoration: none;
        margin-top: 10px;
    }
    .button-group {
        margin-top: 10px;
        display: flex;
        gap: 10px;
    }
    #return{
        display: inline-block;
        background-color: grey;
        color: white;
        font-size: 15px;
        padding: 8px 15px;
        border: none;
        border-radius: 5px;
        text-decoration: none;
        margin-top: 10px;
    }
</style>