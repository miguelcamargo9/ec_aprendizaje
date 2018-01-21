<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;


class TutorsController extends Controller {

    public function showListTutors() {
        return view('TutorsController.list');
    }
}
