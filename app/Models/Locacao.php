<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Locacao extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'locacoes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'cliente_id',
        'carro_id',
        'data_inicio_periodo',
        'data_final_previsto_periodo',
        'data_final_realizado_periodo',
        'valor_diaria',
        'km_inicial',
        'km_final'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<string>
     */
    protected $hidden = [];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected $casts = [
        'cliente_id' => 'integer',
        'carro_id' => 'integer',
        'data_inicio_periodo' => 'datetime',
        'data_final_previsto_periodo' => 'datetime',
        'data_final_realizado_periodo' => 'datetime',
        'valor_diaria' => 'decimal:2',
        'km_inicial' => 'integer',
        'km_final' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relacionamento: Uma locação pertence a um cliente
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    /**
     * Relacionamento: Uma locação pertence a um carro
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function carro()
    {
        return $this->belongsTo(Carro::class);
    }

    /**
     * Scope: Locações ativas (não finalizadas)
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAtivas($query)
    {
        return $query->whereNull('data_final_realizado_periodo');
    }

    /**
     * Scope: Locações finalizadas
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFinalizadas($query)
    {
        return $query->whereNotNull('data_final_realizado_periodo');
    }

    /**
     * Accessor: Calcula o valor total da locação
     *
     * @return float|null
     */
    public function getValorTotalAttribute()
    {
        if (!$this->data_inicio_periodo || !$this->data_final_previsto_periodo) {
            return null;
        }

        $dataFinal = $this->data_final_realizado_periodo ?? $this->data_final_previsto_periodo;
        $dias = $this->data_inicio_periodo->diffInDays($dataFinal) + 1;

        return $dias * $this->valor_diaria;
    }

    /**
     * Accessor: Calcula total de KM rodados
     *
     * @return int|null
     */
    public function getKmRodadosAttribute()
    {
        if (!$this->km_inicial || !$this->km_final) {
            return null;
        }

        return $this->km_final - $this->km_inicial;
    }

    /**
     * Accessor: Verifica se a locação está atrasada
     *
     * @return bool
     */
    public function getAtrasadaAttribute()
    {
        if ($this->data_final_realizado_periodo) {
            return false; // Já foi devolvido
        }

        return now()->isAfter($this->data_final_previsto_periodo);
    }
}
