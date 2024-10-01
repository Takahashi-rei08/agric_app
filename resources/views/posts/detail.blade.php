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
                @if($post->start_date)
                    <p class='start_date'>{{ $post->start_date }}</p>
                    <p class='end_date'>{{ $post->end_date }}</p>
                    <p class='event_color'>{{ $post->event_color }}</p>
                @endif
                <a href="/post/{{ $post->id }}/edit"><!--投稿の編集-->
                    編集
                </a>
                <form action="/post/{{ $post->id }}/delete" id="form_{{ $post->id }}" method="post">
                    @csrf
                    @method('DELETE')
                    <button type="button" onclick="deletePost({{ $post->id }})">削除</button>
                </form>

            </div>
            <div class="footer">
                <a href='/post'>戻る</a>
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
