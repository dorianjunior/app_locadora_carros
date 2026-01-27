<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ModeloResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'marca_id' => $this->marca_id,
            'nome' => $this->nome,
            'imagem' => $this->imagem,
            'imagem_url' => $this->imagem_url,
            'numero_portas' => $this->numero_portas,
            'lugares' => $this->lugares,
            'air_bag' => $this->air_bag,
            'abs' => $this->abs,
            'marca' => new MarcaResource($this->whenLoaded('marca')),
            'carros' => CarroResource::collection($this->whenLoaded('carros')),
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}
