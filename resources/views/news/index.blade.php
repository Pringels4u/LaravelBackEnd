<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Laatste Nieuws') }}
        </h2>
        {{-- Debug removed — all good. --}}
        @if(auth()->check() && auth()->user()->is_admin)
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-6">
                {{-- Temporary inline styles so the button is visible before assets are built --}}
                <a href="{{ route('admin.news.create') }}" id="admin-news-create" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700" style="background:#4f46e5;color:#ffffff;padding:8px 12px;border-radius:6px;display:inline-flex;align-items:center;">
                    + Nieuw Bericht Schrijven
                </a>
            </div>
        @endif
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @forelse($newsItems as $item)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-indigo-500">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900">{{ $item->title }}</h3>
                            <p class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($item->published_at)->format('d-m-Y H:i') }}</p>
                        </div>
                        <div class="ml-4">
                            @auth
                                <form action="{{ route('news.favorite.toggle', $item) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="px-3 py-1 bg-{{ in_array($item->id, $favoriteIds ?? []) ? 'yellow-400' : 'gray-200' }} rounded text-sm">
                                        {{ in_array($item->id, $favoriteIds ?? []) ? 'Favoriet' : 'Markeer' }}
                                    </button>
                                </form>
                            @endauth
                        </div>
                    </div>
                    <div class="mt-4 text-gray-700">
                        {{ Str::limit($item->content, 200) }}
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('news.show', $item) }}" class="text-indigo-600 font-semibold hover:underline"> Lees meer &rarr;</a>
                    </div>
                </div>
            @empty
                <p class="text-center text-gray-500 italic">Er zijn nog geen nieuwsberichten geplaatst.</p>
            @endforelse
        </div>
    </div>
</x-app-layout>
