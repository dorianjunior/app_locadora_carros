<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Http\Requests\StoreClienteRequest;
use App\Http\Requests\UpdateClienteRequest;
use App\Http\Resources\ClienteResource;
use App\Repositories\ClienteRepository;
use App\Services\ClienteService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function __construct(
        private readonly ClienteService $clienteService,
        private readonly Cliente $cliente
    ) {}

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

        return response()->json([
            'success' => true,
            'message' => 'Clientes listados com sucesso',
            'data' => $resultado,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreClienteRequest $request): ClienteResource
    {
        $cliente = $this->clienteService->createCliente($request->validated());

        return new ClienteResource($cliente);
    }

    /**
     * Display the specified resource.
     */
    public function show(Cliente $cliente): ClienteResource
    {
        return new ClienteResource($cliente);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateClienteRequest $request, Cliente $cliente): ClienteResource
    {
        $cliente = $this->clienteService->updateCliente($cliente, $request->validated());

        return new ClienteResource($cliente);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cliente $cliente): JsonResponse
    {
        try {
            $this->clienteService->deleteCliente($cliente);

            return response()->json([
                'success' => true,
                'message' => 'Cliente excluído com sucesso',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }
}
