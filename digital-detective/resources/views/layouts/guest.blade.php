<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('layouts.includes.head')
    </head>
    <body>

        {{ $slot }}

        @livewireScripts
    </body>
</html>
