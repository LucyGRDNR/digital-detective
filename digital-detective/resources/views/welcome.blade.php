<x-guest-layout>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Digitální Detektiv</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
</head>

<body class="bg-[url('/storage/app/public/images/download.png')] bg-repeat bg-center text-white min-h-screen">

    <nav class="mb-6 w-full flex flex-wrap items-center justify-between bg-gray-800 p-4 shadow">
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

    <main class="px-6">
        <div class="grid gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
            @foreach($stories as $story)
                <a href="{{ route('show.story', $story->id) }}" style="text-decoration: none; color: inherit;">
                    <div class="flex flex-col rounded-lg bg-gray-800 bg-opacity-90 p-4">
                        <div class="mb-3 h-48 w-full overflow-hidden rounded">
                            <img src="{{ asset('storage/' . $story->image_path) }}" alt="{{ $story->name }}" class="h-full w-full object-cover" />
                        </div>
                        <h2 class="mb-1 text-lg font-bold">{{ $story->name }}</h2>
                        <p class="mb-1 text-sm text-gray-300">Start: {{ $story->place }}</p>
                        <p class="mb-1 text-sm text-gray-300">Time: {{ $story->time }}</p>
                        <p class="mb-4 text-sm text-gray-300">Distance: {{ $story->distance }}</p>
                    </div>
                </a>
            @endforeach
        </div>
    </main>
    <script src="//unpkg.com/alpinejs" defer></script>
</body>
</html>
