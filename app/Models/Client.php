<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $table = 'cliente';
    public $timestamps = false;

    public function father() {
        return $this->belongsTo('App\Models\Usuario', 'users_id_padre', 'id');
    }
    public function child() {
        return $this->belongsTo('App\Models\Child', 'id_hijo', 'id');
    }
}
