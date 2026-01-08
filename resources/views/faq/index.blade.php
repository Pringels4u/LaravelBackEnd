<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Veelgestelde Vragen (FAQ)') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                @foreach($categories as $category)
                    <div class="mb-8">
                        <h3 class="text-2xl font-bold text-indigo-600 mb-4">{{ $category->name }}</h3>

                        <div class="space-y-4">
                            @foreach($category->faqItems as $item)
                                <div class="border-b pb-4">
                                    <p class="font-semibold text-lg text-gray-900">Q: {{ $item->question }}</p>
                                    <p class="text-gray-600 mt-2">A: {{ $item->answer }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </div>
</x-app-layout>
