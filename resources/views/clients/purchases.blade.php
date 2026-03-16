<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Achats — {{ $client->name }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6">
                <table class="w-full">
                    <thead>
                    <tr class="text-left text-white">
                        <th class="py-2">Date</th>
                        <th class="py-2">Produit</th>
                        <th class="py-2">Quantité</th>
                        <th class="py-2">Notes</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($purchases as $a)
                        <tr class="border-t border-gray-200 dark:border-gray-700">
                            <td class="py-2">{{ \Carbon\Carbon::parse($a->purchased_at)->format('d/m/Y H:i') }}</td>
                            <td class="py-2">{{ $a->product?->name }}</td>
                            <td class="py-2">{{ $a->quantity }}</td>
                            <td class="py-2">{{ $a->notes }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                @if($purchases->isEmpty())
                    <p class="mt-4 text-sm opacity-70 text-white">Aucun achat pour ce client.</p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
