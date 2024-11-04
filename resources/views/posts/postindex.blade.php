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
            投稿
        </x-slot>
        <body>
            <button onclick="location.href='/post/create'" class='post_button'>新規投稿</button><!--新規投稿の作成-->
            <div>
                <h1 id='pageTitle'>自分の投稿</h1>
                <div class='posts'>
                    <!--投稿を最新のものから表示-->
                    @foreach($posts as $post)
                        <div class='post'>
                            <div class='user'>
                                <p id='userNameLabel'>ユーザーネーム</p>
                                <p id='userName'>{{ $post->user->name }}</p>
                            </div>
                            <p id='titleLabel'>タイトル</p>
                            <h2 id='postTitle'>{{ $post->title }}</h2>
                            <div class='plants'>
                                @if($post->action_id)
                                    <p class='action'>作業：{{ $post->action->name }}</p>
                                @endif
                                @if($post->plant_id)
                                    <p class='plant'>作物：{{ $post->plant->name }}</p>
                                    @if($post->plantVariety_id)
                                        <p class='plantVariety'>品種：{{ $post->plantVariety->name}}</p>
                                    @endif
                                @endif
                            </div>
                            @if($post->image)
                                <img src="{{ $post->image }}" class='image'>
                            @endif
                            @if($post->body)
                                <p class='body'>{{ $post->body }}</p>
                            @endif
                            <a id='detail' href="/post/{{ $post->id }}"><!--投稿の編集-->
                                詳細表示
                            </a>
                        </div>
                    @endforeach
                </div>
                <div class='paginate'>{{ $posts->links() }}</div>
            </div>
        </body>
    </x-app-layout>
</html>

<style>
    #pageTitle{
        font-size: 25px;
    }
    .post{
        border: 1px solid gray;
        margin: 15px 0;
        padding: 12px;
    }
    #userNameLabel{
        font-size: 15px;
    }
    #userName{
        font-size: 25px;
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
    .post_button {
        background-color: green;
        color: white;
        font-size: 25px;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        margin-bottom: 20px;
    }
    #detail{
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
</style>