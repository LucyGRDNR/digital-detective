<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('layouts.includes.head')
    </head>
    <body class="bg-[url('/storage/app/public/images/download.png')] bg-repeat bg-center text-white min-h-screen">

        @include('layouts.includes.nav')

        {{ $slot }}

        @livewireScripts
        <script src="//unpkg.com/alpinejs" defer></script>
    </body>
</html>
