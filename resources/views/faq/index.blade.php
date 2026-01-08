<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Veelgestelde Vragen (FAQ)') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                @forelse($categories as $category)
                    <div class="mb-8 border-b pb-6 last:border-0">
                        <h3 class="text-2xl font-bold text-indigo-600 mb-4 italic">
                            {{ $category->name }}
                        </h3>

                        <div class="space-y-6 ml-4">
                            @foreach($category->faqItems as $item)
                                <div>
                                    <p class="font-bold text-lg text-gray-900 flex items-start">
                                        <span class="text-indigo-500 mr-2">Q:</span> {{ $item->question }}
                                    </p>
                                    <p class="text-gray-600 mt-2 flex items-start">
                                        <span class="text-green-500 mr-2 font-bold">A:</span> {{ $item->answer }}
                                    </p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @empty
                    <div class="text-center py-10">
                        <p class="text-gray-500 text-lg italic">Er zijn nog geen FAQ categorieën gevonden.</p>
                        <p class="text-sm text-gray-400">Probeer: <code>php artisan db:seed</code></p>
                    </div>
                @endforelse

            </div>
        </div>
    </div>
</x-app-layout>
