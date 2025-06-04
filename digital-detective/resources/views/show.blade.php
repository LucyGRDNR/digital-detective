<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $story->title }} - Digitální Detektiv</title>
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
        <div class="story-detail">
            <h2>{{ $story->name }}</h2>
            <img src="{{ asset('storage/' . $story->image_path) }}" alt="{{ $story->name }}" class="rounded-md mb-2">


            <p>{{ $story->description }}</p>
            <p>📍 {{ $story->place }} | ⏳ {{ $story->duration }} | 🚶 {{ $story->distance }}</p>

            <a href="{{ route('play.story', ['story' => $story->id]) }}">
                <button class="start-button">Start Playing</button>
            </a>

        </div>
    </main>
</body>

</html>
