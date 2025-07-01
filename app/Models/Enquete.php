<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enquete extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'status',
        'interval',
        'dtinicio',
        'dtfinal',
        'questions',
        'video',
        'nivel',
        'routers'
    ];

    public function respostas()
    {
        return $this->belongsToMany(Respostas::class, 'enquete_respostas');
    }

    public function perguntas()
    {
        return $this->belongsToMany(Respostas::class, 'enquete_perguntas');
    }
}
