<?php

namespace App\Services;

use App\Models\Locacao;
use Illuminate\Support\Facades\DB;

class LocacaoService
{
    /**
     * Create a new locacao
     *
     * @param array<string, mixed> $data
     * @return Locacao
     */
    public function createLocacao(array $data): Locacao
    {
        return DB::transaction(function () use ($data) {
            return Locacao::create($data);
        });
    }

    /**
     * Update an existing locacao
     *
     * @param Locacao $locacao
     * @param array<string, mixed> $data
     * @return Locacao
     */
    public function updateLocacao(Locacao $locacao, array $data): Locacao
    {
        return DB::transaction(function () use ($locacao, $data) {
            $locacao->fill($data);
            $locacao->save();

            return $locacao;
        });
    }

    /**
     * Delete a locacao
     *
     * @param Locacao $locacao
     * @return void
     */
    public function deleteLocacao(Locacao $locacao): void
    {
        DB::transaction(function () use ($locacao) {
            $locacao->delete();
        });
    }
}
