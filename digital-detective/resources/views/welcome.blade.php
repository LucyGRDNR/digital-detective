<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Digitální Detektiv</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

</head>

<body class="bg-[url('/storage/app/public/images/download.png')] bg-repeat bg-center text-white min-h-screen">

    @include('partials._navbar')

    <main class="px-6">
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
            @foreach($stories as $story)
                <div class="relative flex flex-col rounded-lg bg-gray-800 bg-opacity-90 p-4 shadow-md transition duration-200 ease-in-out hover:scale-105 hover:shadow-lg">
                    @auth
                        @if(Auth::user()->hasRole('admin'))
                            <a href="{{ route('stories.edit', $story->id) }}"
                               class="absolute top-2 right-2 text-blue-400 hover:text-blue-200 z-10 p-2 rounded-full bg-gray-700 bg-opacity-70 hover:bg-opacity-100 transition duration-150 ease-in-out"
                               title="Upravit příběh">
                                <i class="fas fa-edit text-lg"></i>
                            </a>
                        @endif
                    @endauth

                    <a href="{{ route('stories.show', $story->id) }}" style="text-decoration: none; color: inherit;">
                        <div class="mb-3 h-48 w-full overflow-hidden rounded">
                            <img src="{{ asset('storage/' . $story->image_path) }}" onerror="this.onerror=null;this.src='https://placehold.co/400x250/333333/FFFFFF?text=No+Image';" alt="{{ $story->name }}" class="h-full w-full object-cover" />
                        </div>
                        <h2 class="mb-1 text-lg font-bold">{{ $story->name }}</h2>
                        <p class="mb-1 text-sm text-gray-300">{{ __('welcome-show.location') }}: {{ $story->place }}</p>
                        <p class="mb-1 text-sm text-gray-300">{{ __('welcome-show.time') }}: {{ $story->time }} {{ __('welcome-show.minutes') }}</p>
                        <p class="mb-4 text-sm text-gray-300">{{ __('welcome-show.distance') }}: {{ $story->distance }} {{ __('welcome-show.kilometers') }}</p>
                    </a>
                </div>
            @endforeach
        </div>
    </main>
    <script src="//unpkg.com/alpinejs" defer></script>
</body>
</html>