<?php

namespace App\Http\Controllers\Resources;

use App\Http\Controllers\Controller;
use App\Models\Client;

class ResourcesController extends Controller {

    public function getClients() {
        return Client::with("father")->with("child")->get();
    }

}
