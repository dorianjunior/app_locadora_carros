<?php

namespace Tests\Unit\Services;

use App\Models\Carro;
use App\Models\Marca;
use App\Models\Modelo;
use App\Services\ModeloService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ModeloServiceTest extends TestCase
{
    use RefreshDatabase;

    private ModeloService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new ModeloService();
        Storage::fake('public');
    }

    public function test_create_modelo_successfully(): void
    {
        $marca = Marca::factory()->create();
        $imagem = UploadedFile::fake()->image('modelo.jpg');

        $data = [
            'marca_id' => $marca->id,
            'nome' => 'Civic',
            'imagem' => $imagem,
            'numero_portas' => 4,
            'lugares' => 5,
            'air_bag' => true,
            'abs' => true,
        ];

        $modelo = $this->service->createModelo($data);

        $this->assertInstanceOf(Modelo::class, $modelo);
        $this->assertEquals('Civic', $modelo->nome);
        $this->assertNotNull($modelo->imagem);
        Storage::disk('public')->assertExists($modelo->imagem);
    }

    public function test_update_modelo_without_image(): void
    {
        $modelo = Modelo::factory()->create(['nome' => 'Corolla']);

        $updated = $this->service->updateModelo($modelo, ['nome' => 'Corolla XEI']);

        $this->assertEquals('Corolla XEI', $updated->nome);
    }

    public function test_update_modelo_with_new_image(): void
    {
        $oldImage = UploadedFile::fake()->image('old.jpg');
        $oldImagePath = $oldImage->store('imagens/modelos', 'public');
        $modelo = Modelo::factory()->create(['imagem' => $oldImagePath]);
        $newImage = UploadedFile::fake()->image('new.jpg');

        $updated = $this->service->updateModelo($modelo, ['imagem' => $newImage]);

        $this->assertNotEquals($oldImagePath, $updated->imagem);
        Storage::disk('public')->assertExists($updated->imagem);
        Storage::disk('public')->assertMissing($oldImagePath);
    }

    public function test_delete_modelo_successfully(): void
    {
        $imagem = UploadedFile::fake()->image('modelo.jpg');
        $modelo = Modelo::factory()->create(['imagem' => $imagem->store('imagens/modelos', 'public')]);

        $this->service->deleteModelo($modelo);

        $this->assertDatabaseMissing('modelos', ['id' => $modelo->id]);
        Storage::disk('public')->assertMissing($modelo->imagem);
    }

    public function test_cannot_delete_modelo_with_carros(): void
    {
        $modelo = Modelo::factory()->create();
        Carro::factory()->create(['modelo_id' => $modelo->id]);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Não é possível excluir este modelo');

        $this->service->deleteModelo($modelo);
    }
}
