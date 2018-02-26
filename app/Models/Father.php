<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Father extends Model
{
    protected $table = 'padre';
    public $timestamps = false;
    
    public function user() {
        return $this->hasOne('App\Models\Usuario', 'id', 'users_id');
    }
}
