<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use App\Http\Requests\StoreMarcaRequest;
use App\Http\Requests\UpdateMarcaRequest;
use App\Http\Resources\MarcaResource;
use App\Repositories\MarcaRepository;
use App\Services\MarcaService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MarcaController extends Controller
{
    public function __construct(
        private readonly MarcaService $marcaService,
        private readonly Marca $marca
    ) {}

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $marcaRepository = new MarcaRepository($this->marca);

        if ($request->has('atributos_modelos')) {
            $atributos_modelos = 'modelos:id,' . $request->atributos_modelos;
            $marcaRepository->selectAtributosRegistrosRelacionados($atributos_modelos);
        } else {
            $marcaRepository->selectAtributosRegistrosRelacionados('modelos');
        }

        if ($request->has('filtro')) {
            $marcaRepository->filtro($request->filtro);
        }

        if ($request->has('atributos')) {
            $marcaRepository->selectAtributos($request->atributos);
        }

        $resultado = $marcaRepository->getResultadoPaginado(10);

        return response()->json([
            'success' => true,
            'message' => 'Marcas listadas com sucesso',
            'data' => $resultado,
        ]);
    }

    /**
     * Get all marcas without pagination (for dropdowns)
     */
    public function all(): JsonResponse
    {
        $marcas = $this->marca
            ->select('id', 'nome')
            ->orderBy('nome')
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Marcas listadas com sucesso',
            'data' => MarcaResource::collection($marcas),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMarcaRequest $request): MarcaResource
    {
        $validated = $request->validated();

        $marca = $this->marcaService->createMarca(
            nome: $validated['nome'],
            imagem: $request->file('imagem')
        );

        $marca->load('modelos');

        return new MarcaResource($marca);
    }

    /**
     * Display the specified resource.
     */
    public function show(Marca $marca): MarcaResource
    {
        $marca->load('modelos');

        return new MarcaResource($marca);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMarcaRequest $request, Marca $marca): MarcaResource
    {
        $validated = $request->validated();

        $marca = $this->marcaService->updateMarca(
            marca: $marca,
            nome: $validated['nome'] ?? null,
            imagem: $request->file('imagem')
        );

        $marca->load('modelos');

        return new MarcaResource($marca);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Marca $marca): JsonResponse
    {
        $modelosCount = $marca->modelos()->count();

        if ($modelosCount > 0) {
            return response()->json([
                'success' => false,
                'message' => "Não é possível excluir esta marca. Existem {$modelosCount} modelo(s) vinculado(s).",
            ], 400);
        }

        $this->marcaService->deleteMarca($marca);

        return response()->json([
            'success' => true,
            'message' => 'Marca excluída com sucesso',
        ]);
    }
}
