<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index()
{
    $clients = Client::orderBy('name')->get();
    return view('clients.index', compact('clients'));
}


    public function purchases(Client $client, Request $request)
    {
        // IMPORTANT : filtre IDOR (achats du commercial connecté)
        $purchases = $client->purchases()
            ->where('user_id', $request->user()->id)
            ->with('product')
            ->orderByDesc('purchased_at')
            ->get();

        return view('clients.purchases', compact('client', 'purchases'));
    }
}
