<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SideBar extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'icon',
        'nvl',
        'url',
        'ativo',
        'ancent',
        'descent',
        'drop'
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
