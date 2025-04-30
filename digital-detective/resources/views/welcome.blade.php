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

    <style>
        body {
            margin: 0;
            padding: 0;
            min-height: 100vh;
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

        main {
            width: 1200px;
            margin: 0 auto;
        }

        .cards {
            background-color: #374151c2;
            border-radius: 20px;
        }

        .cards img {
            width: 100%;
            object-fit: cover;
            height: 100%;
        }

        .cards h2 {
            margin: 10px 0;
            font-size: 18px;
            font-weight: bold;
            text-align: center;
        }

        .cards p {
            font-size: 14px;
            color: #e2e8f0;
            text-align: center;
            padding: 10px 0;
        }
        .grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            width: 100%;
        }

    </style>
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
