<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Client;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Appointment;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Produits (attention : si tu relances seed sans fresh => doublons, donc fresh recommandé)
        Product::factory()->count(8)->create();

        // Clients globaux (pas de user_id dans ta table clients)
        $clients = Client::factory()->count(10)->create();

        // Commerciaux
        User::factory()->count(2)->create()->each(function ($user) use ($clients) {

            // RDV du commercial
            Appointment::factory()->count(5)->create([
                'user_id' => $user->id,
            ]);

            // Achats du commercial sur des clients existants
            $clients->random(5)->each(function ($client) use ($user) {
                Purchase::factory()->count(rand(1, 4))->create([
                    'user_id' => $user->id,
                    'client_id' => $client->id,
                    'product_id' => Product::inRandomOrder()->first()->id,
                ]);
            });
        });
    }
}
