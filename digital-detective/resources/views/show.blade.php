<x-guest-layout>

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
              <strong>{{ __('Location') }}:</strong> {{ $story->place }} <br>
              <strong>{{ __('Time') }}:</strong> {{ $story->time }} minut <br>
              <strong>{{ __('Distance') }}:</strong> {{ $story->distance }} m
            </div>

            @auth
                <a href="{{ route('play.story', ['story' => $story->id]) }}">
                    <button class="w-full rounded bg-blue-600 px-6 py-3 text-white hover:bg-blue-700 text-lg font-semibold transition">
                        {{ __('Play') }}
                    </button>
                </a>
            @else
                <div class="mt-6 text-center text-yellow-400 text-sm md:text-base">
                    {!! __('login_or_register_to_play',
                        [
                            'login' => '<a href="'. route('login') .'" class="underline text-blue-400">'. __('login_link') .'</a>',
                            'register' => '<a href="'. route('register') .'" class="underline text-blue-400">'. __('register_link') .'</a>'
                        ]
                        )
                    !!}
                </div>
            @endauth
        </div>
    </main>

</x-guest-layout>
