<?php

namespace Tests\Unit\Services;

use App\Models\Carro;
use App\Models\Cliente;
use App\Models\Locacao;
use App\Services\LocacaoService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LocacaoServiceTest extends TestCase
{
    use RefreshDatabase;

    private LocacaoService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new LocacaoService();
    }

    public function test_create_locacao_successfully(): void
    {
        $cliente = Cliente::factory()->create();
        $carro = Carro::factory()->create();

        $data = [
            'cliente_id' => $cliente->id,
            'carro_id' => $carro->id,
            'data_inicio_periodo' => now(),
            'data_final_previsto_periodo' => now()->addDays(5),
            'valor_diaria' => 150.00,
            'km_inicial' => 10000,
        ];

        $locacao = $this->service->createLocacao($data);

        $this->assertInstanceOf(Locacao::class, $locacao);
        $this->assertEquals($cliente->id, $locacao->cliente_id);
        $this->assertEquals($carro->id, $locacao->carro_id);
        $this->assertDatabaseHas('locacoes', ['cliente_id' => $cliente->id]);
    }

    public function test_update_locacao_successfully(): void
    {
        $locacao = Locacao::factory()->create(['km_inicial' => 10000]);

        $updated = $this->service->updateLocacao($locacao, ['km_final' => 10500]);

        $this->assertEquals(10500, $updated->km_final);
        $this->assertDatabaseHas('locacoes', ['id' => $locacao->id, 'km_final' => 10500]);
    }

    public function test_delete_locacao_successfully(): void
    {
        $locacao = Locacao::factory()->create();

        $this->service->deleteLocacao($locacao);

        $this->assertDatabaseMissing('locacoes', ['id' => $locacao->id]);
    }
}
