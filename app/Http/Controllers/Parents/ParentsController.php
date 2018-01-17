<?php

namespace App\Http\Controllers\Parents;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ParentsController extends Controller {
  
 
  
 
  /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
   */

  public function showListTickets() {
    return view('ParentsController.list');
  }

  public function showNewTicket() {
    return view('ParentsController.new');
  }

  public function getTicketsByParent(Request $request) {

   // $data = Session::get("user");
    $data = $request->session()->get('user');
    echo $data->id;
    //$result = Ticket::with('tutor', 'state', 'client')->get();
//
//    foreach ($result as $value) {
//      //$value->id_cliente = empty($value->id_cliente) ? "N/A" : $value->id_cliente;
//      //$value->id_tutor = empty($value->id_tutor) ? "N/A" : $value->id_tutor;
//      $value->descripcion = $this->convertUtf8($value->descripcion);
//      foreach ($value->tutor as $tutor) {
//        $value->id_tutor = $tutor->nombre . " " . $tutor->apellido;
//      }
//      foreach ($value->client as $client) {
//        $value->id_cliente = $client->child->nombre . " " . $client->child->apellido;
//      }
//      $value->id_estado = $this->getState(2);
//    }

//    return $result;
    return "Hola andres";
  }

}
