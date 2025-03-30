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

        button:hover {
            background-color: #111;
            color: white;
        }

        button {
            padding: 15px 30px;
            background-color: #374151;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        /* Header */
        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 30px;
        }

        h1 {
            font-size: 25px;
            font-weight: bold;
            color: white;
        }

        /* Header Buttons */
        .header-buttons {
            display: flex;
            gap: 10px;
        }

        .header-buttons button {
            border-radius: 30px;
        }

        .white-button {
            background-color: white;
            color: #374151;
        }

        /* Navigation */
        nav {
            padding: 15px 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        nav ul {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        nav button {
            border-radius: 15px;
            padding: 15px 50px;
        }

        /* Dropdown */
        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #374151c2;
            width: 100%;
            box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
            z-index: 1;
            padding: 15px;
            box-sizing: border-box;
            border-radius: 10px;
            min-width: auto;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        .dropdown-content label {
            display: block;
            margin-bottom: 10px;
            padding-left: 15px;
            font-size: 15px;
        }

        .dropdown-content label input {
            margin-right: 10px;
        }

        /* Search Input */
        nav input {
            padding: 15px 30px;
            border-radius: 10px;
            border: none;
            background-color: #374151c2;
        }

        /* Main Content */
        main {
            width: 1200px;
            margin: 0 auto;
        }

        /* Card Styles */
        .cards {
            background-color: #374151c2;
            border-radius: 20px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            position: relative;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            width: 100%;
            aspect-ratio: 401 / 509;
        }

        .cards:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
        }

        .cards img {
            width: 100%;
            object-fit: cover;
            height: 100%;
        }

        .cards h2 {
            margin: 15px 0;
            font-size: 18px;
            font-weight: bold;
            text-align: center;
        }

        .cards p {
            font-size: 14px;
            color: #e2e8f0;
            text-align: center;
            margin: 10px 0;
        }

        .cards .language-tag {
            background-color: #edf2f7;
            color: #374151;
            padding: 5px 12px;
            border-radius: 15px;
            margin-top: 10px;
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
        <div class="header-buttons">
            <button>Přihlášení</button>
            <button class="white-button">English</button>
        </div>
    </header>

    <nav>
        <ul>
            <li class="dropdown">
                <button>Jazyk</button>
                <div class="dropdown-content">
                    <label><input type="checkbox" value="Czech"> Czech</label>
                    <label><input type="checkbox" value="English"> English</label>
                    <label><input type="checkbox" value="German"> German</label>
                </div>
            </li>

            <li class="dropdown">
                <button>Délka trasy</button>
                <div class="dropdown-content">
                    <label><input type="checkbox" value="Short"> Short</label>
                    <label><input type="checkbox" value="Medium"> Medium</label>
                    <label><input type="checkbox" value="Long"> Long</label>
                </div>
            </li>

            <li class="dropdown">
                <button>Město</button>
                <div class="dropdown-content">
                    <label><input type="checkbox" value="Prague"> Prague</label>
                    <label><input type="checkbox" value="Brno"> Brno</label>
                    <label><input type="checkbox" value="Ostrava"> Ostrava</label>
                </div>
            </li>

            <li class="dropdown">
                <button>Kategorie</button>
                <div class="dropdown-content">
                    <label><input type="checkbox" value="Adventure"> Adventure</label>
                    <label><input type="checkbox" value="Mystery"> Mystery</label>
                    <label><input type="checkbox" value="History"> History</label>
                </div>
            </li>

            <li class="dropdown">
                <button>Náročnost</button>
                <div class="dropdown-content">
                    <label><input type="checkbox" value="Easy"> Easy</label>
                    <label><input type="checkbox" value="Medium"> Medium</label>
                    <label><input type="checkbox" value="Hard"> Hard</label>
                </div>
            </li>

            <li>
                <input type="text" placeholder="Hledat..." class="border p-2 rounded">
            </li>
        </ul>
    </nav>

    <main>
        <div class="grid">
            @foreach($quests as $quest)
            <div class="cards">
                <img src="{{ $quest['image'] }}" alt="{{ $quest['title'] }}" class="rounded-md mb-2">
                <h2>{{ $quest['title'] }}</h2>
                <p>📍 {{ $quest['location'] }} | ⏳ {{ $quest['duration'] }} | 🚶
                    {{ $quest['distance'] }}</p>
                <p class="language-tag">{{ $quest['language'] }}</p>
            </div>
            @endforeach
        </div>
    </main>

</body>

</html>
