<div>
    <h1 class="text-2xl font-bold mb-2 text-white">{{ $story->name }}</h1>
    <p class="text-lg text-gray-300 mb-4">{{ __('play.chapter') }}: <span>{{ $currentChapter->title }}</span></p>

    <div id="game-content-area" class="bg-gray-800 p-4 rounded-lg shadow-md">

        <div id="chapter-content" class="mb-4">
            <p class="text-gray-200 text-base leading-relaxed text-justify">{!! nl2br(e($currentChapter->content)) !!}</p>
        </div>

        @if($currentChapter->image_path)
            <div class="mb-4 overflow-hidden rounded-lg shadow-md">
                <img src="{{ asset('storage/' . $currentChapter->image_path) }}" alt="Chapter Image"
                    class="w-full max-h-64 object-cover object-center">
            </div>
        @endif

        @if($question && !$isGameEnd && !$showFeedback)
            <div class="mt-4 rounded-lg bg-gray-800">
                <h3 class="text-md font-semibold mb-3 text-white">{{ $question->text }}</h3>

                @if($question->hint)
                    <div class="mt-3 mb-3">
                        @if($hintWasShown)
                            <div class="p-3 border border-gray-600 rounded-lg bg-gray-700/70">
                                <p class="text-sm text-gray-300">{{ $question->hint }}</p>
                                <button wire:click="hideHint" class="mt-2 bg-gray-600 text-white px-3 py-1 rounded hover:bg-gray-700 text-xs">{{ __('play.hide_hint') }}</button>
                            </div>
                        @else
                            <button wire:click="showHint" class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700 text-sm"><i class="fa-regular fa-lightbulb"></i></button>
                        @endif
                    </div>
                @endif

                @if(in_array($question->type, [1,2]))
                    <div>
                        <input type="{{ $question->type === 2 ? 'number' : 'text' }}"
                            wire:model.live="inputAnswer"
                            wire:keydown.enter="submitAnswer"
                            class="w-full p-2 rounded bg-gray-700 border border-gray-600 text-white placeholder-gray-400 mt-3 focus:ring focus:ring-blue-500 focus:border-blue-500"
                            placeholder="{{ $question->type === 2 ? __('play.enter_number') : __('play.enter_answer') }}">
                        @error('inputAnswer') <div class="text-red-400 mt-1 text-sm">{{ $message }}</div> @enderror
                        <button wire:click="submitAnswer"
                                class="mt-3 w-full bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 disabled:opacity-50 disabled:cursor-not-allowed"
                                @if($inputAnswer === '') disabled @endif>
                            {{ __('play.submit') }}
                        </button>
                    </div>
                @endif

                @if($question->type === 3)
                    <div class="space-y-2 mt-3">
                        @foreach($question->options as $option)
                            <div>
                                <input type="radio" id="option-{{ $option->id }}" name="question-{{ $question->id }}-options" wire:model.live="selectedOptionId" value="{{ $option->id }}"
                                        class="form-radio h-4 w-4 text-blue-600 bg-gray-700 border-gray-600 focus:ring-blue-500 cursor-pointer">
                                <label for="option-{{ $option->id }}" class="ml-2 text-gray-300 cursor-pointer">{{ $option->text }}</label>
                            </div>
                        @endforeach
                        @error('selectedOptionId') <div class="text-red-400 mt-1 text-sm">{{ $message }}</div> @enderror
                        <button wire:click="submitAnswer"
                                class="mt-3 w-full bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 disabled:opacity-50 disabled:cursor-not-allowed"
                                @if(!$selectedOptionId) disabled @endif>
                            {{ __('play.submit') }}
                        </button>
                    </div>
                @endif
            </div>
        @endif

        @if(!$question && !$isGameEnd && !$showFeedback)
            <div class="mt-4">
                <button wire:click="continueGame"
                        class="w-full bg-blue-600 text-white px-6 py-3 rounded hover:bg-blue-700 text-lg font-semibold">
                    {{ __('play.continue') }}
                </button>
            </div>
        @endif
    </div>

    @if($showFeedback && !$isGameEnd)
        <div class="mt-4 p-4 rounded-lg bg-red-900 border border-red-950">
            <h3 class="text-md font-semibold mb-3 whitespace-pre-wrap text-white">{{ $feedbackMessage }}</h3>
            <button wire:click="clearFeedbackAndContinue"
                    class="mt-3 w-full bg-gray-800 text-white px-4 py-2 rounded hover:bg-gray-700">
                {{ __('play.continue') }}
            </button>
        </div>
    @endif

    @if($isGameEnd)
        <div class="mt-6 text-center text-xl font-semibold text-green-400 p-4 bg-gray-800 rounded-lg shadow-md">
            <span>{{ __('play.end_story_congratulations') }}</span>
            <br>
            <a href="/" class="underline text-blue-400 hover:text-blue-500 mt-4 inline-block">{{ __('play.back_to_homepage') }}</a>
        </div>
    @endif
</div>