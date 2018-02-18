<?php

namespace App\Http\Controllers\Tutor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Child;
use App\Models\Usuario;
use App\Models\Ticket;
use App\Models\State;
use App\Models\registroTutor;
use App\Models\horasRegistro;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Input;

class TutorsController extends Controller {
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

  public function showListTutors() {
    return view('TutorsController.list');
  }

  public function showMyListTutors() {
    return view('TutorsController.mylist');
  }

  public function getAllTickets() {
    //$result = Ticket::with('tutor', 'state', 'client')->get();
    $result = Ticket::with('tutor', 'state', 'client')->where('id_estado', '1')->get();

    foreach ($result as $value) {
      $value->descripcion = $value->descripcion;
      if (count($value->tutor) > 0) {
        foreach ($value->tutor as $tutor) {
          $value->id_tutor = $tutor->name;
        }
      } else {
        $value->id_tutor = "No Asignado";
      }
      foreach ($value->client as $client) {
        $value->id_cliente = $client->child->nombre . " " . $client->child->apellido;
      }
      $value->id_estado = $this->getState($value->id_estado);
      $idTicket = $value->id;
      $ruta = "/tutor/tickets/ticketinfo/$idTicket";
      $boton = "<a href='$ruta'><i class='fa fa-eye' aria-hidden='true'></i></a>";
      $value->ver = $boton;
    }

    return $result;
  }

  public function getMyTickets() {
    $idtutor = Session::get('user');
    $result = Ticket::with('tutor', 'state', 'client')->where('users_id_tutor', $idtutor['id'])->get();

    foreach ($result as $value) {
      $value->descripcion = $value->descripcion;
      if (count($value->tutor) > 0) {
        foreach ($value->tutor as $tutor) {
          $value->id_tutor = $tutor->name;
        }
      } else {
        $value->id_tutor = "No Asignado";
      }
      foreach ($value->client as $client) {
        $value->id_cliente = $client->child->nombre . " " . $client->child->apellido;
      }
      $value->id_estado = $this->getState($value->id_estado);
      $idTicket = $value->id;
      $ruta = "/tutor/tickets/ticketinfo/$idTicket";
      $boton = "<a href='$ruta'><i class='fa fa-eye' aria-hidden='true'>Ojo</i></a>";
      $value->ver = $boton;
    }

    return $result;
  }

  public function getInfoTickets($idTicket) {
    $infoTicket = Ticket::find($idTicket);
    $registrosTutor = registroTutor::where('id_caso', '=', $idTicket)->get(); //BUSCO LOS REGISROS QUE HA HECHO EL TUTOR
    $horasRegistro = registroTutor::where('id_caso', '=', $idTicket)->sum('total_horas');
    $client = $this->getClient($infoTicket->id_cliente);
    $child = $this->getChild($client->id_hijo);
    $parent = $this->getParent($client->users_id_padre);
    $client_name = $child->nombre . " " . $child->apellido . " - (Padre) " . $parent->name;
    $infoTicket->client_name = $client_name;
    $infoTicket->registros = $registrosTutor;
    $infoTicket->horasRegisro = $horasRegistro;
    return view('TutorsController.info', $infoTicket->toArray());
  }

  public function getClient($id_cliente) {
    return Client::find($id_cliente);
  }

  public function getChild($id_child) {
    return Child::find($id_child);
  }

  public function getParent($id_parent) {
    return Usuario::find($id_parent);
  }

  public function getState($id) {
    $stateobj = State::where('id', '=', $id)->get();
    $state = "N/A";
    foreach ($stateobj as $item) {
      if ($item->estado) {
        $state = $item->estado;
      }
    }
    return $state;
  }

  /*
   * GUARDAR EL COMENTARIO DEL TUTOR
   */

  public function addCommentary() {
//        $comentario = trim($request->input('comentario'));
//        $fechaComentario = date("Y-m-d H:i:s");
//        $idCaso = $request->input('id');
    $registros = Input::get('registros');
    $mensaje = Input::get('msg');
    $totalHoras = Input::get('totalH');
    $idCaso = Input::get('idCaso');
    $fechaCreacion = date('Y-m-d H:i:s');

    $datosRegistro = new registroTutor();
    $datosRegistro->id_caso = $idCaso;
    $datosRegistro->total_horas = $totalHoras;
    $datosRegistro->resumen = $mensaje;
    $datosRegistro->fecha_creacion = $fechaCreacion;
  
    try {
      $datosRegistro->save();
      $idRegistro = $datosRegistro->id;
      //RECORRO TODOS LOS REGISTROS DE LAS HORAS
      foreach ($registros as $registro) {
        //HORA DE INICIO
        $hI = date_create($registro['hI']);
        $horaInicio = date_format($hI, 'H:i');
        //HORA FIN
        $hF = date_create($registro['hF']);
        $horaFin = date_format($hF, 'H:i');

        // FECHA DE REGISTRO
        $fechaR = date_create($registro['fecha']);
        $fechaRegistro = date_format($fechaR, 'Y-m-d');
        //GUARDO CADA REGISTRO DE HORAS
        $datosHoraRegistro = new horasRegistro();
        $datosHoraRegistro->registro_tutor_id = $idRegistro;
        $datosHoraRegistro->fecha = $fechaRegistro;
        $datosHoraRegistro->hora_inicio = $horaInicio;
        $datosHoraRegistro->hora_fin = $horaFin;
        $datosHoraRegistro->save();
      }
    } catch (Exception $ex) {
      return response()->json(array('error' => array('Error al guardar el registro')));
    }
    return response()->json(array('success' => true, 'msj' => 'Registro guardado'));



    // Ticket::where('id', '=', $idCaso)->update(array('descripcion' => $comentario, "fecha_comentario" => $fechaComentario,"id_estado" => 4));
  }

}
