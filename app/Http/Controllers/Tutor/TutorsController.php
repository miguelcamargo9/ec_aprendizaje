<?php

namespace App\Http\Controllers\Tutor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Child;
use App\Models\Usuario;
use App\Models\Ticket;
use App\Models\State;
use Illuminate\Support\Facades\Session;


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
            $boton = "<a href='$ruta'><i class='fa fa-eye' aria-hidden='true'></i></a>";
            $value->ver = $boton;
        }

        return $result;
    }

    public function getInfoTickets($idTicket) {
        $infoTicket = Ticket::find($idTicket);
        $client = $this->getClient($infoTicket->id_cliente);
        $child = $this->getChild($client->id_hijo);
        $parent = $this->getParent($client->users_id_padre);
        $client_name = $child->nombre . " " . $child->apellido . " - (Padre) " . $parent->name;
        $infoTicket->client_name = $client_name;
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
  * GUARDAR EL COMENTARIO DEL TUTOR EN EL CASO
  */

    public function addCommentary(Request $request) {
        $comentario = trim($request->input('comentario'));
        $fechaComentario = date("Y-m-d H:i:s");
        $idCaso = $request->input('id');
        Ticket::where('id', '=', $idCaso)->update(array('descripcion' => $comentario, "fecha_comentario" => $fechaComentario,"id_estado" => 4));
    }

}
