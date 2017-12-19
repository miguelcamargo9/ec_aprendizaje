<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $table = 'caso';
    public $timestamps = false;

    public function Client() {
        return $this->belongsTo('Client', 'id_cliente', 'id');
    }
    public function Tutor() {
        return $this->belongsTo('Tutor', 'id_tutor', 'id');
    }
    public function State() {
        return $this->belongsTo('State', 'id_estado', 'id');
    }
}
