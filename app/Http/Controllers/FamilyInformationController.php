<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class FamilyInformationController extends Controller
{
    /** Save family record */
    public function saveRecord(Request $request)
    {
        $request->validate([
            'name'         => 'required|string|max:255',
            'relationship' => 'required|string|max:255',
            'dob'          => 'nullable|date',
            'phone'        => 'nullable|string|max:20',
            'user_id'      => 'nullable|string|max:50',
        ]);

        DB::beginTransaction();
        try {
            DB::table('family_information')->insert([
                'user_id'      => $request->user_id,
                'name'         => $request->name,
                'relationship' => $request->relationship,
                'dob'          => $request->dob,
                'phone'        => $request->phone,
                'created_at'   => now(),
                'updated_at'   => now(),
            ]);

            DB::commit();
            flash()->success('Family information added successfully.');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            flash()->error('Failed to add family information.');
            return redirect()->back();
        }
    }

    /** Update family record */
    public function updateRecord(Request $request, $id)
    {
        $request->validate([
            'name'         => 'required|string|max:255',
            'relationship' => 'required|string|max:255',
            'dob'          => 'nullable|date',
            'phone'        => 'nullable|string|max:20',
        ]);

        DB::table('family_information')
            ->where('id', $id)
            ->update([
                'name'         => $request->name,
                'relationship' => $request->relationship,
                'dob'          => $request->dob,
                'phone'        => $request->phone,
                'updated_at'   => now(),
            ]);

        flash()->success('Family information updated successfully.');
        return redirect()->back();
    }

    /** Delete family record */
    public function deleteRecord($id)
    {
        DB::table('family_information')->where('id', $id)->delete();
        flash()->success('Family information deleted successfully.');
        return redirect()->back();
    }

    /** Fetch family list for a user */
    public function getFamily($user_id)
    {
        return DB::table('family_information')
            ->where('user_id', $user_id)
            ->get();
    }
}