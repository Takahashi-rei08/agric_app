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
            app_name
        </x-slot>
        <body>
            <button onclick="location.href='/post/add_post'" class='post_botton'>新規投稿</botton>
            <div>
                <h1>自分の投稿</h1>
                <div class='myposts'>
                    @foreach($posts as $post)
                        <div class='mypost'>
                            <h2 class='title'>{{ $post->post_title }}</h2>
                            @if($post->post_image)
                                @php
                                    $img = "data:image/jpeg;base64," . base64_encode($record["picture"]); 
                                @endphp
                                <img src=<?= $img ?> class='image'>
                            @endif
                            @if($post->post_body)
                                <p class='body'>{{ $post->post_body }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
                <div class='paginate'>{{ $posts->links() }}</div>
            </div>
        </body>
    </x-app-layout>
</html>
