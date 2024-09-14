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
            <button onclick="location.href='/post/create'" class='post_botton'>新規投稿</botton><!--新規投稿の作成-->
            <div>
                <h1>自分の投稿</h1>
                <div class='myposts'>
                    <!--自分の投稿を最新のものから表示-->
                    @foreach($posts as $post)
                        <div class='mypost'>
                            <h2 class='title'>{{ $post->title }}</h2>
                            @if($post->post_image)
                                <img src="{{ $post->image }}" class='image'>
                            @endif
                            @if($post->post_body)
                                <p class='body'>{{ $post->body }}</p>
                            @endif
                            <button action"{{ route('') }}">
                                編集
                            </button>
                        </div>
                    @endforeach
                </div>
                <div class='paginate'>{{ $posts->links() }}</div>
            </div>
        </body>
    </x-app-layout>
</html>
