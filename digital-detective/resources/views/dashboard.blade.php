<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    {{-- Trix Editor CSS --}}
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@1.3.1/dist/trix.css">

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h3 class="text-lg font-bold mb-4 text-gray-800">Chapter Editor (Preview)</h3>

                {{-- Trix editor --}}
                <form method="POST" action="#">
                    @csrf
                    <input id="chapter-content" type="hidden" name="content">
                    <trix-editor input="chapter-content" class="trix-content"></trix-editor>
                </form>

                <p class="mt-4 text-sm text-gray-600">This is just a preview. The content is not saved anywhere.</p>
            </div>
        </div>
    </div>

    {{-- Trix Editor JS --}}
    <script type="text/javascript" src="https://unpkg.com/trix@1.3.1/dist/trix.js"></script>
</x-app-layout>
