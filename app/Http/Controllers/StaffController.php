<?php

namespace App\Http\Controllers;

use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use App\Models\Position;
use App\Models\Service;
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
            'days' => DateFormatEs::days(),
            'services' => Service::where('status', 1)->whereNotIn('service_type_id', [2])->orderBy('name')->get()
        ]);
    }

    public function getStaff(Request $request) {
        return DataTables::make(Staff::with(['position', 'schedules', 'services']))->toJson();
    }

    public function createModifyStaff(Request $request) {
        if (empty($request->staffId)) {
            $txt = 'guardo';
            $staff = Staff::create([
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
            $staff = Staff::find($request->staffId);
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

        $services = !empty($request->service) ? array_values($request->service) : [];
        $staff->services()->sync($services);

        return response()->json([
            'error' => false,
            'msj'   => 'El staff se '.$txt.' correctamente'
        ], 200);
    }

    public function updateSchedulesStaff(Request $request) {
        $schedules = StaffSchedule::where('staff_id', $request->schedulesStaffId)->get();
        if (sizeof($schedules) == 0) {
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
        } else {
            foreach ($schedules as $key => $s) {
                $schedule = StaffSchedule::find($s->id);
                $schedule->start_time = $request->startTime[$key];
                $schedule->end_time = $request->endTime[$key];
                $schedule->meal_start_time = $request->mealStartTime[$key];
                $schedule->meal_end_time = $request->mealEndTime[$key];
                $schedule->status = isset($request->activeDay[$key]) ? 1 : 0;
                $schedule->save();
            }
        }
        return response()->json([
            'error' => false,
            'msj'   => 'Los horarios se actualizaron correctamente'
        ], 200);
    }

    public function updateImgProfileStaff(Request $request) {
        if (empty($request->file)) {
            return response()->json([
                'error' => true,
                'msj'   => 'No cargo ninguna imagen.'
            ], 200);
        }

        $file = $request->file;
        $extension = $file->getClientOriginalExtension();
        if ($extension != 'jpg' && $extension != 'png') {
            return response()->json([
                'error' => true,
                'msj'   => 'Solo se aceptan imagenes con formato JPG o PNG.'
            ], 200);
        }

        $nameImage = uniqid() . '.' . $extension;
        $file->move('profileStaff', $nameImage);

        $staff = Staff::find($request->staffId);
        if (!empty($staff->image_profile)) {
            if (file_exists('profileStaff/'.$staff->image_profile)) {
                unlink('profileStaff/'.$staff->image_profile);
            }
        }
        $staff->image_profile = $nameImage;
        $staff->save();

        return response()->json([
            'error' => false,
            'msj'   => $nameImage
        ], 200);
    }
}
