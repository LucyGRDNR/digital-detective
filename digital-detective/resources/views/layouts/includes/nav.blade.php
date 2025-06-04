<nav class="mb-6 w-full flex flex-wrap items-center justify-between bg-gray-800 p-4 shadow">
    <div class="text-2xl font-bold text-white mb-2 sm:mb-0">
        <a href="{{ route('index') }}">
            Digitální Detektiv
        </a>
    </div>

    <div class="flex flex-col sm:flex-row sm:items-center sm:space-x-4 w-full sm:w-auto gap-2">
        @guest
            <a href="{{ route('login') }}" class="text-blue-400 hover:underline text-left sm:text-center">
                {{ __('Log In') }}
            </a>
            <a href="{{ route('register') }}" class="rounded bg-blue-600 px-4 py-2 text-white hover:bg-blue-700 text-center sm:text-left">
                {{ __('Sign Up') }}
            </a>
        @endguest

        @auth
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" class="flex items-center space-x-2 bg-gray-700 px-4 py-2 rounded text-white hover:bg-gray-600">
                    <span>{{ Auth::user()->name }}</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <div x-show="open" @click.away="open = false"
                    class="absolute right-0 mt-2 w-48 bg-white text-black rounded shadow-lg z-50">
                    <a href="{{ route('profile.show') }}"
                        class="block px-4 py-2 text-sm hover:bg-gray-100">
                        {{ __('Profile') }}
                    </a>

                    <form method="POST" action="{{ route('logout') }}" class="block">
                        @csrf
                        <button
                            type="submit"
                            class="w-full text-left px-4 py-2 text-sm hover:bg-gray-100">
                            {{ __('Log Out') }}
                        </button>
                    </form>
                </div>
            </div>
        @endauth

        @php
            $lang = Session::get('locale');
        @endphp

        @if($lang == 'cs')
        <a href="{{ route('changeLocale', ['locale' => 'en']) }}">
            <span
                src="{{ asset('img/flags/en.svg') }}"
                alt="{{ __('Language switch') }}"
                title="{{ __('Switch to :language.', ['language' => 'English']) }}"
                aria-title="{{ __('Switch to :language.', ['language' => 'English']) }}"
                class="img--locale img__en">
            </span>
        </a>
        @else
        <a href="{{ route('changeLocale', ['locale' => 'cs']) }}">
            <span
                src="{{ asset('storageimg/flags/cs.svg') }}"
                alt="{{ __('Language switch') }}"
                title="{{ __('Switch to :language.', ['language' => 'češtiny']) }}"
                aria-title="{{ __('Switch to :language.', ['language' => 'češtiny']) }}"
                class="img--locale img__cs">
            </span>
        </a>
        @endif
    </div>
</nav>
