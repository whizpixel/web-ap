<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Product;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        $catalogue = [
            ['name' => 'InfoTools CRM Web', 'price' => 59.00, 'description' => 'Portail CRM pour commerciaux (RDV + achats)'],
            ['name' => 'InfoTools CRM Manager (Desktop)', 'price' => 129.00, 'description' => 'CRM complet pour managers (prospects/clients/factures)'],
            ['name' => 'Module Facturation', 'price' => 39.00, 'description' => 'Génération et suivi des factures clients'],
            ['name' => 'Module Gestion de stock', 'price' => 49.00, 'description' => 'Gestion produits + stock (entrées/sorties)'],
            ['name' => 'Audit & Traçabilité', 'price' => 19.00, 'description' => 'Journalisation des actions sensibles (audit logs)'],
            ['name' => 'Dimensionnement Infrastructure', 'price' => 399.00, 'description' => 'Étude de dimensionnement (CPU/RAM/stockage)'],
            ['name' => 'Mise en place Infrastructure', 'price' => 799.00, 'description' => 'Installation serveur + réseau + services (DNS/DHCP/AD si besoin)'],
            ['name' => 'Maintenance & Support (mensuel)', 'price' => 149.00, 'description' => 'Support + correctifs + suivi incident'],
        ];

        return $this->faker->randomElement($catalogue);
    }
}
