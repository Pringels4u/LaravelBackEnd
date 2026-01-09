<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Veelgestelde Vragen (FAQ)') }}
            </h2>

            @auth
                @if(auth()->user()->is_admin)
                    <div>
                        <a href="{{ route('admin.faq.create') }}" class="inline-flex items-center px-3 py-2 bg-indigo-600 text-white rounded" style="background:#4f46e5;color:#ffffff;padding:6px 10px;border-radius:6px;border:none;">+ Nieuwe FAQ</a>
                    </div>
                @endif
            @endauth
        </div>
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
                                <div class="relative">
                                    <p class="font-bold text-lg text-gray-900 flex items-start">
                                        <span class="text-indigo-500 mr-2">Q:</span> {{ $item->question }}
                                    </p>
                                    <p class="text-gray-600 mt-2 flex items-start">
                                        <span class="text-green-500 mr-2 font-bold">A:</span> {{ $item->answer }}
                                    </p>

                                    @auth
                                        @if(auth()->user()->is_admin)
                                            <div class="absolute right-0 top-0 flex gap-2">
                                                <form action="{{ route('admin.faq.edit', ['faq' => $item->id]) }}" method="GET" style="display:inline">
                                                    <button type="submit" class="text-xs px-2 py-1 bg-indigo-600 text-white rounded" style="background:#4f46e5;color:#ffffff;padding:4px 8px;border-radius:6px;border:none;">Bewerk</button>
                                                </form>

                                                <form action="{{ url('admin/faq/' . $item->id) }}" method="POST" onsubmit="return confirm('Weet je zeker dat je dit item wilt verwijderen?');" style="display:inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-xs px-2 py-1 bg-red-600 text-white rounded" style="background:#dc2626;color:#ffffff;padding:4px 8px;border-radius:6px;border:none;">Verwijder</button>
                                                </form>
                                            </div>
                                        @endif
                                    @endauth
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
