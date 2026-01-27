<?php

namespace App\Http\Controllers;

use App\Models\Carro;
use App\Http\Requests\StoreCarroRequest;
use App\Http\Requests\UpdateCarroRequest;
use App\Repositories\CarroRepository;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CarroController extends Controller
{
    use ApiResponse;

    protected $carro;

    public function __construct(Carro $carro)
    {
        $this->carro = $carro;
    }

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

        return $this->successResponse($resultado, 'Carros listados com sucesso');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCarroRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreCarroRequest $request): JsonResponse
    {
        try {
            $carro = $this->carro->create($request->validated());
            $carro->load('modelo.marca');

            return $this->createdResponse($carro, 'Carro criado com sucesso');
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Erro ao criar carro: ' . $e->getMessage(),
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
        $carro = $this->carro->with('modelo.marca')->find($id);

        if (!$carro) {
            return $this->notFoundResponse('Carro não encontrado');
        }

        return $this->successResponse($carro, 'Carro encontrado com sucesso');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCarroRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateCarroRequest $request, $id): JsonResponse
    {
        try {
            $carro = $this->carro->find($id);

            if (!$carro) {
                return $this->notFoundResponse('Carro não encontrado');
            }

            $carro->fill($request->validated());
            $carro->save();
            $carro->load('modelo.marca');

            return $this->successResponse($carro, 'Carro atualizado com sucesso');
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Erro ao atualizar carro: ' . $e->getMessage(),
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
            $carro = $this->carro->find($id);

            if (!$carro) {
                return $this->notFoundResponse('Carro não encontrado');
            }

            $locacoesCount = $carro->locacoes()->count();
            if ($locacoesCount > 0) {
                return $this->errorResponse(
                    "Não é possível excluir este carro. Existem {$locacoesCount} locação(ões) vinculada(s).",
                    400
                );
            }

            $carro->delete();

            return $this->successResponse(null, 'Carro excluído com sucesso');
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Erro ao excluir carro: ' . $e->getMessage(),
                500
            );
        }
    }
}
