<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perguntas extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'question',
        'type',
        'status',
        'options',
        'interval',
        'dtinicio',
        'dtfinal',
        'nivel',
    ];

    public function respostas()
    {
        return $this->belongsToMany(Respostas::class, 'pergunta_respostas');
    }
    public function enquetes()
    {
        return $this->belongsToMany(Enquete::class, 'enquete_perguntas');
    }
}
