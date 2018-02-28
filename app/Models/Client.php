<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $table = 'cliente';
    public $timestamps = false;

    public function father() {
        return $this->hasOne('App\Models\Usuario', 'id', 'users_id_padre');
    }
    public function child() {
        return $this->hasOne('App\Models\Child', 'id', 'id_hijo');
    }
}
