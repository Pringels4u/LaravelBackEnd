<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $newsItem->title }}
            </h2>
            <a href="{{ route('news.index') }}" class="text-sm text-gray-600 hover:underline">&larr; Terug naar overzicht</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-8">
                @if($newsItem->image)
                    <img src="{{ asset('storage/' . $newsItem->image) }}" class="w-full h-64 object-cover rounded-lg mb-6">
                @endif

                <p class="text-gray-500 text-sm mb-4 italic italic">Gepubliceerd op: {{ \Carbon\Carbon::parse($newsItem->published_at)->format('d F Y') }}</p>

                <div class="prose max-w-none text-gray-800 leading-relaxed text-lg">
                    {!! nl2br(e($newsItem->content)) !!}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
