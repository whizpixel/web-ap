<x-app-layout>
    <x-slot name="header">
        <div style="display:flex;align-items:center;justify-content:space-between;">
            <h2 style="font-family:'Syne',sans-serif;font-weight:700;font-size:1.75rem;color:var(--white);letter-spacing:-0.03em;">
                Mon <span style="color:var(--red-vivid);">CRM</span>
            </h2>
            <a href="{{ route('web.appointments.create') }}" class="btn-primary">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Nouveau RDV
            </a>
        </div>
    </x-slot>

    @php
        $upcoming = \App\Models\Appointment::where('user_id', auth()->id())
            ->where('starts_at', '>=', now())
            ->orderBy('starts_at')
            ->take(6)
            ->get();
        $total = \App\Models\Appointment::where('user_id', auth()->id())->count();
        $next  = $upcoming->first();
    @endphp

    <style>
        .kpi-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        @media (max-width: 768px) {
            .kpi-grid { grid-template-columns: 1fr; }
            .rdv-grid  { grid-template-columns: 1fr !important; }
        }

        .kpi-card {
            background: rgba(22,26,29,0.6);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(229,56,59,0.12);
            border-radius: 16px;
            padding: 1.5rem;
            position: relative;
            overflow: hidden;
            transition: border-color 0.3s, transform 0.2s;
        }

        .kpi-card:hover {
            border-color: rgba(229,56,59,0.3);
            transform: translateY(-2px);
        }

        .kpi-card::before {
            content: '';
            position: absolute;
            top: 0; right: 0;
            width: 80px; height: 80px;
            background: radial-gradient(circle, rgba(229,56,59,0.12) 0%, transparent 70%);
            border-radius: 50%;
        }

        .kpi-label {
            font-family: 'Syne', sans-serif;
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: var(--gray-warm);
            margin-bottom: 0.75rem;
        }

        .kpi-value {
            font-family: 'Syne', sans-serif;
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--white);
            letter-spacing: -0.04em;
            line-height: 1;
        }

        .kpi-value.red { color: var(--red-vivid); }

        .kpi-sub {
            font-size: 0.8rem;
            color: var(--gray-warm);
            margin-top: 0.4rem;
        }

        .section-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.25rem;
        }

        .section-title {
            font-family: 'Syne', sans-serif;
            font-weight: 700;
            font-size: 1rem;
            color: var(--white);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .section-title::before {
            content: '';
            display: block;
            width: 3px;
            height: 18px;
            background: var(--red-vivid);
            border-radius: 2px;
        }

        .rdv-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
        }

        .rdv-card {
            background: rgba(11,9,10,0.4);
            border: 1px solid rgba(229,56,59,0.1);
            border-radius: 12px;
            padding: 1.25rem;
            transition: all 0.2s;
            position: relative;
            overflow: hidden;
        }

        .rdv-card:hover {
            border-color: rgba(229,56,59,0.3);
            background: rgba(229,56,59,0.04);
        }

        .rdv-card::after {
            content: '';
            position: absolute;
            left: 0; top: 0; bottom: 0;
            width: 3px;
            background: linear-gradient(to bottom, var(--red-vivid), var(--red-deep));
            border-radius: 3px 0 0 3px;
        }

        .rdv-client {
            font-family: 'Syne', sans-serif;
            font-weight: 600;
            font-size: 0.95rem;
            color: var(--white);
            margin-bottom: 0.3rem;
        }

        .rdv-date {
            font-size: 0.8rem;
            color: var(--red-vivid);
            font-weight: 500;
            margin-bottom: 0.5rem;
        }

        .rdv-notes {
            font-size: 0.8rem;
            color: var(--gray-warm);
            margin-bottom: 0.85rem;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .rdv-actions {
            display: flex;
            gap: 0.5rem;
        }

        .badge-upcoming {
            display: inline-block;
            padding: 0.2rem 0.6rem;
            background: rgba(229,56,59,0.15);
            border: 1px solid rgba(229,56,59,0.25);
            color: var(--red-vivid);
            border-radius: 20px;
            font-size: 0.7rem;
            font-weight: 600;
            font-family: 'Syne', sans-serif;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .quick-links {
            display: flex;
            gap: 0.75rem;
            flex-wrap: wrap;
        }

        .quick-link {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.6rem 1rem;
            background: rgba(229,56,59,0.08);
            border: 1px solid rgba(229,56,59,0.15);
            border-radius: 10px;
            color: var(--off-white);
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 500;
            transition: all 0.2s;
        }

        .quick-link:hover {
            background: rgba(229,56,59,0.18);
            border-color: rgba(229,56,59,0.35);
            color: var(--white);
        }
    </style>

    {{-- KPIs --}}
    <div class="kpi-grid">
        <div class="kpi-card">
            <div class="kpi-label">RDV à venir</div>
            <div class="kpi-value red">{{ $upcoming->count() }}</div>
            <div class="kpi-sub">sur {{ $total }} au total</div>
        </div>

        <div class="kpi-card">
            <div class="kpi-label">Prochain rendez-vous</div>
            @if($next)
                <div class="kpi-value" style="font-size:1.2rem;margin-bottom:0.3rem;">{{ $next->client_name }}</div>
                <div class="kpi-sub" style="color:var(--red-vivid);">
                    {{ \Carbon\Carbon::parse($next->starts_at)->format('d/m/Y à H:i') }}
                </div>
            @else
                <div class="kpi-value" style="font-size:1.5rem;color:var(--gray-warm);">—</div>
                <div class="kpi-sub">Aucun RDV planifié</div>
            @endif
        </div>

        <div class="kpi-card">
            <div class="kpi-label">Accès rapide</div>
            <div class="quick-links" style="margin-top:0.5rem;">
                <a href="{{ route('web.appointments.index') }}" class="quick-link">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    Mes RDV
                </a>
                <a href="{{ route('web.products.index') }}" class="quick-link">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 7H4a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
                    Produits
                </a>
                <a href="{{ route('web.clients.index') }}" class="quick-link">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    Clients
                </a>
            </div>
        </div>
    </div>

    {{-- RDV à venir --}}
    <div class="glass-card">
        <div class="section-header">
            <div class="section-title">Mes RDV à venir</div>
            <a href="{{ route('web.appointments.create') }}" class="btn-primary" style="font-size:0.8rem;padding:0.45rem 1rem;">
                + Nouveau
            </a>
        </div>

        @if($upcoming->isEmpty())
            <div class="empty-state">Aucun rendez-vous à venir.</div>
        @else
            <div class="rdv-grid">
                @foreach($upcoming as $rdv)
                    <div class="rdv-card">
                        <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:0.4rem;">
                            <div class="rdv-client">{{ $rdv->client_name }}</div>
                            <span class="badge-upcoming">À venir</span>
                        </div>
                        <div class="rdv-date">
                            {{ \Carbon\Carbon::parse($rdv->starts_at)->format('d/m/Y à H:i') }}
                        </div>
                        @if($rdv->notes)
                            <div class="rdv-notes">{{ $rdv->notes }}</div>
                        @endif
                        <div class="rdv-actions">
                            <a href="{{ route('web.appointments.edit', $rdv) }}" class="btn-secondary" style="font-size:0.8rem;padding:0.4rem 0.85rem;">
                                Modifier
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

</x-app-layout>