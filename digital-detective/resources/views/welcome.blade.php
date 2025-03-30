<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Digitální Detektiv</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        <header class="flex justify-between items-center bg-white p-4 shadow-md rounded-lg">
            <h1 class="text-2xl font-bold">Digitální Detektiv</h1>
            <div class="flex space-x-4">
                <button class="px-4 py-2 bg-gray-200 rounded">Přihlášení</button>
                <button class="px-4 py-2 bg-blue-500 text-white rounded">English</button>
            </div>
        </header>

        <nav class="flex space-x-2 my-4">
            <button class="px-4 py-2 bg-gray-300 rounded">Jazyk</button>
            <button class="px-4 py-2 bg-gray-300 rounded">Délka trasy</button>
            <button class="px-4 py-2 bg-gray-300 rounded">Město</button>
            <button class="px-4 py-2 bg-gray-300 rounded">Kategorie</button>
            <button class="px-4 py-2 bg-gray-300 rounded">Náročnost</button>
            <input type="text" placeholder="Hledat..." class="border p-2 rounded flex-1">
        </nav>

        <main>
            <div class="grid grid-cols-3 gap-4">
                @foreach($quests as $quest)
                <div class="bg-white p-4 shadow rounded-lg">
                    <img src="{{ $quest['image'] }}" alt="{{ $quest['title'] }}" class="rounded-md mb-2">
                    <h2 class="text-lg font-bold">{{ $quest['title'] }}</h2>
                    <p class="text-sm text-gray-600">📍 {{ $quest['location'] }} | ⏳ {{ $quest['duration'] }} | 🚶 {{ $quest['distance'] }}</p>
                    <p class="mt-2 text-sm bg-gray-200 p-1 inline-block">{{ $quest['language'] }}</p>
                </div>
                @endforeach
            </div>
        </main>
    </div>
</body>

</html>
