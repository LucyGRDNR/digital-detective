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

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body class="bg-[url('/storage/app/public/images/download.png')] bg-repeat bg-center text-white min-h-screen">
    @include('partials._navbar')

    <main class="px-6 py-6">
        <div x-data="{
            searchQuery: '',
            filterDistance: '',
            filterTime: '',
            stories: @js($stories),

            filteredStories() {
                return this.stories.filter(story => {
                    const query = this.searchQuery.toLowerCase();
                    const matchesQuery = story.name.toLowerCase().includes(query) || story.place.toLowerCase().includes(query);

                    let distanceMatch = true;
                    if (this.filterDistance === 'short') distanceMatch = story.distance <= 2;
                    else if (this.filterDistance === 'medium') distanceMatch = story.distance > 2 && story.distance <= 5;
                    else if (this.filterDistance === 'long') distanceMatch = story.distance > 5;

                    let timeMatch = true;
                    if (this.filterTime === 'short') timeMatch = story.time <= 15;
                    else if (this.filterTime === 'medium') timeMatch = story.time > 15 && story.time <= 30;
                    else if (this.filterTime === 'long') timeMatch = story.time > 30;

                    return matchesQuery && distanceMatch && timeMatch;
                });
            },

            clearFilters() {
                this.searchQuery = '';
                this.filterDistance = '';
                this.filterTime = '';
            }
        }" class="space-y-6 max-w-6xl mx-auto"> <form @submit.prevent class="flex flex-col md:flex-row gap-4 w-full items-center">
                <input type="text" x-model="searchQuery" placeholder="{{ __('welcome-show.search') }}"
                    class="p-2 rounded bg-gray-700 text-white placeholder-gray-400 w-full md:flex-1 min-w-[180px]">

                <div class="flex flex-col sm:flex-row gap-4 w-full md:flex-1">
                    <div class="relative w-full sm:flex-1" x-data="{ distanceDropdownOpen: false }">
                        <button @click="distanceDropdownOpen = !distanceDropdownOpen" type="button"
                            class="flex items-center justify-between w-full space-x-1 bg-gray-700 px-3 py-2 rounded text-white hover:bg-gray-600 transition duration-200 ease-in-out">
                            <span>
                                <template x-if="filterDistance === ''">
                                    <span>{{ __('welcome-show.distance') }}</span>
                                </template>
                                <template x-if="filterDistance === 'short'">
                                    <span>0 - 2 km</span>
                                </template>
                                <template x-if="filterDistance === 'medium'">
                                    <span>2 - 5 km</span>
                                </template>
                                <template x-if="filterDistance === 'long'">
                                    <span>5+ km</span>
                                </template>
                            </span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <div x-show="distanceDropdownOpen" @click.away="distanceDropdownOpen = false"
                            x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="transform opacity-0 scale-95"
                            x-transition:enter-end="transform opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="transform opacity-100 scale-100"
                            x-transition:leave-end="transform opacity-0 scale-95"
                            class="absolute left-0 mt-2 w-full min-w-max bg-gray-700 text-white rounded shadow-lg z-50 origin-top-left border border-gray-600">
                            <button type="button" @click="filterDistance = ''; distanceDropdownOpen = false"
                                class="block w-full text-left px-4 py-2 hover:bg-gray-600 transition duration-150 ease-in-out"
                                :class="{ 'font-bold bg-gray-600': filterDistance === '' }"
                            >{{ __('welcome-show.distance') }}</button>
                            <button type="button" @click="filterDistance = 'short'; distanceDropdownOpen = false"
                                class="block w-full text-left px-4 py-2 hover:bg-gray-600 transition duration-150 ease-in-out"
                                :class="{ 'font-bold bg-gray-600': filterDistance === 'short' }"
                            >0 - 2 km</button>
                            <button type="button" @click="filterDistance = 'medium'; distanceDropdownOpen = false"
                                class="block w-full text-left px-4 py-2 hover:bg-gray-600 transition duration-150 ease-in-out"
                                :class="{ 'font-bold bg-gray-600': filterDistance === 'medium' }"
                            >2 - 5 km</button>
                            <button type="button" @click="filterDistance = 'long'; distanceDropdownOpen = false"
                                class="block w-full text-left px-4 py-2 hover:bg-gray-600 transition duration-150 ease-in-out"
                                :class="{ 'font-bold bg-gray-600': filterDistance === 'long' }"
                            >5+ km</button>
                        </div>
                    </div>

                    <div class="relative w-full sm:flex-1" x-data="{ timeDropdownOpen: false }">
                        <button @click="timeDropdownOpen = !timeDropdownOpen" type="button"
                            class="flex items-center justify-between w-full space-x-1 bg-gray-700 px-3 py-2 rounded text-white hover:bg-gray-600 transition duration-200 ease-in-out">
                            <span>
                                <template x-if="filterTime === ''">
                                    <span>{{ __('welcome-show.time') }}</span>
                                </template>
                                <template x-if="filterTime === 'short'">
                                    <span>0 - 15 min</span>
                                </template>
                                <template x-if="filterTime === 'medium'">
                                    <span>15 - 30 min</span>
                                </template>
                                <template x-if="filterTime === 'long'">
                                    <span>30+ min</span>
                                </template>
                            </span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <div x-show="timeDropdownOpen" @click.away="timeDropdownOpen = false"
                            x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="transform opacity-0 scale-95"
                            x-transition:enter-end="transform opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="transform opacity-100 scale-100"
                            x-transition:leave-end="transform opacity-0 scale-95"
                            class="absolute left-0 mt-2 w-full min-w-max bg-gray-700 text-white rounded shadow-lg z-50 origin-top-left border border-gray-600">
                            <button type="button" @click="filterTime = ''; timeDropdownOpen = false"
                                class="block w-full text-left px-4 py-2 hover:bg-gray-600 transition duration-150 ease-in-out"
                                :class="{ 'font-bold bg-gray-600': filterTime === '' }"
                            >{{ __('welcome-show.time') }}</button>
                            <button type="button" @click="filterTime = 'short'; timeDropdownOpen = false"
                                class="block w-full text-left px-4 py-2 hover:bg-gray-600 transition duration-150 ease-in-out"
                                :class="{ 'font-bold bg-gray-600': filterTime === 'short' }"
                            >0 - 15 min</button>
                            <button type="button" @click="filterTime = 'medium'; timeDropdownOpen = false"
                                class="block w-full text-left px-4 py-2 hover:bg-gray-600 transition duration-150 ease-in-out"
                                :class="{ 'font-bold bg-gray-600': filterTime === 'medium' }"
                            >15 - 30 min</button>
                            <button type="button" @click="filterTime = 'long'; timeDropdownOpen = false"
                                class="block w-full text-left px-4 py-2 hover:bg-gray-600 transition duration-150 ease-in-out"
                                :class="{ 'font-bold bg-gray-600': filterTime === 'long' }"
                            >30+ min</button>
                        </div>
                    </div>
                </div>

                <button type="button" @click="clearFilters"
                    class="p-2 bg-gray-700 hover:bg-red-800 text-white rounded w-full md:w-auto flex-none">
                    <i class="fas fa-times-circle mr-1"></i> {{ __('welcome-show.clear') }}
                </button>
            </form>

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3">
                <template x-for="story in filteredStories()" :key="story.id">
                    <div
                        class="relative flex flex-col rounded-lg bg-gray-800 bg-opacity-90 p-4 shadow-md transition duration-200 ease-in-out hover:scale-105 hover:shadow-lg">
                        <template x-if="{{ Auth::check() && Auth::user()->hasRole('admin') ? 'true' : 'false' }}">
                            <a :href="`/stories/${story.id}/edit`"
                                class="absolute top-2 right-2 text-blue-400 hover:text-blue-200 z-10 p-2 rounded-full bg-gray-700 bg-opacity-70 hover:bg-opacity-100 transition duration-150 ease-in-out"
                                title="Upravit příběh">
                                <i class="fas fa-edit text-lg"></i>
                            </a>
                        </template>

                        <a :href="`/stories/${story.id}`" style="text-decoration: none; color: inherit;">
                            <div class="mb-3 h-48 w-full overflow-hidden rounded">
                                <img :src="story.image_path ? `/storage/${story.image_path}` : 'https://placehold.co/400x250/333333/FFFFFF?text=No+Image'"
                                    alt="" class="h-full w-full object-cover" />
                            </div>
                            <h2 class="mb-1 text-lg font-bold text-center" x-text="story.name"></h2>
                            <p class="mb-2 text-sm text-gray-300">
                                <strong class="text-gray-200">
                                    <i class="fas fa-map-marker-alt mr-2 text-base"></i> <span>{{ __('welcome-show.location') }}</span>:
                                </strong> <span x-text="story.place"></span>
                            </p>
                            <p class="mb-2 text-sm text-gray-300">
                                <strong class="text-gray-200">
                                    <i class="fas fa-clock mr-2"></i> <span>{{ __('welcome-show.time') }}</span>:
                                </strong> <span x-text="story.time"></span> <span>{{ __('welcome-show.minutes') }}</span>
                            </p>
                            <p class="mb-2 text-sm text-gray-300">
                                <strong class="text-gray-200">
                                    <i class="fas fa-route mr-2"></i> <span>{{ __('welcome-show.distance') }}</span>:
                                </strong> <span x-text="story.distance"></span> <span>{{ __('welcome-show.kilometers') }}</span>
                            </p>
                        </a>
                    </div>
                </template>
            </div>
        </div>
    </main>

    <script src="//unpkg.com/alpinejs" defer></script>
</body>

</html>