<x-app-layout>
    <x-slot name="header">
        <div style="display:flex;align-items:center;justify-content:space-between;">
            <h2 style="font-family:'Syne',sans-serif;font-weight:700;font-size:1.75rem;color:var(--white);letter-spacing:-0.03em;">
                Mes <span style="color:var(--red-vivid);">Rendez-vous</span>
            </h2>
            <a href="{{ route('web.appointments.create') }}" class="btn-primary">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Nouveau RDV
            </a>
        </div>
    </x-slot>

    <style>
        .rdv-list { display: flex; flex-direction: column; gap: 0.75rem; }

        .rdv-row {
            background: rgba(22,26,29,0.6);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(229,56,59,0.1);
            border-radius: 14px;
            padding: 1.1rem 1.25rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            transition: all 0.2s;
            position: relative;
            overflow: hidden;
        }

        .rdv-row::before {
            content: '';
            position: absolute;
            left: 0; top: 0; bottom: 0;
            width: 3px;
            background: linear-gradient(to bottom, var(--red-vivid), var(--red-deep));
            border-radius: 3px 0 0 3px;
        }

        .rdv-row:hover {
            border-color: rgba(229,56,59,0.3);
            background: rgba(22,26,29,0.8);
        }

        .rdv-info { flex: 1; }

        .rdv-client {
            font-family: 'Syne', sans-serif;
            font-weight: 600;
            font-size: 0.95rem;
            color: var(--white);
            margin-bottom: 0.25rem;
        }

        .rdv-date {
            font-size: 0.8rem;
            color: var(--red-vivid);
            font-weight: 500;
        }

        .rdv-note {
            font-size: 0.78rem;
            color: var(--gray-warm);
            margin-top: 0.2rem;
        }

        .rdv-actions { display: flex; gap: 0.5rem; align-items: center; flex-shrink: 0; }

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

    @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif

    <div style="display:flex;align-items:center;gap:0.75rem;margin-bottom:1.5rem;">
        <div class="section-title" style="margin-bottom:0;">Planning</div>
        <span class="count-badge">{{ $appointments->count() }} RDV</span>
    </div>

    @if($appointments->isEmpty())
        <div class="glass-card">
            <div class="empty-state">Aucun rendez-vous pour le moment.</div>
        </div>
    @else
        <div class="rdv-list">
            @foreach($appointments as $a)
                <div class="rdv-row">
                    <div class="rdv-info">
                        <div class="rdv-client">{{ $a->client_name }}</div>
                        <div class="rdv-date">
                            {{ \Carbon\Carbon::parse($a->starts_at)->format('d/m/Y à H:i') }}
                        </div>
                        @if($a->notes)
                            <div class="rdv-note">{{ $a->notes }}</div>
                        @endif
                    </div>
                    <div class="rdv-actions">
                        <a href="{{ route('web.appointments.edit', $a) }}" class="btn-secondary" style="font-size:0.8rem;padding:0.4rem 0.85rem;">
                            Modifier
                        </a>
                        <form method="POST" action="{{ route('web.appointments.destroy', $a) }}"
                              onsubmit="return confirm('Supprimer ce RDV ?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-danger" style="font-size:0.8rem;padding:0.4rem 0.85rem;">
                                Supprimer
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

</x-app-layout>