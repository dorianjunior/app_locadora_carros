<?php

namespace App\Services;

use App\Models\Modelo;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ModeloService
{
    /**
     * Create a new modelo with image
     *
     * @param array<string, mixed> $data
     * @return Modelo
     */
    public function createModelo(array $data): Modelo
    {
        return DB::transaction(function () use ($data) {
            $imagemUrn = null;

            if (isset($data['imagem']) && $data['imagem'] instanceof UploadedFile) {
                $imagemUrn = $this->storeImagem($data['imagem']);
            }

            return Modelo::create([
                'marca_id' => $data['marca_id'],
                'nome' => $data['nome'],
                'imagem' => $imagemUrn,
                'numero_portas' => $data['numero_portas'],
                'lugares' => $data['lugares'],
                'air_bag' => $data['air_bag'],
                'abs' => $data['abs'],
            ]);
        });
    }

    /**
     * Update an existing modelo
     *
     * @param Modelo $modelo
     * @param array<string, mixed> $data
     * @return Modelo
     */
    public function updateModelo(Modelo $modelo, array $data): Modelo
    {
        return DB::transaction(function () use ($modelo, $data) {
            if (isset($data['imagem']) && $data['imagem'] instanceof UploadedFile) {
                $this->deleteImagem($modelo->imagem);
                $modelo->imagem = $this->storeImagem($data['imagem']);
            }

            $modelo->fill(collect($data)->except('imagem')->toArray());
            $modelo->save();

            return $modelo;
        });
    }

    /**
     * Delete a modelo
     *
     * @param Modelo $modelo
     * @return void
     * @throws \Exception
     */
    public function deleteModelo(Modelo $modelo): void
    {
        $carrosCount = $modelo->carros()->count();

        if ($carrosCount > 0) {
            throw new \Exception(
                "Não é possível excluir este modelo. Existem {$carrosCount} carro(s) vinculado(s)."
            );
        }

        DB::transaction(function () use ($modelo) {
            $this->deleteImagem($modelo->imagem);
            $modelo->delete();
        });
    }

    /**
     * Store uploaded image
     *
     * @param UploadedFile $file
     * @return string
     */
    private function storeImagem(UploadedFile $file): string
    {
        return $file->store('imagens/modelos', 'public');
    }

    /**
     * Delete image from storage
     *
     * @param string|null $path
     * @return void
     */
    private function deleteImagem(?string $path): void
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}
