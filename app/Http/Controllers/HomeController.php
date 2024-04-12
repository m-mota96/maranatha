<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Module;

class HomeController extends Controller
{
    public function index() {
        $modules = Module::with(['subModules' => function($query){
            $query->whereHas('users', function($query) {
                $query->where('user_id', auth()->user()->id);
            });
        }])->where('status', 1)->where('module_id', null)
        ->whereHas('users', function($query) {
            $query->where('user_id', auth()->user()->id);
        })->get();
        return view('home')->with([
            'menu' => null,
            'menu' => $modules
        ]);
    }
}
