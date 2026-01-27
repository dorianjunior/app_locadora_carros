<?php

namespace App\Services;

use App\Models\Cliente;
use Illuminate\Support\Facades\DB;

class ClienteService
{
    /**
     * Create a new cliente
     *
     * @param array<string, mixed> $data
     * @return Cliente
     */
    public function createCliente(array $data): Cliente
    {
        return DB::transaction(function () use ($data) {
            return Cliente::create($data);
        });
    }

    /**
     * Update an existing cliente
     *
     * @param Cliente $cliente
     * @param array<string, mixed> $data
     * @return Cliente
     */
    public function updateCliente(Cliente $cliente, array $data): Cliente
    {
        return DB::transaction(function () use ($cliente, $data) {
            $cliente->fill($data);
            $cliente->save();

            return $cliente;
        });
    }

    /**
     * Delete a cliente
     *
     * @param Cliente $cliente
     * @return void
     * @throws \Exception
     */
    public function deleteCliente(Cliente $cliente): void
    {
        $locacoesCount = $cliente->locacoes()->count();

        if ($locacoesCount > 0) {
            throw new \Exception(
                "Não é possível excluir este cliente. Existem {$locacoesCount} locação(ões) vinculada(s)."
            );
        }

        DB::transaction(function () use ($cliente) {
            $cliente->delete();
        });
    }
}
