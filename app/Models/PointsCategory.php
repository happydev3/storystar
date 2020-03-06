<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PointsCategory extends Model
{
    protected $table = 'points_category';
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'points',
        'is_active'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    public static function dropdown()
    {
        $categories = self::where(['is_displayed' => 1])->get()->toArray();
        $return = [];
        foreach ($categories as $c) {
            $return[$c['name']] = $c['description'];
        }
        return $return;
    }
}
