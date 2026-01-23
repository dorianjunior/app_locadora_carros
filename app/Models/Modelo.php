<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modelo extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'marca_id',
        'nome',
        'imagem',
        'numero_portas',
        'lugares',
        'air_bag',
        'abs'
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
        'marca_id' => 'integer',
        'numero_portas' => 'integer',
        'lugares' => 'integer',
        'air_bag' => 'boolean',
        'abs' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relacionamento: Um modelo pertence a uma marca
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function marca()
    {
        return $this->belongsTo(Marca::class);
    }

    /**
     * Relacionamento: Um modelo possui muitos carros
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function carros()
    {
        return $this->hasMany(Carro::class);
    }

    /**
     * Accessor: URL completa da imagem
     *
     * @return string|null
     */
    public function getImagemUrlAttribute()
    {
        return $this->imagem ? asset('storage/' . $this->imagem) : null;
    }
}
