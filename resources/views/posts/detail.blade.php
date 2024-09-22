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
            <div class='mypost'>
                <h2 class='title'>{{ $post->title }}</h2>
                @if($post->image)
                    <img src="{{ $post->image }}" class='image'>
                @endif
                @if($post->body)
                    <p class='body'>{{ $post->body }}</p>
                @endif
                @if($post->start_date)
                    <p class='start_date'>{{ $post->start_date }}</p>
                    <p class='end_date'>{{ $post->end_date }}</p>
                    <p class='event_color'>{{ $post->event_color }}</p>
                @endif
                <a href="/post/{{ $post->id }}/edit"><!--投稿の編集-->
                    編集
                </a>
            </div>
            <div class="footer">
                <a href='/post'>戻る</a>
            </div>
        </body>
    </x-app-layout>
</html>
