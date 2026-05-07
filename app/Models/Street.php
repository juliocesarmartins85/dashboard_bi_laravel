<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Street extends Model
{
    /** @use HasFactory<\Database\Factories\StreetFactory> */
    use HasFactory;

    // Adicionado latitude e longitude ao fillable
    protected $fillable = [
        'name',
        'neighborhood_id',
        'latitude',
        'longitude'
    ];

    /**
     * Relacionamento com o Bairro
     */
    public function neighborhood(): BelongsTo
    {
        return $this->belongsTo(Neighborhood::class);
    }

    /**
     * Relacionamento com as Linhas (Rotas)
     * Muitas ruas pertencem a muitas rotas (tabela pivô: route_street)
     */
    public function routes(): BelongsToMany
    {
        return $this->belongsToMany(Route::class, 'route_street');
    }

    /**
     * Acessório para formatar as coordenadas para o mapa (Opcional, mas útil)
     */
    public function getCoordinatesAttribute(): string
    {
        return "{$this->latitude}, {$this->longitude}";
    }
}
