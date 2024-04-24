<?php

namespace App\Http\Controllers;

use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\ServiceType;
use App\Traits\Modules;
use App\Traits\Permissions;

class ServiceController extends Controller
{
    public function services() {
        $module = Modules::module(12);
        if (empty($module)) {
            return redirect('dashboard');
        }
        
        return view('operation.services')->with([
            'modulo' => $module,
            'menu' => Modules::modulesMenu(),
            'permissions' => Permissions::permissionsUser($module->id),
            'serviceTypes' => ServiceType::where('status', 1)->orderBy('name')->get()
        ]);
    }

    public function getServices(Request $request) {
        return DataTables::make(Service::with(['service_type']))->toJson();
    }

    public function createModifyService(Request $request) {
        if (empty($request->serviceId)) {
            $txt = 'guardo';
            Service::create([
                'service_type_id' => $request->serviceType,
                'name' => trim($request->serviceName),
                'price' => trim($request->price),
                'discounted_price' => !empty($request->priceDiscount) ? trim($request->priceDiscount) : null,
                'time' => trim($request->time),
            ]);
        } else {
            $txt = 'modifico';
            $service = Service::find($request->serviceId);
            $service->service_type_id = $request->serviceType;
            $service->name = trim($request->serviceName);
            $service->price = trim($request->price);
            $service->discounted_price = !empty($request->priceDiscount) ? trim($request->priceDiscount) : null;
            $service->time = trim($request->time);
            $service->save();
        }
        return response()->json([
            'error' => false,
            'msj'   => 'El servicio se '.$txt.' correctamente'
        ], 200);
    }
}
