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
</head>

<body>
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
</body>

</html>
