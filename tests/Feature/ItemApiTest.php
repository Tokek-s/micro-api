<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ItemApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_health_reports_a_connected_database(): void
    {
        $this->getJson('/api/health')
            ->assertOk()
            ->assertExactJson([
                'status' => 'ok',
                'database' => 'connected',
            ]);
    }

    public function test_item_can_be_created_and_listed(): void
    {
        $data = [
            'name' => 'Item de prueba',
            'description' => 'Descripción del item',
        ];

        $this->postJson('/api/items', $data)
            ->assertCreated()
            ->assertJsonPath('name', $data['name']);

        $this->assertDatabaseHas('items', $data);

        $this->getJson('/api/items')
            ->assertOk()
            ->assertJsonCount(1)
            ->assertJsonFragment($data);
    }

    public function test_item_fields_are_required(): void
    {
        $this->postJson('/api/items', [])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['name', 'description']);
    }
}
