<?php

namespace App\Http\Controllers\Parents;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\Child;
use App\Models\Client;
use App\Models\Usuario;
use App\Models\registroTutor;
use App\Models\horasRegistro;
use Illuminate\Support\Facades\Input;

class ParentsController extends Controller {

  public function showListTickets() {
    return view('ParentsController.list');
  }

  public function showNewTicket() {
    return view('ParentsController.new');
  }

  /*
   * DEVUELVO LOS CASOS DE CADA PADRE
   */

  public function getTicketsByParent(Request $request) {

    // $data = Session::get("user");
    $data = $request->session()->get('user');
    $idParentUser = $data->id; //ID DEL USUARIO PADRE QUE ESTA EN SESSION
    //$idParent = Father::where('id_usuario', '=', $idParentUser)->get();//ID DEL PADRE QUE ESTA EN SESSION
    $childByParent = Client::where('users_id_padre', '=', $idParentUser)->pluck("id")->toArray();
    //var_dump($childByParent);
    $ticketsByParent = Ticket::whereIn("id_cliente", $childByParent)
                    ->leftJoin('cliente', 'caso.id_cliente', '=', 'cliente.id')
                    ->leftJoin('hijo', 'cliente.id_hijo', '=', 'hijo.id')
                    ->leftJoin('estado', 'caso.id_estado', '=', 'estado.id')
                    ->select('estado.estado as estado', 'hijo.nombre as estudiante', 'caso.fecha_inicio as fechai', 'caso.descripcion as desc', 'caso.id as id')->get();

    $respuesta = array();
    foreach ($ticketsByParent->toArray() as $ticket) {
      $idTicket = $ticket['id'];
      $ruta = "/parents/ticketinfo/$idTicket";
      $boton = "<a href='$ruta'><i class='fa fa-eye' aria-hidden='true'></i></a>";
      $ticket['boton'] = $boton;
      array_push($respuesta, $ticket);
    }

    return json_encode($respuesta);
  }

  /*
   * DEVUELVO LA INFORMACION DE UN CASO EN ESPECIFICO 
   */

  public function getInfoTickets($idTicket) {
    $infoTicket = Ticket::find($idTicket);
    $registrosTutor = registroTutor::where([['id_caso', '=', $idTicket], ['aprobado', '=', 'S']])->get(); //BUSCO LOS REGISROS QUE HA HECHO EL TUTOR
    $horasRegistro = registroTutor::where('id_caso', '=', $idTicket)->sum('total_horas');

    $client = $this->getClient($infoTicket->id_cliente);
    $child = $this->getChild($client->id_hijo);
    $parent = $this->getParent($client->users_id_padre);
    $client_name = $child->nombre . " " . $child->apellido;
    $infoTicket->client_name = $client_name;
    $infoTicket->registros = $registrosTutor;
    $infoTicket->horasRegisro = $horasRegistro;
    return view('ParentsController.info', $infoTicket->toArray());
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

  /*
   * GUARDAR EL COMENTARIO DEL PADRE EN EL CASO
   */

  public function addCommentary(Request $request) {
    $comentario = trim($request->input('respuestaPadre'));
    $fechaComentario = date("Y-m-d H:i:s");
    $idCaso = $request->input('idCaso');
    $idRegistro = $request->input('idRegistro');
    $nuevoEstado = 8;
    $datosUpdate = array(
        "respuesta_padre" => $comentario,
        "fecha_comentario_padre" => $fechaComentario);

    try {
      registroTutor::where('id', '=', $idRegistro)->update($datosUpdate);
      $todosAprobados = registroTutor::where(array("aprobado" => 'N', "id_caso" => $idCaso))->get()->count();
      if ($todosAprobados == 0) {
        Ticket::where('ID', '=', $idCaso)->update(array('id_estado' => $nuevoEstado));
      }
    } catch (Exception $ex) {
      return response()->json(array('error' => array('Error al guardar el comentario')));
    }
    return response()->json(array('success' => true, 'msj' => 'Comentario guardado'));
  }

  public function sendEamil() {
    $cabeceras = 'MIME-Version: 1.0' . "\r\n";
    $cabeceras .= 'Content-type: text/html; charset=utf-8' . "\r\n";
    $cabeceras .= 'From: Emocion Creativa <info@emocioncreativa.com>' . "\r\n";

    $para = "andre0190@gmail.com";

    $titulo = "Caso verificado";

    $ticket = Ticket::where("id", $idTicket)
                    ->leftJoin('users', 'caso.users_id_tutor', '=', 'users.id')
                    ->leftJoin('cliente', 'caso.id_cliente', '=', 'cliente.id')
                    ->leftJoin('hijo', 'cliente.id_hijo', '=', 'hijo.id')
                    ->leftJoin('estado', 'caso.id_estado', '=', 'estado.id')
                    ->select('estado.estado as estado', 'hijo.nombre as estudiante', 'hijo.apellido as estudianteAp', 'users.name as tutor')->get();
    $ticket->toArray();
    $estudiante = "{$ticket['estudiante']} {$ticket['estudianteAp']}";
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
                     el caso del estudiante:$estudiante con el tutro: $tutor ya se encuentra en el estado $estado
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
