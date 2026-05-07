<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StopTimes extends Model
{
    /** @use HasFactory<\Database\Factories\StopTimeFactory> */
    use HasFactory;

    protected $fillable = ['trip_id', 'stop_id', 'arrival_time', 'stop_sequence'];

    public function trip()
    {
        return $this->belongsTo(Trip::class);
    }
    public function stop()
    {
        return $this->belongsTo(Stop::class);
    }
}
