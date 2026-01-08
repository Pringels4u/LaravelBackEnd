<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Nieuwsbericht Schrijven</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                <form action="{{ route('news.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <div>
                        <x-input-label for="title" value="Titel" />
                        <x-text-input id="title" name="title" type="text" class="block mt-1 w-full" required />
                    </div>

                    <div>
                        <x-input-label for="content" value="Inhoud" />
                        <textarea id="content" name="content" rows="5" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500"></textarea>
                    </div>

                    <div>
                        <x-input-label for="published_at" value="Publicatiedatum" />
                        <x-text-input id="published_at" name="published_at" type="datetime-local" class="block mt-1 w-full" value="{{ now()->format('Y-m-d\TH:i') }}" />
                    </div>

                    <div>
                        <x-input-label for="image" value="Afbeelding (optioneel)" />
                        <input type="file" name="image" class="mt-1 block w-full text-sm">
                    </div>

                    <x-primary-button>Bericht Publiceren</x-primary-button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
