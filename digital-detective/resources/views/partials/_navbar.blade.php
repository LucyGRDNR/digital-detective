<nav class="mb-6 w-full flex items-center justify-between bg-gray-900 bg-opacity-90 p-4 shadow-lg" x-data="{ open: false }">
    <div class="text-2xl font-bold text-white">
        <a href="{{ route('home') }}" class="text-white hover:text-gray-300 transition duration-200 ease-in-out">{{ __('welcome-show.digital_detective') }}</a>
    </div>

    <button @click="open = true" class="sm:hidden text-white focus:outline-none p-2 rounded-md hover:bg-gray-700 transition duration-200 ease-in-out">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
        </svg>
    </button>

    <div class="hidden sm:flex sm:items-center sm:space-x-6">
        @guest
            <div class="relative" x-data="{ langDropdownOpen: false }">
                <button @click="langDropdownOpen = !langDropdownOpen" class="flex items-center space-x-1 bg-gray-700 px-3 py-1 rounded-md text-white hover:bg-gray-600 transition duration-200 ease-in-out">
                    <i class="fas fa-globe mr-2"></i> {{ strtoupper(App::getLocale()) }}
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <div x-show="langDropdownOpen" @click.away="langDropdownOpen = false"
                    x-transition:enter="transition ease-out duration-100"
                    x-transition:enter-start="transform opacity-0 scale-95"
                    x-transition:enter-end="transform opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-75"
                    x-transition:leave-start="transform opacity-100 scale-100"
                    x-transition:leave-end="transform opacity-0 scale-95"
                    class="absolute right-0 mt-2 w-32 bg-gray-700 text-white rounded-md shadow-lg z-50 origin-top-right border border-gray-600">
                    <form action="{{ route('language.switch') }}" method="POST">
                        @csrf
                        <input type="hidden" name="locale" value="cs">
                        <button type="submit" class="block w-full text-left px-4 py-2 rounded-t-md hover:bg-gray-600 transition duration-150 ease-in-out @if(App::getLocale() == 'cs') font-bold bg-gray-600 @endif">Česky</button>
                    </form>
                    <form action="{{ route('language.switch') }}" method="POST">
                        @csrf
                        <input type="hidden" name="locale" value="en">
                        <button type="submit" class="block w-full text-left px-4 py-2 rounded-b-md hover:bg-gray-600 transition duration-150 ease-in-out @if(App::getLocale() == 'en') font-bold bg-gray-600 @endif">English</button>
                    </form>
                </div>
            </div>

            <a href="{{ route('login') }}" class="text-blue-400 hover:underline transition duration-200 ease-in-out">{{ __('welcome-show.login_link') }}</a>
            <a href="{{ route('register') }}" class="rounded bg-blue-600 px-4 py-2 text-white hover:bg-blue-700 transition duration-200 ease-in-out">{{ __('welcome-show.register_link') }}</a>
        @endguest

        @auth
            @php
                $currentXp = Auth::user()->xp ?? 0;
                $currentLevel = Auth::user()->level ?? 1;
                $xpThreshold = 75; 

                $xpForCurrentLevelStart = ($currentLevel - 1) * $xpThreshold;
                $xpIntoCurrentLevel = $currentXp - $xpForCurrentLevelStart;
                $xpNeededForNextLevel = $xpThreshold;
                $xpProgressPercent = ($xpNeededForNextLevel > 0) ? ($xpIntoCurrentLevel / $xpNeededForNextLevel) * 100 : 100;
                $xpRemaining = $xpNeededForNextLevel - $xpIntoCurrentLevel;
            @endphp

            <div class="relative" x-data="{ dropdownOpen: false }">
                <button @click="dropdownOpen = !dropdownOpen" class="flex items-center space-x-2 bg-gray-700 px-3 py-1 rounded-md text-white hover:bg-gray-600 transition duration-200 ease-in-out">
                    <span>{{ Auth::user()->name }}</span>
                    <span class="ml-2 px-2 py-1 bg-blue-600 text-xs rounded-full font-bold">Lvl {{ $currentLevel }}</span> {{-- Displays Level on button --}}
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <div x-show="dropdownOpen" @click.away="dropdownOpen = false"
                    x-transition:enter="transition ease-out duration-100"
                    x-transition:enter-start="transform opacity-0 scale-95"
                    x-transition:enter-end="transform opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-75"
                    x-transition:leave-start="transform opacity-100 scale-100"
                    x-transition:leave-end="transform opacity-0 scale-95"
                    class="absolute right-0 mt-2 w-48 bg-gray-700 text-white rounded-md shadow-lg z-50 border border-gray-600">
                    
                    <div class="px-4 py-2 text-xs border-b border-gray-600">
                        <p class="mb-1">XP: {{ $xpIntoCurrentLevel }}/{{ $xpNeededForNextLevel }}</p>
                        <div class="relative w-full h-3 bg-gray-600 rounded-full overflow-hidden">
                            <div class="absolute inset-0 bg-blue-500 transition-all duration-300 ease-in-out rounded-full" style="width: {{ $xpProgressPercent }}%;"></div>
                        </div>
                    </div>

                    <div class="py-1 border-b border-gray-600">
                        <form action="{{ route('language.switch') }}" method="POST">
                            @csrf
                            <input type="hidden" name="locale" value="cs">
                            <button type="submit" class="block w-full text-left px-4 py-2 hover:bg-gray-600 transition duration-150 ease-in-out @if(App::getLocale() == 'cs') font-bold bg-gray-600 @endif">
                                <i class="fas fa-globe mr-2"></i> Česky
                            </button>
                        </form>
                        <form action="{{ route('language.switch') }}" method="POST">
                            @csrf
                            <input type="hidden" name="locale" value="en">
                            <button type="submit" class="block w-full text-left px-4 py-2 hover:bg-gray-600 transition duration-150 ease-in-out @if(App::getLocale() == 'en') font-bold bg-gray-600 @endif">
                                <i class="fas fa-globe mr-2"></i> English
                            </button>
                        </form>
                    </div>

                    @if(Auth::user()->hasRole('admin'))
                        <a href="{{ route('story.create') }}" class="block px-4 py-2 text-sm hover:bg-gray-600 transition duration-150 ease-in-out">
                        {{ __('welcome-show.add_new_story') }}
                        </a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}" class="block">
                        @csrf
                        <button type="submit" class="w-full text-left px-4 py-2 text-sm hover:bg-gray-600 transition duration-150 ease-in-out rounded-b">{{ __('welcome-show.logout') }}</button>
                    </form>
                </div>
            </div>
        @endauth
    </div>

    <div x-show="open"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-300"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-40 sm:hidden"
        @click.away="open = false"
        x-cloak>

        <div class="absolute inset-0 bg-black opacity-50"></div>

        <div class="fixed inset-y-0 right-0 w-64 bg-gray-900 shadow-lg transform translate-x-full transition-transform ease-in-out duration-300 z-50"
            :class="{ 'translate-x-0': open, 'translate-x-full': !open }">
            <div class="p-4 pt-10">
                <button @click="open = false" class="absolute top-4 right-4 text-white focus:outline-none p-2 rounded-md hover:bg-gray-700 transition duration-200 ease-in-out">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>

                <div class="flex flex-col space-y-4 pt-4">
                    @auth
                    <div class="flex items-center space-x-2 bg-gray-700 px-4 py-2 rounded-md text-white border border-gray-600">
                        <span class="font-bold text-lg leading-none">{{ Auth::user()->name }}</span>
                        <span class="ml-2 px-2 py-1 bg-blue-600 text-sm rounded-full font-bold">Lvl {{ $currentLevel }}</span>
                    </div>

                    <div class="px-4 py-2 text-xs">
                        <p class="mb-1 text-white">XP: {{ $xpIntoCurrentLevel }}/{{ $xpNeededForNextLevel }}</p>
                        <div class="relative w-full h-3 bg-gray-600 rounded-full overflow-hidden">
                            <div class="absolute inset-0 bg-blue-500 transition-all duration-300 ease-in-out rounded-full" style="width: {{ $xpProgressPercent }}%;"></div>
                        </div>
                        <p class="mt-1 text-gray-400">Total: {{ $currentXp }} XP</p>
                    </div>
                    @endauth

                    <div class="relative w-full mt-8" x-data="{ langDropdownOpen: false }">
                        <button @click="langDropdownOpen = !langDropdownOpen" class="flex items-center justify-between w-full space-x-1 bg-gray-700 px-4 py-2 rounded-md text-white hover:bg-gray-600 transition duration-200 ease-in-out">
                            <span class="flex items-center space-x-2"><i class="fas fa-globe mr-2"></i> {{ strtoupper(App::getLocale()) }}</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <div x-show="langDropdownOpen" @click.away="langDropdownOpen = false"
                            x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="transform opacity-0 scale-95"
                            x-transition:enter-end="transform opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="transform opacity-100 scale-100"
                            x-transition:leave-end="transform opacity-0 scale-95"
                            class="absolute left-0 mt-2 w-full bg-gray-700 text-white rounded-md shadow-lg z-50 border border-gray-600">
                            <form action="{{ route('language.switch') }}" method="POST">
                                @csrf
                                <input type="hidden" name="locale" value="cs">
                                <button type="submit" class="block w-full text-left px-4 py-2 rounded-t-md hover:bg-gray-600 transition duration-150 ease-in-out @if(App::getLocale() == 'cs') font-bold bg-gray-600 @endif">Česky</button>
                            </form>
                            <form action="{{ route('language.switch') }}" method="POST">
                                @csrf
                                <input type="hidden" name="locale" value="en">
                                <button type="submit" class="block w-full text-left px-4 py-2 rounded-b-md hover:bg-gray-600 transition duration-150 ease-in-out @if(App::getLocale() == 'en') font-bold bg-gray-600 @endif">English</button>
                            </form>
                        </div>
                    </div>

                    @auth
                    @if(Auth::user()->hasRole('admin'))
                        <a href="{{ route('story.create') }}" class="block px-4 py-2 text-lg text-white hover:bg-gray-700 rounded transition duration-200 ease-in-out">{{ __('welcome-show.add_new_story') }}</a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}" class="block">
                        @csrf
                        <button type="submit" class="w-full text-left px-4 py-2 text-lg text-white hover:bg-gray-700 rounded transition duration-200 ease-in-out">{{ __('welcome-show.logout') }}</button>
                    </form>
                    @endauth

                    @guest
                        <a href="{{ route('login') }}" class="text-blue-400 hover:underline text-lg transition duration-200 ease-in-out">{{ __('welcome-show.login_link') }}</a>
                        <a href="{{ route('register') }}" class="rounded bg-blue-600 px-4 py-2 text-white hover:bg-blue-700 text-lg transition duration-200 ease-in-out">{{ __('welcome-show.register_link') }}</a>
                    @endguest
                </div>
            </div>
        </div>
</nav>
