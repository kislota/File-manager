<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\FileManager;

class IndexController extends Controller {

    public function index($path = null) {

        $dir = FileManager::dirAll($path);

        return view('fileManager', compact(['dir']));
    }

}
