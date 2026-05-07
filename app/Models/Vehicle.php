<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vehicle extends Model
{
    /** @use HasFactory<\Database\Factories\VehicleFactory> */
    use HasFactory;

    protected $fillable = [
        'plate',
        'idMoovsec',
        'dataMoovsec',
        'device_serial',
        'status',
        'model',
        'capacity',
        'has_accessibility',
        'route_id'
    ];

    // O segredo está aqui:
    protected $casts = [
        'dataMoovsec' => 'array',
    ];

    public function trips()
    {
        return $this->hasMany(Trip::class);
    }

    /**
     * Obtém todas as paradas associadas a este veículo.
     */
    public function stops(): HasMany
    {
        // O Laravel assume automaticamente que a chave estrangeira 
        // na tabela 'stops' é 'vehicle_id'
        return $this->hasMany(Stop::class);
    }
}
