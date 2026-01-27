<?php

namespace Tests\Unit\Services;

use App\Models\Carro;
use App\Models\Locacao;
use App\Models\Modelo;
use App\Services\CarroService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CarroServiceTest extends TestCase
{
    use RefreshDatabase;

    private CarroService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new CarroService();
    }

    public function test_create_carro_successfully(): void
    {
        $modelo = Modelo::factory()->create();
        $data = [
            'modelo_id' => $modelo->id,
            'placa' => 'ABC-1234',
            'disponivel' => true,
            'km' => 0,
        ];

        $carro = $this->service->createCarro($data);

        $this->assertInstanceOf(Carro::class, $carro);
        $this->assertEquals('ABC-1234', $carro->placa);
        $this->assertTrue($carro->disponivel);
        $this->assertDatabaseHas('carros', ['placa' => 'ABC-1234']);
    }

    public function test_update_carro_successfully(): void
    {
        $carro = Carro::factory()->create(['km' => 1000]);
        $data = ['km' => 5000, 'disponivel' => false];

        $updated = $this->service->updateCarro($carro, $data);

        $this->assertEquals(5000, $updated->km);
        $this->assertFalse($updated->disponivel);
    }

    public function test_delete_carro_without_locacoes(): void
    {
        $carro = Carro::factory()->create();

        $result = $this->service->deleteCarro($carro);

        $this->assertTrue($result);
        $this->assertDatabaseMissing('carros', ['id' => $carro->id]);
    }

    public function test_cannot_delete_carro_with_locacoes(): void
    {
        $carro = Carro::factory()->create();
        Locacao::factory()->create(['carro_id' => $carro->id]);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Não é possível excluir este carro');

        $this->service->deleteCarro($carro);
    }
}
