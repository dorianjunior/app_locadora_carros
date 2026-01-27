<?php

namespace App\Http\Controllers;

use App\Models\Carro;
use App\Http\Requests\StoreCarroRequest;
use App\Http\Requests\UpdateCarroRequest;
use App\Http\Resources\CarroResource;
use App\Repositories\CarroRepository;
use App\Services\CarroService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CarroController extends Controller
{
    public function __construct(
        private readonly CarroService $carroService,
        private readonly Carro $carro
    ) {}

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $carroRepository = new CarroRepository($this->carro);

        if ($request->has('atributos_modelo')) {
            $atributos_modelo = 'modelo:id,' . $request->atributos_modelo;
            $carroRepository->selectAtributosRegistrosRelacionados($atributos_modelo);
        } else {
            $carroRepository->selectAtributosRegistrosRelacionados('modelo');
        }

        // Carregar relacionamento aninhado marca através de modelo
        if ($request->has('atributos_marca')) {
            $atributos_marca = 'modelo.marca:id,' . $request->atributos_marca;
            $carroRepository->selectAtributosRegistrosRelacionados($atributos_marca);
        } else {
            $carroRepository->selectAtributosRegistrosRelacionados('modelo.marca');
        }

        if ($request->has('filtro')) {
            $carroRepository->filtro($request->filtro);
        }

        if ($request->has('atributos')) {
            $carroRepository->selectAtributos($request->atributos);
        }

        $resultado = $carroRepository->getResultadoPaginado(10);

        return response()->json([
            'success' => true,
            'message' => 'Carros listados com sucesso',
            'data' => $resultado,
        ]);
    }

    /**
     * Get all carros without pagination (for dropdowns)
     */
    public function all(): JsonResponse
    {
        $carros = $this->carro
            ->with(['modelo:id,nome,marca_id', 'modelo.marca:id,nome'])
            ->select('id', 'placa', 'modelo_id', 'disponivel')
            ->where('disponivel', true)
            ->orderBy('placa')
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Carros listados com sucesso',
            'data' => CarroResource::collection($carros),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCarroRequest $request): CarroResource
    {
        $carro = $this->carroService->createCarro($request->validated());
        $carro->load('modelo.marca');

        return new CarroResource($carro);
    }

    /**
     * Display the specified resource.
     */
    public function show(Carro $carro): CarroResource
    {
        $carro->load('modelo.marca');

        return new CarroResource($carro);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCarroRequest $request, Carro $carro): CarroResource
    {
        $carro = $this->carroService->updateCarro($carro, $request->validated());
        $carro->load('modelo.marca');

        return new CarroResource($carro);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Carro $carro): JsonResponse
    {
        try {
            $this->carroService->deleteCarro($carro);

            return response()->json([
                'success' => true,
                'message' => 'Carro excluído com sucesso',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }
}
