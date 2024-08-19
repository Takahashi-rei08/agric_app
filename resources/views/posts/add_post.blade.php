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
        <body class='posts'>
            <button onclick="location.href='/post/add_post'" class='post_botton'>新規投稿</botton>
            <div class='myposts'>
                <h1>自分の投稿</h1>
            </div>
        </body>
    </x-app-layout>
</html>
