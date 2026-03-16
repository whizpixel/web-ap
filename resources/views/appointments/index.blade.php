<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Mes Rendez-vous
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 p-3 bg-green-100 rounded">{{ session('success') }}</div>
            @endif

            <p class="text-sm text-gray-600 mb-3">
                {{ $appointments->count() }} rendez-vous
            </p>

            <div class="mb-4">
                <a href="{{ route('web.appointments.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded">+
                    Nouveau RDV</a>
            </div>

            <div class="bg-white shadow rounded p-4">


                @forelse($appointments as $a)
                    <div class="border-b py-3 flex justify-between items-center">
                        <div>
                            <div class="font-semibold">{{ $a->client_name }}</div>
                            <div class="text-sm text-gray-600">
                                {{ \Carbon\Carbon::parse($a->starts_at)->format('d/m/Y H:i') }}
                            </div>
                            @if ($a->notes)
                                <div class="text-sm">{{ $a->notes }}</div>
                            @endif
                        </div>

                        <div class="flex gap-2">
                            <a class="px-3 py-1 bg-gray-200 rounded"
                                href="{{ route('web.appointments.edit', $a) }}">Modifier</a>

                            <form method="POST" action="{{ route('web.appointments.destroy', $a) }}"
                                onsubmit="return confirm('Supprimer ce RDV ?')">
                                @csrf
                                @method('DELETE')
                                <button class="px-3 py-1 bg-red-600 text-white rounded">Supprimer</button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p>Aucun rendez-vous pour l’instant.</p>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
