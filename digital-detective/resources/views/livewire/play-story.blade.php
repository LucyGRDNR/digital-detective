<div class="max-w-3xl mx-auto rounded-lg bg-gray-900 bg-opacity-80 p-6 shadow-md border border-gray-700 text-white">

    <div class="mb-6">
        <h3 class="text-2xl font-bold mb-2">Obsah kapitoly</h3>
        <p class="whitespace-pre-line text-gray-300">{{ $chapterContent }}</p>
    </div>

    @if ($question)
        <div class="mb-6">
            <h4 class="text-xl font-semibold mb-2">Otázka:</h4>
            <p class="mb-4 text-gray-200">{{ $question->content }}</p>

            @if ($questionType == 1)
                <div class="space-y-3">
                    @foreach ($question->options as $option)
                        <button
                            wire:click="submitAnswer({{ $option->id }})"
                            class="w-full text-left rounded bg-blue-600 px-4 py-3 hover:bg-blue-700 transition">
                            {{ $option->text }}
                        </button>
                    @endforeach
                </div>
            @else
                <div class="flex space-x-3">
                    <input
                        type="text"
                        wire:model.defer="answerInput"
                        placeholder="Zadejte odpověď..."
                        class="flex-grow rounded border border-gray-600 bg-gray-800 px-4 py-2 text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                    >
                    <button
                        wire:click="submitAnswer"
                        class="rounded bg-green-600 px-4 py-2 text-white hover:bg-green-700 transition">
                        Odeslat
                    </button>
                </div>
            @endif
        </div>
    @endif

    @if ($showNextButton)
        <div class="mt-6">
            <button
                wire:click="nextChapter"
                class="w-full text-left text-center rounded bg-blue-600 px-4 py-3 hover:bg-blue-700 transition">
                Dále
            </button>
        </div>
    @endif

    @if ($storyEnded)
        <div class="mt-6 text-center">
            <p class="text-xl text-green-400 font-bold">Konec příběhu</p>
        </div>
    @endif

</div>
