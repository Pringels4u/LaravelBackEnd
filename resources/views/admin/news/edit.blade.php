<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Nieuwsbericht Bewerken</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                <form action="{{ route('admin.news.update', $newsItem) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <x-input-label for="title" value="Titel" />
                        <x-text-input id="title" name="title" type="text" class="block mt-1 w-full" required value="{{ old('title', $newsItem->title) }}" />
                    </div>

                    <div>
                        <x-input-label for="content" value="Inhoud" />
                        <textarea id="content" name="content" rows="5" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500">{{ old('content', $newsItem->content) }}</textarea>
                    </div>

                    <div>
                        <x-input-label for="published_at" value="Publicatiedatum" />
                        <x-text-input id="published_at" name="published_at" type="datetime-local" class="block mt-1 w-full" value="{{ old('published_at', \Carbon\Carbon::parse($newsItem->published_at)->format('Y-m-d\TH:i')) }}" />
                    </div>

                    <div>
                        <x-input-label for="image" value="Afbeelding (optioneel)" />
                        @if($newsItem->image)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $newsItem->image) }}" class="w-48 h-32 object-cover rounded">
                            </div>
                        @endif
                        <input type="file" name="image" class="mt-1 block w-full text-sm">
                    </div>

                    <div class="flex items-center gap-4">
                        <x-primary-button>Opslaan</x-primary-button>

                        <form action="{{ route('admin.news.destroy', $newsItem) }}" method="POST" onsubmit="return confirm('Weet je zeker dat je dit bericht wilt verwijderen?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-3 py-2 bg-red-600 text-white rounded">Verwijder bericht</button>
                        </form>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
