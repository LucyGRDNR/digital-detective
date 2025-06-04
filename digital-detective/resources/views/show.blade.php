<x-guest-layout>

    <header>
        <h1>Digitální Detektiv</h1>
    </header>

    <main>
        <div class="story-detail">
            <h2>{{ $story->name }}</h2>
            <img src="{{ asset('storage/' . $story->image_path) }}" alt="{{ $story->name }}" class="rounded-md mb-2">

            <p>{{ $story->description }}</p>
            <p>📍 {{ $story->place }} | ⏳ {{ $story->duration }} | 🚶 {{ $story->distance }}</p>

            <a href="{{ route('play.story', ['story' => $story->id]) }}">
                <button class="start-button">
                    {{ __('Start Playing') }}
                </button>
            </a>

        </div>
    </main>

</x-guest-layout>
