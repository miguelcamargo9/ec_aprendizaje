<?php

namespace App\Http\Controllers\Parents;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\State;
use App\Models\Tutor;
use App\Models\Client;
use App\Models\Father;
use App\Models\Usuario;
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
                        ->leftJoin('users', 'caso.users_id_tutor', '=', 'users.id')
                        ->leftJoin('cliente', 'caso.id_cliente', '=', 'cliente.id')
                        ->leftJoin('hijo', 'cliente.id_hijo', '=', 'hijo.id')
                        ->leftJoin('estado', 'caso.id_estado', '=', 'estado.id')
                        ->select('estado.estado as estado', 'hijo.nombre as estudiante', 'users.name AS tutor', 'caso.fecha_inicio as fechai', 'caso.fecha_fin as fechaf', 'caso.descripcion as desc', 'caso.id as id')->get();

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
        return view('ParentsController.info', $infoTicket->toArray());
    }

}
