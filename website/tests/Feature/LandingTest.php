<?php

namespace Tests\Feature;

use Tests\TestCase;

class LandingTest extends TestCase
{
    public function test_home_renders_the_landing_page(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Blade components you actually own.');
        $response->assertSee('Browse');
    }

    public function test_components_grid_moved_to_components_route(): void
    {
        $response = $this->get('/components');

        $response->assertStatus(200);
        $response->assertSee('button');
    }

    public function test_getting_started_guide_renders(): void
    {
        $response = $this->get('/getting-started');

        $response->assertStatus(200);
        $response->assertSee('Getting Started');
        $response->assertSee('composer require --dev safi/laralcn-ui');
        $response->assertSee('php artisan ui:add button');
    }
}
