<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Module;
use App\Traits\Modules;

class HomeController extends Controller
{
    public function index() {
        return view('home')->with([
            'modulo' => null,
            'menu' => Modules::modulesMenu()
        ]);
    }
}
