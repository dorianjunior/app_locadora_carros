<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use App\Models\Modelo;
use App\Models\Carro;
use App\Models\Cliente;
use App\Models\Locacao;
use Illuminate\Http\JsonResponse;

class DashboardController extends Controller
{
    /**
     * Get dashboard statistics
     *
     * @return JsonResponse
     */
    public function stats(): JsonResponse
    {
        $stats = [
            'total_marcas' => Marca::count(),
            'total_modelos' => Modelo::count(),
            'total_carros' => Carro::count(),
            'total_clientes' => Cliente::count(),
            'locacoes_ativas' => Locacao::whereNull('data_final_realizado_periodo')->count(),
            'locacoes_finalizadas' => Locacao::whereNotNull('data_final_realizado_periodo')->count(),
            'total_locacoes' => Locacao::count(),
            'carros_disponiveis' => Carro::where('disponivel', true)->count(),
            'carros_em_uso' => Carro::where('disponivel', false)->count(),
        ];

        return response()->json([
            'success' => true,
            'message' => 'Estatísticas carregadas com sucesso',
            'data' => $stats,
        ]);
    }

    /**
     * Get recent rentals for dashboard
     *
     * @return JsonResponse
     */
    public function recentRentals(): JsonResponse
    {
        $recentRentals = Locacao::with(['cliente:id,nome', 'carro:id,placa,modelo_id', 'carro.modelo:id,nome'])
            ->latest()
            ->limit(5)
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Locações recentes carregadas com sucesso',
            'data' => $recentRentals,
        ]);
    }

    /**
     * Get active rentals summary
     *
     * @return JsonResponse
     */
    public function activeRentals(): JsonResponse
    {
        $activeRentals = Locacao::with(['cliente:id,nome', 'carro:id,placa,modelo_id', 'carro.modelo:id,nome'])
            ->whereNull('data_final_realizado_periodo')
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Locações ativas carregadas com sucesso',
            'data' => $activeRentals,
        ]);
    }
}
