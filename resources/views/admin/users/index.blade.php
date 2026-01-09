<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Beheer gebruikers') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 text-green-700">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="mb-4 text-red-700">{{ session('error') }}</div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <table class="w-full table-auto">
                    <thead>
                        <tr class="text-left">
                            <th class="px-4 py-2">ID</th>
                            <th class="px-4 py-2">Naam</th>
                            <th class="px-4 py-2">Email</th>
                            <th class="px-4 py-2">Admin</th>
                            <th class="px-4 py-2">Acties</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr class="border-t">
                                <td class="px-4 py-2">{{ $user->id }}</td>
                                <td class="px-4 py-2">{{ $user->name }}</td>
                                <td class="px-4 py-2">{{ $user->email }}</td>
                                <td class="px-4 py-2">{{ $user->is_admin ? 'Ja' : 'Nee' }}</td>
                                <td class="px-4 py-2">
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('user.show', $user) }}" class="text-sm px-2 py-1 bg-gray-200 rounded hover:bg-gray-300">Bekijk</a>

                                        @if(auth()->user()->id !== $user->id)
                                            <form method="POST" action="{{ route('admin.users.toggleAdmin', $user) }}" onsubmit="return confirm('{{ $user->is_admin ? 'Weet je zeker dat je deze gebruiker adminrechten wilt afnemen?' : 'Weet je zeker dat je deze gebruiker admin wilt maken?' }}');" style="display:inline">
                                                @csrf
                                                <button type="submit" class="text-sm px-2 py-1 {{ $user->is_admin ? 'bg-red-600' : 'bg-indigo-600' }} text-white rounded">
                                                    {{ $user->is_admin ? 'Haal admin af' : 'Maak admin' }}
                                                </button>
                                            </form>
                                        @else
                                            <em class="text-sm italic text-gray-500">Jij</em>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
