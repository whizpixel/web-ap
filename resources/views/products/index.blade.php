<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white-500 dark:text-gray-200 leading-tight">
            Produits
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6">
                <table class="w-full">
                    <thead>
                    <tr class="text-left text-white">
                        <th class="py-2">Nom</th>
                        <th class="py-2">Prix</th>
                        <th class="py-2">Description</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($products as $p)
                        <tr class="border-t border-gray-200 dark:border-gray-700 text-white">
                            <td class="py-2">{{ $p->name }}</td>
                            <td class="py-2">{{ number_format($p->price, 2, ',', ' ') }} €</td>
                            <td class="py-2">{{ $p->description }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                @if($products->isEmpty())
                    <p class="mt-4 text-sm opacity-70 text-white">Aucun produit pour le moment.</p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
