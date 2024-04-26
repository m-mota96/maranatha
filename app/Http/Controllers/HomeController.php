<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ServiceType;
use App\Models\Staff;
use App\Traits\Modules;

class HomeController extends Controller
{
    public function index() {
        return view('home')->with([
            'modulo' => null,
            'menu' => Modules::modulesMenu(),
            'serviceTypes' => ServiceType::with(['services'])->where('status', 1)->get(),
            'staff' => Staff::with(['services', 'schedules'])->where('status', 1)->get()
        ]);
    }
}
