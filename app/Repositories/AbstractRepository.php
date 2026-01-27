<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

abstract class AbstractRepository
{
    protected Builder $query;

    public function __construct(protected Model $model)
    {
        $this->resetQuery();
    }

    public function selectAtributosRegistrosRelacionados(string|array $atributos): self
    {
        $this->query = $this->query->with($atributos);

        return $this;
    }

    public function filtro(string $filtros): self
    {
        $filtrosArray = explode(';', $filtros);

        foreach ($filtrosArray as $condicao) {
            $parametros = explode(':', $condicao);

            if (count($parametros) === 3) {
                [$campo, $operador, $valor] = $parametros;
                $this->query = $this->query->where($campo, $operador, $valor);
            }
        }

        return $this;
    }

    public function selectAtributos(string $atributos): self
    {
        $this->query = $this->query->selectRaw($atributos);

        return $this;
    }

    public function getResultado(): Collection
    {
        $resultado = $this->query->get();
        $this->resetQuery();

        return $resultado;
    }

    public function getResultadoPaginado(int $numeroRegistroPorPagina): LengthAwarePaginator
    {
        $resultado = $this->query->paginate($numeroRegistroPorPagina);
        $this->resetQuery();

        return $resultado;
    }

    protected function resetQuery(): void
    {
        $this->query = $this->model->newQuery();
    }
}
