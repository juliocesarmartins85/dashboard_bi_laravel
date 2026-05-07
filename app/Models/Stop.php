<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Stop extends Model
{
    use HasFactory;

    /**
     * Atributos que podem ser preenchidos em massa.
     * Ajustados para refletir a logística de transporte de São Lourenço.
     */
    protected $fillable = [
        'linha',       // Ex: Linha 01, Linha 04
        'itinerario',  // Ex: JOÃO DE DEUS - SANTA MÔNICA
        'localizacao', // Ex: Rua José Simeão Dutra n 990[cite: 1]
        'status',      // Ex: Executado, Falta executar, Remanejar[cite: 1]
        'latitude',    // Coordenada decimal
        'longitude',   // Coordenada decimal
        'vehicle_id',   // Relacionamento com veículo (opcional)
        'route_id',     // Relacionamento com rota (opcional)
    ];

    /**
     * Relação com os horários de parada (StopTimes).
     */
    public function stopTimes()
    {
        return $this->hasMany(StopTimes::class);
    }

    /**
     * Obtém o veículo que é dono desta parada.
     */
    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }
}
