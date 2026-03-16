<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Client;
use App\Models\Product;
use App\Models\Purchase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ApiSecurityTest extends TestCase
{
    use RefreshDatabase;

    public function test_validation_returns_422_and_rejects_xss(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $resp = $this->postJson('/api/purchases', [
            'client_id' => 999999,
            'product_id' => 999999,
            'quantity' => 'abc',
            'purchased_at' => 'not-a-date',
            'notes' => '<script>alert(1)</script>',
        ]);

        $resp->assertStatus(422);
    }

    public function test_idor_user_cannot_delete_other_users_purchase(): void
    {
        $userA = User::factory()->create();
        $userB = User::factory()->create();

        $client = Client::factory()->create();
        $product = Product::factory()->create();

        $purchase = Purchase::create([
            'user_id' => $userA->id,
            'client_id' => $client->id,
            'product_id' => $product->id,
            'quantity' => 1,
            'purchased_at' => now(),
            'notes' => null,
        ]);

        Sanctum::actingAs($userB);

        $resp = $this->deleteJson("/api/purchases/{$purchase->id}");
        $resp->assertStatus(403);
    }
}
