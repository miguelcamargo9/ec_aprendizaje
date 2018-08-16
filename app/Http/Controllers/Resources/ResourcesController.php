<?php

namespace App\Http\Controllers\Resources;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Usuario;
use App\Models\Universities;
use App\Models\Degrees;
use App\Models\Banks;
use Illuminate\Support\Facades\Input;

class ResourcesController extends Controller {

  public function getClients() {
    return Client::with("father")->with("child")->get();
  }

  public function getTutors() {
    return Usuario::where("profiles_id", "=", 3)->get();
  }

  public function getTutorById() {
    $idTutor = Input::get('idTutor');
    return Usuario::find($idTutor);
  }

  public function getUniversities() {
    return Universities::all();
  }

  public function getDegrees() {
    return Degrees::all();
  }

  public function getBanks() {
    return Banks::all();
  }

}
