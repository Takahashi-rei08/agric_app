<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">

        <title>Home</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    </head>
    
    <x-app-layout>
        <x-slot name="header">
            Home
        </x-slot>
        <body class='homes'>
            <div>
                <h2>最新投稿</h2>
                <div class='posts'>
                    <!--投稿を最新のものから表示-->
                    @foreach($posts as $post)
                        <div class='mypost'>
                            <h2 class='title'>{{ $post->title }}</h2>
                            @if($post->image)
                                <img src="{{ $post->image }}" class='image'>
                            @endif
                            @if($post->body)
                                <p class='body'>{{ $post->body }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </body>
    </x-app-layout>
</html>
