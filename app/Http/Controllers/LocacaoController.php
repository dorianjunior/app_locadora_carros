<?php

namespace App\Http\Controllers;

use App\Models\Locacao;
use App\Http\Requests\StoreLocacaoRequest;
use App\Http\Requests\UpdateLocacaoRequest;
use App\Repositories\LocacaoRepository;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LocacaoController extends Controller
{
    use ApiResponse;

    protected $locacao;

    public function __construct(Locacao $locacao)
    {
        $this->locacao = $locacao;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $locacaoRepository = new LocacaoRepository($this->locacao);

        if ($request->has('filtro')) {
            $locacaoRepository->filtro($request->filtro);
        }

        if ($request->has('atributos')) {
            $locacaoRepository->selectAtributos($request->atributos);
        }

        $resultado = $locacaoRepository->getResultadoPaginado(10);

        return $this->successResponse($resultado, 'Locações listadas com sucesso');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreLocacaoRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreLocacaoRequest $request): JsonResponse
    {
        try {
            $locacao = $this->locacao->create($request->validated());
            $locacao->load(['cliente', 'carro.modelo.marca']);

            return $this->createdResponse($locacao, 'Locação criada com sucesso');
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Erro ao criar locação: ' . $e->getMessage(),
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
        $locacao = $this->locacao->with(['cliente', 'carro.modelo.marca'])->find($id);

        if (!$locacao) {
            return $this->notFoundResponse('Locação não encontrada');
        }

        return $this->successResponse($locacao, 'Locação encontrada com sucesso');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateLocacaoRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateLocacaoRequest $request, $id): JsonResponse
    {
        try {
            $locacao = $this->locacao->find($id);

            if (!$locacao) {
                return $this->notFoundResponse('Locação não encontrada');
            }

            $locacao->fill($request->validated());
            $locacao->save();
            $locacao->load(['cliente', 'carro.modelo.marca']);

            return $this->successResponse($locacao, 'Locação atualizada com sucesso');
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Erro ao atualizar locação: ' . $e->getMessage(),
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
            $locacao = $this->locacao->find($id);

            if (!$locacao) {
                return $this->notFoundResponse('Locação não encontrada');
            }

            $locacao->delete();

            return $this->successResponse(null, 'Locação excluída com sucesso');
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Erro ao excluir locação: ' . $e->getMessage(),
                500
            );
        }
    }
}
