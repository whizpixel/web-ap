<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Modifier RDV</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded p-4">
                <form method="POST" action="{{ route('web.appointments.update', $appointment) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="block">Nom client</label>
                        <input class="w-full border rounded p-2" name="client_name"
                               value="{{ old('client_name', $appointment->client_name) }}" required>
                        @error('client_name') <div class="text-red-600 text-sm">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="block">Date / heure</label>
                        <input type="datetime-local" class="w-full border rounded p-2" name="starts_at"
                               value="{{ old('starts_at', \Carbon\Carbon::parse($appointment->starts_at)->format('Y-m-d\TH:i')) }}"
                               required>
                        @error('starts_at') <div class="text-red-600 text-sm">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="block">Notes</label>
                        <textarea class="w-full border rounded p-2" name="notes">{{ old('notes', $appointment->notes) }}</textarea>
                    </div>

                    <div class="flex gap-2">
                        <button class="px-4 py-2 bg-blue-600 text-white rounded">Enregistrer</button>
                        <a class="px-4 py-2 bg-gray-200 rounded" href="{{ route('web.appointments.index') }}">Retour</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
