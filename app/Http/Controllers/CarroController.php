<?php

namespace App\Http\Controllers;

use App\Models\Carro;
use Illuminate\Http\Request;
use App\Repositories\CarroRepository;

class CarroController extends Controller
{
    public function __construct(Carro $carro) {
        $this->carro = $carro;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $carroRepository = new CarroRepository($this->carro);

        if($request->has('atributos_modelo')) {
            $atributos_modelo = 'modelo:id,'.$request->atributos_modelo;
            $carroRepository->selectAtributosRegistrosRelacionados($atributos_modelo);
        } else {
            $carroRepository->selectAtributosRegistrosRelacionados('modelo');
        }

        if($request->has('filtro')) {
            $carroRepository->filtro($request->filtro);
        }

        if($request->has('atributos')) {
            $carroRepository->selectAtributos($request->atributos);
        }

        return response()->json($carroRepository->getResultadoPaginado(10), 200);
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
            $request->validate($this->carro->rules());

            $carro = $this->carro->create([
                'modelo_id' => $request->modelo_id,
                'placa' => $request->placa,
                'disponivel' => $request->disponivel,
                'km' => $request->km
            ]);

            return response()->json($carro, 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao criar carro',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Carro  $carro
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $carro = $this->carro->with('modelo')->find($id);
        if($carro === null) {
            return response()->json([
                'message' => 'Carro não encontrado',
                'error' => 'O carro solicitado não existe ou foi removido'
            ], 404);
        }

        return response()->json($carro, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Carro  $carro
     * @return \Illuminate\Http\Response
     */
    public function edit(Carro $carro)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Carro  $carro
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $carro = $this->carro->find($id);

            if($carro === null) {
                return response()->json([
                    'message' => 'Carro não encontrado',
                    'error' => 'Não foi possível atualizar. O carro não existe'
                ], 404);
            }

            if($request->method() === 'PATCH') {
                $regrasDinamicas = array();

                foreach($carro->rules() as $input => $regra) {
                    if(array_key_exists($input, $request->all())) {
                        $regrasDinamicas[$input] = $regra;
                    }
                }

                $request->validate($regrasDinamicas);
            } else {
                $request->validate($carro->rules());
            }

            $carro->fill($request->all());
            $carro->save();

            return response()->json($carro, 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao atualizar carro',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Carro  $carro
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $carro = $this->carro->find($id);

            if($carro === null) {
                return response()->json([
                    'message' => 'Carro não encontrado',
                    'error' => 'Não foi possível excluir. O carro não existe'
                ], 404);
            }

            $locacoesCount = $carro->locacoes()->count();
            if($locacoesCount > 0) {
                return response()->json([
                    'message' => 'Não é possível excluir este carro',
                    'error' => "Existem {$locacoesCount} locação(ões) vinculada(s) a este carro. Remova as locações antes de excluir o carro."
                ], 400);
            }

            $carro->delete();

            return response()->json([
                'message' => 'Carro excluído com sucesso'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao excluir carro',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
