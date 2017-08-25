<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Navigation extends Model
{
    public function pos()
    {
        return $this->belongsTo('App\NavigationPositions', 'id', 'position_id');
    }

    public function child()
    {
        return $this->hasMany('App\Navigation', 'parent_id', 'id');
    }
}
