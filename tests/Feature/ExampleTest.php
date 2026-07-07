<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * Guests hitting the root see the public static landing page.
     */
    public function test_guests_see_the_public_landing_page(): void
    {
        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee('Kona Fight Camp');
    }
}
