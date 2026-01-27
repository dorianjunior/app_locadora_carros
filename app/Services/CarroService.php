<?php

namespace App\Services;

use App\Models\Carro;
use Illuminate\Support\Facades\DB;

class CarroService
{
    public function createCarro(array $data): Carro
    {
        return DB::transaction(function () use ($data) {
            return Carro::create($data);
        });
    }

    public function updateCarro(Carro $carro, array $data): Carro
    {
        return DB::transaction(function () use ($carro, $data) {
            $carro->fill($data);
            $carro->save();

            return $carro;
        });
    }

    public function deleteCarro(Carro $carro): bool
    {
        $locacoesCount = $carro->locacoes()->count();

        if ($locacoesCount > 0) {
            throw new \Exception("Não é possível excluir este carro. Existem {$locacoesCount} locação(ões) vinculada(s).");
        }

        return DB::transaction(function () use ($carro) {
            return $carro->delete();
        });
    }
}
