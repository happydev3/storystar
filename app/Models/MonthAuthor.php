<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MonthAuthor extends Model
{

    use SoftDeletes;

    protected $table = 'month_author';
    protected $primaryKey = 'id';

    public $timestamps = false;
    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */


    protected $fillable = [
        'user_id', 'month', 'created_timestamp', 'updated_timestamp',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    ];


    /**
     * A Month of author is a user
     *
     * @var array
     */

    public function user()
    {
        return $this->belongsTo('App\Models\SiteUser', 'user_id');
    }


}
