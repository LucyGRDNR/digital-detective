<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $story->name }} - {{ __('welcome-show.digital_detective') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body class="bg-[url('/storage/app/public/images/download.png')] bg-repeat bg-center text-white min-h-screen">

    @include('partials._navbar')

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
                <p class="mb-1 text-md text-gray-300">{{ __('welcome-show.location') }}: {{ $story->place }}</p>
                <p class="mb-1 text-md text-gray-300">{{ __('welcome-show.time') }}: {{ $story->time }} {{ __('welcome-show.minutes') }}</p>
                <p class="mb-4 text-md text-gray-300">{{ __('welcome-show.distance') }}: {{ $story->distance }} {{ __('welcome-show.kilometers') }}</p>
            </div>

             @auth
                @php
                    $user = Auth::user();
                    $userProgress = $user->progress()->where('story_id', $story->id)->first();
                    $hasActivePlaythrough = ($userProgress && $userProgress->current_chapter_id !== null && !$userProgress->is_end);
                    $userEverCompletedStory = ($userProgress && $userProgress->completed);
                @endphp


                <div class="mt-auto pt-4">
                    @if ($hasActivePlaythrough)
                        <div class="flex flex-col sm:flex-row justify-between space-y-2 sm:space-y-0 sm:space-x-2">
                            <a href="{{ route('play.story', ['story' => $story->id]) }}"
                               class="flex-1 text-center py-2 px-4 rounded-md bg-gray-800 hover:bg-green-800 text-white hover:bg-green-700 transition duration-150 ease-in-out text-lg font-semibold">
                                {{ __('welcome-show.resume_story') }}
                            </a>
                            <a href="{{ route('play.story', ['story' => $story->id, 'start_over' => true]) }}"
                               class="flex-1 text-center py-2 px-4 rounded-md bg-gray-800 hover:bg-red-800 text-white hover:bg-red-700 transition duration-150 ease-in-out text-lg font-semibold">
                                {{ __('welcome-show.start_over') }}
                            </a>
                        </div>
                    @else
                        <a href="{{ route('play.story', ['story' => $story->id, 'start_over' => true]) }}"
                           class="block text-center py-2 px-4 rounded-md bg-blue-600 text-white hover:bg-blue-700 transition duration-150 ease-in-out text-lg font-semibold">
                            {{ __('welcome-show.start_story') }}
                        </a>
                    @endif
                </div>
            @else
                <div class="mt-6 text-center text-yellow-400 text-sm md:text-base">
                    {!! __('welcome-show.login_or_register_to_play',
                        [
                            'login' => '<a href="'. route('login') .'" class="underline text-blue-400">'. __('welcome-show.login_link') .'</a>',
                            'register' => '<a href="'. route('register') .'" class="underline text-blue-400">'. __('welcome-show.register_link') .'</a>'
                        ]
                        )
                    !!}
                </div>
            @endauth

        </div>
    </main>
    <script src="//unpkg.com/alpinejs" defer></script>
</body>
</html>