<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Web extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'url',
        'emp',
        'name',
        'desc',
        'endereco',
        'telefonefixo',
        'telefone0800',
        'telefone',
        'locale',
        'root',
        'whatsappnum',
        'whatsapp',
        'favicon',
        'logo',
        'email',
        'quem_somos',
        'form_contact',
        'areacliente',
        'asset_web'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [];
}
