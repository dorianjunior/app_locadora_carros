<?php

namespace Tests\Unit\Services;

use App\Models\Marca;
use App\Services\MarcaService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class MarcaServiceTest extends TestCase
{
    use RefreshDatabase;

    private MarcaService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new MarcaService();
        Storage::fake('public');
    }

    public function test_create_marca_successfully(): void
    {
        $imagem = UploadedFile::fake()->image('marca.jpg');

        $marca = $this->service->createMarca('Toyota', $imagem);

        $this->assertInstanceOf(Marca::class, $marca);
        $this->assertEquals('Toyota', $marca->nome);
        $this->assertNotNull($marca->imagem);
        Storage::disk('public')->assertExists($marca->imagem);
    }

    public function test_update_marca_nome_only(): void
    {
        $marca = Marca::factory()->create(['nome' => 'Ford']);

        $updated = $this->service->updateMarca($marca, 'Toyota', null);

        $this->assertEquals('Toyota', $updated->nome);
        $this->assertEquals($marca->imagem, $updated->imagem);
    }

    public function test_update_marca_with_new_image(): void
    {
        $oldImage = UploadedFile::fake()->image('old.jpg');
        $oldImagePath = $oldImage->store('imagens/marcas', 'public');
        $marca = Marca::factory()->create(['imagem' => $oldImagePath]);
        $newImage = UploadedFile::fake()->image('new.jpg');

        $updated = $this->service->updateMarca($marca, null, $newImage);

        $this->assertNotEquals($oldImagePath, $updated->imagem);
        Storage::disk('public')->assertExists($updated->imagem);
        Storage::disk('public')->assertMissing($oldImagePath);
    }

    public function test_delete_marca_removes_image(): void
    {
        $imagem = UploadedFile::fake()->image('marca.jpg');
        $marca = Marca::factory()->create(['imagem' => $imagem->store('imagens/marcas', 'public')]);

        $result = $this->service->deleteMarca($marca);

        $this->assertTrue($result);
        $this->assertDatabaseMissing('marcas', ['id' => $marca->id]);
        Storage::disk('public')->assertMissing($marca->imagem);
    }
}
