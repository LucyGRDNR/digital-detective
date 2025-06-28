<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>{{ __('create-edit.edit_story') }}: {{ $story->name }} - {{ __('create-edit.digital_detective') }}</title>

        @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/edit.js'])

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
    </head>

    <body class="bg-[url('/storage/app/public/images/download.png')] bg-no-repeat bg-cover bg-fixed text-white min-h-screen relative">

        @include('partials._navbar')

        <main class="px-6">
            <form id="story-edit-form" method="POST" action="{{ route('stories.update', $story->id) }}"
                enctype="multipart/form-data" class="max-w-4xl mx-auto p-6 bg-white shadow-md rounded-lg my-8">
                @csrf
                @method('PUT')

                <div class="mb-6 p-4 border rounded-lg bg-gray-50">
                    <h3 class="text-lg font-semibold mb-4 text-gray-800">{{ __('create-edit.story_details') }}</h3>
                    <div class="space-y-4">

                        <div>
                            <label for="story-name" class="block text-sm font-medium text-gray-700 mb-1">
                                {{ __('create-edit.story_name') }}:<span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="story-name" name="name" maxlength="80" required
                                class="story-input border border-gray-300 p-2 rounded-md w-full focus:ring-purple-500 focus:border-purple-500 text-gray-900"
                                value="{{ old('name', $story->name) }}">
                                <p id="error-name" class="text-red-500 text-xs mt-1"></p>
                            @error('name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="story-description" class="block text-sm font-medium text-gray-700 mb-1">
                                {{ __('create-edit.story_description') }}:<span class="text-red-500">*</span>
                            </label>
                            <textarea id="story-description" name="description" rows="3"
                                class="story-input border border-gray-300 p-2 rounded-md w-full focus:ring-purple-500 focus:border-purple-500 text-gray-900"
                                >{{ old('description', $story->description) }}</textarea>
                            <p id="error-description" class="text-red-500 text-xs mt-1"></p>
                            @error('description')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                                <label for="image-upload" class="block text-sm font-medium text-gray-700 mb-1">
                                {{ __('create-edit.story_main_image') }}:<span class="text-red-500">*</span>
                            </label>
                            <input type="file" id="image-upload" name="image_file" accept="image/*" required
                                class="story-input block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 file:cursor-pointer">
                            <p id="error-image_file" class="text-red-500 text-xs mt-1"></p>
                                @error('image_file')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div id="current-story-image-preview" class="mt-4 {{ $story->image_path ? '' : 'hidden' }}">
                            <img id="story-image-tag" src="{{ $story->image_path ? asset('storage/' . $story->image_path) : '' }}" class="max-w-full h-auto rounded-md" alt="{{ __('create-edit.current_story_image') }}">
                        </div>

                        <div>
                            <label for="story-place" class="block text-sm font-medium text-gray-700 mb-1">
                                {{ __('create-edit.story_place') }}:<span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="story-place" maxlength="80" name="place"
                                class="story-input border border-gray-300 p-2 rounded-md w-full focus:ring-purple-500 focus:border-purple-500 text-gray-900"
                                value="{{ old('place', $story->place) }}">
                            <p id="error-place" class="text-red-500 text-xs mt-1"></p>
                            @error('place')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="place-gps" class="block text-sm font-medium text-gray-700 mb-1">
                                {{ __('create-edit.story_place_gps_optional') }}
                            </label>
                            <input type="text" id="place-gps" name="place_GPS"
                                class="story-input border border-gray-300 p-2 rounded-md w-full focus:ring-purple-500 focus:border-purple-500 text-gray-900"
                                value="{{ old('place_GPS', $story->place_GPS) }}">
                            @error('place_GPS')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                            <div>
                                <label for="story-distance" class="block text-sm font-medium text-gray-700 mb-1">
                                    {{ __('create-edit.story_distance_km') }}:<span class="text-red-500">*</span>
                                </label>
                                <input type="number" id="story-distance" name="distance" min="0"
                                    value="{{ old('distance', $story->distance) }}" required
                                    class="story-input border border-gray-300 p-2 rounded-md w-full focus:ring-purple-500 focus:border-purple-500 text-gray-900">
                                <p id="error-distance" class="text-red-500 text-xs mt-1"></p>
                                    @error('distance')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="story-time" class="block text-sm font-medium text-gray-700 mb-1">
                                    {{ __('create-edit.story_estimated_time_minutes') }}:<span class="text-red-500">*</span>
                                </label>
                                <input type="number" id="story-time" name="time" min="0"
                                    value="{{ old('time', $story->time) }}" required
                                    class="story-input border border-gray-300 p-2 rounded-md w-full focus:ring-purple-500 focus:border-purple-500 text-gray-900">
                                <p id="error-time" class="text-red-500 text-xs mt-1"></p>
                                @error('time')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div id="chapters-container" class="space-y-6"></div>

                <input type="hidden" name="chapters_data" id="chapters-data-input">
                <input type="hidden" name="chapter_images_to_delete" id="chapter-images-to-delete-input">
                <input type="hidden" name="deleted_question_ids" id="deleted-question-ids-input">
                <input type="hidden" name="deleted_option_ids" id="deleted-option-ids-input">

                <div class="flex justify-between items-center mt-8">

                    <button type="button" onclick="addChapter()" class="cursor-pointer bg-gray-800 hover:bg-blue-700 text-white px-8 py-3 rounded-lg transition duration-200 ease-in-out">
                        <i class="fas fa-plus mr-2"></i> {{ __('create-edit.add_chapter_button') }}
                    </button>

                    <div class="flex space-x-4">
                        <button type="submit" form="story-delete-form"
                            class="cursor-pointer bg-gray-800 hover:bg-red-800 text-white px-8 py-3 rounded-lg shadow-lg transition duration-200 ease-in-out"
                            onclick="return confirm('{{ __('create-edit.confirm_delete_story') }}');">
                            <i class="fas fa-trash-alt mr-2"></i> {{ __('create-edit.delete_story_button') }}
                        </button>

                        <button type="submit" onclick="prepareAndSubmitStory(event)"
                            class="cursor-pointer bg-gray-800 hover:bg-green-800 text-white px-8 py-3 rounded-lg shadow-lg transition duration-200 ease-in-out">
                            {{ __('create-edit.save_changes_button') }}
                        </button>
                    </div>
                </div>
            </form>

            <form id="story-delete-form" method="POST" action="{{ route('stories.destroy', $story->id) }}" class="hidden">
                @csrf
                @method('DELETE')
            </form>

            <template id="chapter-template">
                <div class="border rounded-lg p-6 space-y-4 chapter-block relative bg-white shadow-sm">

                    <input type="hidden" class="chapter-temp-id">
                    <input type="hidden" class="chapter-db-id">

                    <h3 class="text-lg font-semibold mb-4 text-gray-800 flex justify-between items-center">
                        <span class="flex-shrink-0">{{ __('create-edit.chapter') }} <span class="chapter-number"></span></span>
                        <span class="chapter-next-display text-sm font-normal text-gray-500 text-right flex-grow flex-shrink min-w-0 break-words ml-4"></span>
                    </h3>

                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4">
                        <label for="chapter-title" class="font-semibold text-gray-700 sm:w-1/4">{{ __('create-edit.chapter_title') }}:<span class="text-red-500">*</span></label>
                        <input type="text" maxlength="40" class="chapter-title border border-gray-300 p-2 rounded-md w-full sm:w-3/4 focus:ring-blue-500 focus:border-blue-500 text-gray-700" required>
                        <p class="error-chapter-title text-red-500 text-xs mt-1"></p>
                    </div>

                    <div>
                        <label for="chapter-content" class="block font-semibold text-gray-700 mb-1">{{ __('create-edit.chapter_content') }}:<span class="text-red-500">*</span></label>
                        <textarea class="chapter-content border border-gray-300 p-2 rounded-md w-full focus:ring-blue-500 focus:border-blue-500 text-gray-700" rows="4" required></textarea>
                        <p class="error-chapter-content text-red-500 text-xs mt-1"></p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('create-edit.chapter_upload_image_optional') }}</label>
                        <div class="current-chapter-image-container mb-2 hidden">
                            <img src="" alt="{{ __('create-edit.current_chapter_image') }}" class="max-w-full h-auto rounded-md border border-gray-300">
                            <button type="button"
                                class="delete-chapter-image-button bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-md text-sm mt-2 transition duration-200 ease-in-out">
                                <i class="fas fa-times mr-1"></i> {{ __('create-edit.delete_image') }}
                            </button>
                        </div>
                        <input type="file" class="chapter-image-upload story-input block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 file:cursor-pointer">
                        <p class="error-chapter-image-upload text-red-500 text-xs mt-1"></p>
                    </div>

                    <div class="flex items-center mt-4">
                        <input type="checkbox" class="is-end-chapter mr-2 h-5 w-5 text-blue-600 rounded focus:ring-blue-500 border border-gray-300 cursor-pointer">
                        <label class="font-semibold text-gray-700 cursor-pointer">{{ __('create-edit.is_end_chapter') }}</label>
                    </div>

                    <div class="next-chapter-section mt-4 hidden">
                        <label for="next-chapter" class="block font-semibold text-gray-700 mb-1">{{ __('create-edit.next_chapter_title') }}:</label>
                        <select class="next-chapter cursor-pointer border border-gray-300 p-2 rounded-md w-full focus:ring-blue-500 focus:border-blue-500 text-gray-700">
                        </select>
                        <p class="error-next-chapter text-red-500 text-xs mt-1"></p>
                    </div>

                    <div class="has-question-section mt-4 hidden">
                        <label for="has-question" class="block font-semibold text-gray-700 mb-1">{{ __('create-edit.add_question') }}</label>
                        <select class="has-question cursor-pointer border border-gray-300 rounded-md p-2 w-full focus:ring-blue-500 focus:border-blue-500 text-gray-700">
                            <option value="0">{{ __('create-edit.no') }}</option>
                            <option value="1">{{ __('create-edit.yes') }}</option>
                        </select>
                    </div>

                    <div class="question-section hidden space-y-4 p-4 border rounded-lg bg-gray-100 mt-4">
                        <h4 class="text-md font-semibold text-gray-800">{{ __('create-edit.question_details') }}</h4>
                        <input type="hidden" class="question-db-id">

                        <div>
                            <label for="question-text" class="block text-sm font-medium text-gray-700 mb-1">{{ __('create-edit.question_text') }}:<span class="text-red-500">*</span></label>
                            <textarea class="question-text border border-gray-300 p-2 rounded-md w-full focus:ring-blue-500 focus:border-blue-500 text-gray-700" rows="2" required></textarea>
                            <p class="error-question-text text-red-500 text-xs mt-1"></p>
                        </div>

                        <div>
                            <label for="question-hint" class="block text-sm font-medium text-gray-700 mb-1">{{ __('create-edit.question_hint_optional') }}:</label>
                            <input type="text" class="question-hint border border-gray-300 p-2 rounded-md w-full focus:ring-blue-500 focus:border-blue-500 text-gray-700">
                            <p class="error-question-hint text-red-500 text-xs mt-1"></p>
                        </div>

                        <div>
                            <label for="question-type" class="block text-sm font-medium text-gray-700 mb-1">{{ __('create-edit.answer_type') }}:<span class="text-red-500">*</span></label>
                            <select class="question-type cursor-pointer border border-gray-300 rounded-md p-2 w-full focus:ring-blue-500 focus:border-blue-500 text-gray-700" required>
                                <option value="">{{ __('create-edit.select_answer_type') }}</option>
                                <option value="1">{{ __('create-edit.answer_type_text') }}</option>
                                <option value="2">{{ __('create-edit.answer_type_number') }}</option>
                                <option value="3">{{ __('create-edit.answer_type_multiple_choice') }}</option>
                            </select>
                            <p class="error-question-type text-red-500 text-xs mt-1"></p>
                        </div>

                        <div class="input-answer-section hidden mt-4">
                            <label for="input-answer" class="block text-sm font-medium text-gray-700 mb-1">{{ __('create-edit.correct_answer') }}:<span class="text-red-500">*</span></label>
                            <input type="text" class="input-answer border border-gray-300 p-2 rounded-md w-full focus:ring-blue-500 focus:border-blue-500 text-gray-700" required>
                            <p class="error-input-answer text-red-500 text-xs mt-1"></p>
                        </div>

                        <div class="mcq-answer-section hidden mt-4">
                            <h5 class="text-md font-semibold text-gray-700 mb-2">{{ __('create-edit.options_max_5') }}</h5>
                            <div class="options space-y-3">
                            </div>
                            <button type="button" class="add-option cursor-pointer bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded-md mt-3 text-sm transition duration-200 ease-in-out">
                                <i class="fas fa-plus mr-1"></i> {{ __('create-edit.add_option') }}
                            </button>
                            <p class="error-options-count text-red-500 text-xs mt-1"></p>
                        </div>

                        <div>
                            <label for="wrong-feedback" class="block text-sm font-medium text-gray-700 mb-1">{{ __('create-edit.wrong_answer_feedback') }}:<span class="text-red-500">*</span></label>
                            <textarea class="wrong-feedback border border-gray-300 p-2 rounded-md w-full focus:ring-blue-500 focus:border-blue-500 text-gray-700" rows="2" required></textarea>
                            <p class="error-wrong-feedback text-red-500 text-xs mt-1"></p>
                        </div>
                    </div>

                    <button type="button"
                        class="delete-chapter cursor-pointer absolute top-2 right-2 text-xl text-red-600 hover:text-red-800 font-bold transition duration-200 ease-in-out"
                        title="{{ __('create-edit.delete_chapter') }}">
                        &times;
                    </button>
                </div>
            </template>

            <template id="option-template">
                <div class="border border-gray-200 rounded-md p-3 relative option-item">

                    <input type="hidden" class="option-db-id">

                    <input type="text" class="option-text border border-gray-300 p-2 rounded-md w-full mb-2 text-sm focus:ring-blue-500 focus:border-blue-500 text-gray-700" placeholder="{{ __('create-edit.option_text_placeholder') }}" required>
                    <p class="error-option-text text-red-500 text-xs mt-1"></p>

                    <div class="flex items-center mb-2">
                        <input type="checkbox" class="is-correct mr-2 h-4 w-4 text-green-600 rounded focus:ring-blue-500 border border-gray-300 cursor-pointer">
                        <label class="text-sm font-medium text-gray-700 cursor-pointer">{{ __('create-edit.correct_answer') }}</label>
                    </div>

                    <label class="block text-xs font-medium text-gray-600 mb-1">{{ __('create-edit.go_to_chapter') }}:</label>
                    <select class="option-next cursor-pointer border border-gray-300 p-2 rounded-md w-full text-sm focus:ring-blue-500 focus:border-blue-500 text-gray-700" required>
                    </select>
                    <p class="error-option-next text-red-500 text-xs mt-1"></p>

                    <button type="button" class="delete-option cursor-pointer absolute top-2 right-2 text-lg text-red-500 hover:text-red-700 font-bold transition duration-200 ease-in-out" title="{{ __('create-edit.remove_option') }}">
                        &times;
                    </button>
                </div>
            </template>

        </main>
        <script>
            window.initialStoryData = @json($story);
            window.baseImageUrl = "{{ Storage::url('') }}";
        </script>
        <script>
            window.Laravel = {lang: {!! json_encode(trans('create-edit')) !!}};
        </script>
        <script src="//unpkg.com/alpinejs" defer></script>
    </body>
</html>
