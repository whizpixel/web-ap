<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\AuditLog;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    /**
     * Liste des rendez-vous du commercial connecté (Sécurité IDOR)
     */
    public function index(Request $request)
    {
        $appointments = Appointment::where('user_id', $request->user()->id)
            ->orderBy('starts_at')
            ->get();

        return $request->expectsJson() ? $appointments : view('appointments.index', compact('appointments'));
    }

    /**
     * Formulaire de création
     */
    public function create()
    {
        return view('appointments.create');
    }

    /**
     * Enregistrement du RDV + Log d'audit
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'client_name' => ['required', 'string', 'max:255'],
            'starts_at'   => ['required', 'date'],
            'notes'       => ['nullable', 'string'],
        ]);

        $data['user_id'] = $request->user()->id;
        $appointment = Appointment::create($data);

        // Journalisation obligatoire pour le barème
        AuditLog::create([
            'user_id'     => auth()->id(),
            'action'      => 'CREATE',
            'entity_type' => 'Appointment',
            'entity_id'   => $appointment->id,
            'meta'        => json_encode(['client' => $appointment->client_name]),
        ]);

        return $request->expectsJson() ? $appointment : redirect()->route('web.appointments.index')->with('success', 'Rendez-vous créé.');
    }

    /**
     * Formulaire de modification avec protection IDOR
     */
    public function edit(Request $request, Appointment $appointment)
    {
        // Vérifie que le RDV appartient bien au commercial
        abort_unless($appointment->user_id === $request->user()->id, 403);

        return view('appointments.edit', compact('appointment'));
    }

    /**
     * Mise à jour du RDV + Log d'audit
     */
    public function update(Request $request, Appointment $appointment)
    {
        abort_unless($appointment->user_id === $request->user()->id, 403);

        $data = $request->validate([
            'client_name' => ['required', 'string', 'max:255'],
            'starts_at'   => ['required', 'date'],
            'notes'       => ['nullable', 'string'],
        ]);

        $appointment->update($data);

        AuditLog::create([
            'user_id'     => auth()->id(),
            'action'      => 'UPDATE',
            'entity_type' => 'Appointment',
            'entity_id'   => $appointment->id,
            'meta'        => json_encode(['status' => 'updated']),
        ]);

        return $request->expectsJson() ? $appointment : redirect()->route('web.appointments.index')->with('success', 'Rendez-vous mis à jour.');
    }

    /**
     * Suppression du RDV + Log d'audit
     */
    public function destroy(Request $request, Appointment $appointment)
    {
        abort_unless($appointment->user_id === $request->user()->id, 403);

        // On logue l'action AVANT la suppression pour garder l'ID en trace
        AuditLog::create([
            'user_id'     => auth()->id(),
            'action'      => 'DELETE',
            'entity_type' => 'Appointment',
            'entity_id'   => $appointment->id,
            'meta'        => json_encode(['client' => $appointment->client_name]),
        ]);

        $appointment->delete();

        return $request->expectsJson() ? response()->noContent() : redirect()->route('web.appointments.index')->with('success', 'Rendez-vous supprimé.');
    }
}