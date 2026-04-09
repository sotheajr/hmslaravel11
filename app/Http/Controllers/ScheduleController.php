<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Department;
use App\Models\Designation;
use App\Models\Shiftlist;
use App\Models\Schedule;

class ScheduleController extends Controller
{
    public function indexschedule()
    {
        $schedules = Schedule::with(['employee','department','designation','shift'])->get();

        // ✅ Calendar Events
        $events = [];
        foreach ($schedules as $s) {
            $events[] = [
                'id'    => $s->id,
                'title' => $s->employee->name . ' (' . $s->shift->shift_name . ')',
                'start' => $s->work_date,
                'color' => '#28a745'
            ];
        }

        return view('employees.shiftscheduling', [
            'employees'   => Employee::all(),
            'departments' => Department::all(),
            'designations'=> Designation::all(),
            'shiftlists'  => Shiftlist::all(),
            'schedules'   => $schedules,
            'events'      => $events
        ]);
    }

    // CREATE
    public function storeschedule(Request $request)
    {
        $request->validate([
            'employee_id'=>'required',
            'department_id'=>'required',
            'designation_id'=>'required',
            'shiftlist_id'=>'required',
            'work_date'=>'required|date',
            'worked_hours' => 'required|numeric',
        ]);

        if ($request->worked_hours > 8) {
            return response()->json([
                'status' => 'error',
                'message' => 'Worked hours exceed 8. Please use Overtime/OT Auto instead!'
            ], 422);
        }

        Schedule::create($request->only(
            'employee_id','department_id','designation_id','shiftlist_id','work_date'
        ));

        return response()->json(['status'=>'success']);
    }

    // EDIT
    public function editschedule($id)
    {
        return response()->json(Schedule::findOrFail($id));
    }

    // UPDATE
    public function updateschedule(Request $request)
    {
        $schedule = Schedule::findOrFail($request->schedule_id);

        $schedule->update($request->only(
            'employee_id','department_id','designation_id','shiftlist_id','work_date'
        ));

        return response()->json(['status'=>'success']);
    }

    // DELETE
    public function destroyschedule($id)
    {
        Schedule::findOrFail($id)->delete();
        return response()->json(['status'=>'deleted']);
    }

    // ✅ DRAG DROP UPDATE DATE
    public function updateDate(Request $request)
    {
        $schedule = Schedule::findOrFail($request->id);

        $schedule->update([
            'work_date' => $request->start
        ]);

        return response()->json(['status'=>'updated']);
    }
}