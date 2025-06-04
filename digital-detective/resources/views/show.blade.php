<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $story->name }} - Digitální Detektiv</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
</head>

<body class="bg-[url('/storage/app/public/images/download.png')] bg-repeat bg-center text-white min-h-screen">

    <nav class="w-full flex flex-wrap items-center justify-between bg-gray-800 p-4">
        <div class="text-2xl font-bold text-white mb-2 sm:mb-0">Digitální Detektiv</div>

        <div class="flex flex-col sm:flex-row sm:items-center sm:space-x-4 w-full sm:w-auto gap-2">
            @guest
                <a href="{{ route('login') }}" class="text-blue-400 hover:underline text-left sm:text-center">Přihlásit se</a>
                <a href="{{ route('register') }}" class="rounded bg-blue-600 px-4 py-2 text-white hover:bg-blue-700 text-center sm:text-left">Registrovat se</a>
            @endguest

            @auth
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="flex items-center space-x-2 bg-gray-700 px-4 py-2 rounded text-white hover:bg-gray-600">
                        <span>{{ Auth::user()->name }}</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <div x-show="open" @click.away="open = false"
                         class="absolute right-0 mt-2 w-48 bg-white text-black rounded shadow-lg z-50">
                        <a href="{{ route('profile.show') }}"
                           class="block px-4 py-2 text-sm hover:bg-gray-100">Profil</a>

                        <form method="POST" action="{{ route('logout') }}" class="block">
                            @csrf
                            <button type="submit"
                                    class="w-full text-left px-4 py-2 text-sm hover:bg-gray-100">Odhlásit se</button>
                        </form>
                    </div>
                </div>
            @endauth
        </div>
    </nav>

    <main class="px-4 py-10">
        <div class="max-w-3xl mx-auto rounded-lg bg-gray-900 bg-opacity-80 p-6 shadow-md border border-gray-700">
            <div class="mb-6">
                <img src="{{ asset('storage/' . $story->image_path) }}"
                     alt="{{ $story->name }}"
                     class="w-full h-64 object-cover rounded-lg shadow" />
            </div>

            <h1 class="text-3xl font-bold mb-4">{{ $story->name }}</h1>

            <p class="text-gray-300 mb-4 text-sm md:text-base">{{ $story->description }}</p>

            <div class="mb-6 text-sm md:text-base text-gray-400">
              <strong>Místo:</strong> {{ $story->place }} <br>
              <strong>Čas:</strong> {{ $story->time }} minut <br>
              <strong>Vzdálenost:</strong> {{ $story->distance }} m
            </div>

            @auth
                <a href="{{ route('play.story', ['story' => $story->id]) }}">
                    <button class="w-full rounded bg-blue-600 px-6 py-3 text-white hover:bg-blue-700 text-lg font-semibold transition">
                        Hrát
                    </button>
                </a>
            @else
                <div class="mt-6 text-center text-yellow-400 text-sm md:text-base">
                    Pro spuštění hry se prosím <a href="{{ route('login') }}" class="underline text-blue-400">přihlaste</a> nebo <a href="{{ route('register') }}" class="underline text-blue-400">zaregistrujte</a>.
                </div>
            @endauth
        </div>
    </main>
    <script src="//unpkg.com/alpinejs" defer></script>
</body>
</html>
