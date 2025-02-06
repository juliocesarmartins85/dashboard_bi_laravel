<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfileUser extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'mac_address',
        'status',
        'organizacao',
        'telefone',
        'funcao',
        'funcaosis',
        'endereco',
        'bairro',
        'cidade',
        'desc',
        'facebook',
        'twitter',
        'instagram',
        'linkedin',
        'foto'
    ];
}
