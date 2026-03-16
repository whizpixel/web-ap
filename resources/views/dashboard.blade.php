<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-900 dark:text-white leading-tight">
                Mon CRM
            </h2>

            <a href="{{ route('web.appointments.create') }}"
               class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700 transition shadow">
                + Nouveau RDV
            </a>
        </div>
    </x-slot>

    @php
        $upcoming = \App\Models\Appointment::where('user_id', auth()->id())
            ->where('starts_at', '>=', now())
            ->orderBy('starts_at')
            ->take(6)
            ->get();
    @endphp

    <div class="py-8">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- KPIs --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="rounded-xl bg-white dark:bg-gray-900 shadow p-5 border border-gray-100 dark:border-gray-800">
                    <div class="text-sm text-gray-500 dark:text-gray-400">RDV à venir</div>
                    <div class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">
                        {{ $upcoming->count() }}
                    </div>
                </div>

                <div class="rounded-xl bg-white dark:bg-gray-900 shadow p-5 border border-gray-100 dark:border-gray-800">
                    <div class="text-sm text-gray-500 dark:text-gray-400">Prochain RDV</div>
                    <div class="mt-2 text-base font-semibold text-gray-900 dark:text-white">
                        {{ $upcoming->first()?->client_name ?? '—' }}
                    </div>
                    <div class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        {{ $upcoming->first()
                            ? \Carbon\Carbon::parse($upcoming->first()->starts_at)->format('d/m/Y H:i')
                            : 'Aucun' }}
                    </div>
                </div>

                <div class="rounded-xl bg-white dark:bg-gray-900 shadow p-5 border border-gray-100 dark:border-gray-800">
                    <div class="text-sm text-gray-500 dark:text-gray-400">Accès rapide</div>
                    <div class="mt-3 flex flex-wrap gap-2">
                        <a href="{{ route('web.appointments.index') }}"
                           class="px-3 py-2 rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-900
                                  dark:bg-gray-800 dark:hover:bg-gray-700 dark:text-white transition">
                            Mes RDV
                        </a>
                        <a href="{{ route('web.products.index') }}"
                           class="px-3 py-2 rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-900
                                  dark:bg-gray-800 dark:hover:bg-gray-700 dark:text-white transition">
                            Produits
                        </a>
                    </div>
                </div>
            </div>

            {{-- Liste RDV --}}
            <div class="rounded-xl bg-white dark:bg-gray-900 shadow border border-gray-100 dark:border-gray-800">
                <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-800">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Mes RDV à venir
                    </h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Les 6 prochains rendez-vous (triés par date).
                    </p>
                </div>

                <div class="p-6">
                    @if($upcoming->isEmpty())
                        <div class="rounded-lg bg-gray-50 dark:bg-gray-800 p-4 text-gray-700 dark:text-gray-200">
                            Aucun rendez-vous à venir.
                        </div>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($upcoming as $rdv)
                                <div class="rounded-xl border border-gray-200 dark:border-gray-800
                                            bg-white dark:bg-gray-900 p-4 hover:shadow-md transition">
                                    <div class="flex items-start justify-between gap-3">
                                        <div>
                                            <div class="text-base font-semibold text-gray-900 dark:text-white">
                                                {{ $rdv->client_name }}
                                            </div>
                                            <div class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                                {{ \Carbon\Carbon::parse($rdv->starts_at)->format('d/m/Y H:i') }}
                                            </div>
                                        </div>

                                        <span class="text-xs px-2 py-1 rounded-full
                                                     bg-blue-100 text-blue-700
                                                     dark:bg-blue-900/40 dark:text-blue-200">
                                            À venir
                                        </span>
                                    </div>

                                    @if($rdv->notes)
                                        <div class="mt-3 text-sm text-gray-700 dark:text-gray-200">
                                            {{ $rdv->notes }}
                                        </div>
                                    @endif

                                    <div class="mt-4 flex gap-2">
                                        <a href="{{ route('web.appointments.edit', $rdv) }}"
                                           class="px-3 py-2 rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-900
                                                  dark:bg-gray-800 dark:hover:bg-gray-700 dark:text-white transition text-sm">
                                            Modifier
                                        </a>
                                        <a href="{{ route('web.appointments.index') }}"
                                           class="px-3 py-2 rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-900
                                                  dark:bg-gray-800 dark:hover:bg-gray-700 dark:text-white transition text-sm">
                                            Voir tout
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
