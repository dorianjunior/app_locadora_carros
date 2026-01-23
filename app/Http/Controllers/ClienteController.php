<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Http\Requests\StoreClienteRequest;
use App\Http\Requests\UpdateClienteRequest;
use App\Repositories\ClienteRepository;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    use ApiResponse;

    protected $cliente;

    public function __construct(Cliente $cliente)
    {
        $this->cliente = $cliente;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $clienteRepository = new ClienteRepository($this->cliente);

        if ($request->has('filtro')) {
            $clienteRepository->filtro($request->filtro);
        }

        if ($request->has('atributos')) {
            $clienteRepository->selectAtributos($request->atributos);
        }

        $resultado = $clienteRepository->getResultadoPaginado(10);

        return $this->successResponse($resultado, 'Clientes listados com sucesso');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreClienteRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreClienteRequest $request): JsonResponse
    {
        try {
            $cliente = $this->cliente->create($request->validated());

            return $this->createdResponse($cliente, 'Cliente criado com sucesso');
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Erro ao criar cliente: ' . $e->getMessage(),
                500
            );
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id): JsonResponse
    {
        $cliente = $this->cliente->find($id);

        if (!$cliente) {
            return $this->notFoundResponse('Cliente não encontrado');
        }

        return $this->successResponse($cliente, 'Cliente encontrado com sucesso');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateClienteRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateClienteRequest $request, $id): JsonResponse
    {
        try {
            $cliente = $this->cliente->find($id);

            if (!$cliente) {
                return $this->notFoundResponse('Cliente não encontrado');
            }

            $cliente->fill($request->validated());
            $cliente->save();

            return $this->successResponse($cliente, 'Cliente atualizado com sucesso');
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Erro ao atualizar cliente: ' . $e->getMessage(),
                500
            );
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        try {
            $cliente = $this->cliente->find($id);

            if (!$cliente) {
                return $this->notFoundResponse('Cliente não encontrado');
            }

            $locacoesCount = $cliente->locacoes()->count();
            if ($locacoesCount > 0) {
                return $this->errorResponse(
                    "Não é possível excluir este cliente. Existem {$locacoesCount} locação(ões) vinculada(s).",
                    400
                );
            }

            $cliente->delete();

            return $this->successResponse(null, 'Cliente excluído com sucesso');
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Erro ao excluir cliente: ' . $e->getMessage(),
                500
            );
        }
    }
}
