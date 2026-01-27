<?php

namespace Tests\Feature\Marca;

use App\Models\Marca;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class MarcaTest extends TestCase
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

    public function test_can_list_marcas(): void
    {
        Marca::factory()->count(3)->create();

        $response = $this->withHeaders(["Authorization" => "Bearer " . $this->token])
            ->getJson('/api/v1/marca');

        $response->assertOk()
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    'data' => [
                        '*' => ['id', 'nome', 'imagem'],
                    ],
                ],
            ]);
    }

    public function test_can_get_all_marcas_without_pagination(): void
    {
        Marca::factory()->count(5)->create();

        $response = $this->withHeaders(["Authorization" => "Bearer " . $this->token])
            ->getJson('/api/v1/marca/all');

        $response->assertOk()
            ->assertJsonCount(5, 'data');
    }

    public function test_can_create_marca(): void
    {
        $imagem = UploadedFile::fake()->image('toyota.jpg');

        $response = $this->withHeaders(["Authorization" => "Bearer " . $this->token])
            ->postJson('/api/v1/marca', [
                'nome' => 'Toyota',
                'imagem' => $imagem,
            ]);

        $response->assertCreated()
            ->assertJsonStructure(['data' => ['id', 'nome', 'imagem', 'imagem_url']]);

        $this->assertDatabaseHas('marcas', ['nome' => 'Toyota']);
        Storage::disk('public')->assertExists('imagens/marcas/' . basename($response->json('imagem')));
    }

    public function test_cannot_create_marca_without_required_fields(): void
    {
        $response = $this->withHeaders(["Authorization" => "Bearer " . $this->token])
            ->postJson('/api/v1/marca', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['nome', 'imagem']);
    }

    public function test_cannot_create_marca_with_duplicate_name(): void
    {
        Marca::factory()->create(['nome' => 'Toyota']);
        $imagem = UploadedFile::fake()->image('toyota.jpg');

        $response = $this->withHeaders(["Authorization" => "Bearer " . $this->token])
            ->postJson('/api/v1/marca', [
                'nome' => 'Toyota',
                'imagem' => $imagem,
            ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['nome']);
    }

    public function test_can_show_marca(): void
    {
        $marca = Marca::factory()->create();

        $response = $this->withHeaders(["Authorization" => "Bearer " . $this->token])
            ->getJson("/api/v1/marca/{$marca->id}");

        $response->assertOk()
            ->assertJson([
                'data' => [
                    'id' => $marca->id,
                    'nome' => $marca->nome,
                ],
            ]);
    }

    public function test_can_update_marca(): void
    {
        $marca = Marca::factory()->create(['nome' => 'Ford']);
        $novaImagem = UploadedFile::fake()->image('toyota.jpg');

        $response = $this->withHeaders(["Authorization" => "Bearer " . $this->token])
            ->putJson("/api/v1/marca/{$marca->id}", [
                'nome' => 'Toyota',
                'imagem' => $novaImagem,
            ]);

        $response->assertOk()
            ->assertJson([
                'data' => [
                    'nome' => 'Toyota',
                ],
            ]);

        $this->assertDatabaseHas('marcas', [
            'id' => $marca->id,
            'nome' => 'Toyota',
        ]);
    }

    public function test_can_delete_marca_without_modelos(): void
    {
        $marca = Marca::factory()->create();

        $response = $this->withHeaders(["Authorization" => "Bearer " . $this->token])
            ->deleteJson("/api/v1/marca/{$marca->id}");

        $response->assertOk()
            ->assertJson([
                'success' => true,
                'message' => 'Marca excluída com sucesso',
            ]);

        $this->assertDatabaseMissing('marcas', ['id' => $marca->id]);
    }

    public function test_cannot_access_marca_without_authentication(): void
    {
        $response = $this->getJson('/api/v1/marca');

        $response->assertUnauthorized();
    }

}
