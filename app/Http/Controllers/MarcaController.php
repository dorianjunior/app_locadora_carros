<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use App\Models\Marca;
use Illuminate\Http\Request;
use App\Repositories\MarcaRepository;

class MarcaController extends Controller
{
    public function __construct(Marca $marca) {
        $this->marca = $marca;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $marcaRepository = new MarcaRepository($this->marca);

        if($request->has('atributos_modelos')) {
            $atributos_modelos = 'modelos:id,'.$request->atributos_modelos;
            $marcaRepository->selectAtributosRegistrosRelacionados($atributos_modelos);
        } else {
            $marcaRepository->selectAtributosRegistrosRelacionados('modelos');
        }

        if($request->has('filtro')) {
            $marcaRepository->filtro($request->filtro);
        }

        if($request->has('atributos')) {
            $marcaRepository->selectAtributos($request->atributos);
        }

        return response()->json($marcaRepository->getResultadoPaginado(10), 200);
    }

    /**
     * Get all marcas without pagination (for dropdowns)
     *
     * @return \Illuminate\Http\Response
     */
    public function all()
    {
        $marcas = $this->marca->select('id', 'nome')->orderBy('nome')->get();
        return response()->json($marcas, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $request->validate($this->marca->rules(), $this->marca->feedback());

            if (!$request->hasFile('imagem')) {
                return response()->json([
                    'message' => 'Erro ao criar marca',
                    'errors' => ['imagem' => ['A imagem é obrigatória']]
                ], 422);
            }

            $imagem = $request->file('imagem');
            $imagem_urn = $imagem->store('imagens', 'public');

            $marca = $this->marca->create([
                'nome' => $request->nome,
                'imagem' => $imagem_urn
            ]);

            return response()->json($marca, 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao criar marca',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $marca = $this->marca->with('modelos')->find($id);
        if($marca === null) {
            return response()->json([
                'message' => 'Marca não encontrada',
                'error' => 'A marca solicitada não existe ou foi removida'
            ], 404);
        }

        return response()->json($marca, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Marca  $marca
     * @return \Illuminate\Http\Response
     */
    public function edit(Marca $marca)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $marca = $this->marca->find($id);

            if($marca === null) {
                return response()->json([
                    'message' => 'Marca não encontrada',
                    'error' => 'Não foi possível atualizar. A marca não existe'
                ], 404);
            }

            if($request->method() === 'PATCH') {
                $regrasDinamicas = array();
                $feedbackDinamico = array();

                foreach($marca->rules() as $input => $regra) {
                    if(array_key_exists($input, $request->all())) {
                        $regrasDinamicas[$input] = $regra;
                    }
                }

                foreach($marca->feedback() as $input => $mensagem) {
                    if(array_key_exists(explode('.', $input)[0], $request->all())) {
                        $feedbackDinamico[$input] = $mensagem;
                    }
                }

                $request->validate($regrasDinamicas, $feedbackDinamico);
            } else {
                $request->validate($marca->rules(), $marca->feedback());
            }

            $marca->fill($request->all());

            if($request->file('imagem')) {
                Storage::disk('public')->delete($marca->imagem);
                $imagem = $request->file('imagem');
                $imagem_urn = $imagem->store('imagens', 'public');
                $marca->imagem = $imagem_urn;
            }

            $marca->save();
            return response()->json($marca, 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao atualizar marca',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $marca = $this->marca->find($id);

            if($marca === null) {
                return response()->json([
                    'message' => 'Marca não encontrada',
                    'error' => 'Não foi possível excluir. A marca não existe'
                ], 404);
            }

            $modelosCount = $marca->modelos()->count();
            if($modelosCount > 0) {
                return response()->json([
                    'message' => 'Não é possível excluir esta marca',
                    'error' => "Existem {$modelosCount} modelo(s) vinculado(s) a esta marca. Remova ou reatribua os modelos antes de excluir a marca."
                ], 400);
            }

            Storage::disk('public')->delete($marca->imagem);
            $marca->delete();

            return response()->json([
                'message' => 'Marca excluída com sucesso'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao excluir marca',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
