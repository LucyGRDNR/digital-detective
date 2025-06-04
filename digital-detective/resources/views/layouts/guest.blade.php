<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('layouts.includes.head')
    </head>
    <body>

        @include('layouts.includes.language')

        {{ $slot }}

        @livewireScripts
    </body>
</html>
