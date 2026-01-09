<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">FAQ Item Toevoegen</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                <form action="{{ route('admin.faq.store') }}" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <x-input-label for="category_id" value="Categorie" />
                        <select name="category_id" id="category_id" class="block mt-1 w-full border-gray-300 rounded-md">
                            <option value="">-- Kies een bestaande categorie --</option>
                            @foreach($categories as $c)
                                <option value="{{ $c->id }}">{{ $c->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <x-input-label for="new_category" value="Nieuwe categorie (optioneel)" />
                        <x-text-input id="new_category" name="new_category" type="text" class="block mt-1 w-full" />
                    </div>

                    <div>
                        <x-input-label for="question" value="Vraag" />
                        <x-text-input id="question" name="question" type="text" class="block mt-1 w-full" required />
                    </div>

                    <div>
                        <x-input-label for="answer" value="Antwoord" />
                        <textarea id="answer" name="answer" rows="6" class="block mt-1 w-full border-gray-300 rounded-md"></textarea>
                    </div>

                    <x-primary-button>Voeg toe</x-primary-button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
