<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Breadcrumbs extends Model
{
    use HasFactory;

    protected $fillable = [
        'page',
        'title',
        'bannerimg',
        'bannertitle',
        'bannerbody',
        'breadcrumbs'
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
