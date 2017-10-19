<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\View;

class HomeController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $user = Auth::user();
        $menus = $this->getMenus($user->profiles_id);
//        echo "<pre>"; print_r($menus);        die();
        $request->session()->put('menu', $menus);
        return view('HomeController.home');
    }

    public function getMenus($id_profile) {
        $interfaces = View::join('interfaces_profiles', function ($join) {
                    $join->on('interfaces_profiles.id_interface', '=', 'interface.id');
                })->where('interfaces_profiles.id_profile', '=', $id_profile)->orderBy('order', 'asc')->orderBy('id', 'asc')->get();
        $menus = array();
        foreach ($interfaces as $interfaz) {
            if (isset($interfaz->id_father)) {
                $menus[$interfaz->id_father]['sons'][] = $interfaz->toArray();
            } else {
                $menus[$interfaz->id] = $interfaz->toArray();
            }
        }
        return $menus;
    }

}
