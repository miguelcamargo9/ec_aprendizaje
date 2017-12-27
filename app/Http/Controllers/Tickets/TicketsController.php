<?php

namespace App\Http\Controllers\Tickets;

use App\Http\Controllers\Controller;
use App\Models\State;
use App\Models\Ticket;
use App\Models\Tutor;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;


class TicketsController extends Controller {
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
        return view('TicketsController.list',array('mensaje' => ''));
    }
    
    public function showNewTicket() {
        return view('TicketsController.new',array('mensaje' => ''));
    }

    public function  createNewTicket(){
        $fechaIni = Input::get('dateini');
        $fechaFin = Input::get('dateend');
        $descripcion = Input::get('description');

        $datosCaso = new Ticket();
        $datosCaso->id_estado = 1;
        $datosCaso->fecha_inicio = "$fechaIni";
        $datosCaso->fecha_fin = "$fechaFin";
        $datosCaso->descripcion = "$descripcion";
        $datosCaso->save();

        return view('TicketsController.new', array('mensaje' => 'caso creado con éxito'));
    }

    public function  editTicket(){
        $descripcion = Input::get('description');
        $perfil= Session::get('idPeril');
        $userid = Session::get('user');
        echo "$userid - $perfil"; die();
        Ticket::where('ID', '=', $id)->update(array('id_tutor' => 1,'descripcion' => $descripcion));

        return view('TicketsController.new', array('mensaje' => 'caso asignado el caso con éxito'));
    }

    public function getAllTickets() {
        $result = Ticket::with('tutor','state','client')->get();

        foreach ($result as $value) {
            //$value->id_cliente = empty($value->id_cliente) ? "N/A" : $value->id_cliente;
            //$value->id_tutor = empty($value->id_tutor) ? "N/A" : $value->id_tutor;
            $value->descripcion= $this->convertUtf8($value->descripcion);
            foreach ($value->tutor as $tutor){
                $value->id_tutor = $tutor->nombre." ".$tutor->apellido;
            }
            foreach ($value->client as $client){
                $value->id_cliente = $client->child->nombre." ".$client->child->apellido;
            }
            $value->id_estado = $this->getState(2);
        }

        return $result;
    }

    public function getCreatedTickets() {
        $result = Ticket::where('id_estado','=',1)->get();
        foreach ($result as $value) {
            $value->id_cliente = ($value->id_cliente != "") ? $value->id_cliente : "N/A";
            $value->id_tutor = ($value->id_tutor != "") ? $value->id_cliente : "N/A";
            $value->descripcion=$this->convertUtf8($value->descripcion);
        }

        return $result;
    }

    public function updateState(Request $request){
        $asignados = $request->input('ids');
        $user = Session::get('user');
        $mensaje = "No se puede asignar caso al usuario ". $user['name']." porque no esta registrado como tutor!";
        if (preg_match_all('/=\d+/',$asignados,$matches))
        {
            //var_export ($matches);
            foreach ($matches[0] as $id){
                $id = substr($id,1);
                if($user['profiles_id'] == 3){
                    $tutor = Tutor::where('id_user','=',$user['id'])->first();
                    Ticket::where('ID', '=', $id)->update(array('id_tutor' => $tutor->id,'id_estado' => 2));
                    $mensaje = "Caso(s) asignados con éxito al tutor ". $user['name']."!";
                }
            }
        }
        return $mensaje;
    }
    public function convertUtf8($value) {
        return mb_detect_encoding($value, mb_detect_order(), true) === 'UTF-8' ? $value : mb_convert_encoding($value, 'UTF-8');
    }

    public function getTutor($id) {
        $tutorobj = Tutor::where('id','=',$id)->get();
        $tutorname = "N/A";
        foreach ($tutorobj as $item) {
            if($item->nombre && $item->apellido){
                $tutorname = $item->nombre." ".$item->apellido;
            }
        }
        return $tutorname;
    }

    public function getState($id) {
        $stateobj = State::where('id','=',$id)->get();
        $state = "N/A";
        foreach ($stateobj as $item) {
            if($item->estado){
                $state = $item->estado;
            }
        }
        return $state;
    }
}
