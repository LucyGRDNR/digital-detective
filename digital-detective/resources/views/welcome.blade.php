<x-guest-layout>

    <header>
        <h1>Digitální Detektiv</h1>
    </header>

    <main>
        <div class="grid">
            @foreach($stories as $story)
            <a href="{{ route('show.story', $story->id) }}" style="text-decoration: none; color: inherit;">
                <div class="cards">
                    <img src="{{ asset('storage/' . $story->image_path) }}" alt="{{ $story->name }}" class="rounded-md mb-2">
                    <h2>{{ $story->name }}</h2>
                    <p>📍 {{ $story->place }} | ⏳ {{ $story->time }} | 🚶 {{ $story->distance }}</p>
                </div>
            </a>
            @endforeach
        </div>
    </main>

</x-guest-layout>
