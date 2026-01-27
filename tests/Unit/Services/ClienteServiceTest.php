<?php

namespace Tests\Unit\Services;

use App\Models\Cliente;
use App\Models\Locacao;
use App\Services\ClienteService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClienteServiceTest extends TestCase
{
    use RefreshDatabase;

    private ClienteService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new ClienteService();
    }

    public function test_create_cliente_successfully(): void
    {
        $data = [
            'nome' => 'João Silva',
            'email' => 'joao@example.com',
            'cpf' => '12345678901',
            'telefone' => '11999999999',
            'endereco' => 'Rua Teste, 123',
        ];

        $cliente = $this->service->createCliente($data);

        $this->assertInstanceOf(Cliente::class, $cliente);
        $this->assertEquals('João Silva', $cliente->nome);
        $this->assertEquals('joao@example.com', $cliente->email);
        $this->assertDatabaseHas('clientes', ['nome' => 'João Silva']);
    }

    public function test_update_cliente_successfully(): void
    {
        $cliente = Cliente::factory()->create(['nome' => 'Maria']);

        $updated = $this->service->updateCliente($cliente, ['nome' => 'Maria Silva']);

        $this->assertEquals('Maria Silva', $updated->nome);
        $this->assertDatabaseHas('clientes', ['id' => $cliente->id, 'nome' => 'Maria Silva']);
    }

    public function test_delete_cliente_successfully(): void
    {
        $cliente = Cliente::factory()->create();

        $this->service->deleteCliente($cliente);

        $this->assertDatabaseMissing('clientes', ['id' => $cliente->id]);
    }

    public function test_cannot_delete_cliente_with_locacoes(): void
    {
        $cliente = Cliente::factory()->create();
        Locacao::factory()->create(['cliente_id' => $cliente->id]);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Não é possível excluir este cliente');

        $this->service->deleteCliente($cliente);
    }
}
