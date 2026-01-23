<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use App\Http\Requests\StoreMarcaRequest;
use App\Http\Requests\UpdateMarcaRequest;
use App\Repositories\MarcaRepository;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MarcaController extends Controller
{
    use ApiResponse;

    protected $marca;

    public function __construct(Marca $marca)
    {
        $this->marca = $marca;
    }

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

        return $this->successResponse($resultado, 'Marcas listadas com sucesso');
    }

    /**
     * Get all marcas without pagination (for dropdowns)
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function all(): JsonResponse
    {
        $marcas = $this->marca->select('id', 'nome')
            ->orderBy('nome')
            ->get();

        return $this->successResponse($marcas, 'Marcas listadas com sucesso');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreMarcaRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreMarcaRequest $request): JsonResponse
    {
        try {
            $imagem = $request->file('imagem');
            $imagem_urn = $imagem->store('imagens/marcas', 'public');

            $marca = $this->marca->create([
                'nome' => $request->nome,
                'imagem' => $imagem_urn
            ]);

            $marca->load('modelos');

            return $this->createdResponse($marca, 'Marca criada com sucesso');
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Erro ao criar marca: ' . $e->getMessage(),
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
        $marca = $this->marca->with('modelos')->find($id);

        if (!$marca) {
            return $this->notFoundResponse('Marca não encontrada');
        }

        return $this->successResponse($marca, 'Marca encontrada com sucesso');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateMarcaRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateMarcaRequest $request, $id): JsonResponse
    {
        try {
            $marca = $this->marca->find($id);

            if (!$marca) {
                return $this->notFoundResponse('Marca não encontrada');
            }

            if ($request->hasFile('imagem')) {
                // Remove a imagem antiga
                if ($marca->imagem && Storage::disk('public')->exists($marca->imagem)) {
                    Storage::disk('public')->delete($marca->imagem);
                }

                $imagem = $request->file('imagem');
                $imagem_urn = $imagem->store('imagens/marcas', 'public');
                $marca->imagem = $imagem_urn;
            }

            if ($request->has('nome')) {
                $marca->nome = $request->nome;
            }

            $marca->save();
            $marca->load('modelos');

            return $this->successResponse($marca, 'Marca atualizada com sucesso');
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Erro ao atualizar marca: ' . $e->getMessage(),
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
            $marca = $this->marca->find($id);

            if (!$marca) {
                return $this->notFoundResponse('Marca não encontrada');
            }

            $modelosCount = $marca->modelos()->count();
            if ($modelosCount > 0) {
                return $this->errorResponse(
                    "Não é possível excluir esta marca. Existem {$modelosCount} modelo(s) vinculado(s).",
                    400
                );
            }

            if ($marca->imagem && Storage::disk('public')->exists($marca->imagem)) {
                Storage::disk('public')->delete($marca->imagem);
            }

            $marca->delete();

            return $this->successResponse(null, 'Marca excluída com sucesso');
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Erro ao excluir marca: ' . $e->getMessage(),
                500
            );
        }
    }
}
