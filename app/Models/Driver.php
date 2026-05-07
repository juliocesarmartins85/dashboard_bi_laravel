<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    /** @use HasFactory<\Database\Factories\DriverFactory> */
    use HasFactory;

    protected $fillable = ['name', 'license_number', 'phone', 'is_active'];

    public function trips()
    {
        return $this->hasMany(Trip::class);
    }
}
