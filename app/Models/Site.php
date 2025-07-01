<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    use HasFactory;

    protected $fillable = [
        'url',
        'name',
        'author',
        'description',
        'keywords',
        'endereco',
        'telefone',
        'locale',
        'root',
        'whatsapp',
        'logo',
        'favicon',
        'appletouchicon',
        'email',
        'areacliente',
        'googlesiteverification',
        'googlemaps',
        'keywords',
    ];
}
