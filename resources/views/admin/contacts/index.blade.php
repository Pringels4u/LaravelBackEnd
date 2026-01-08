<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Inbox Contactberichten</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                @forelse($messages as $msg)
                    <div class="border-b py-4">
                        <div class="flex justify-between">
                            <div>
                                <p class="font-bold">{{ $msg->name }} &lt;{{ $msg->email }}&gt;</p>
                                <p class="text-sm text-gray-600">{{ $msg->subject ?? 'Geen onderwerp' }}</p>
                            </div>
                            <div class="text-sm text-gray-500">{{ $msg->created_at->format('d-m-Y H:i') }}</div>
                        </div>
                        <div class="mt-2 text-gray-800 whitespace-pre-wrap">{{ $msg->message }}</div>
                    </div>
                @empty
                    <p class="text-center text-gray-500">Geen berichten gevonden.</p>
                @endforelse

                <div class="mt-6">
                    {{ $messages->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
