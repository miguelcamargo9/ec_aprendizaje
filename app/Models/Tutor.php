<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tutor extends Model {

    protected $table = 'tutor';
    public $timestamps = false;
    
    public function user() {
        return $this->hasOne('App\Models\Usuario', 'id', 'users_id');
    }
    public function university() {
        return $this->hasOne('App\Models\Universities', 'id', 'universidad_id');
    }
    public function degree() {
        return $this->hasOne('App\Models\Degrees', 'id', 'carrera_id');
    }
    public function bank() {
        return $this->hasOne('App\Models\Banks', 'id', 'banco_id');
    }

}
