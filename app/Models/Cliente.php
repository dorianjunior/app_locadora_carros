<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'nome',
        'email',
        'cpf',
        'telefone',
        'endereco'
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
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relacionamento: Um cliente possui muitas locações
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function locacoes()
    {
        return $this->hasMany(Locacao::class);
    }

    /**
     * Accessor: CPF formatado
     *
     * @return string|null
     */
    public function getCpfFormatadoAttribute()
    {
        if (!$this->cpf) return null;

        return preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '$1.$2.$3-$4', $this->cpf);
    }
}
