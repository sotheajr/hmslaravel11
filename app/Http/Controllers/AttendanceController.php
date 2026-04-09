<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Employee;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function index()
{
    $attendances = Attendance::with('employee')->latest()->get();
    $employees = Employee::all();

    $events = $attendances->map(function($att){
        // បម្លែង date ទៅ format ISO8601 (fullcalendar require)
        $startDate = Carbon::parse($att->date)->toDateString();

        return [
            'title' => $att->employee->name ?? 'N/A', // employee name បង្ហាញលើថ្ងៃ
            'start' => $startDate,
            'allDay' => true,
            'backgroundColor' => $att->overtime > 0 ? '#f39c12' : '#00a65a',
            'borderColor' => '#000',
        ];
    });

    return view('employees.attendanceemployee', compact('attendances','employees','events'));
}

    public function store(Request $request)
    {
        Attendance::create($request->all());
        return response()->json(['success'=>true]);
    }

      public function edit($id)
    {
        $attendance = Attendance::findOrFail($id);
        return response()->json($attendance);
    }

    public function update(Request $request)
    {
        $att = Attendance::findOrFail($request->attendance_id);
        $att->update($request->all());

        return response()->json(['success'=>true]);
    }

    public function destroy($id)
    {
        Attendance::findOrFail($id)->delete();
        return response()->json(['success'=>true]);
    }

    public function punch(Request $request)
    {
        $today = Carbon::today()->toDateString();
        $userId = auth()->user()->id;

        $att = Attendance::firstOrCreate([
            'employee_id'=>$userId,
            'date'=>$today
        ]);

        if($request->type=='in'){
            $att->punch_in = now()->format('H:i:s');
        }

        if($request->type=='out'){
            $att->punch_out = now()->format('H:i:s');

            if($att->punch_in){
                $hours = Carbon::parse($att->punch_in)->diffInHours(now());
                if($hours > 8){
                    $att->overtime = $hours - 8;
                }
            }
        }

        $att->save();

        return response()->json(['success'=>true]);
    }
}