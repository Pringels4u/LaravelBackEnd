<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ $newsItem->title }}</h2>

            <div class="flex items-center gap-3">
                <a href="{{ route('news.index') }}" class="text-sm text-gray-600 hover:underline">&larr; Terug naar overzicht</a>

                @auth
                    @if(auth()->user()->is_admin)
                        <a href="{{ route('admin.news.edit', $newsItem) }}" class="text-sm px-3 py-1 bg-indigo-600 text-white rounded hover:bg-indigo-700">Bewerk</a>
                        <form action="{{ route('admin.news.destroy', $newsItem) }}" method="POST" onsubmit="return confirm('Weet je zeker dat je dit bericht wilt verwijderen?');" style="display:inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-sm px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700">Verwijder</button>
                        </form>
                    @endif
                @endauth
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-8">
                @if($newsItem->image)
                    <img src="{{ asset('storage/' . $newsItem->image) }}" class="w-full h-64 object-cover rounded-lg mb-6">
                @endif

                <div class="flex justify-between items-start">
                    <p class="text-gray-500 text-sm mb-4 italic italic">Gepubliceerd op: {{ \Carbon\Carbon::parse($newsItem->published_at)->format('d F Y') }}</p>
                    <div>
                        @auth
                            <form action="{{ route('news.favorite.toggle', $newsItem) }}" method="POST">
                                @csrf
                                <button type="submit" class="px-3 py-1 rounded text-sm {{ $isFavorited ? 'bg-yellow-400' : 'bg-gray-200' }}">
                                    {{ $isFavorited ? 'Favoriet' : 'Markeer' }}
                                </button>
                            </form>
                        @endauth
                    </div>
                </div>

                <div class="prose max-w-none text-gray-800 leading-relaxed text-lg">
                    {!! nl2br(e($newsItem->content)) !!}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
