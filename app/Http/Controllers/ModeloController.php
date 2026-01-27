<?php

namespace App\Http\Controllers;

use App\Models\Modelo;
use App\Http\Requests\StoreModeloRequest;
use App\Http\Requests\UpdateModeloRequest;
use App\Http\Resources\ModeloResource;
use App\Repositories\ModeloRepository;
use App\Services\ModeloService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ModeloController extends Controller
{
    public function __construct(
        private readonly ModeloService $modeloService,
        private readonly Modelo $modelo
    ) {}

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $modeloRepository = new ModeloRepository($this->modelo);

        if ($request->has('atributos_marca')) {
            $atributos_marca = 'marca:id,' . $request->atributos_marca;
            $modeloRepository->selectAtributosRegistrosRelacionados($atributos_marca);
        } else {
            $modeloRepository->selectAtributosRegistrosRelacionados('marca');
        }

        if ($request->has('filtro')) {
            $modeloRepository->filtro($request->filtro);
        }

        if ($request->has('atributos')) {
            $modeloRepository->selectAtributos($request->atributos);
        }

        $resultado = $modeloRepository->getResultadoPaginado(10);

        return response()->json([
            'success' => true,
            'message' => 'Modelos listados com sucesso',
            'data' => $resultado,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreModeloRequest $request): ModeloResource
    {
        $modelo = $this->modeloService->createModelo($request->validated());
        $modelo->load('marca');

        return new ModeloResource($modelo);
    }

    /**
     * Display the specified resource.
     */
    public function show(Modelo $modelo): ModeloResource
    {
        $modelo->load('marca');

        return new ModeloResource($modelo);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateModeloRequest $request, Modelo $modelo): ModeloResource
    {
        $modelo = $this->modeloService->updateModelo($modelo, $request->validated());
        $modelo->load('marca');

        return new ModeloResource($modelo);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Modelo $modelo): JsonResponse
    {
        try {
            $this->modeloService->deleteModelo($modelo);

            return response()->json([
                'success' => true,
                'message' => 'Modelo excluído com sucesso',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }
}
