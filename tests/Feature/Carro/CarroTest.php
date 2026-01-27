<?php

namespace Tests\Feature\Carro;

use App\Models\Carro;
use App\Models\Modelo;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CarroTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private string $token;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->token = auth('api')->login($this->user);
    }

    public function test_can_list_carros(): void
    {
        Carro::factory()->count(3)->create();

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $this->token])
            ->getJson('/api/v1/carro');

        $response->assertOk()
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    'data' => [
                        '*' => ['id', 'placa', 'disponivel', 'km'],
                    ],
                ],
            ]);
    }

    public function test_can_create_carro(): void
    {
        $modelo = Modelo::factory()->create();

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $this->token])
            ->postJson('/api/v1/carro', [
                'modelo_id' => $modelo->id,
                'placa' => 'ABC-1234',
                'disponivel' => true,
                'km' => 0,
            ]);

        $response->assertCreated()
            ->assertJsonStructure(['data' => ['id', 'placa', 'disponivel', 'km']]);

        $this->assertDatabaseHas('carros', ['placa' => 'ABC-1234']);
    }

    public function test_cannot_create_carro_with_duplicate_placa(): void
    {
        Carro::factory()->create(['placa' => 'ABC-1234']);
        $modelo = Modelo::factory()->create();

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $this->token])
            ->postJson('/api/v1/carro', [
                'modelo_id' => $modelo->id,
                'placa' => 'ABC-1234',
                'disponivel' => true,
                'km' => 0,
            ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['placa']);
    }

    public function test_can_show_carro(): void
    {
        $carro = Carro::factory()->create();

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $this->token])
            ->getJson("/api/v1/carro/{$carro->id}");

        $response->assertOk()
            ->assertJson([
                'data' => [
                    'id' => $carro->id,
                    'placa' => $carro->placa,
                ],
            ]);
    }

    public function test_can_update_carro(): void
    {
        $carro = Carro::factory()->create(['km' => 1000]);

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $this->token])
            ->putJson("/api/v1/carro/{$carro->id}", [
                'modelo_id' => $carro->modelo_id,
                'placa' => $carro->placa,
                'disponivel' => false,
                'km' => 5000,
            ]);

        $response->assertOk()
            ->assertJson([
                'data' => [
                    'km' => 5000,
                    'disponivel' => false,
                ],
            ]);

        $this->assertDatabaseHas('carros', [
            'id' => $carro->id,
            'km' => 5000,
            'disponivel' => false,
        ]);
    }

    public function test_can_delete_carro_without_locacoes(): void
    {
        $carro = Carro::factory()->create();

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $this->token])
            ->deleteJson("/api/v1/carro/{$carro->id}");

        $response->assertOk()
            ->assertJson([
                'success' => true,
                'message' => 'Carro excluído com sucesso',
            ]);

        $this->assertDatabaseMissing('carros', ['id' => $carro->id]);
    }

    public function test_can_filter_carros_disponveis(): void
    {
        Carro::factory()->create(['disponivel' => true]);
        Carro::factory()->create(['disponivel' => false]);

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $this->token])
            ->getJson('/api/v1/carro?filtro=disponivel:=:1');

        $response->assertOk();
        $data = $response->json('data.data');
        $this->assertTrue($data[0]['disponivel']);
    }
}
