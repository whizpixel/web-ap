<x-app-layout>
    <x-slot name="header">
        <div style="display:flex;align-items:center;gap:1rem;">
            <a href="{{ route('web.appointments.index') }}" style="display:flex;align-items:center;color:var(--gray-warm);text-decoration:none;font-size:0.85rem;transition:color 0.2s;" onmouseover="this.style.color='var(--white)'" onmouseout="this.style.color='var(--gray-warm)'">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
                Rendez-vous
            </a>
            <span style="color:rgba(229,56,59,0.4);">/</span>
            <h2 style="font-family:'Syne',sans-serif;font-weight:700;font-size:1.75rem;color:var(--white);letter-spacing:-0.03em;">
                Modifier <span style="color:var(--red-vivid);">RDV</span>
            </h2>
        </div>
    </x-slot>

    <style>
        .form-card {
            max-width: 540px;
            background: rgba(22,26,29,0.6);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(229,56,59,0.12);
            border-radius: 20px;
            padding: 2rem;
        }

        .form-stack { display: flex; flex-direction: column; gap: 1.25rem; }

        .error-msg {
            font-size: 0.78rem;
            color: var(--red-vivid);
            margin-top: 0.3rem;
            display: flex;
            align-items: center;
            gap: 0.3rem;
        }

        .form-actions { display: flex; gap: 0.75rem; margin-top: 0.5rem; }

        .current-info {
            background: rgba(229,56,59,0.06);
            border: 1px solid rgba(229,56,59,0.12);
            border-radius: 10px;
            padding: 0.85rem 1rem;
            margin-bottom: 0.25rem;
        }

        .current-info .ci-label {
            font-family: 'Syne', sans-serif;
            font-size: 0.68rem;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--gray-warm);
            margin-bottom: 0.25rem;
        }

        .current-info .ci-value {
            font-size: 0.875rem;
            color: var(--off-white);
            font-weight: 500;
        }
    </style>

    <div class="form-card">
        {{-- Infos actuelles --}}
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:0.75rem;margin-bottom:1.5rem;">
            <div class="current-info">
                <div class="ci-label">Client actuel</div>
                <div class="ci-value">{{ $appointment->client_name }}</div>
            </div>
            <div class="current-info">
                <div class="ci-label">Date actuelle</div>
                <div class="ci-value">{{ \Carbon\Carbon::parse($appointment->starts_at)->format('d/m/Y H:i') }}</div>
            </div>
        </div>

        <form method="POST" action="{{ route('web.appointments.update', $appointment) }}">
            @csrf
            @method('PUT')

            <div class="form-stack">

                <div class="form-group">
                    <label class="form-label">Nom du client</label>
                    <input class="form-input" name="client_name"
                           value="{{ old('client_name', $appointment->client_name) }}" required>
                    @error('client_name')
                        <div class="error-msg">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Date & heure</label>
                    <input type="datetime-local" class="form-input" name="starts_at"
                           value="{{ old('starts_at', \Carbon\Carbon::parse($appointment->starts_at)->format('Y-m-d\TH:i')) }}"
                           required style="color-scheme: dark;">
                    @error('starts_at')
                        <div class="error-msg">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Notes <span style="font-weight:400;text-transform:none;letter-spacing:0;color:rgba(177,167,166,0.5);">(optionnel)</span></label>
                    <textarea class="form-input" name="notes">{{ old('notes', $appointment->notes) }}</textarea>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-primary">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                        Enregistrer
                    </button>
                    <a href="{{ route('web.appointments.index') }}" class="btn-secondary">
                        Retour
                    </a>
                </div>

            </div>
        </form>
    </div>

</x-app-layout>