<?php

namespace App\Http\Controllers;

use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use App\Models\Position;
use App\Traits\Modules;
use App\Traits\Permissions;

class PositionController extends Controller
{
    public function positions() {
        $module = Modules::module(10);
        if (empty($module)) {
            return redirect('dashboard');
        }
        
        return view('organization.positions')->with([
            'modulo' => $module,
            'menu' => Modules::modulesMenu(),
            'permissions' => Permissions::permissionsUser($module->id)
        ]);
    }

    public function getPositions(Request $request) {
        return DataTables::make(Position::all())->toJson();
    }

    public function createModifyPosition(Request $request) {
        if (empty($request->positionId)) {
            $txt = 'guardo';
            Position::create(['name' => trim($request->positionName)]);
        } else {
            $txt = 'modifico';
            $position = Position::where('id', $request->positionId)->first();
            $position->name = trim($request->positionName);
            $position->save();
        }
        return response()->json([
            'error' => false,
            'msj'   => 'El puesto se '.$txt.' correctamente'
        ], 200);
    }
}
