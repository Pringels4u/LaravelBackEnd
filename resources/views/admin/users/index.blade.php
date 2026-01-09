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
                <div class="mb-4">
                    <a href="{{ route('admin.users.create') }}" class="px-3 py-2 bg-green-600 text-white rounded" style="background-color:#16a34a;color:#fff;padding:6px 10px;border-radius:6px;">+ Nieuwe gebruiker</a>
                </div>
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
                                        @if(!empty($user->username))
                                            <a href="{{ route('user.show', $user->username) }}" class="text-sm px-2 py-1 bg-gray-200 rounded hover:bg-gray-300" style="background-color:#e5e7eb;color:#111;padding:4px 8px;border-radius:6px;">Bekijk</a>
                                        @else
                                            <span class="text-sm px-2 py-1 bg-gray-100 text-gray-500 rounded" style="background-color:#f3f4f6;color:#6b7280;padding:4px 8px;border-radius:6px;">Geen username</span>
                                        @endif

                                        @if(auth()->user()->id !== $user->id)
                                            <form method="POST" action="{{ route('admin.users.toggleAdmin', $user) }}" onsubmit="return confirm('{{ $user->is_admin ? 'Weet je zeker dat je deze gebruiker adminrechten wilt afnemen?' : 'Weet je zeker dat je deze gebruiker admin wilt maken?' }}');" style="display:inline">
                                                @csrf
                                                <button type="submit" class="text-sm px-2 py-1 {{ $user->is_admin ? 'bg-red-600' : 'bg-indigo-600' }} text-white rounded" style="{{ $user->is_admin ? 'background-color:#ef4444;color:#fff;padding:6px 10px;border-radius:6px;' : 'background-color:#4f46e5;color:#fff;padding:6px 10px;border-radius:6px;' }}">
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
