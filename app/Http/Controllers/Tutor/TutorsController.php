<?php

namespace App\Http\Controllers\Tutor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Child;
use App\Models\Usuario;
use App\Models\Tutor;
use App\Models\Ticket;
use App\Models\TicketTutores;
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
    $result = Ticket::with('state', 'client')->where('id_estado', '1')->get();

    foreach ($result as $value) {
      $value->descripcion = $this->convertUtf8($value->descripcion);
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
    $myTickets = TicketTutores::where('users_id_tutor', $idtutor['id'])->get();

    $result = Array();
    
    foreach ($myTickets as $myTicket) {
      $ticket = Ticket::with('state', 'client')->find($myTicket->caso_id);
      $result[] = $ticket;
    }

    foreach ($result as $value) {
      $value->descripcion = $this->convertUtf8($value->descripcion);
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

  public function getInfoTickets($idTicket, $documentos = false) {
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
    $infoTicket->documentos = ($documentos) ? "ok" : "false";
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

  public function addCommentary(Request $params) {
//        $comentario = trim($request->input('comentario'));
//        $fechaComentario = date("Y-m-d H:i:s");
//        $idCaso = $request->input('id');
    $documento = $params->file('documentos');
    $mensaje = Input::get('msg');
    $registros = Input::get('registros');
    $registros = json_decode($registros,true);
      //NOMBRES
      $nombre = $documento->getClientOriginalName();
      ///RUTA DONDE VOY A GUARDAR LOS DOCUMENTOS
      //$documento->move("$idTutor/$anio/$mes/$idTicket", "$nombre");
    
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
      Ticket::where('ID', '=', $idCaso)->update(array('id_estado' => 6));
      $idRegistro = $datosRegistro->id;
      //GUARDO EL DOCUMENTO QUE ADJUNTO EL TUTOR
      $documento->move("$idCaso/$idRegistro", "$nombre");
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
  }

  //CONSULTO LA SEMANA ACTUAL PARA SABER QUE FECHAS TIENE AUTORIZADAS EL TUTOR PARA REGUSTRAR
  //TAMBIEN CONSULTO SI EL TUTOR TIENE PERMISOS PARA HACER REGISTROS DE SEMANAS ANTERIORES
  public function dateRegistry() {
    ///BUSCO SI EL TUTOR TIENE PERMISOS PARA REGISTRAR SEMAMAS ANTERIORES
    $idtutor = Session::get('user');
    $permiso = Tutor::where('users_id', $idtutor['id'])->get(['permiso_registro']);
    $perm = ($permiso[0]['permiso_registro']);
    $hoy = date("Y-m-d");
    //$hoy=date("2018-04-18");

    $diaInicio = date('N', strtotime($hoy));
    $diaFin = 7 - $diaInicio;
    $diaInicio = $diaInicio - 1;
    $nuevoDiaIni = strtotime($hoy . "- $diaInicio days");
    $nuevoDiaFin = strtotime($hoy . "+ $diaFin days");

    $fechaIni = date("Y/m/d", $nuevoDiaIni);
    $fechaFin = date("Y/m/d", $nuevoDiaFin);

    $respuesta = array("fechaIni" => $fechaIni, "fechaFin" => $fechaFin, "permiso" => "$perm");
    return json_encode($respuesta);
  }

  public function guardarDocumentos(Request $params) {
    //GUARDAR LOS DOCUMENTOS QUE ADJUNTE EL TUTOR
    $tutorSession = Session::get('user');
    $idTutor = $tutorSession['id'];
    $documentos = $params->file('documentos');
    $mes = $params->input("mes_documento");
    $anio = $params->input("anio_documento");
    $idTicket = $params->input("idCaso");
    foreach ($documentos as $documento) {
      //NOMBRES
      $nombre = $documento->getClientOriginalName();
      ///RUTA DONDE VOY A GUARDAR LOS DOCUMENTOS
      $documento->move("$idTutor/$anio/$mes/$idTicket", "$nombre");
    }
    return $this->getInfoTickets($idTicket, true);
  }

  public function convertUtf8($value) {
    return mb_detect_encoding($value, mb_detect_order(), true) === 'UTF-8' ? $value : mb_convert_encoding($value, 'UTF-8');
  }

}
