<x-app-layout>
    <x-slot name="header">
        <div style="display:flex;align-items:center;justify-content:space-between;">
            <h2 style="font-family:'Syne',sans-serif;font-weight:700;font-size:1.75rem;color:var(--white);letter-spacing:-0.03em;">
                Mes <span style="color:var(--red-vivid);">Clients</span>
            </h2>
            <a href="{{ route('web.products.index') }}" class="btn-secondary">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 7H4a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
                Produits
            </a>
        </div>
    </x-slot>

    <style>
        .clients-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 1rem;
        }

        .client-card {
            background: rgba(22,26,29,0.6);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(229,56,59,0.12);
            border-radius: 16px;
            padding: 1.25rem 1.5rem;
            text-decoration: none;
            display: block;
            transition: all 0.25s;
            position: relative;
            overflow: hidden;
        }

        .client-card:hover {
            border-color: rgba(229,56,59,0.4);
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.35);
        }

        .client-card::after {
            content: '→';
            position: absolute;
            right: 1.25rem;
            bottom: 1.25rem;
            font-size: 1rem;
            color: var(--red-vivid);
            opacity: 0;
            transform: translateX(-6px);
            transition: all 0.2s;
        }

        .client-card:hover::after {
            opacity: 1;
            transform: translateX(0);
        }

        .client-avatar {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: linear-gradient(135deg, var(--red-mid), var(--red-deep));
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Syne', sans-serif;
            font-weight: 800;
            font-size: 1rem;
            color: white;
            margin-bottom: 0.85rem;
            flex-shrink: 0;
        }

        .client-name {
            font-family: 'Syne', sans-serif;
            font-weight: 700;
            font-size: 0.95rem;
            color: var(--white);
            margin-bottom: 0.35rem;
            letter-spacing: -0.01em;
        }

        .client-info {
            font-size: 0.8rem;
            color: var(--gray-warm);
            display: flex;
            align-items: center;
            gap: 0.4rem;
            margin-bottom: 0.2rem;
        }

        .client-cta {
            margin-top: 0.85rem;
            font-size: 0.78rem;
            color: var(--red-vivid);
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 0.3rem;
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

        .count-badge {
            display: inline-flex;
            align-items: center;
            background: rgba(229,56,59,0.15);
            border: 1px solid rgba(229,56,59,0.25);
            color: var(--red-vivid);
            font-family: 'Syne', sans-serif;
            font-size: 0.75rem;
            font-weight: 700;
            padding: 0.15rem 0.6rem;
            border-radius: 20px;
        }
    </style>

    <div style="display:flex;align-items:center;gap:0.75rem;margin-bottom:1.5rem;">
        <div class="section-title" style="margin-bottom:0;">Répertoire</div>
        <span class="count-badge">{{ $clients->count() }} clients</span>
    </div>

    @if($clients->isEmpty())
        <div class="glass-card">
            <div class="empty-state">Aucun client enregistré.</div>
        </div>
    @else
        <div class="clients-grid">
            @foreach($clients as $c)
                <a href="{{ route('web.clients.purchases', $c) }}" class="client-card">
                    <div class="client-avatar">{{ strtoupper(substr($c->name, 0, 1)) }}</div>
                    <div class="client-name">{{ $c->name }}</div>
                    @if($c->email)
                        <div class="client-info">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                            {{ $c->email }}
                        </div>
                    @endif
                    @if($c->phone)
                        <div class="client-info">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 13a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.59 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                            {{ $c->phone }}
                        </div>
                    @endif
                    <div class="client-cta">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
                        Voir l'historique des achats
                    </div>
                </a>
            @endforeach
        </div>
    @endif

</x-app-layout>