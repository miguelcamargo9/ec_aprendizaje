<?php

namespace App\Http\Controllers\InsertInfo;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Usuario;
use App\Models\Father;
use App\Models\Child;
use App\Models\InfoClientes;
use DateTime;

class InsertInfoController extends Controller {

  public function insertClients() {
    $infoclientes = InfoClientes::select('nombrepadre', 'apellidopadre', 'cedula', 'email')
            ->groupBy('nombrepadre', 'apellidopadre', 'cedula', 'email')
            ->get();   

    foreach ($infoclientes as $client) {
      $id_user = $this->insertUser($client->nombrepadre, $client->apellidopadre, $client->cedula, $client->email);
      $this->insertFather($id_user);

      $infohijos = InfoClientes::where('cedula', $client->cedula)->get();

      foreach ($infohijos as $child) {
        $cumpleanos = new DateTime($child->fechanacimeinto);
        $hoy = new DateTime();
        $annos = $hoy->diff($cumpleanos);
        $id_child = $this->insertChild($child->hijo, $child->colegio, $child->calendario, $child->curso, $child->fechanacimeinto, $annos->y, $id_user);
        $this->insertClient($id_user, $id_child);
      }
    }
  }

  public function insertUser($name, $lastname, $identification_number, $email) {
    $nameex = (strstr($name, " ")) ? explode(" ", $name)[0] : $name;
    $lastnameex = (strstr($lastname, " ")) ? explode(" ", $lastname)[0] : $lastname;
    $password = strtoupper(substr($nameex, 0, 1)) . strtolower($lastnameex);
    $newuser = new Usuario;
    $newuser->name = "$name $lastname";
    $newuser->identification_number = $identification_number;
    $newuser->email = "$email";
    $newuser->password = bcrypt($password);
    $newuser->created_at = date("Y-m-d H:i:s");
    $newuser->updated_at = date("Y-m-d H:i:s");
    $newuser->profiles_id = 2;

    $newuser->save();
    return $newuser->id;
  }

  public function insertFather($id, $second = "N") {
    $newfather = new Father;
    $newfather->users_id = $id;
    $newfather->segundo_padre = $second;

    $newfather->save();
  }

  public function insertChild($name, $school, $calendar, $course, $burndate, $age, $id_user) {
    $newchild = new Child;
    $newchild->nombre = $name;
    $newchild->colegio = $school;
    $newchild->calendario = $calendar;
    $newchild->curso = $course;
    $newchild->fecha_nacimiento = $burndate;
    $newchild->edad = $age;
    $newchild->id_user_primer_responsable = $id_user;

    $newchild->save();
    return $newchild->id;
  }

  public function insertClient($id_father, $id_child) {
    $newclient = new Client;
    $newclient->users_id_padre = $id_father;
    $newclient->id_hijo = $id_child;

    $newclient->save();
  }

}
