<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Play Story</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-[url('/storage/app/public/images/download.png')] bg-repeat bg-center text-white min-h-screen">

  <nav class="w-full flex flex-wrap items-center justify-between bg-gray-800 p-4 shadow">
    <div class="text-2xl font-bold text-white mb-2 sm:mb-0">Digitální Detektiv</div>
</nav>
    <main class="px-4 py-10 max-w-3xl mx-auto">
        @livewire('play-story', ['firstChapterId' => $first_chapter_id])
    </main>

    @livewireScripts
</body>
</html>
