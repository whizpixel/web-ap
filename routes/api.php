<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

// API Controllers
use App\Http\Controllers\Api\ProductController as ApiProductController;
use App\Http\Controllers\Api\PurchaseController as ApiPurchaseController;

use App\Http\Controllers\AppointmentController;

/*
|--------------------------------------------------------------------------
| API Login (Sanctum - Postman)
|--------------------------------------------------------------------------
| Throttling: 10 tentatives / minute
*/
Route::post('/login', function (Request $request) {
    $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    $user = User::where('email', $request->email)->first();

    if (! $user || ! Hash::check($request->password, $user->password)) {
        return response()->json(['message' => 'Invalid credentials'], 401);
    }

    return response()->json([
        'token' => $user->createToken('postman')->plainTextToken,
    ]);
})->middleware('throttle:10,1')->name('api.login');


/*
|--------------------------------------------------------------------------
| Protected API routes (Sanctum)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth:sanctum'])
    ->name('api.')
    ->group(function () {

        // Produits (lecture)
        Route::get('/products', [ApiProductController::class, 'index'])
            ->name('products.index');

        // Achats
        Route::post('/purchases', [ApiPurchaseController::class, 'store'])
            ->name('purchases.store');

        Route::get('/clients/{client}/purchases', [ApiPurchaseController::class, 'byClient'])
            ->name('clients.purchases');

        Route::delete('/purchases/{purchase}', [ApiPurchaseController::class, 'destroy'])
            ->name('purchases.destroy');

        // (Optionnel) si tu veux garder ton API RDV
        Route::apiResource('appointments', AppointmentController::class);
    });
