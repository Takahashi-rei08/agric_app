<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">

        <title>serched</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    </head>
    
    <x-app-layout>
        <x-slot name="header">
            検索結果
        </x-slot>
        <body class='homes'>
            <div>
                <div class='posts'>
                    <!--投稿を最新のものから表示-->
                    @foreach($posts as $post)
                        <div class='user'>
                            <p id='userName'>{{ $post->user->name }}</p>
                        </div>
                        <div class='post'>
                            <h2 class='title'>{{ $post->title }}</h2>
                            <div class='plants'>
                                @if($post->action_id)
                                    <p class='action'>{{ $post->action->name }}</p>
                                @endif
                                @if($post->plant_id)
                                    <p class='plant'>{{ $post->plant->name }}</p>
                                @endif
                                @if($post->plantVariety_id)
                                    <p class='plantVariety'>{{ $post->plantVariety ? $post->plantVariety->name : '未設定' }}</p>
                                @endif
                            </div>
                            @if($post->image)
                                <img src="{{ $post->image }}" class='image'>
                            @endif
                            @if($post->body)
                                <p class='body'>{{ $post->body }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
                <div class='paginate'>{{ $posts->links() }}</div>
            </div>
        </body>
    </x-app-layout>
</html>
