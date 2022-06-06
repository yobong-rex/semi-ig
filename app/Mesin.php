<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mesin extends Model
{
    public $timestamps = false;

    public function komponens(){
        return $this->hasMany('App\Komponen', 'mesin_idmesin');
    }

    public function kapasitas(){
        return $this->hasMany('App\Kapasitas', 'mesin_idmesin');
    }

    public function teams(){
        return $this->belongsToMany('App\Mesin', 'mesin_has_teams', 'mesin_idmesin', 'teams_idteam');
    }
}
