<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Usuario;
use App\Models\Father;
use App\Models\Child;
use App\Models\Ticket;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class ClientsController extends Controller {

    public function showListClients() {
        return view('AdminController.Client.list');
    }

    public function getAllClients() {
        $result = Father::with("user")->get();
        foreach ($result as $value) {
            $ruta = "/admin/client/view/edit/{$value->id}";
            $boton = "<a href='$ruta' alt='Editar Cliente {$value->user->name}'>Editar <i class='fa fa-edit'></i></a>  ";
            $ruta = "/admin/client/view/delete/{$value->id}";
            $boton .= "<a href='$ruta' alt='Eliminar Cliente {$value->user->name}'>Eliminar <i class='fa fa-minus-circle'></i></a>";
            $value->opciones = $boton;
        }

        return $result;
    }

    public function viewDeleteClient($idFather) {
        $infoClient = Father::with("user")->find($idFather);
        $infoClient->children = Client::with('child')->where('users_id_padre', '=', $infoClient->users_id)->get()->toArray();
        foreach ($infoClient->children as $child) {
            $child['name'] = $child['child']['nombre'];
        }
        if (isset($infoClient->children[0]['child']['id_user_segundo_responsable'])) {
            $infoClient->usertwo = Usuario::find($infoClient->children[0]['child']['id_user_segundo_responsable'])->toArray();
        }
        return view('AdminController.Client.delete', $infoClient->toArray());
    }

    public function viewEditClient($idFather) {
        $infoClient = Father::with("user")->find($idFather);
        $infoClient->children = Client::with('child')->where('users_id_padre', '=', $infoClient->users_id)->get()->toArray();
        foreach ($infoClient->children as $child) {
            $child['name'] = $child['child']['nombre'];
        }
        if (isset($infoClient->children[0]['child']['id_user_segundo_responsable'])) {
            $infoClient->usertwo = Usuario::find($infoClient->children[0]['child']['id_user_segundo_responsable'])->toArray();
        }
        return view('AdminController.Client.edit', $infoClient->toArray());
    }

    public function viewCreateClient() {
        return view('AdminController.Client.new');
    }

    public function editClient(Request $request) {
        $id = Input::get('id');
        $idUser = Input::get('id_user');
        $idUserTwo = null;

        $rules = $this->getClientsRules();
        $messages = $this->getClientsMessages();
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->passes()) {
            try {
                $idUserTwo = Input::get('id_user_two');
                $namesecond = Input::get('namesecond');
                $children = Input::get('children');
                Usuario::where('id', '=', $idUser)->update(
                        array(
                            'name' => Input::get('name'),
                            'identification_number' => Input::get('identification_number'),
                            'email' => Input::get('email'),
                            'updated_at' => date("Y-m-d H:i:s"),
                        )
                );
                if (isset($idUserTwo)) {
                    if (isset($namesecond)) {
                        Usuario::where('id', '=', $idUserTwo)->update(
                                array(
                                    'name' => Input::get('namesecond'),
                                    'identification_number' => Input::get('identification_number_second'),
                                    'email' => Input::get('email_second'),
                                    'updated_at' => date("Y-m-d H:i:s"),
                                )
                        );
                    } else {
                        $father = Father::where('users_id', '=', $idUserTwo);
                        $user = Usuario::find($idUserTwo);
                        try {
                            $idUserTwo = null;
                            Child::where('id_user_primer_responsable', '=', $idUser)->update(
                                    array(
                                        'id_user_segundo_responsable' => null
                                    )
                            );
                            $father->delete();
                            $user->delete();
                        } catch (Exception $ex) {
                            return response()->json(array('error' => array('Error eliminando el tutor')));
                        }
                    }
                } elseif (isset($namesecond)) {
                    $nametwo = explode(" ", $namesecond);
                    $idUserTwo = $this->insertUser($nametwo[0], $nametwo[1], Input::get('identification_number_second'), Input::get('email_second'));
                    $this->insertFather($idUserTwo);
                }

                $clientchildren = Client::where('users_id_padre', '=', $idUser)->get();
                foreach ($clientchildren as $client) {
                    $found_key = array_search($client->id_hijo, array_column($children, 'id_hijo'));
                    if (is_numeric($found_key)) {
                        Child::where('id', '=', $client->id_hijo)->update(
                                array(
                                    'nombre' => $children[$found_key]['name'],
                                    'id_user_segundo_responsable' => $idUserTwo
                                )
                        );
                    } else {
                        $tickets = Ticket::where('id_cliente', '=', $idUser)->count();
                        if ($tickets > 0) {
                            return response()->json(array('error' => array('El cliente tiene casos asignados, no se pueden eliminar hijos')));
                        } else {
                            $clientobj = Client::find($client->id);
                            $clientobj->delete();
                            $childobj = Child::find($client->id_hijo);
                            $childobj->delete();
                        }
                    }
                }
                foreach ($children as $child) {
                    if (!isset($child['id'])) {
                        $id_child = $this->insertChild($child['name'], $idUser, $idUserTwo);
                        $this->insertClient($idUser, $id_child);
                    }
                }


                return response()->json(array('success' => true, 'msj' => 'Tutor Editado con Éxito'));
            } catch (Exception $ex) {
                return response()->json(array('error' => array('Error editanto el tutor')));
            }
        } else {
            return response()->json($validator->messages());
        }
    }

    public function createClient(Request $request) {
        $rules = $this->getClientsRules();
        $messages = $this->getClientsMessages();
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->passes()) {
            try {
                $namesecond = Input::get('namesecond');
                $children = Input::get('children');
                $id_user_two = null;
                $id_user = $this->insertUser(Input::get('name'), Input::get('lastname'), Input::get('identification_number'), Input::get('email'));
                $this->insertFather($id_user);
                if (isset($namesecond)) {
                    $id_user_two = $this->insertUser(Input::get('namesecond'), Input::get('lastnamesecond'), Input::get('identification_number_second'), Input::get('email_second'));
                    $this->insertFather($id_user_two);
                }
                foreach ($children as $key => $child) {
                    $id_child = $this->insertChild($child['name'], $id_user, $id_user_two);
                    $this->insertClient($id_user, $id_child);
                }
                return response()->json(array('success' => true, 'msj' => 'Cliente Creado con Éxito'));
            } catch (Exception $ex) {
                return response()->json(array('error' => array('Error creando el cliente')));
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
        $newuser->profiles_id = 2;

        $newuser->save();
        return $newuser->id;
    }

    public function insertChild($name, $id_user, $id_user_two) {
        $newchild = new Child;
        $newchild->nombre = $name;
        $newchild->id_user_primer_responsable = $id_user;
        $newchild->id_user_segundo_responsable = $id_user_two;

        $newchild->save();
        return $newchild->id;
    }

    public function insertClient($id_father, $id_child) {
        $newclient = new Client;
        $newclient->users_id_padre = $id_father;
        $newclient->id_hijo = $id_child;

        $newclient->save();
    }

    public function insertFather($id) {
        $newfather = new Father;
        $newfather->users_id = $id;

        $newfather->save();
    }

    public function getClientsRules() {
        $rules = array(
            'email' => array('email'),
            'namesecond' => array('regex:/^(.+?)\\s(.+?)(?:\\s(.+?)){1,4}?$|^(.+?)\\s(.+?)$/'),
            'email_second' => array('email')
        );
        return $rules;
    }

    public function getClientsMessages() {
        $messages = array(
            'email.email' => 'Formato de correo incorrecto',
            'namesecond.regex' => 'Formato de nombre incorrecto',
            'email_second.email' => 'Formato de correo incorrecto'
        );
        return $messages;
    }

    public function deleteClient() {
        $id = Input::get('id');
        $idUser = Input::get('id_user');
        $idUserTwo = Input::get('id_user_two');

        $clientchildren = Client::where('users_id_padre', '=', $idUser)->get();
        foreach ($clientchildren as $client) {
            $tickets = Ticket::where('id_cliente', '=', $idUser)->count();
            if ($tickets > 0) {
                return response()->json(array('error' => array('El cliente tiene casos asignados, no se puede eliminar.')));
            } else {
                $clientObj = Client::find($client->id);
                $child = Child::find($client->id_hijo);
                try {
                    $clientObj->delete();
                    $child->delete();
                } catch (Exception $ex) {
                    return response()->json(array('error' => array('Error eliminando el cliente')));
                }
            }
        }
        $father = Father::find($id);
        $user = Usuario::find($idUser);

        if (isset($idUserTwo)) {
            $fatherTwo = Father::where('users_id', '=', $idUserTwo);
            $userTwo = Usuario::find($idUserTwo);
        }

        try {
            $father->delete();
            $user->delete();
            if (isset($fatherTwo)) {
                $fatherTwo->delete();
            }
            if (isset($userTwo)) {
                $userTwo->delete();
            }
            return response()->json(array('success' => true, 'msj' => 'Cliente Eliminado con Éxito'));
        } catch (Exception $ex) {
            return response()->json(array('error' => array('Error eliminando el cliente')));
        }
    }

}
