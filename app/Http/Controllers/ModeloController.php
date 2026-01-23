<?php

namespace App\Http\Controllers;

use App\Models\Modelo;
use App\Http\Requests\StoreModeloRequest;
use App\Http\Requests\UpdateModeloRequest;
use App\Repositories\ModeloRepository;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ModeloController extends Controller
{
    use ApiResponse;

    protected $modelo;

    public function __construct(Modelo $modelo)
    {
        $this->modelo = $modelo;
    }

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

        return $this->successResponse($resultado, 'Modelos listados com sucesso');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreModeloRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreModeloRequest $request): JsonResponse
    {
        try {
            $imagem = $request->file('imagem');
            $imagem_urn = $imagem->store('imagens/modelos', 'public');

            $modelo = $this->modelo->create([
                'marca_id' => $request->marca_id,
                'nome' => $request->nome,
                'imagem' => $imagem_urn,
                'numero_portas' => $request->numero_portas,
                'lugares' => $request->lugares,
                'air_bag' => $request->air_bag,
                'abs' => $request->abs
            ]);

            $modelo->load('marca');

            return $this->createdResponse($modelo, 'Modelo criado com sucesso');
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Erro ao criar modelo: ' . $e->getMessage(),
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
        $modelo = $this->modelo->with('marca')->find($id);

        if (!$modelo) {
            return $this->notFoundResponse('Modelo não encontrado');
        }

        return $this->successResponse($modelo, 'Modelo encontrado com sucesso');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateModeloRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateModeloRequest $request, $id): JsonResponse
    {
        try {
            $modelo = $this->modelo->find($id);

            if (!$modelo) {
                return $this->notFoundResponse('Modelo não encontrado');
            }

            if ($request->hasFile('imagem')) {
                if ($modelo->imagem && Storage::disk('public')->exists($modelo->imagem)) {
                    Storage::disk('public')->delete($modelo->imagem);
                }

                $imagem = $request->file('imagem');
                $imagem_urn = $imagem->store('imagens/modelos', 'public');
                $modelo->imagem = $imagem_urn;
            }

            $modelo->fill($request->except('imagem'));
            $modelo->save();
            $modelo->load('marca');

            return $this->successResponse($modelo, 'Modelo atualizado com sucesso');
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Erro ao atualizar modelo: ' . $e->getMessage(),
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
            $modelo = $this->modelo->find($id);

            if (!$modelo) {
                return $this->notFoundResponse('Modelo não encontrado');
            }

            $carrosCount = $modelo->carros()->count();
            if ($carrosCount > 0) {
                return $this->errorResponse(
                    "Não é possível excluir este modelo. Existem {$carrosCount} carro(s) vinculado(s).",
                    400
                );
            }

            if ($modelo->imagem && Storage::disk('public')->exists($modelo->imagem)) {
                Storage::disk('public')->delete($modelo->imagem);
            }

            $modelo->delete();

            return $this->successResponse(null, 'Modelo excluído com sucesso');
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Erro ao excluir modelo: ' . $e->getMessage(),
                500
            );
        }
    }
}
