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
            作物の追加
        </x-slot>
        <body>
            <form action="{{ route('store_plant') }}" method='POST'>
                @csrf
                
                <!-- actionの追加 -->
                <input type="text" name='plant' placeholder='追加したい作物を入力'/>
                
                <input type="submit" value="追加"/>
            </form>
        </body>
    </x-app-layout>
</html>
