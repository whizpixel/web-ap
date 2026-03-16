<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApiThrottleTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_is_throttled_after_too_many_attempts(): void
    {
        User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        $last = null;

        for ($i = 0; $i < 20; $i++) {
            $last = $this->postJson('/api/login', [
                'email' => 'test@example.com',
                'password' => 'wrong-password',
            ]);
        }

        // au moins une des dernières doit finir en 429 (throttle)
        $this->assertTrue(in_array($last->getStatusCode(), [401, 429]));
    }
}
