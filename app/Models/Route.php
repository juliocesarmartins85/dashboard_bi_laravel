<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    /** @use HasFactory<\Database\Factories\RouteFactory> */
    use HasFactory;

    protected $fillable = ['short_name', 'long_name', 'type', 'color'];

    public function streets()
    {
        return $this->belongsToMany(Street::class, 'route_street')->withPivot('order');
    }

    public function trips()
    {
        return $this->hasMany(Trip::class);
    }
}
