<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>{{ $story->name }} - {{ __('play.digital_detective') }}</title>
      @vite(['resources/css/app.css', 'resources/js/app.js'])

      <link rel="preconnect" href="https://fonts.googleapis.com">
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
      <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">

      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
      <meta name="csrf-token" content="{{ csrf_token() }}">
      @livewireStyles
  </head>
  <body class="bg-[url('/storage/app/public/images/download.png')] bg-repeat bg-center text-white min-h-screen">
    @include('partials._navbar')
    <main class="px-4 py-10">
      <div id="game-container" class="max-w-3xl mx-auto rounded-lg bg-gray-900 bg-opacity-80 p-6 shadow-md border border-gray-700">
         @livewire('play-story', ['story' => $story, 'start_over' => $startOver])
      </div>
    </main>
      @livewireScripts
  </body>
</html>
