<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Ads extends Model
{


    protected $table = 'google_ads';
    protected $primaryKey = 'id';

    public $timestamps = false;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */


    protected $fillable = [
        'page_name', 'ads_code', 'created_timestamp', 'updated_timestamp',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    ];


}
