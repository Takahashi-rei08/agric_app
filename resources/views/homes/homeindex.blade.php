<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">

        <title>app_name</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    </head>
    
    <x-app-layout>
        <x-slot name="header">
            app_name
        </x-slot>
        <body class='homes'>
            <h1>home</h1>
            <div>
                <h2>最新投稿</h2>
            </div>
        </body>
    </x-app-layout>
</html>
