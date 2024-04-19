<?php

namespace App\Http\Controllers;

use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use App\Models\Position;
use App\Models\Staff;
use App\Models\StaffSchedule;
use App\Traits\DateFormatEs;
use App\Traits\Modules;
use App\Traits\Permissions;

class StaffController extends Controller
{
    public function staff() {
        $module = Modules::module(9);
        if (empty($module)) {
            return redirect('dashboard');
        }
        
        return view('organization.staff')->with([
            'modulo' => $module,
            'menu' => Modules::modulesMenu(),
            'permissions' => Permissions::permissionsUser($module->id),
            'positions' => Position::where('status', 1)->get(),
            'days' => DateFormatEs::days()
        ]);
    }

    public function getStaff(Request $request) {
        return DataTables::make(Staff::with(['position', 'schedules']))->toJson();
    }

    public function createModifyStaff(Request $request) {
        if (empty($request->staffId)) {
            $txt = 'guardo';
            Staff::create([
                'position_id' => $request->position,
                'name' => trim($request->staffName),
                'first_name' => trim($request->firstName),
                'last_name' => trim($request->lastName),
                'birthdate' => !empty($request->birthdate) ? trim($request->birthdate) : null,
                'curp' => !empty($request->curp) ? trim($request->curp) : null,
                'rfc' => !empty($request->rfc) ? trim($request->rfc) : null,
                'email' => !empty($request->email) ? trim($request->email) : null,
                'phone' => !empty($request->phone) ? trim($request->phone) : null,
                'commission' => !empty($request->commission) ? trim($request->commission) : null,
            ]);
        } else {
            $txt = 'modifico';
            $staff = Staff::where('id', $request->staffId)->first();
            $staff->position_id = $request->position;
            $staff->name = trim($request->staffName);
            $staff->first_name = trim($request->firstName);
            $staff->last_name = trim($request->lastName);
            $staff->birthdate = !empty($request->birthdate) ? trim($request->birthdate) : null;
            $staff->curp = !empty($request->curp) ? trim($request->curp) : null;
            $staff->rfc = !empty($request->rfc) ? trim($request->rfc) : null;
            $staff->email = !empty($request->email) ? trim($request->email) : null;
            $staff->phone = !empty($request->phone) ? trim($request->phone) : null;
            $staff->commission = !empty($request->commission) ? trim($request->commission) : null;
            $staff->save();
        }
        return response()->json([
            'error' => false,
            'msj'   => 'El staff se '.$txt.' correctamente'
        ], 200);
    }

    public function updateSchedulesStaff(Request $request) {
        for ($i=0; $i < sizeof($request->day); $i++) { 
            $data[] = [
                'staff_id' => $request->schedulesStaffId,
                'day' => $request->day[$i],
                'start_time' => $request->startTime[$i],
                'end_time' => $request->endTime[$i],
                'meal_start_time' => $request->mealStartTime[$i],
                'meal_end_time' => $request->mealEndTime[$i],
                'status' => isset($request->activeDay[$i]) ? 1 : 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];
        }
        StaffSchedule::insert($data);
        return response()->json([
            'error' => false,
            'msj'   => 'Los horarios se actualizaron correctamente'
        ], 200);
    }
}
