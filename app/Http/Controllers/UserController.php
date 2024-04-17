<?php

namespace App\Http\Controllers;

use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Module;
use App\Models\User;
use App\Traits\Modules;

class UserController extends Controller
{
    public function users() {
        $module = Module::with(['dad'])->where('id', 3)
        ->whereHas('users', function($query) {
            $query->where('user_id', auth()->user()->id);
        })
        ->first();
        if (empty($module)) {
            return redirect('dashboard');
        }
        return view('configuration.users')->with([
            'modulo' => $module,
            'menu' => Modules::modulesMenu()
        ]);
    }

    public function getUsers(Request $request) {
        return DataTables::make(User::with(['modules'])->whereNotIn('id', [1])->select('id', 'name', 'user'))->toJson();
    }

    public function createModifyUser(Request $request) {

        $user = User::where('user', $request->user)->first();
        if (!empty($user)) {
            if ($request->userId != $user->id) {
                return response()->json([
                    'error' => true,
                    'msj'   => 'El usuario que ingresó ya se ecnuentra registrado<br>Por favor intente con otro.'
                ], 200);
            }
        }

        if ($request->password != $request->passwordTwo) {
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
            if (!empty($request->password)) {
                $user->password = Hash::make(trim($request->password));
            }
            $user->save();
        }
        return response()->json([
            'error' => false,
            'msj'   => 'El usuario se '.$txt.' correctamente'
        ], 200);
    }
}
