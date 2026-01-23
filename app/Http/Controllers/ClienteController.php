<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use App\Repositories\ClienteRepository;

class ClienteController extends Controller
{
    public function __construct(Cliente $cliente) {
        $this->cliente = $cliente;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $clienteRepository = new ClienteRepository($this->cliente);

        if($request->has('filtro')) {
            $clienteRepository->filtro($request->filtro);
        }

        if($request->has('atributos')) {
            $clienteRepository->selectAtributos($request->atributos);
        }

        return response()->json($clienteRepository->getResultadoPaginado(10), 200);
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
            $request->validate($this->cliente->rules());

            $cliente = $this->cliente->create([
                'nome' => $request->nome,
                'email' => $request->email,
                'cpf' => $request->cpf,
                'telefone' => $request->telefone,
                'endereco' => $request->endereco
            ]);

            return response()->json($cliente, 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao criar cliente',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cliente = $this->cliente->find($id);
        if($cliente === null) {
            return response()->json([
                'message' => 'Cliente não encontrado',
                'error' => 'O cliente solicitado não existe ou foi removido'
            ], 404);
        }

        return response()->json($cliente, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $cliente = $this->cliente->find($id);

            if($cliente === null) {
                return response()->json([
                    'message' => 'Cliente não encontrado',
                    'error' => 'Não foi possível atualizar. O cliente não existe'
                ], 404);
            }

            if($request->method() === 'PATCH') {
                $regrasDinamicas = array();

                foreach($cliente->rules() as $input => $regra) {
                    if(array_key_exists($input, $request->all())) {
                        $regrasDinamicas[$input] = $regra;
                    }
                }

                $request->validate($regrasDinamicas);
            } else {
                $request->validate($cliente->rules());
            }

            $cliente->fill($request->all());
            $cliente->save();

            return response()->json($cliente, 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao atualizar cliente',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $cliente = $this->cliente->find($id);

            if($cliente === null) {
                return response()->json([
                    'message' => 'Cliente não encontrado',
                    'error' => 'Não foi possível excluir. O cliente não existe'
                ], 404);
            }

            $locacoesCount = $cliente->locacoes()->count();
            if($locacoesCount > 0) {
                return response()->json([
                    'message' => 'Não é possível excluir este cliente',
                    'error' => "Existem {$locacoesCount} locação(ões) vinculada(s) a este cliente. Remova as locações antes de excluir o cliente."
                ], 400);
            }

            $cliente->delete();

            return response()->json([
                'message' => 'Cliente excluído com sucesso'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao excluir cliente',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
