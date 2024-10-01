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
            <button onclick="location.href='/post/create'" class='post_botton'>新規投稿</button><!--新規投稿の作成-->
            <div>
                <h1>自分の投稿</h1>
                <div class='myposts'>
                    <!--自分の投稿を最新のものから表示-->
                    @foreach($posts as $post)
                        <div class='mypost'>
                            <h2 class='title'>{{ $post->title }}</h2>
                            <div class='plants'>
                                @if($post->action_id)
                                    <p class='action'>{{ $post->action->name }}</p>
                                @endif
                                @if($post->plant_id)
                                    <p class='plant'>{{ $post->plant->name }}</p>
                                @endif
                                @if($post->plantVariety_id)
                                    <p class='plantVariety'>{{ $post->plantVariety->name }}</p>
                                @endif
                            </div>
                            @if($post->image)
                                <img src="{{ $post->image }}" class='image'>
                            @endif
                            @if($post->body)
                                <p class='body'>{{ $post->body }}</p>
                            @endif
                            <a href="/post/{{ $post->id }}"><!--投稿の編集-->
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
