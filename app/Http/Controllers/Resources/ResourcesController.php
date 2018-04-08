<?php

namespace App\Http\Controllers\Resources;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Usuario;
use App\Models\Universities;

class ResourcesController extends Controller {

    public function getClients() {
        return Client::with("father")->with("child")->get();
    }
    
    public function getTutors() {
        return Usuario::where("profiles_id", "=", 3)->get();
    }
    
    public function getUniversities() {
        return Universities::all();
    }

}
