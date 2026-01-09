<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Nieuwe gebruiker aanmaken') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                @if($errors->any())
                    <div class="mb-4 text-red-600">
                        <ul class="list-disc pl-5">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.users.store') }}">
                    @csrf

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Naam</label>
                        <input type="text" name="name" value="{{ old('name') }}" required class="mt-1 block w-full" />
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Username</label>
                        <input type="text" name="username" value="{{ old('username') }}" required class="mt-1 block w-full" />
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" required class="mt-1 block w-full" />
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Wachtwoord</label>
                        <input type="password" name="password" required class="mt-1 block w-full" />
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Wachtwoord (bevestiging)</label>
                        <input type="password" name="password_confirmation" required class="mt-1 block w-full" />
                    </div>

                    <div class="mb-4">
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="is_admin" value="1" class="mr-2" {{ old('is_admin') ? 'checked' : '' }} />
                            <span>Maak admin</span>
                        </label>
                    </div>

                    <div class="flex items-center gap-2">
                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded" style="background-color:#4f46e5;color:#fff;padding:8px 12px;border-radius:6px;">Maak gebruiker</button>
                        <a href="{{ route('admin.users.index') }}" class="px-4 py-2 bg-gray-200 rounded" style="background-color:#e5e7eb;color:#111;padding:8px 12px;border-radius:6px;">Annuleer</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
