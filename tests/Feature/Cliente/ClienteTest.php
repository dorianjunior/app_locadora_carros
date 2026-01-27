<?php

namespace Tests\Feature\Cliente;

use App\Models\Cliente;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClienteTest extends TestCase
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

    public function test_can_list_clientes(): void
    {
        Cliente::factory()->count(3)->create();

        $response = $this->withHeaders(["Authorization" => "Bearer " . $this->token])
            ->getJson('/api/v1/cliente');

        $response->assertOk()
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    'data' => [
                        '*' => ['id', 'nome'],
                    ],
                ],
            ]);
    }

    public function test_can_create_cliente(): void
    {
        $response = $this->withHeaders(["Authorization" => "Bearer " . $this->token])
            ->postJson('/api/v1/cliente', [
                'nome' => 'João Silva',
                'email' => 'joao@example.com',
                'cpf' => '12345678901',
                'telefone' => '11999999999',
            ]);

        $response->assertCreated()
            ->assertJsonStructure(['data' => ['id', 'nome', 'email', 'cpf']]);

        $this->assertDatabaseHas('clientes', ['nome' => 'João Silva']);
    }

    public function test_cannot_create_cliente_without_nome(): void
    {
        $response = $this->withHeaders(["Authorization" => "Bearer " . $this->token])
            ->postJson('/api/v1/cliente', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['nome']);
    }

    public function test_can_show_cliente(): void
    {
        $cliente = Cliente::factory()->create();

        $response = $this->withHeaders(["Authorization" => "Bearer " . $this->token])
            ->getJson("/api/v1/cliente/{$cliente->id}");

        $response->assertOk()
            ->assertJson([
                'data' => [
                    'id' => $cliente->id,
                    'nome' => $cliente->nome,
                ],
            ]);
    }

    public function test_can_update_cliente(): void
    {
        $cliente = Cliente::factory()->create(['nome' => 'João Silva']);

        $response = $this->withHeaders(["Authorization" => "Bearer " . $this->token])
            ->putJson("/api/v1/cliente/{$cliente->id}", [
                'nome' => 'Maria Santos',
                'email' => $cliente->email,
                'cpf' => $cliente->cpf,
                'telefone' => $cliente->telefone,
            ]);

        $response->assertOk()
            ->assertJson([
                'data' => ['nome' => 'Maria Santos'],
            ]);

        $this->assertDatabaseHas('clientes', [
            'id' => $cliente->id,
            'nome' => 'Maria Santos',
        ]);
    }

    public function test_can_delete_cliente_without_locacoes(): void
    {
        $cliente = Cliente::factory()->create();

        $response = $this->withHeaders(["Authorization" => "Bearer " . $this->token])
            ->deleteJson("/api/v1/cliente/{$cliente->id}");

        $response->assertOk()
            ->assertJson([
                'success' => true,
                'message' => 'Cliente excluído com sucesso',
            ]);

        $this->assertDatabaseMissing('clientes', ['id' => $cliente->id]);
    }

    public function test_can_filter_clientes_by_name(): void
    {
        Cliente::factory()->create(['nome' => 'João Silva']);
        Cliente::factory()->create(['nome' => 'Maria Santos']);

        $response = $this->withHeaders(["Authorization" => "Bearer " . $this->token])
            ->getJson('/api/v1/cliente?filtro=nome:like:%João%');

        $response->assertOk();
        $data = $response->json('data.data');
        $this->assertCount(1, $data);
        $this->assertStringContainsString('João', $data[0]['nome']);
    }

}
