<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class BlockedIpAddress extends Model
{
    use SoftDeletes;

    protected $table = 'blocked_ip_addresses';
    protected $primaryKey = 'id';

    protected $fillable = [
        'ip_address'
    ];

}
