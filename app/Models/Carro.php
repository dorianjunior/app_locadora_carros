<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carro extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'modelo_id',
        'placa',
        'disponivel',
        'km'
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
        'modelo_id' => 'integer',
        'disponivel' => 'boolean',
        'km' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relacionamento: Um carro pertence a um modelo
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function modelo()
    {
        return $this->belongsTo(Modelo::class);
    }

    /**
     * Relacionamento: Um carro possui muitas locações
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function locacoes()
    {
        return $this->hasMany(Locacao::class);
    }

    /**
     * Scope: Carros disponíveis
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeDisponiveis($query)
    {
        return $query->where('disponivel', true);
    }

    /**
     * Scope: Carros indisponíveis
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeIndisponiveis($query)
    {
        return $query->where('disponivel', false);
    }
}
