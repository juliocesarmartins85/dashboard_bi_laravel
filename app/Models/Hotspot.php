<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotspot extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'host',
        'user',
        'pass',
        'port',
        'id_hotspot',
        'token'
    ];
}
