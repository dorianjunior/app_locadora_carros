<?php

namespace App\Services;

use App\Models\Marca;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class MarcaService
{
    public function createMarca(string $nome, UploadedFile $imagem): Marca
    {
        return DB::transaction(function () use ($nome, $imagem) {
            $imagemUrn = $this->storeImagem($imagem);

            return Marca::create([
                'nome' => $nome,
                'imagem' => $imagemUrn,
            ]);
        });
    }

    public function updateMarca(Marca $marca, ?string $nome, ?UploadedFile $imagem): Marca
    {
        return DB::transaction(function () use ($marca, $nome, $imagem) {
            if ($imagem) {
                $this->deleteImagem($marca->imagem);
                $marca->imagem = $this->storeImagem($imagem);
            }

            if ($nome) {
                $marca->nome = $nome;
            }

            $marca->save();

            return $marca;
        });
    }

    public function deleteMarca(Marca $marca): bool
    {
        return DB::transaction(function () use ($marca) {
            $this->deleteImagem($marca->imagem);

            return $marca->delete();
        });
    }

    private function storeImagem(UploadedFile $imagem): string
    {
        return $imagem->store('imagens/marcas', 'public');
    }

    private function deleteImagem(?string $imagemPath): void
    {
        if ($imagemPath && Storage::disk('public')->exists($imagemPath)) {
            Storage::disk('public')->delete($imagemPath);
        }
    }
}
