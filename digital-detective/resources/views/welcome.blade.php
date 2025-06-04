<x-guest-layout>

    <main class="px-6">
        <div class="grid gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
            @foreach($stories as $story)
                <a href="{{ route('show.story', $story->id) }}" style="text-decoration: none; color: inherit;">
                    <div class="flex flex-col rounded-lg bg-gray-800 bg-opacity-90 p-4">
                        <div class="mb-3 h-48 w-full overflow-hidden rounded">
                            <img src="{{ asset('storage/' . $story->image_path) }}" alt="{{ $story->name }}" class="h-full w-full object-cover" />
                        </div>
                        <h2 class="mb-1 text-lg font-bold">{{ $story->name }}</h2>
                        <p class="mb-1 text-sm text-gray-300">{{ __('Start') }}: {{ $story->place }}</p>
                        <p class="mb-1 text-sm text-gray-300">{{ __('Time') }}: {{ $story->time }}</p>
                        <p class="mb-4 text-sm text-gray-300">{{ __('Distance') }}: {{ $story->distance }}</p>
                    </div>
                </a>
            @endforeach
        </div>
    </main>

</x-guest-layout>
