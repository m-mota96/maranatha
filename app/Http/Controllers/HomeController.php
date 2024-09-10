<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
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

    public function searchStaff(Request $request) {
        $numberDayWeek  = date('N', strtotime($request->date));
        $dateQuote      = $request->date;
        $servicesId     = $request->services;
        $hourStartQuote = $request->horary;
        $addTime        = 0;

        // $services = Service::whereIn('id', $servicesId)->select('id', 'name', 'time')->get();
        // foreach ($services as $key => $s) {
        //     $addTime = $addTime + $s->time;
        // }
        // $hourEndQuote = date("H:i", strtotime($hourStartQuote) + ($addTime * 60) );
        // dd($hourStartQuote.' - '.$hourEndQuote);

        $staff = Staff::with(['schedules', 'services'])->where('status', 1)
        ->whereHas('schedules', function($query) use($numberDayWeek) {
            $query->where('day', $numberDayWeek)->where('status', 1);
        })
        ->whereHas('services', function($query) use($servicesId) {
            $query->whereIn('id', $servicesId);
        })
        ->get();
        
        return response()->json([
            'error' => false,
            'msj'   => '',
            'data'  => $staff
        ], 200);
    }
}
