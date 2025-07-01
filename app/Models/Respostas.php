<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Respostas extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'mac',
        'resposta',
        'id_enquete',
        'id_pergunta',
        'id_profile_usuario',
    ];

    public function perguntas()
    {
        return $this->belongsToMany(Perguntas::class, 'pergunta_respostas');
    }
    public function enquetes()
    {
        return $this->belongsToMany(Enquete::class, 'enquete_respostas');
    }
}
