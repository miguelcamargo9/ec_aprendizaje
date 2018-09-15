<?php

namespace App\Http\Controllers;

use App\Models\View;
use App\Models\Profile;

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
    public function index() {
        return view('HomeController.home');
    }

    public static function getMenus($id_profile) {
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
    
    public static function getProfile($id_profile){
        return Profile::find($id_profile); 
    }

}
