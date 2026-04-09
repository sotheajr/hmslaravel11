<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class ExperienceInformationController extends Controller
{
    /** Save experience record */
    public function saveRecord(Request $request)
    {
        $request->validate([
            'user_id'      => 'nullable|string|max:50',
            'company_name' => 'required|string|max:255',
            'location'     => 'required|string|max:255',
            'job_position' => 'nullable|string|max:255',
            'period_from'  => 'nullable|date',
            'period_to'    => 'nullable|date',
        ]);

        DB::beginTransaction();
        try {
            DB::table('experience_information')->insert([
                'user_id'      => $request->user_id,
                'company_name' => $request->company_name,
                'location'     => $request->location,
                'job_position' => $request->job_position,
                'period_from'  => $request->period_from,
                'period_to'    => $request->period_to,
                'created_at'   => now(),
                'updated_at'   => now(),
            ]);

            DB::commit();
            flash()->success('Experience added successfully.');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            dd($e->getMessage()); // 👉 debug error
        }
    }

    /** Update experience record */
    public function updateRecord(Request $request, $id)
    {
        $request->validate([
            'company_name' => 'required|string|max:255',
            'location'     => 'required|string|max:255',
            'job_position' => 'nullable|string|max:255',
            'period_from'  => 'nullable|date',
            'period_to'    => 'nullable|date',
        ]);

        DB::table('experience_information')->where('id', $id)->update([
            'company_name' => $request->company_name,
            'location'     => $request->location,
            'job_position' => $request->job_position,
            'period_from'  => $request->period_from,
            'period_to'    => $request->period_to,
            'updated_at'   => now(),
        ]);

        flash()->success('Experience updated successfully.');
        return redirect()->back();
    }

    /** Delete experience record */
    public function deleteRecord($id)
    {
        DB::table('experience_information')->where('id', $id)->delete();
        flash()->success('Experience deleted successfully.');
        return redirect()->back();
    }

    /** Fetch experience list */
    public function getExperience($user_id)
    {
        return DB::table('experience_information')->where('user_id', $user_id)->get();
    }
}