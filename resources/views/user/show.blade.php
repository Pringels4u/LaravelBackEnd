<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profiel van ') }} {{ $user->username ?? $user->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 flex items-start">

                {{-- Foto aan de linkerkant --}}
                <div class="flex-shrink-0 mr-10">
                    @if($user->profile_picture)
                        <img src="{{ asset('storage/' . $user->profile_picture) }}" class="w-40 h-40 rounded-full object-cover shadow-md">
                    @else
                        <div class="w-40 h-40 rounded-full bg-gray-200 flex items-center justify-center text-gray-400 border shadow-inner">
                            Geen foto
                        </div>
                    @endif
                </div>

                {{-- Gegevens aan de rechterkant --}}
                <div class="flex-grow">
                    <h1 class="text-3xl font-bold text-gray-900">{{ $user->name }}</h1>
                    <p class="text-indigo-600 font-medium italic">@ {{ $user->username }}</p>

                    <div class="mt-6 border-t pt-4">
                        <p class="text-sm text-gray-500 uppercase font-bold tracking-widest">Verjaardag</p>
                        <p class="text-gray-800">{{ $user->birthday ? \Carbon\Carbon::parse($user->birthday)->format('d F Y') : 'Niet opgegeven' }}</p>
                    </div>

                    <div class="mt-4">
                        <p class="text-sm text-gray-500 uppercase font-bold tracking-widest">Biografie</p>
                        <p class="text-gray-700 leading-relaxed">{{ $user->bio ?? 'Deze gebruiker heeft nog geen biografie geschreven.' }}</p>
                    </div>

                    {{-- Toon "Bewerk" knop alleen als je naar je EIGEN profiel kijkt --}}
                    @auth
                        @if(auth()->id() === $user->id)
                            <div class="mt-8">
                                <a href="{{ route('profile.edit') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    Profiel Bewerken
                                </a>
                            </div>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
