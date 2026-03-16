<x-app-layout>
    <x-slot name="header">
        <div style="display:flex;align-items:center;justify-content:space-between;">
            <div style="display:flex;align-items:center;gap:1rem;">
                <a href="{{ route('web.clients.index') }}" style="display:flex;align-items:center;color:var(--gray-warm);text-decoration:none;font-size:0.85rem;transition:color 0.2s;" onmouseover="this.style.color='var(--white)'" onmouseout="this.style.color='var(--gray-warm)'">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
                    Clients
                </a>
                <span style="color:rgba(229,56,59,0.4);">/</span>
                <h2 style="font-family:'Syne',sans-serif;font-weight:700;font-size:1.75rem;color:var(--white);letter-spacing:-0.03em;">
                    {{ $client->name }}
                </h2>
            </div>
        </div>
    </x-slot>

    <style>
        .client-profile {
            display: flex;
            align-items: center;
            gap: 1.25rem;
            margin-bottom: 1.5rem;
        }

        .profile-avatar {
            width: 56px;
            height: 56px;
            border-radius: 14px;
            background: linear-gradient(135deg, var(--red-mid), var(--red-deep));
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Syne', sans-serif;
            font-weight: 800;
            font-size: 1.4rem;
            color: white;
            flex-shrink: 0;
            box-shadow: 0 4px 15px rgba(164,22,26,0.4);
        }

        .profile-info .name {
            font-family: 'Syne', sans-serif;
            font-weight: 700;
            font-size: 1.1rem;
            color: var(--white);
            margin-bottom: 0.3rem;
        }

        .profile-meta {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .profile-meta span {
            font-size: 0.8rem;
            color: var(--gray-warm);
            display: flex;
            align-items: center;
            gap: 0.35rem;
        }

        .stats-row {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        @media (max-width: 640px) {
            .stats-row { grid-template-columns: 1fr; }
        }

        .stat-card {
            background: rgba(22,26,29,0.6);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(229,56,59,0.12);
            border-radius: 14px;
            padding: 1.1rem 1.25rem;
        }

        .stat-label {
            font-family: 'Syne', sans-serif;
            font-size: 0.68rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: var(--gray-warm);
            margin-bottom: 0.5rem;
        }

        .stat-value {
            font-family: 'Syne', sans-serif;
            font-weight: 800;
            font-size: 1.75rem;
            color: var(--red-vivid);
            letter-spacing: -0.04em;
        }

        .section-title {
            font-family: 'Syne', sans-serif;
            font-weight: 700;
            font-size: 1rem;
            color: var(--white);
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1.25rem;
        }

        .section-title::before {
            content: '';
            display: block;
            width: 3px;
            height: 18px;
            background: var(--red-vivid);
            border-radius: 2px;
        }

        table { width: 100%; border-collapse: collapse; }

        thead th {
            font-family: 'Syne', sans-serif;
            font-size: 0.68rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: var(--gray-warm);
            padding: 0.75rem 1rem;
            text-align: left;
            border-bottom: 1px solid rgba(229,56,59,0.15);
        }

        tbody tr { transition: background 0.15s; }

        tbody tr:hover { background: rgba(229,56,59,0.05); }

        tbody td {
            padding: 0.9rem 1rem;
            font-size: 0.875rem;
            color: var(--off-white);
            border-bottom: 1px solid rgba(255,255,255,0.04);
        }

        .td-date { color: var(--gray-warm); font-size: 0.8rem; }

        .td-product {
            font-weight: 500;
            color: var(--white);
        }

        .td-qty {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 28px;
            height: 28px;
            background: rgba(229,56,59,0.12);
            border: 1px solid rgba(229,56,59,0.2);
            border-radius: 7px;
            font-family: 'Syne', sans-serif;
            font-weight: 700;
            font-size: 0.8rem;
            color: var(--red-vivid);
        }

        .td-notes {
            font-size: 0.8rem;
            color: var(--gray-warm);
            font-style: italic;
        }
    </style>

    {{-- Profil client --}}
    <div class="glass-card" style="margin-bottom:1.25rem;">
        <div class="client-profile">
            <div class="profile-avatar">{{ strtoupper(substr($client->name, 0, 1)) }}</div>
            <div class="profile-info">
                <div class="name">{{ $client->name }}</div>
                <div class="profile-meta">
                    @if($client->email)
                        <span>
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                            {{ $client->email }}
                        </span>
                    @endif
                    @if($client->phone)
                        <span>
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 13a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.59 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                            {{ $client->phone }}
                        </span>
                    @endif
                </div>
            </div>
        </div>

        {{-- Stats --}}
        <div class="stats-row">
            <div class="stat-card">
                <div class="stat-label">Achats total</div>
                <div class="stat-value">{{ $purchases->count() }}</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Produits distincts</div>
                <div class="stat-value">{{ $purchases->pluck('product_id')->unique()->count() }}</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Quantité totale</div>
                <div class="stat-value">{{ $purchases->sum('quantity') }}</div>
            </div>
        </div>
    </div>

    {{-- Tableau des achats --}}
    <div class="glass-card">
        <div class="section-title">Historique des achats</div>

        @if($purchases->isEmpty())
            <div class="empty-state">Aucun achat enregistré pour ce client.</div>
        @else
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Produit</th>
                        <th>Qté</th>
                        <th>Notes</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($purchases as $a)
                        <tr>
                            <td class="td-date">
                                {{ \Carbon\Carbon::parse($a->purchased_at)->format('d/m/Y') }}
                                <span style="opacity:0.5;font-size:0.75rem;">
                                    {{ \Carbon\Carbon::parse($a->purchased_at)->format('H:i') }}
                                </span>
                            </td>
                            <td class="td-product">{{ $a->product?->name ?? '—' }}</td>
                            <td><span class="td-qty">{{ $a->quantity }}</span></td>
                            <td class="td-notes">{{ $a->notes ?? '—' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

</x-app-layout>