<?php

namespace Tests\Feature\Modelo;

use App\Models\Marca;
use App\Models\Modelo;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ModeloTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private string $token;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');
        $this->user = User::factory()->create();
        $this->token = auth('api')->login($this->user);
    }

    public function test_can_list_modelos(): void
    {
        Modelo::factory()->count(3)->create();

        $response = $this->withHeaders(["Authorization" => "Bearer " . $this->token])
            ->getJson('/api/v1/modelo');

        $response->assertOk()
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    'data' => [
                        '*' => ['id', 'nome', 'marca_id'],
                    ],
                ],
            ]);
    }

    public function test_can_create_modelo(): void
    {
        $marca = Marca::factory()->create();
        $imagem = UploadedFile::fake()->image('corolla.jpg');

        $response = $this->withHeaders(["Authorization" => "Bearer " . $this->token])
            ->postJson('/api/v1/modelo', [
                'marca_id' => $marca->id,
                'nome' => 'Corolla',
                'imagem' => $imagem,
                'numero_portas' => 4,
                'lugares' => 5,
                'air_bag' => true,
                'abs' => true,
            ]);

        $response->assertCreated()
            ->assertJsonStructure(['data' => ['id', 'nome', 'marca_id', 'imagem']]);

        $this->assertDatabaseHas('modelos', [
            'nome' => 'Corolla',
            'marca_id' => $marca->id,
        ]);
    }

    public function test_cannot_create_modelo_without_required_fields(): void
    {
        $response = $this->withHeaders(["Authorization" => "Bearer " . $this->token])
            ->postJson('/api/v1/modelo', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['marca_id', 'nome', 'imagem']);
    }

    public function test_can_show_modelo(): void
    {
        $modelo = Modelo::factory()->create();

        $response = $this->withHeaders(["Authorization" => "Bearer " . $this->token])
            ->getJson("/api/v1/modelo/{$modelo->id}");

        $response->assertOk()
            ->assertJson([
                'data' => [
                    'id' => $modelo->id,
                    'nome' => $modelo->nome,
                ],
            ]);
    }

    public function test_can_update_modelo(): void
    {
        $modelo = Modelo::factory()->create(['nome' => 'Corolla']);

        $response = $this->withHeaders(["Authorization" => "Bearer " . $this->token])
            ->putJson("/api/v1/modelo/{$modelo->id}", [
                'marca_id' => $modelo->marca_id,
                'nome' => 'Camry',
                'numero_portas' => 4,
                'lugares' => 5,
                'air_bag' => true,
                'abs' => true,
            ]);

        $response->assertOk()
            ->assertJson([
                'data' => ['nome' => 'Camry'],
            ]);

        $this->assertDatabaseHas('modelos', [
            'id' => $modelo->id,
            'nome' => 'Camry',
        ]);
    }

    public function test_can_delete_modelo_without_carros(): void
    {
        $modelo = Modelo::factory()->create();

        $response = $this->withHeaders(["Authorization" => "Bearer " . $this->token])
            ->deleteJson("/api/v1/modelo/{$modelo->id}");

        $response->assertOk()
            ->assertJson([
                'success' => true,
                'message' => 'Modelo excluído com sucesso',
            ]);

        $this->assertDatabaseMissing('modelos', ['id' => $modelo->id]);
    }

    public function test_can_filter_modelos_by_marca(): void
    {
        $marca = Marca::factory()->create();
        Modelo::factory()->create(['marca_id' => $marca->id]);
        Modelo::factory()->create();

        $response = $this->withHeaders(["Authorization" => "Bearer " . $this->token])
            ->getJson("/api/v1/modelo?filtro=marca_id:=:{$marca->id}");

        $response->assertOk();
        $data = $response->json('data.data');
        $this->assertCount(1, $data);
    }

}
