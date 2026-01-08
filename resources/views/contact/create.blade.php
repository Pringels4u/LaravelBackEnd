<x-guest-layout>
    <div class="max-w-3xl mx-auto py-12">
        <div class="bg-white p-6 shadow-sm sm:rounded-lg">
            @if(session('success'))
                <div class="mb-4 text-green-700">{{ session('success') }}</div>
            @endif

            <form action="{{ route('contact.store') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <x-input-label for="name" value="Naam" />
                    <x-text-input id="name" name="name" type="text" class="block mt-1 w-full" required />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="email" value="E-mail" />
                    <x-text-input id="email" name="email" type="email" class="block mt-1 w-full" required />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="subject" value="Onderwerp (optioneel)" />
                    <x-text-input id="subject" name="subject" type="text" class="block mt-1 w-full" />
                    <x-input-error :messages="$errors->get('subject')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="message" value="Bericht" />
                    <textarea id="message" name="message" rows="6" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500" required></textarea>
                    <x-input-error :messages="$errors->get('message')" class="mt-2" />
                </div>

                <x-primary-button>Verstuur</x-primary-button>
            </form>
        </div>
    </div>
</x-guest-layout>
