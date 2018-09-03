<?php

namespace App\Http\Controllers\Tickets;

use App\Http\Controllers\Controller;
use App\Models\State;
use App\Models\Ticket;
use App\Models\TicketTutores;
use App\Models\Tutor;
use App\Models\Client;
use App\Models\Child;
use App\Models\Usuario;
use App\Models\registroTutor;
use App\Models\horasRegistro;
use App\Models\Bills;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

class TicketsController extends Controller {

  public function showListTickets() {
    return view('TicketsController.list', array('mensaje' => ''));
  }

  public function showNewTicket() {
    return view('TicketsController.new', array('mensaje' => ''));
  }

  public function createNewTicket() {
    $fechaIni = Input::get('initdate');
    $id_cliente = Input::get('cliente');

    $datosFactura = Input::get('datosFactura');
    $tutores = Input::get('tutors');

    $datosCaso = new Ticket();
    $datosCaso->id_estado = 1;
    $datosCaso->id_cliente = $id_cliente;
    $datosCaso->fecha_inicio = "$fechaIni";
    $datosCaso->fecha_creacion = Date("Y-m-d H:i:s");
    $datosCaso->users_id_creator = Session::get('user')->id;
    try {
      $datosCaso->save();
      $idCaso = $datosCaso->id;
      $nuevaFactura = new Bills();
      $nuevaFactura->caso_id = $idCaso;
      foreach ($datosFactura as $campoFac => $valor) {
        $nuevaFactura->$campoFac = $valor;
      }
      $nuevaFactura->save();
      foreach ($tutores as $tutor) {
        $ticketTutores = new TicketTutores();
        $ticketTutores->caso_id = $idCaso;
        $ticketTutores->users_id_tutor = $tutor['tutor']['id'];
        $ticketTutores->save();
      }
    } catch (Exception $ex) {
      return response()->json(array('error' => array('Error creando el proceso')));
    }
    return response()->json(array('success' => true, 'msj' => 'Proceso Creado con Exito'));
  }

  public function editInfoTicket() {
    $id = Input::get('id');
    $datosFactura = Input::get('datosFactura');
    $tutores = Input::get('tutors');

    try {
      TicketTutores::where('caso_id', '=', $id)->delete();

      $invoice = Bills::where('caso_id', '=', $id)->first();
      foreach ($datosFactura as $campoFac => $valor) {
        $invoice->$campoFac = $valor;
      }
      $invoice->save();

      foreach ($tutores as $tutor) {
        $ticketTutores = new TicketTutores();
        $ticketTutores->caso_id = $id;
        $ticketTutores->users_id_tutor = $tutor['tutor']['id'];
        $ticketTutores->save();
      }
    } catch (Exception $ex) {
      return response()->json(array('error' => array('Error editando el proceso')));
    }
    return response()->json(array('success' => true, 'msj' => 'Proceso Editado con Exito'));
  }

  public function editTicket() {
    //$comentario = Input::get('comentario');
    $fecha_ini = Input::get('fecha_ini');
    $fecha_fin = Input::get('fecha_fin');
    $id = Input::get('id');
    $cierre = Input::get('cierre');
    if (isset($cierre)) {
      //ENVIO DE CORREO


      $cabeceras = 'MIME-Version: 1.0' . "\r\n";
      $cabeceras .= 'Content-type: text/html; charset=utf-8' . "\r\n";
      $cabeceras .= 'From: Emocion Creativa <info@emocioncreativa.com>' . "\r\n";

      $titulo = "Caso verificado";

      $ticket = Ticket::where("caso.id", "=", $id)
                      ->leftJoin('cliente', 'caso.id_cliente', '=', 'cliente.id')
                      ->leftJoin('hijo', 'cliente.id_hijo', '=', 'hijo.id')
                      ->leftJoin('estado', 'caso.id_estado', '=', 'estado.id')
                      ->select('estado.estado as estado', 'hijo.nombre as hijoName', 'hijo.apellido as estudianteAp', 'cliente.users_id_padre as clientid')->first();

      $cliente = Usuario::find($ticket->clientid);
      $para = "andre0190@gmail.com";
//      $para = $cliente->email;

      $tutors = TicketTutores::where('caso_id', '=', $id)->get();
      $nombreturores = "";

      foreach ($tutors as $tutor) {
        $mistutor = Usuario::find($tutor->users_id_tutor);
        $nombreturores .= $mistutor->name . ", ";
      }

      $nombreturores = substr($nombreturores, 0, -2);
      $ticket->toArray();
      $estudiante = "{$ticket['hijoName']} {$ticket['estudianteAp']}";
      $tutor = $ticket['tutor'];
      $estado = $ticket['estado'];

      $mensaje = "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Strict//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd'>
              <html xmlns='http://www.w3.org/1999/xhtml' xml:lang='en'>
              <head>
                      <meta http-equiv='Content-Type' content='text/html;charset=UTF-8'>
                      <title>Caso verificado</title>
                      <meta name='viewport' content='width=device-width, initial-scale=1.0'/>
              </head>
              <body style='background-color: #f6f6f6'>
              <table width='700' border='0' align='center' cellpadding='0' cellspacing='0' style='font-family: Verdana, Geneva, sans-serif; text-align: center; background-color: white;'>
                 <tr>
                   <td colspan='4'>
                     el caso del estudiante:$estudiante con el tutro: $nombreturores ya se encuentra en el estado $estado
                   </td>
                 </tr>


                <tr>
                  <td height='60'></td>
                </tr>
                <tr style='background-color: #f7f7f7; color: #79797d;'>
                  <td colspan='4'><p style='font-size: 12px; margin: 30px;'>Copyright © 2018 Emoción creativa </p></td>
                </tr>
              </table>
              </body>
              </html>";

      mail($para, $titulo, $mensaje, $cabeceras);
    } else {
      Ticket::where('id', '=', $id)->update(array('descripcion' => $comentario, "fecha_inicio" => $fecha_ini));
    }
  }

  public function getAllTickets() {
    $result = Ticket::with('state', 'client')->get();

    foreach ($result as $value) {
      //$value->id_cliente = empty($value->id_cliente) ? "N/A" : $value->id_cliente;
      //$value->id_tutor = empty($value->id_tutor) ? "N/A" : $value->id_tutor;
      $value->descripcion = $this->convertUtf8($value->descripcion);
      foreach ($value->client as $client) {
        $value->id_cliente = $client->child->nombre . " " . $client->child->apellido;
      }
      $value->id_estado = $this->getState($value->id_estado);
      $idTicket = $value->id;
      $ruta = "/tickets/ticketinfo/$idTicket";
      $boton = "<a href='$ruta' alt='Ver Proceso {$idTicket}'>Ver <i class='fa fa-eye'></i></a>";
      $ruta = "/tickets/view/edit/$idTicket";
      $boton .= "<a href='$ruta' alt='Editar Proceso {$idTicket}'>Editar <i class='fa fa-edit'></i></a>";
      $value->ver = $boton;
    }

    return $result;
  }

  public function getCreatedTickets() {
    $result = Ticket::where('id_estado', '=', 1)->get();
    foreach ($result as $value) {
      $value->id_cliente = ($value->id_cliente != "") ? $value->id_cliente : "N/A";
      $value->id_tutor = ($value->id_tutor != "") ? $value->id_cliente : "N/A";
      $value->descripcion = $this->convertUtf8($value->descripcion);
    }

    return $result;
  }

  public function updateState(Request $request) {
    $asignados = $request->input('ids');
    $user = Session::get('user');
    $mensaje = "No se puede asignar caso al usuario " . $user['name'] . " porque no esta registrado como tutor!";
    if (preg_match_all('/=\d+/', $asignados, $matches)) {
      //var_export ($matches);
      foreach ($matches[0] as $id) {
        $id = substr($id, 1);
        if ($user['profiles_id'] == 3) {
          Ticket::where('ID', '=', $id)->update(array('users_id_tutor' => $user['id'], 'id_estado' => 2));
          $mensaje = "Caso(s) asignados con éxito al tutor " . $user['name'] . "!";
        }
      }
    }
    return $mensaje;
  }

  public function convertUtf8($value) {
    return mb_detect_encoding($value, mb_detect_order(), true) === 'UTF-8' ? $value : mb_convert_encoding($value, 'UTF-8');
  }

  public function getTutor($id) {
    $tutorobj = Tutor::where('id', '=', $id)->get();
    $tutorname = "N/A";
    foreach ($tutorobj as $item) {
      if ($item->nombre && $item->apellido) {
        $tutorname = $item->nombre . " " . $item->apellido;
      }
    }
    return $tutorname;
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
    return view('TicketsController.info', $infoTicket->toArray());
  }

  /*
   * DEVUELVO LA INFORMACION DE HORAS PARA CADA REGISTRO DEL TUTOR
   */

  public function getDetalleRegistros() {
    $idRegistro = Input::get('idRegistro');
    $idCaso = Input::get('idCaso');
    $horasRegistro = horasRegistro::where('registro_tutor_id', '=', $idRegistro)->get();
    //BUSCO LOS ARCHIVOS QUE HAYA CARGADO EL TUTOR PARA ESE REGISTRO
    $ruta = public_path("$idCaso/$idRegistro");
    $directorio = opendir($ruta); //ruta actual
    while ($archivo = readdir($directorio)) { //obtenemos un archivo y luego otro sucesivamente
      if (!is_dir($archivo)) {//verificamos si es o no un directorio
        $horasRegistro["nombreEnlace"] = $archivo;
        $horasRegistro["enlace"] = url("/$idCaso/$idRegistro/$archivo");
      }
    }
    return $horasRegistro->toJson();
  }

  /*
   * APROBAR LOS COMENTARIOS QUE DEJO EL TUTOR EN EL CASO
   */

  public function aprobarRegistro() {
    $resumen = Input::get('resumen');
    $idCaso = Input::get('idCaso');
    $idRegistro = Input::get('idRegistro');
    $fecha = date("Y-m-d H:i:s");
    ///TRAIGO LA INFORMACION PARA ENVIAR EL CORREO
    $ticket = Ticket::where("caso.id", "=", $idCaso)
                    ->leftJoin('cliente', 'caso.id_cliente', '=', 'cliente.id')
                    ->leftJoin('hijo', 'cliente.id_hijo', '=', 'hijo.id')
                    ->leftJoin('estado', 'caso.id_estado', '=', 'estado.id')
                    ->select('estado.estado as estado', 'hijo.nombre as hijoName', 'cliente.users_id_padre as clientid')->first();
    $cliente = Usuario::find($ticket->clientid);
    $para = "andre0190@gmail.com";
//    $para = $cliente->email;
    
    $tutors = TicketTutores::where('caso_id', '=', $idCaso)->get();
    $nombreturores = "";


    ///TUTOR DEL CASO
    foreach ($tutors as $tutor) {
      $mistutor = Usuario::find($tutor->users_id_tutor);
      $nombreturores .= $mistutor->name . ", ";
    }

    //HORAS DEL REGISTRO
    $horasRegistro = horasRegistro::where('registro_tutor_id', '=', $idRegistro)->get();
    
    try {
      registroTutor::where('id', '=', $idRegistro)->update(array("resumen" => $resumen, "aprobado" => "S", "fecha_aprobacion" => $fecha));
      $todosAprobados = registroTutor::where(array("aprobado" => 'N', "id_caso" => $idCaso))->get()->count();
      if ($todosAprobados == 0) {
        Ticket::where('id', '=', $idCaso)->update(array('id_estado' => 3));
      }
      $this->email($para, $horasRegistro, $nombreturores, $resumen);
    } catch (Exception $ex) {
      return response()->json(array('error' => array('Error al aprobar el registro')));
    }
    return response()->json(array('success' => true, 'msj' => 'Registro aprobado'));
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

  public function viewEditTicket($idTicket) {
    $infoTicket = Ticket::find($idTicket);
    $infoTicket->tutors = TicketTutores::where('caso_id', '=', $idTicket)->get();
    $infoTicket->invoice = Bills::where('caso_id', '=', $idTicket)->first();
    foreach ($infoTicket->tutors as $tutor) {
      $tutor->user = Usuario::find($tutor->users_id_tutor);
    }
    return view('TicketsController.edit', $infoTicket->toArray());
  }

  /*
   * FUNCION CON EL CUERPO DEL EMAIL QUE SE ENVIA AL PADRE CUANDO SE APRUEBA UN REGISTRO DEL TUTOR
   */

  private function email($para,$horas,$tutor,$resumen) {
    $cabeceras = 'MIME-Version: 1.0' . "\r\n";
    $cabeceras .= 'Content-type: text/html; charset=utf-8' . "\r\n";
    $cabeceras .= 'From: Emocion Creativa <info@emocioncreativa.com>' . "\r\n";

    $titulo = "Nuevo comentario en el caso de tutoria";
    $mensaje = "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Strict//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd'>
              <html xmlns='http://www.w3.org/1999/xhtml' xml:lang='en'>
              <head>
                      <meta http-equiv='Content-Type' content='text/html;charset=UTF-8'>
                      <title>Caso verificado</title>
                      <meta name='viewport' content='width=device-width, initial-scale=1.0'/>
              </head>
              <body style='background-color: #f6f6f6'>
              <table width='700' border='0' align='center' cellpadding='0' cellspacing='0' style='font-family: Verdana, Geneva, sans-serif; text-align: center; background-color: white;'>
                 <tr>
                  <td>
                    <img src='".url("/img/logo.jpeg")."'/>
                  </td>
                 </tr>
                  <tr>
                   <td colspan='4'>
                   <br>
                     El tutor $tutor agrego un nuevo registro de la tutoria
                   </td>
                 </tr><tr>td><h3>Registros: </h3></td></tr>";
                 foreach ($horas as $hora) {
                    $fecha = $hora->fecha;
                    $horaIni = $hora->hora_inicio;
                    $horaFin = $hora->hora_fin;
                   $mensaje .= "<tr>
                      <td>
                        Fecha: $fecha
                      </td>
                      <td >
                        Hora de inicio: $horaIni
                      </td>
                      <td>
                        Hora de fin: $horaFin
                      </td>
                    </tr>";
                  }
                 

      $mensaje .= "
                <tr>
                   <td>
                     <h3>Comentario: </h3>
                     <p>$resumen</p>
                   </td>
                </tr>
                <tr>
                  <td height='60'></td>
                </tr>
                <tr style='background-color: #f7f7f7; color: #79797d;'>
                  <td colspan='4'><p style='font-size: 12px; margin: 30px;'>Copyright © 2018 Emoción creativa </p></td>
                </tr>
              </table>
              </body>
              </html>";

    mail($para, $titulo, $mensaje, $cabeceras);
  }

}
