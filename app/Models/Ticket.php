<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $table = 'caso';
    public $timestamps = false;

    public function client() {
        return $this->hasMany('App\Models\Client', 'id', 'id_cliente');
    }
    public function tutor() {
        return $this->hasMany('App\Models\Tutor', 'id', 'id_tutor');
    }
    public function state() {
        return $this->hasMany('App\Models\State', 'id', 'id_estado');
    }
}
