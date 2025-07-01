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
}
