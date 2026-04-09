<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shiftlist;

class ShiftlistController extends Controller
{
    // View Page
    public function shiftListIndex()
    {
        $shift = Shiftlist::all();
        return view('employees.shiftlist', compact('shift'));
    }

    // SAVE SHIFT
    public function saveRecordShiftlist(Request $request)
    {
        $request->validate([
            'shift_name' => 'required',
            'start_time' => 'required',
        ]);

        $shift = Shiftlist::create([
            'shift_name'     => $request->shift_name,
            'start_time'     => $request->start_time,
            'min_start_time' => $request->min_start_time,
            'max_start_time' => $request->max_start_time,
            'end_time'       => $request->end_time,
            'min_end_time'   => $request->min_end_time,
            'max_end_time'   => $request->max_end_time,
            'break_time'     => $request->break_time,
            'status'         => 1,
        ]);

        return response()->json(['status'=>'success','id'=>$shift->id]);
    }

    // UPDATE SHIFT
    public function updateRecordShiftlist(Request $request)
    {
        $shift = Shiftlist::findOrFail($request->id);
        $shift->update([
            'shift_name'     => $request->shift_name,
            'start_time'     => $request->start_time,
            'min_start_time' => $request->min_start_time,
            'max_start_time' => $request->max_start_time,
            'end_time'       => $request->end_time,
            'min_end_time'   => $request->min_end_time,
            'max_end_time'   => $request->max_end_time,
            'break_time'     => $request->break_time,
            'status'         => 1,
        ]);

        return response()->json(['status'=>'updated']);
    }

    // DELETE SHIFT
    public function deleteRecordShiftlist(Request $request)
    {
        Shiftlist::findOrFail($request->id)->delete();
        return response()->json(['status'=>'deleted']);
    }
}