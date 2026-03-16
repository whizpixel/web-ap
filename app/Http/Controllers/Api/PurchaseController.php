<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePurchaseRequest;
use App\Models\Client;
use App\Models\Purchase;
use App\Models\AuditLog;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    public function store(StorePurchaseRequest $request)
    {
        $purchase = Purchase::create([
            'user_id' => $request->user()->id,
            'client_id' => $request->client_id,
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'purchased_at' => $request->purchased_at,
            'notes' => $request->notes,
        ]);

        AuditLog::create([
            'user_id' => $request->user()->id,
            'action' => 'purchase.create',
            'entity_type' => Purchase::class,
            'entity_id' => $purchase->id,
            'meta' => [
                'client_id' => $purchase->client_id,
                'product_id' => $purchase->product_id,
            ],
        ]);

        return response()->json($purchase, 201);
    }

    public function byClient(Client $client, Request $request)
    {
        $purchases = Purchase::where('client_id', $client->id)
            ->where('user_id', $request->user()->id) // IDOR
            ->with('product')
            ->get();

        return $purchases;
    }

    public function destroy(Purchase $purchase, Request $request)
    {
        $this->authorize('delete', $purchase);

        $purchase->delete();

        AuditLog::create([
            'user_id' => $request->user()->id,
            'action' => 'purchase.delete',
            'entity_type' => Purchase::class,
            'entity_id' => $purchase->id,
        ]);

        return response()->noContent();
    }
}
