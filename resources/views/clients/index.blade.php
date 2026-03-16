<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-900 dark:text-white leading-tight">
                Clients
            </h2>
            <a href="{{ route('web.products.index') }}"
               class="px-4 py-2 rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-900
                      dark:bg-gray-800 dark:hover:bg-gray-700 dark:text-white transition">
                Produits
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-900 shadow sm:rounded-lg border border-gray-100 dark:border-gray-800">
                <div class="p-6">
                    @if($clients->isEmpty())
                        <div class="rounded-lg bg-gray-50 dark:bg-gray-800 p-4 text-gray-700 dark:text-gray-200">
                            Aucun client enregistré.
                        </div>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($clients as $c)
                                <a href="{{ route('web.clients.purchases', $c) }}"
                                   class="block rounded-xl border border-gray-200 dark:border-gray-800
                                          bg-white dark:bg-gray-900 p-4 hover:shadow-md transition">
                                    <div class="font-semibold text-gray-900 dark:text-white">{{ $c->name }}</div>
                                    <div class="text-sm text-gray-600 dark:text-gray-300">{{ $c->email ?? '—' }}</div>
                                    <div class="text-sm text-gray-600 dark:text-gray-300">{{ $c->phone ?? '—' }}</div>
                                    <div class="mt-3 text-sm text-blue-700 dark:text-blue-300">
                                        Voir l’historique des achats →
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
