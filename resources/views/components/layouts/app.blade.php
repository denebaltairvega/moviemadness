<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="application-name" content="{{ config('app.name') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>{{ config('app.name') }}</title>
    @filamentStyles
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-black font-rubik flex flex-col text-white w-full antialiased">
    <div class="flex flex-col min-h-screen">
        <x-navigation-bar />
        <div class="flex-1 flex flex-col">
            @isset($slot)
                {{ $slot }}
            @endisset
        </div>
        <x-footer />
    </div>
    @livewire('notifications')
    @filamentScripts
</body>

</html>
