<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeviceHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_user',
        'mac_address',
        'host_name',
        'ip_adress',
        'server',
        'hotspot'
    ];
}
