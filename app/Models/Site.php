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
        'telegram_bot',
        'telegram_group',
        'googlemaps',
        'keywords',
    ];
}
