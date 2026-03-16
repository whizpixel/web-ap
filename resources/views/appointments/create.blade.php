<x-app-layout>
    <x-slot name="header">
        <div style="display:flex;align-items:center;gap:1rem;">
            <a href="{{ route('web.appointments.index') }}" style="display:flex;align-items:center;color:var(--gray-warm);text-decoration:none;font-size:0.85rem;transition:color 0.2s;" onmouseover="this.style.color='var(--white)'" onmouseout="this.style.color='var(--gray-warm)'">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
                Rendez-vous
            </a>
            <span style="color:rgba(229,56,59,0.4);">/</span>
            <h2 style="font-family:'Syne',sans-serif;font-weight:700;font-size:1.75rem;color:var(--white);letter-spacing:-0.03em;">
                Nouveau <span style="color:var(--red-vivid);">RDV</span>
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
    </style>

    <div class="form-card">
        <form method="POST" action="{{ route('web.appointments.store') }}">
            @csrf
            <div class="form-stack">

                <div class="form-group">
                    <label class="form-label">Nom du client</label>
                    <input class="form-input" name="client_name"
                           placeholder="Ex: Société Dupont"
                           value="{{ old('client_name') }}" required>
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
                           value="{{ old('starts_at') }}" required
                           style="color-scheme: dark;">
                    @error('starts_at')
                        <div class="error-msg">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Notes <span style="font-weight:400;text-transform:none;letter-spacing:0;color:rgba(177,167,166,0.5);">(optionnel)</span></label>
                    <textarea class="form-input" name="notes"
                              placeholder="Informations complémentaires...">{{ old('notes') }}</textarea>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-primary">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                        Créer le RDV
                    </button>
                    <a href="{{ route('web.appointments.index') }}" class="btn-secondary">
                        Annuler
                    </a>
                </div>

            </div>
        </form>
    </div>

</x-app-layout>