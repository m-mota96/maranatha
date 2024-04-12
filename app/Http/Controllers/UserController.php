<?php

namespace App\Http\Controllers;

use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Module;
use App\Models\User;

class UserController extends Controller
{
    public function users() {

        $modules = Module::with(['subModules.dad' => function($query){
            $query->whereHas('users', function($query) {
                $query->where('user_id', auth()->user()->id);
            });
        }])->where('status', 1)->where('module_id', null)
        ->whereHas('users', function($query) {
            $query->where('user_id', auth()->user()->id);
        })->get();

        $module = Module::with(['dad'])->where('id', 3)->first();

        return view('configuration.users')->with([
            'modulo' => $module,
            'menu' => $modules
        ]);
    }

    public function getUsers(Request $request) {
        return DataTables::make(User::whereNotIn('id', [1])->select('id', 'name', 'user'))->toJson();
    }

    public function createModifyUser(Request $request) {

        $user = User::where('user', $request->user)->first();
        if (!empty($user)) {
            return response()->json([
                'error' => true,
                'msj'   => 'El usuario usuario que ingresó ya se ecnuentra reistrado<br>Por favor intente con otro.'
            ], 200);
        }

        if ($request->password != $passwordTwo) {
            return response()->json([
                'error' => true,
                'msj'   => 'Las contraseñas no coinciden.'
            ], 200);
        }


        if (empty($request->userId)) {
            $txt = 'guardo';
            User::create([
                'name'     => trim($request->nameUser),
                'user'     => trim($request->user),
                'password' => Hash::make(trim($request->password)),
            ]);
        } else {
            // $user = Module::where('id', $request->userId)->first();
            $txt = 'modifico';
            $user->name     = trim($request->nameUser);
            $user->user     = trim($request->user);
            $user->password = Hash::make(trim($request->password));
            $user->save();
        }
        return response()->json([
            'error' => false,
            'msj'   => 'El usuario se '.$txt.' correctamente'
        ], 200);
    }
}
