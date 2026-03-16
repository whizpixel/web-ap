<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AppointmentController extends Controller
{
public function index(Request $request)
{
    $appointments = Appointment::where('user_id', $request->user()->id)
        ->orderBy('starts_at')
        ->get();

    if ($request->expectsJson()) {
        return $appointments;
    }

    return view('appointments.index', compact('appointments'));
}

public function create()
{
    return view('appointments.create');
}

public function store(Request $request)
{

    $data = $request->validate([
        'client_name' => ['required', 'string', 'max:255'],
        'starts_at'   => ['required', 'date'],
        'notes'       => ['nullable', 'string'],
    ]);

    $data['user_id'] = $request->user()->id;

    $appointment = Appointment::create($data);

    if ($request->expectsJson()) {
        return $appointment;
    }

    return redirect()->route('web.appointments.index')->with('success', 'Rendez-vous créé.');
}

public function edit(Request $request, Appointment $appointment)
{
    abort_unless($appointment->user_id === $request->user()->id, 403);
    return view('appointments.edit', compact('appointment'));
}

public function update(Request $request, Appointment $appointment)
{
    abort_unless($appointment->user_id === $request->user()->id, 403);

    $data = $request->validate([
        'client_name' => ['required', 'string', 'max:255'],
        'starts_at'   => ['required', 'date'],
        'notes'       => ['nullable', 'string'],
    ]);

    $appointment->update($data);

    if ($request->expectsJson()) {
        return $appointment;
    }

    return redirect()->route('web.appointments.index')->with('success', 'Rendez-vous modifié.');
}

public function destroy(Request $request, Appointment $appointment)
{
    abort_unless($appointment->user_id === $request->user()->id, 403);
    $appointment->delete();

    if ($request->expectsJson()) {
        return response()->noContent();
    }

    return redirect()->route('web.appointments.index')->with('success', 'Rendez-vous supprimé.');
}
}
