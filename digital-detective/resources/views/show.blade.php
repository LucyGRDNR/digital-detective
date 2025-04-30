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

    <style>
        body {
            background: url('{{ asset('storage/images/DD_background.jpg') }}') no-repeat center center fixed;
            background-size: cover;
            font-family: "Montserrat", sans-serif;
            color: white;
        }

        header {
            padding: 15px 30px;
        }

        h1 {
            font-size: 25px;
            font-weight: bold;
            color: white;
        }

        h2 {
            margin: 10px 0;
            font-size: 18px;
            font-weight: bold;
            text-align: center;
        }

        .story-detail {
            text-align: center;
            background-color: rgba(0, 0, 0, 0.6);
            padding: 30px;
            border-radius: 10px;
            max-width: 800px;
            margin: 0 auto;
            margin-top: 50px;
        }

        .story-detail img {
            width: 60%;
            max-width: 400px;
            height: auto;
            border-radius: 10px;
            margin: 20px auto;
            display: block;
        }

        .start-button {
            padding: 15px 30px;
            background-color: #374151;
            cursor: pointer;
            font-size: 16px;
            color: white;
            margin-top: 20px;
            border-radius: 30px;
        }
    </style>
</body>
</html>
