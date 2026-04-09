<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class EducationInformationController extends Controller
{
    /** Save education record */
    public function saveEducation(Request $request)
    {
        $request->validate([
            'user_id'    => 'nullable|string|max:50',
            'institution'=> 'required|string|max:255',
            'subject'    => 'required|string|max:255',
            'start_date' => 'nullable|date',
            'end_date'   => 'nullable|date',
            'degree'     => 'nullable|string|max:100',
            'grade'      => 'nullable|string|max:50',
        ]);

        DB::beginTransaction();
        try {
            DB::table('education_information')->insert([
                'user_id'    => $request->user_id,
                'institution'=> $request->institution,
                'subject'    => $request->subject,
                'start_date' => $request->start_date,
                'end_date'   => $request->end_date,
                'degree'     => $request->degree,
                'grade'      => $request->grade,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::commit();
            flash()->success('Education information added successfully.');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            flash()->error('Failed to add education information.');
            return redirect()->back();
        }
    }

    /** Update education record */
    public function updateEducation(Request $request, $id)
    {
        $request->validate([
            'institution'=> 'required|string|max:255',
            'subject'    => 'required|string|max:255',
            'start_date' => 'nullable|date',
            'end_date'   => 'nullable|date',
            'degree'     => 'nullable|string|max:100',
            'grade'      => 'nullable|string|max:50',
        ]);
    
        DB::table('education_information')->where('id', $id)->update([
            'institution'=> $request->institution,
            'subject'    => $request->subject,
            'start_date' => $request->start_date,
            'end_date'   => $request->end_date,
            'degree'     => $request->degree,
            'grade'      => $request->grade,
            'updated_at' => now(),
        ]);

        flash()->success('Education information updated successfully.');
        return redirect()->back();
    }

    /** Delete education record */
    public function deleteEducation($id)
    {
        DB::table('education_information')->where('id', $id)->delete();
        flash()->success('Education information deleted successfully.');
        return redirect()->back();
    }

    /** Fetch education list for a user */
    public function getEducation($user_id)
    {
        return DB::table('education_information')->where('user_id', $user_id)->get();
    }
}