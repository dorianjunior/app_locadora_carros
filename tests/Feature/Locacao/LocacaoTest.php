<?php

namespace Tests\Feature\Locacao;

use App\Models\Carro;
use App\Models\Cliente;
use App\Models\Locacao;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LocacaoTest extends TestCase
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

    public function test_can_list_locacoes(): void
    {
        Locacao::factory()->count(3)->create();

        $response = $this->withHeaders(["Authorization" => "Bearer " . $this->token])
            ->getJson('/api/v1/locacao');

        $response->assertOk()
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    'data' => [
                        '*' => ['id', 'cliente_id', 'carro_id', 'data_inicio_periodo'],
                    ],
                ],
            ]);
    }

    public function test_can_create_locacao(): void
    {
        $cliente = Cliente::factory()->create();
        $carro = Carro::factory()->create(['disponivel' => true]);

        $response = $this->withHeaders(["Authorization" => "Bearer " . $this->token])
            ->postJson('/api/v1/locacao', [
                'cliente_id' => $cliente->id,
                'carro_id' => $carro->id,
                'data_inicio_periodo' => now()->addDay()->format('Y-m-d'),
                'data_final_previsto_periodo' => now()->addDays(5)->format('Y-m-d'),
                'valor_diaria' => 100.00,
                'km_inicial' => 10000,
            ]);

        $response->assertCreated()
            ->assertJsonStructure(['data' => ['id', 'cliente_id', 'carro_id', 'valor_total']]);

        $this->assertDatabaseHas('locacoes', [
            'cliente_id' => $cliente->id,
            'carro_id' => $carro->id,
        ]);
    }

    public function test_cannot_create_locacao_with_past_date(): void
    {
        $cliente = Cliente::factory()->create();
        $carro = Carro::factory()->create();

        $response = $this->withHeaders(["Authorization" => "Bearer " . $this->token])
            ->postJson('/api/v1/locacao', [
                'cliente_id' => $cliente->id,
                'carro_id' => $carro->id,
                'data_inicio_periodo' => now()->subDay()->format('Y-m-d'),
                'data_final_previsto_periodo' => now()->addDays(5)->format('Y-m-d'),
                'valor_diaria' => 100.00,
            ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['data_inicio_periodo']);
    }

    public function test_cannot_create_locacao_with_invalid_date_range(): void
    {
        $cliente = Cliente::factory()->create();
        $carro = Carro::factory()->create();

        $response = $this->withHeaders(["Authorization" => "Bearer " . $this->token])
            ->postJson('/api/v1/locacao', [
                'cliente_id' => $cliente->id,
                'carro_id' => $carro->id,
                'data_inicio_periodo' => now()->addDays(5)->format('Y-m-d'),
                'data_final_previsto_periodo' => now()->addDay()->format('Y-m-d'),
                'valor_diaria' => 100.00,
            ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['data_final_previsto_periodo']);
    }

    public function test_can_show_locacao(): void
    {
        $locacao = Locacao::factory()->create();

        $response = $this->withHeaders(["Authorization" => "Bearer " . $this->token])
            ->getJson("/api/v1/locacao/{$locacao->id}");

        $response->assertOk()
            ->assertJson([
                'data' => [
                    'id' => $locacao->id,
                    'cliente_id' => $locacao->cliente_id,
                    'carro_id' => $locacao->carro_id,
                ],
            ]);
    }

    public function test_can_update_locacao(): void
    {
        $locacao = Locacao::factory()->create();
        $dataInicio = now()->addDay();

        $response = $this->withHeaders(["Authorization" => "Bearer " . $this->token])
            ->putJson("/api/v1/locacao/{$locacao->id}", [
                'cliente_id' => $locacao->cliente_id,
                'carro_id' => $locacao->carro_id,
                'data_inicio_periodo' => $dataInicio->format('Y-m-d'),
                'data_final_previsto_periodo' => $dataInicio->copy()->addDays(10)->format('Y-m-d'),
                'valor_diaria' => 150.00,
                'km_inicial' => $locacao->km_inicial,
            ]);

        $response->assertOk()
            ->assertJson([
                'data' => ['valor_diaria' => '150.00'],
            ]);
    }

    public function test_can_delete_locacao(): void
    {
        $locacao = Locacao::factory()->create();

        $response = $this->withHeaders(["Authorization" => "Bearer " . $this->token])
            ->deleteJson("/api/v1/locacao/{$locacao->id}");

        $response->assertOk()
            ->assertJson([
                'success' => true,
                'message' => 'Locação excluída com sucesso',
            ]);

        $this->assertDatabaseMissing('locacoes', ['id' => $locacao->id]);
    }

    public function test_can_filter_locacoes_by_cliente(): void
    {
        $cliente = Cliente::factory()->create();
        Locacao::factory()->create(['cliente_id' => $cliente->id]);
        Locacao::factory()->create();

        $response = $this->withHeaders(["Authorization" => "Bearer " . $this->token])
            ->getJson("/api/v1/locacao?filtro=cliente_id:=:{$cliente->id}");

        $response->assertOk();
        $data = $response->json('data.data');
        $this->assertCount(1, $data);
    }

}
