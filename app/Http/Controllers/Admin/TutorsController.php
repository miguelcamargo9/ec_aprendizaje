<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tutor;
use App\Models\Usuario;
use App\Models\Ticket;
use App\Models\Universities;
use App\Models\Degrees;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class TutorsController extends Controller {

  public function showListTutors() {
    return view('AdminController.Tutor.list');
  }

  public function getAllTutors() {
    $tutors = Tutor::with('user')->get();
    foreach ($tutors as $tutor) {
      $ruta = "/admin/tutor/view/edit/{$tutor->id}";
      $boton = "<a href='$ruta' title='Editar Tutor {$tutor->user->name}'>Editar <i class='fa fa-edit'></i></a>  ";
      if ($tutor->estado === 'Activo') {
        $ruta = "/admin/tutor/view/inactivate/{$tutor->id}";
        $boton .= "<a href='$ruta' title='Inactivar Tutor {$tutor->user->name}'>Inactivar <i class='fa fa-minus-circle'></i></a> ";
      } else {
        $ruta = "/admin/tutor/view/activate/{$tutor->id}";
        $boton .= "<a href='$ruta' title='Activar Tutor {$tutor->user->name}'>Activar <i class='fa fa-plus-circle'></i></a> ";
      }
      $ruta = "/admin/tutor/view/delete/{$tutor->id}";
      $boton .= "<a href='$ruta' title='Eliminar Tutor {$tutor->user->name}'>Eliminar <i class='fa fa-trash'></i></a>";
      $tutor->opciones = $boton;
    }

    return $tutors;
  }

  public function viewDeleteTutor($idTutor) {
    $infoTutor = Tutor::with('user')->with('university')->with('degree')->with('bank')->find($idTutor);
    return view('AdminController.Tutor.delete', $infoTutor->toArray());
  }

  public function viewInactivateTutor($idTutor) {
    $infoTutor = Tutor::with('user')->with('university')->with('degree')->with('bank')->find($idTutor);
    return view('AdminController.Tutor.inactivate', $infoTutor->toArray());
  }

  public function viewActivateTutor($idTutor) {
    $infoTutor = Tutor::with('user')->with('university')->with('degree')->with('bank')->find($idTutor);
    return view('AdminController.Tutor.activate', $infoTutor->toArray());
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
        if (Input::get('newuniversity') != "") {
          $id_university = $this->insertUniversity(Input::get('newuniversity'));
        } else {
          $id_university = Input::get('university');
        }
        if (Input::get('newdegree') != "") {
          $id_degree = $this->insertDegree(Input::get('newdegree'));
        } else {
          $id_degree = Input::get('degree');
        }
        Tutor::where('id', '=', $id)->update(
                array(
                    'universidad_id' => $id_university,
                    'carrera_id' => $id_degree,
                    'semestre' => Input::get('semester'),
                    'graduado' => (int) Input::get('graduate'),
                    'celular' => Input::get('mobile'),
                    'numero_cuenta' => Input::get('accountnumber'),
                    'tipo_cuenta' => Input::get('accounttype'),
                    'banco_id' => Input::get('bank'),
                    'permiso_registro' => Input::get('pastregister')
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
        if (Input::get('newuniversity') != "") {
          $id_university = $this->insertUniversity(Input::get('newuniversity'));
        } else {
          $id_university = Input::get('university');
        }
        if (Input::get('newdegree') != "") {
          $id_degree = $this->insertDegree(Input::get('newdegree'));
        } else {
          $id_degree = Input::get('degree');
        }
        $this->insertTutor($id_user, $id_university, $id_degree, Input::get('semester'), Input::get('graduate'), Input::get('mobile'), Input::get('accountnumber'), Input::get('accounttype'), Input::get('bank'), Input::get('pastregister'));
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
    $password = strtoupper(substr($nameex, 0, 1)) . strtolower($lastnameex);
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

  public function insertUniversity($name) {
    $newuniversity = new Universities;
    $newuniversity->universidad = $name;

    $newuniversity->save();
    return $newuniversity->id;
  }

  public function insertDegree($name) {
    $newdegree = new Degrees();
    $newdegree->carrera = $name;

    $newdegree->save();
    return $newdegree->id;
  }

  public function insertTutor($id, $university, $degree, $semester, $graduate, $mobile, $accountnumber, $accounttype, $bank, $pastregister) {
    $newtutor = new Tutor;
    $newtutor->universidad_id = $university;
    $newtutor->carrera_id = $degree;
    $newtutor->semestre = $semester;
    $newtutor->graduado = (int) $graduate;
    $newtutor->celular = "$mobile";
    $newtutor->numero_cuenta = "$accountnumber";
    $newtutor->tipo_cuenta = $accounttype;
    $newtutor->banco_id = $bank;
    $newtutor->pastregister = $pastregister;
    $newtutor->users_id = $id;

    $newtutor->save();
  }

  public function getTutorsRules() {
    $rules = array(
        'identification_number' => array('numeric', 'min:5'),
        'email' => array('email')
    );
    return $rules;
  }

  public function getTutorsMessages() {
    $messages = array(
        'identification_number.numeric' => 'El campo número de identifiación debe ser númerico',
        'email.email' => 'Formato de correo incorrecto',
        'valxhour.numeric' => 'El campo valor por hora debe ser númerico',
        'mobile.numeric' => 'El campo celular debe ser númerico',
        'accountnumber.numeric' => 'El campo número de cuenta debe ser númerico'
    );
    return $messages;
  }

  public function deleteTutor() {
    $id = Input::get('id');
    $idUser = Input::get('id_user');

    $tickets = Ticket::where('users_id_tutor', '=', $idUser)->get();

    if (count($tickets) > 0) {
      return response()->json(array('error' => array('El tutor tiene casos asignados, no se puede eliminar')));
    } else {
      $tutor = Tutor::find($id);
      $user = Usuario::find($idUser);
      try {
        $tutor->delete();
        $user->delete();
        return response()->json(array('success' => true, 'msj' => 'Tutor Eliminado con Éxito'));
      } catch (Exception $ex) {
        return response()->json(array('error' => array('Error eliminando el tutor')));
      }
    }
  }

  public function activateTutor() {
    $id = Input::get('id');
    $idUser = Input::get('id_user');
    $estado = "Activo";

    try {
      Tutor::where('id', '=', $id)->update(
              array(
                  'estado' => $estado,
              )
      );
      return response()->json(array('success' => true, 'msj' => 'Tutor Activado con Éxito'));
    } catch (Exception $ex) {
      return response()->json(array('error' => array('Error activando el tutor')));
    }
  }

  public function inactivateTutor() {
    $id = Input::get('id');
    $idUser = Input::get('id_user');
    $estado = "Inactivo";

    try {
      Tutor::where('id', '=', $id)->update(
              array(
                  'estado' => $estado,
              )
      );
      return response()->json(array('success' => true, 'msj' => 'Tutor Inactivado con Éxito'));
    } catch (Exception $ex) {
      return response()->json(array('error' => array('Error inactivando el tutor')));
    }
  }

}
