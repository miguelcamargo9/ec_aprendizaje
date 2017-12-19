<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $table = 'cliente';
    public $timestamps = false;

    public function Father() {
        return $this->belongsTo('Father', 'id_padre', 'Id');
    }
    public function Child() {
        return $this->belongsTo('Child', 'id_hijo', 'Id');
    }
}
