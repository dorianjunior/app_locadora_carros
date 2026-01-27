<?php

namespace App\Http\Controllers;

use App\Models\Locacao;
use App\Http\Requests\StoreLocacaoRequest;
use App\Http\Requests\UpdateLocacaoRequest;
use App\Http\Resources\LocacaoResource;
use App\Repositories\LocacaoRepository;
use App\Services\LocacaoService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LocacaoController extends Controller
{
    public function __construct(
        private readonly LocacaoService $locacaoService,
        private readonly Locacao $locacao
    ) {}

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $locacaoRepository = new LocacaoRepository($this->locacao);

        // Carregar relacionamento cliente
        if ($request->has('atributos_cliente')) {
            $atributos_cliente = 'cliente:id,' . $request->atributos_cliente;
            $locacaoRepository->selectAtributosRegistrosRelacionados($atributos_cliente);
        } else {
            $locacaoRepository->selectAtributosRegistrosRelacionados('cliente');
        }

        // Carregar relacionamento carro
        if ($request->has('atributos_carro')) {
            $atributos_carro = 'carro:id,' . $request->atributos_carro;
            $locacaoRepository->selectAtributosRegistrosRelacionados($atributos_carro);
        } else {
            $locacaoRepository->selectAtributosRegistrosRelacionados('carro');
        }

        // Carregar relacionamento modelo através do carro
        if ($request->has('atributos_modelo')) {
            $atributos_modelo = 'carro.modelo:id,' . $request->atributos_modelo;
            $locacaoRepository->selectAtributosRegistrosRelacionados($atributos_modelo);
        } else {
            $locacaoRepository->selectAtributosRegistrosRelacionados('carro.modelo');
        }

        if ($request->has('filtro')) {
            $locacaoRepository->filtro($request->filtro);
        }

        if ($request->has('atributos')) {
            $locacaoRepository->selectAtributos($request->atributos);
        }

        $resultado = $locacaoRepository->getResultadoPaginado(10);

        return response()->json([
            'success' => true,
            'message' => 'Locações listadas com sucesso',
            'data' => $resultado,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLocacaoRequest $request): LocacaoResource
    {
        $locacao = $this->locacaoService->createLocacao($request->validated());
        $locacao->load(['cliente', 'carro.modelo.marca']);

        return new LocacaoResource($locacao);
    }

    /**
     * Display the specified resource.
     */
    public function show(Locacao $locacao): LocacaoResource
    {
        $locacao->load(['cliente', 'carro.modelo.marca']);

        return new LocacaoResource($locacao);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLocacaoRequest $request, Locacao $locacao): LocacaoResource
    {
        $locacao = $this->locacaoService->updateLocacao($locacao, $request->validated());
        $locacao->load(['cliente', 'carro.modelo.marca']);

        return new LocacaoResource($locacao);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Locacao $locacao): JsonResponse
    {
        $this->locacaoService->deleteLocacao($locacao);

        return response()->json([
            'success' => true,
            'message' => 'Locação excluída com sucesso',
        ]);
    }
}
