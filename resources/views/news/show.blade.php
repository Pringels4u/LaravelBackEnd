<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ $newsItem->title }}</h2>

            <div class="flex items-center gap-3">
                <a href="{{ route('news.index') }}" class="text-sm text-gray-600 hover:underline">&larr; Terug naar overzicht</a>

                @auth
                    @if(auth()->user()->is_admin)
                        <form action="{{ route('admin.news.edit', $newsItem) }}" method="GET" style="display:inline">
                            <button type="submit" class="text-sm px-3 py-1 bg-indigo-600 text-white rounded hover:bg-indigo-700" style="background:#4f46e5;color:#ffffff;padding:6px 8px;border-radius:6px;border:none;">Bewerk</button>
                        </form>
                        <form action="{{ route('admin.news.destroy', ['news' => $newsItem->id]) }}" method="POST" onsubmit="return confirm('Weet je zeker dat je dit bericht wilt verwijderen?');" style="display:inline;margin-left:6px;">
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
    {{-- Comments section --}}
    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">Reacties</h3>

                @if(session('success'))
                    <div class="mb-4 text-green-700">{{ session('success') }}</div>
                @endif

                @if($newsItem->comments->isEmpty())
                    <p class="text-gray-600">Nog geen reacties. Wees de eerste!</p>
                @else
                    <div class="space-y-4 mb-4">
                        @foreach($newsItem->comments as $comment)
                            <div class="border rounded p-3">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <strong>{{ $comment->user->name }}</strong>
                                        <div class="text-sm text-gray-500">{{ $comment->created_at->diffForHumans() }}</div>
                                    </div>
                                </div>
                                <div class="mt-2 text-gray-800">{{ nl2br(e($comment->content)) }}</div>
                            </div>
                        @endforeach
                    </div>
                @endif

                @auth
                    <form method="POST" action="{{ route('news.comments.store', $newsItem) }}">
                        @csrf
                        <div class="mb-3">
                            <label class="block text-sm font-medium text-gray-700">Laat een reactie achter</label>
                            <textarea name="content" rows="4" required class="mt-1 block w-full border rounded p-2">{{ old('content') }}</textarea>
                        </div>
                        <div>
                            <button type="submit" class="px-3 py-1 bg-indigo-600 text-white rounded" style="background:#4f46e5;color:#fff;padding:8px 12px;border-radius:6px;">Plaats reactie</button>
                        </div>
                    </form>
                @else
                    <p class="text-gray-600">Je moet <a href="{{ route('login') }}" class="text-indigo-600">inloggen</a> om te reageren.</p>
                @endauth
            </div>
        </div>
    </div>
</x-app-layout>
