<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tutor;
use App\Models\Usuario;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class TutorsController extends Controller {

    public function showListTutors() {
        return view('AdminController.Tutor.list');
    }

    public function getAllTutors() {
        $result = Tutor::with('user')->get();
        foreach ($result as $value) {
            $ruta = "/admin/tutor/view/edit/{$value->id}";
            $boton = "<a href='$ruta' alt='Editar Tutor {$value->user->name}'>Editar <i class='fa fa-edit'></i></a>  ";
            $ruta = "/admin/tutor/view/delete/{$value->id}";
            $boton .= "<a href='$ruta' alt='Eliminar Tutor {$value->user->name}'>Eliminar <i class='fa fa-minus-circle'></i></a>";
            $value->opciones = $boton;
        }

        return $result;
    }

    public function viewDeleteTutor($idTutor) {
        $infoTutor = Tutor::with('user')->find($idTutor);
        return view('AdminController.Tutor.delete', $infoTutor->toArray());
    }

    public function viewEditTutor($idTutor) {
        $infoTutor = Tutor::with('user')->find($idTutor);
        return view('AdminController.Tutor.edit', $infoTutor->toArray());
    }
    
    public function viewCreateTutor() {
        return view('AdminController.Tutor.new');
    }

    public function editTutor(Request $request) {
        $id = Input::get('id');
        $idUser = Input::get('id_user');

        $rules = $this->getTutorsRules();
        $messages = $this->getTutorsMessages();
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->passes()) {
            try {
                Usuario::where('id', '=', $idUser)->update(
                        array(
                            'name' => Input::get('name'),
                            'identification_number' => Input::get('identification_number'),
                            'email' => Input::get('email'),
                            'updated_at' => date("Y-m-d H:i:s"),
                        )
                );
                Tutor::where('id', '=', $id)->update(
                        array(
                            'universidad' => Input::get('university'),
                            'carrera' => Input::get('degree'),
                            'semestre' => Input::get('semester'),
                            'valor_hora' => Input::get('valxhour'),
                            'celular' => Input::get('mobile'),
                            'numero_cuenta' => Input::get('accountnumber')
                        )
                );
                return response()->json(array('success' => true, 'msj' => 'Tutor Editado con Éxito'));
            } catch (Exception $ex) {
                return response()->json(array('error' => array('Error editanto el tutor')));
            }
        } else {
            return response()->json($validator->messages());
        }
    }
    
    public function createTutor(Request $request) {
        $rules = $this->getTutorsRules();
        $messages = $this->getTutorsMessages();
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->passes()) {
            try {
                $id_user = $this->insertUser(Input::get('name'), Input::get('lastname'), Input::get('identification_number'), Input::get('email'));
                $this->insertTutor($id_user, Input::get('university'), Input::get('degree'), Input::get('semester'), Input::get('valxhour'), Input::get('mobile'), Input::get('accountnumber'));
                return response()->json(array('success' => true, 'msj' => 'Tutor Creado con Éxito'));
            } catch (Exception $ex) {
                return response()->json(array('error' => array('Error creando el tutor')));
            }
        } else {
            return response()->json($validator->messages());
        }
    }
    
    public function insertUser($name, $lastname, $identification_number, $email) {
        $nameex = (strstr($name, " ")) ? explode(" ", $name)[0] : $name;
        $lastnameex = (strstr($lastname, " ")) ? explode(" ", $lastname)[0] : $lastname;              
        $password = strtoupper(substr($nameex, 0, 1)).strtolower($lastnameex);
        $newuser = new Usuario;
        $newuser->name = "$name $lastname";
        $newuser->identification_number = $identification_number;
        $newuser->email = "$email";
        $newuser->password = bcrypt($password);
        $newuser->created_at = date("Y-m-d H:i:s");
        $newuser->updated_at = date("Y-m-d H:i:s");
        $newuser->profiles_id = 3;

        $newuser->save();
        return $newuser->id;
    }
    
    public function insertTutor($id, $university, $degree, $semester, $valxhour, $mobile, $accountnumber) {
        $newtutor = new Tutor;
        $newtutor->universidad = "$university";
        $newtutor->carrera = "$degree";
        $newtutor->semestre = $semester;
        $newtutor->valor_hora = "$valxhour";
        $newtutor->celular = "$mobile";
        $newtutor->numero_cuenta = "$accountnumber";
        $newtutor->users_id = $id;

        $newtutor->save();
    }

    public function getTutorsRules() {
        $rules = array(
            'identification_number' => array('numeric', 'min:5'),
            'email' => array('email'),
            'semester' => array('numeric', 'min:1', 'max:30')
        );
        return $rules;
    }

    public function getTutorsMessages() {
        $messages = array(
            'identification_number.numeric' => 'El campo número de identifiación debe ser númerico',
            'email.email' => 'Formato de correo incorrecto',
            'semester.numeric' => 'El campo semestre debe ser númerico',
            'valxhour.numeric' => 'El campo valor por hora debe ser númerico',
            'mobile.numeric' => 'El campo celular debe ser númerico',
            'accountnumber.numeric' => 'El campo número de cuenta debe ser númerico'
        );
        return $messages;
    }

}
