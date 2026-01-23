<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use App\Models\Modelo;
use Illuminate\Http\Request;
use App\Repositories\ModeloRepository;

class ModeloController extends Controller
{
    public function __construct(Modelo $modelo) {
        $this->modelo = $modelo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $modeloRepository = new ModeloRepository($this->modelo);

        if($request->has('atributos_marca')) {
            $atributos_marca = 'marca:id,'.$request->atributos_marca;
            $modeloRepository->selectAtributosRegistrosRelacionados($atributos_marca);
        } else {
            $modeloRepository->selectAtributosRegistrosRelacionados('marca');
        }

        if($request->has('filtro')) {
            $modeloRepository->filtro($request->filtro);
        }

        if($request->has('atributos')) {
            $modeloRepository->selectAtributos($request->atributos);
        }

        return response()->json($modeloRepository->getResultadoPaginado(10), 200);
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
            $request->validate($this->modelo->rules(), $this->modelo->feedback());

            if (!$request->hasFile('imagem')) {
                return response()->json([
                    'message' => 'Erro ao criar modelo',
                    'errors' => ['imagem' => ['A imagem é obrigatória']]
                ], 422);
            }

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

            return response()->json($modelo, 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao criar modelo',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Modelo  $modelo
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $modelo = $this->modelo->with('marca')->find($id);
        if($modelo === null) {
            return response()->json([
                'message' => 'Modelo não encontrado',
                'error' => 'O modelo solicitado não existe ou foi removido'
            ], 404);
        }

        return response()->json($modelo, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Modelo  $modelo
     * @return \Illuminate\Http\Response
     */
    public function edit(Modelo $modelo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Modelo  $modelo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $modelo = $this->modelo->find($id);

            if($modelo === null) {
                return response()->json([
                    'message' => 'Modelo não encontrado',
                    'error' => 'Não foi possível atualizar. O modelo não existe'
                ], 404);
            }

            if($request->method() === 'PATCH') {
                $regrasDinamicas = array();
                $feedbackDinamico = array();

                foreach($modelo->rules() as $input => $regra) {
                    if(array_key_exists($input, $request->all())) {
                        $regrasDinamicas[$input] = $regra;
                    }
                }

                foreach($modelo->feedback() as $input => $mensagem) {
                    if(array_key_exists(explode('.', $input)[0], $request->all())) {
                        $feedbackDinamico[$input] = $mensagem;
                    }
                }

                $request->validate($regrasDinamicas, $feedbackDinamico);
            } else {
                $request->validate($modelo->rules(), $modelo->feedback());
            }

            // Atualiza a imagem apenas se uma nova foi enviada
            if($request->file('imagem')) {
                Storage::disk('public')->delete($modelo->imagem);
                $imagem = $request->file('imagem');
                $imagem_urn = $imagem->store('imagens/modelos', 'public');
                $modelo->imagem = $imagem_urn;
            }

            $modelo->fill($request->all());
            $modelo->save();

            return response()->json($modelo, 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao atualizar modelo',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Modelo  $modelo
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $modelo = $this->modelo->find($id);

            if($modelo === null) {
                return response()->json([
                    'message' => 'Modelo não encontrado',
                    'error' => 'Não foi possível excluir. O modelo não existe'
                ], 404);
            }

            // Verifica se existem carros associados a este modelo
            $carrosCount = $modelo->carros()->count();
            if($carrosCount > 0) {
                return response()->json([
                    'message' => 'Não é possível excluir este modelo',
                    'error' => "Existem {$carrosCount} carro(s) vinculado(s) a este modelo. Remova ou reatribua os carros antes de excluir o modelo."
                ], 400);
            }

            Storage::disk('public')->delete($modelo->imagem);
            $modelo->delete();

            return response()->json([
                'message' => 'Modelo excluído com sucesso'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao excluir modelo',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
