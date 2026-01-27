<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LocacaoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  mixed  $request
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'cliente_id' => $this->cliente_id,
            'carro_id' => $this->carro_id,
            'data_inicio_periodo' => $this->data_inicio_periodo?->toISOString(),
            'data_final_previsto_periodo' => $this->data_final_previsto_periodo?->toISOString(),
            'data_final_realizado_periodo' => $this->data_final_realizado_periodo?->toISOString(),
            'valor_diaria' => $this->valor_diaria,
            'valor_total' => $this->valor_total,
            'km_inicial' => $this->km_inicial,
            'km_final' => $this->km_final,
            'km_rodados' => $this->km_rodados,
            'atrasada' => $this->atrasada,
            'cliente' => new ClienteResource($this->whenLoaded('cliente')),
            'carro' => new CarroResource($this->whenLoaded('carro')),
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}
