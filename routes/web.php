<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppointmentController;
use App\Models\Appointment;
use Illuminate\Http\Request;


Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->get('/dashboard', function (Request $request) {
    $nextAppointments = Appointment::where('user_id', $request->user()->id)
        ->where('starts_at', '>=', now())
        ->orderBy('starts_at')
        ->take(3)
        ->get();

    return view('dashboard', compact('nextAppointments'));
})->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::middleware(['auth'])
    ->name('web.')
    ->group(function () {
        Route::resource('appointments', AppointmentController::class)->except(['show']);
    });

Route::middleware(['auth'])->name('web.')->group(function () {
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/clients/{client}/purchases', [ClientController::class, 'purchases'])->name('clients.purchases');
});

Route::middleware(['auth'])->name('web.')->group(function () {
    // Produits
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');

    // Clients (liste)
    Route::get('/clients', [ClientController::class, 'index'])->name('clients.index');

    // Achats d’un client (historique)
    Route::get('/clients/{client}/purchases', [ClientController::class, 'purchases'])->name('clients.purchases');
});
