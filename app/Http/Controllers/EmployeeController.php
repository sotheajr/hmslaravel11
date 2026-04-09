<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Designation;
use App\Models\Employee;
use App\Models\Overtime;
use App\Models\ProfileInformation;
use App\Models\Timesheet;
use App\Models\User;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class EmployeeController extends Controller
{
    /** All Employee Card View */
    public function cardAllEmployee(Request $request)
    {
        $users = DB::table('users')
                    ->join('employees','users.user_id','employees.employee_id')
                    ->select('users.*','employees.birth_date', 'employees.gender','employees.line_manager')
                    ->get(); 
        $userList = DB::table('users')->get();
        $permission_lists = DB::table('permission_lists')->get();
        return view('employees.allemployeecard',compact('users','userList','permission_lists'));
    }

    /** All Employee List */
    public function listAllEmployee()
    {
        $users = DB::table('users')
                    ->join('employees','users.user_id', 'employees.employee_id')
                    ->select('users.*','employees.birth_date','employees.gender','employees.line_manager')
                    ->get();
        $userList = DB::table('users')->get();
        $permission_lists = DB::table('permission_lists')->get();
        return view('employees.employeelist',compact('users','userList','permission_lists'));
    }

    /** Save Data Employee */
            public function saveRecord(Request $request)
{
    $request->validate([
        'name'         => 'required|string|max:255',
        'email'        => 'required|email',
        'birth_date'   => 'required|string',
        'gender'       => 'required|string',
        'employee_id'  => 'required|string',
        'line_manager' => 'required|string',
        'avatar'       => 'nullable|image|mimes:jpg,jpeg,png',
    ]);

    DB::beginTransaction();
    try {
        $birth_date = Carbon::parse($request->birth_date)->format('Y-m-d');

        $employee = Employee::updateOrCreate(
            ['email' => $request->email],
            [
                'name'         => $request->name,
                'birth_date'   => $birth_date,
                'gender'       => $request->gender,
                'employee_id'  => $request->employee_id,
                'line_manager' => $request->line_manager,
            ]
        );

        $information = ProfileInformation::updateOrCreate(
            ['user_id' => $request->employee_id],
            [
                'name'       => $request->name,
                'email'      => $request->email,
                'birth_date' => $birth_date,
                'gender'     => $request->gender,
                'reports_to' => $request->line_manager,
            ]
        );

        if ($request->hasFile('avatar')) {
            $avatarName = time().'.'.$request->avatar->extension();
            $request->avatar->move(public_path('uploads/avatar'), $avatarName);
            $employee->avatar = $avatarName;
            $information->avatar = $avatarName;
            $employee->save();
            $information->save();
        }

        // Permissions
        if ($request->permission) {
            for ($i = 0; $i < count($request->id_count); $i++) {
                DB::table('module_permissions')->insert([
                    'employee_id'       => $request->employee_id,
                    'module_permission' => $request->permission[$i],
                    'id_count'          => $request->id_count[$i],
                    'read'              => $request->read[$i] ?? 'N',
                    'write'             => $request->write[$i] ?? 'N',
                    'create'            => $request->create[$i] ?? 'N',
                    'delete'            => $request->delete[$i] ?? 'N',
                    'import'            => $request->import[$i] ?? 'N',
                    'export'            => $request->export[$i] ?? 'N',
                ]);
            }
        }

        DB::commit();
        flash()->success('Add new employee successfully :)');
        return redirect()->route('all/employee/card');

    } catch (\Exception $e) {
        DB::rollback();
        flash()->error('Add new employee fail :) '.$e->getMessage());
        return redirect()->back();
    }
}
    
    /** Edit Record */
    public function viewRecord($employee_id)
    {
        $permission = DB::table('employees')
            ->join('module_permissions','employees.employee_id','module_permissions.employee_id')
            ->select('employees.*','module_permissions.*')->where('employees.employee_id',$employee_id)->get();
        $employees = DB::table('employees')->where('employee_id',$employee_id)->get();
        return view('employees.edit.editemployee',compact('employees','permission'));
    }

    /** Update Record */
    public function updateRecord( Request $request)
    {
        DB::beginTransaction();
        try {

            // update table Employee
            $updateEmployee = [
                'id'           => $request->id,
                'name'         => $request->name,
                'email'        => $request->email,
                'birth_date'   => $request->birth_date,
                'gender'       => $request->gender,
                'employee_id'  => $request->employee_id,
                'line_manager' => $request->line_manager,
            ];

            // update table user
            $updateUser = [
                'id'    => $request->id,
                'name'  => $request->name,
                'email' => $request->email,
            ];

            // update table module_permissions
            for($i = 0;$i<count($request->id_permission);$i++)
            {
                $UpdateModule_permissions = [
                    'employee_id'       => $request->employee_id,
                    'module_permission' => $request->permission[$i],
                    'id'                => $request->id_permission[$i],
                    'read'              => $request->read[$i],
                    'write'             => $request->write[$i],
                    'create'            => $request->create[$i],
                    'delete'            => $request->delete[$i],
                    'import'            => $request->import[$i],
                    'export'            => $request->export[$i],
                ];
                module_permission::where('id',$request->id_permission[$i])->update($UpdateModule_permissions);
            }

            $information = ProfileInformation::updateOrCreate(['user_id' => $request->employee_id]);
            $information->name         = $request->name;
            $information->user_id      = $request->employee_id;
            $information->email        = $request->email;
            $information->birth_date   = $request->birth_date;
            $information->gender       = $request->gender;
            $information->reports_to   = $request->line_manager;
            $information->save();

            $user = User::updateOrCreate(['user_id' => $request->employee_id]);
            $user->name         = $request->name;
            $user->user_id      = $request->employee_id;
            $user->email        = $request->email;
            $user->line_manager = $request->line_manager;
            $user->save();

            User::where('id',$request->id)->update($updateUser);
            Employee::where('id',$request->id)->update($updateEmployee);
        
            DB::commit();
            flash()->success('Updated record successfully :)');
            return redirect()->route('all/employee/card');
        }catch(\Exception $e){
            DB::rollback();
            flash()->error('Updated record fail :)');
            return redirect()->back();
        }
    }

    /** Delete Record */
    public function deleteRecord($employee_id)
    {
        DB::beginTransaction();
        try{
            Employee::where('employee_id',$employee_id)->delete();
            module_permission::where('employee_id',$employee_id)->delete();

            DB::commit();
            flash()->success('Delete record successfully :)');
            return redirect()->route('all/employee/card');
        }catch(\Exception $e){
            DB::rollback();
            flash()->error('Delete record fail :)');
            return redirect()->back();
        }
    }

    /** Employee Search */
    public function employeeSearch(Request $request)
    {
        $users = DB::table('users')
                    ->join('employees','users.user_id','employees.employee_id')
                    ->select('users.*','employees.birth_date','employees.gender','employees.line_manager')->get();
        $permission_lists = DB::table('permission_lists')->get();
        $userList = DB::table('users')->get();

        // search by id
        if($request->employee_id)
        {
            $users = DB::table('users')
                        ->join('employees','users.user_id','employees.employee_id')
                        ->select('users.*','employees.birth_date','employees.gender','employees.line_manager')
                        ->where('employee_id','LIKE','%'.$request->employee_id.'%')->get();
        }
        // search by name
        if($request->name)
        {
            $users = DB::table('users')
                        ->join('employees','users.user_id','employees.employee_id')
                        ->select('users.*','employees.birth_date','employees.gender','employees.line_manager')
                        ->where('users.name','LIKE','%'.$request->name.'%')->get();
        }
        // search by name
        if($request->position)
        {
            $users = DB::table('users')
                        ->join('employees','users.user_id','employees.employee_id')
                        ->select('users.*','employees.birth_date','employees.gender','employees.line_manager')
                        ->where('users.position','LIKE','%'.$request->position.'%')->get();
        }

        // search by name and id
        if($request->employee_id && $request->name)
        {
            $users = DB::table('users')
                        ->join('employees','users.user_id','employees.employee_id')
                        ->select('users.*','employees.birth_date','employees.gender','employees.line_manager')
                        ->where('employee_id','LIKE','%'.$request->employee_id.'%')
                        ->where('users.name','LIKE','%'.$request->name.'%')
                        ->get();
        }
        // search by position and id
        if($request->employee_id && $request->position)
        {
            $users = DB::table('users')
                        ->join('employees','users.user_id','employees.employee_id')
                        ->select('users.*','employees.birth_date', 'employees.gender', 'employees.line_manager')
                        ->where('employee_id','LIKE','%'.$request->employee_id.'%')
                        ->where('users.position','LIKE','%'.$request->position.'%')->get();
        }
        // search by name and position
        if($request->name && $request->position)
        {
            $users = DB::table('users')
                        ->join('employees','users.user_id','employees.employee_id')
                        ->select('users.*','employees.birth_date','employees.gender','employees.line_manager')
                        ->where('users.name','LIKE','%'.$request->name.'%')
                        ->where('users.position','LIKE','%'.$request->position.'%')->get();
        }
        // search by name and position and id
        if($request->employee_id && $request->name && $request->position)
        {
            $users = DB::table('users')
                        ->join('employees','users.user_id','employees.employee_id')
                        ->select('users.*','employees.birth_date','employees.gender','employees.line_manager')
                        ->where('employee_id','LIKE','%'.$request->employee_id.'%')
                        ->where('users.name','LIKE','%'.$request->name.'%')
                        ->where('users.position','LIKE','%'.$request->position.'%')->get();
        }
        return view('employees.allemployeecard',compact('users','userList','permission_lists'));
    }

    /** List Search */
    public function employeeListSearch(Request $request)
    {
        $users = DB::table('users')
                    ->join('employees','users.user_id','employees.employee_id')
                    ->select('users.*','employees.birth_date','employees.gender','employees.line_manager')->get(); 
        $permission_lists = DB::table('permission_lists')->get();
        $userList         = DB::table('users')->get();

        // search by id
        if($request->employee_id)
        {
            $users = DB::table('users')
                        ->join('employees','users.user_id','employees.employee_id')
                        ->select('users.*','employees.birth_date','employees.gender','employees.line_manager')
                        ->where('employee_id','LIKE','%'.$request->employee_id.'%')->get();
        }

        // search by name
        if($request->name)
        {
            $users = DB::table('users')
                        ->join('employees','users.user_id','employees.employee_id')
                        ->select('users.*','employees.birth_date','employees.gender','employees.line_manager')
                        ->where('users.name','LIKE','%'.$request->name.'%')->get();
        }

        // search by name
        if($request->position)
        {
            $users = DB::table('users')
                        ->join('employees','users.user_id','employees.employee_id')
                        ->select('users.*','employees.birth_date','employees.gender','employees.line_manager')
                        ->where('users.position','LIKE','%'.$request->position.'%')->get();
        }

        // search by name and id
        if($request->employee_id && $request->name)
        {
            $users = DB::table('users')
                        ->join('employees','users.user_id','employees.employee_id')
                        ->select('users.*','employees.birth_date','employees.gender','employees.line_manager')
                        ->where('employee_id','LIKE','%'.$request->employee_id.'%')
                        ->where('users.name','LIKE','%'.$request->name.'%')->get();
        }

        // search by position and id
        if($request->employee_id && $request->position)
        {
            $users = DB::table('users')
                        ->join('employees','users.user_id','employees.employee_id')
                        ->select('users.*','employees.birth_date','employees.gender','employees.line_manager')
                        ->where('employee_id','LIKE','%'.$request->employee_id.'%')
                        ->where('users.position','LIKE','%'.$request->position.'%')->get();
        }

        // search by name and position
        if($request->name && $request->position)
        {
            $users = DB::table('users')
                        ->join('employees','users.user_id','employees.employee_id')
                        ->select('users.*','employees.birth_date','employees.gender','employees.line_manager')
                        ->where('users.name','LIKE','%'.$request->name.'%')
                        ->where('users.position','LIKE','%'.$request->position.'%')->get();
        }

        // search by name and position and id
        if($request->employee_id && $request->name && $request->position)
        {
            $users = DB::table('users')
                        ->join('employees','users.user_id','employees.employee_id')
                        ->select('users.*','employees.birth_date','employees.gender','employees.line_manager')
                        ->where('employee_id','LIKE','%'.$request->employee_id.'%')
                        ->where('users.name','LIKE','%'.$request->name.'%')
                        ->where('users.position','LIKE','%'.$request->position.'%')->get();
        }
        return view('employees.employeelist',compact('users','userList','permission_lists'));
    }

    /** Employee profile */
    public function profileEmployee($user_id)
    {
        function getUserDetails($user_id) {
            return DB::table('users')
                ->leftJoin('personal_information as pi', 'pi.user_id', 'users.user_id')
                ->leftJoin('profile_information as pr', 'pr.user_id', 'users.user_id')
                ->leftJoin('user_emergency_contacts as ue', 'ue.user_id', 'users.user_id')
                ->leftJoin('bank_information as bi', 'bi.user_id','=',  'users.user_id')
                ->leftJoin('family_information as fi', 'fi.user_id', 'users.user_id')
                ->leftJoin('education_information as ei', 'ei.user_id', 'users.user_id')
                 ->leftJoin('experience_information as ex', 'ex.user_id', 'users.user_id')
                ->select(
                    'users.*',
                    'pi.passport_no', 'pi.passport_expiry_date', 'pi.tel',
                    'pi.nationality', 'pi.religion', 'pi.marital_status',
                    'pi.employment_of_spouse', 'pi.children',
                    'pr.birth_date', 'pr.gender', 'pr.address', 'pr.country', 
                    'pr.state', 'pr.pin_code', 'pr.phone_number', 
                    'pr.department', 'pr.designation', 'pr.reports_to',
                    'ue.name_primary', 'ue.relationship_primary', 'ue.phone_primary', 
                    'ue.phone_2_primary', 'ue.name_secondary', 
                    'ue.relationship_secondary', 'ue.phone_secondary', 
                    'ue.phone_2_secondary',
                    'bi.bank_name', 'bi.bank_account_no', 'bi.ifsc_code', 'bi.pan_no',
                    'fi.dob as family_dob', 'fi.phone as family_phone', 'fi.id as family_id',
                    'ei.institution', 'ei.subject', 'ei.start_date', 'ei.end_date','ei.degree', 'ei.grade', 'ei.id as education_id',
                    'ex.company_name', 'ex.location', 'ex.job_position', 'ex.period_from','ex.period_to')
                     
                ->where('users.user_id', $user_id);
        }
        
        $user = getUserDetails($user_id)->get();   // For multiple results
        $users = getUserDetails($user_id)->first(); // For a single result
        $family = DB::table('family_information')->where('user_id', $user_id)->get(); 
        $education = DB::table('education_information')->where('user_id', $user_id)->get();
        $experience = DB::table('experience_information')->where('user_id', $user_id)->get();
        return view('employees.employeeprofile',compact('user','users','family','education','experience'));
    }

    /** Page Departments */
    public function index()
    {
        $departments = DB::table('departments')->get();
        return view('employees.departments',compact('departments'));
    }

    /** Save Record */
    public function saveRecordDepartment(Request $request)
    {
        $request->validate([
            'department' => 'required|string|max:255',
        ]);

        DB::beginTransaction();
        try {

            $department = Department::where('department',$request->department)->first();
            if ($department === null)
            {
                $department = new Department;
                $department->department = $request->department;
                $department->save();
    
                DB::commit();
                flash()->success('Add new department successfully :)');
                return redirect()->back();
            } else {
                DB::rollback();
                flash()->error('Add new department exits :)');
                return redirect()->back();
            }
        } catch(\Exception $e) {
            DB::rollback();
            flash()->error('Add new department fail :)');
            return redirect()->back();
        }
    }

    /** Update Record */
    public function updateRecordDepartment(Request $request)
    {
        DB::beginTransaction();
        try {
            // update table departments
            $department = [
                'id'         => $request->id,
                'department' => $request->department,
            ];
            Department::where('id',$request->id)->update($department);
            DB::commit();
            flash()->success('Updated record successfully :)');
            return redirect()->back();
        } catch(\Exception $e) {
            DB::rollback();
            flash()->success('Updated record fail :)');
            return redirect()->back();
        }
    }

    /** Delete Record */
    public function deleteRecordDepartment(Request $request) 
    {
        try {
            Department::destroy($request->id);
            flash()->success('Department deleted successfully :)');
            return redirect()->back();
        } catch(\Exception $e) {
            DB::rollback();
            flash()->error('Department delete fail :)');
            return redirect()->back();
        }
    }

    /** Page Designations */
   
    public function designationsIndex()
{
    $designations = Designation::with('department')->get();
    $departments = Department::all(); // ដើម្បី select ក្នុង form
    return view('employees.designations', compact('designations', 'departments'));
}

// Save Designation
public function saveRecordDesignations(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'department_id' => 'required|exists:departments,id',
    ]);

    try {
        Designation::create([
            'name' => $request->name,
            'department_id' => $request->department_id,
        ]);
        flash()->success('Designation added successfully :)');
        return redirect()->back();
    } catch (\Exception $e) {
        flash()->error('Failed to add designation :)');
        return redirect()->back();
    }
}

// Update Designation
public function updateRecordDesignations(Request $request)
{
    $request->validate([
        'id' => 'required|exists:designations,id',
        'name' => 'required|string|max:255',
        'department_id' => 'required|exists:departments,id',
    ]);

    try {
        Designation::where('id', $request->id)->update([
            'name' => $request->name,
            'department_id' => $request->department_id,
        ]);
        flash()->success('Designation updated successfully :)');
        return redirect()->back();
    } catch (\Exception $e) {
        flash()->error('Failed to update designation :)');
        return redirect()->back();
    }
}

// Delete Designation
public function deleteRecordDesignations(Request $request)
{
    try {
        Designation::destroy($request->id);
        flash()->success('Designation deleted successfully :)');
        return redirect()->back();
    } catch (\Exception $e) {
        flash()->error('Failed to delete designation :)');
        return redirect()->back();
    }
}
     public function timeSheetIndex()
{
    $timesheets = Timesheet::with('employee')->get();
    $employees  = Employee::all();

    return view('employees.timesheet', compact('timesheets','employees'));
}

// Get One (Edit)
public function getTimeSheet($id)
{
    $timesheet = Timesheet::findOrFail($id);
    return response()->json($timesheet);
}

// Create
public function saveRecordTimeSheets(Request $request)
{
    $request->validate([
        'employee_id' => 'required',
        'project' => 'required',
        'date' => 'required|date',
        'assigned_hours' => 'required|integer',
        'worked_hours' => 'required|integer',
    ]);

    Timesheet::create($request->all());

    return response()->json(['success' => true]);
}

// Update
public function updateRecordTimeSheets(Request $request)
{
    $request->validate([
        'employee_id' => 'required',
        'project' => 'required',
        'date' => 'required|date',
        'assigned_hours' => 'required|integer',
        'worked_hours' => 'required|integer',
    ]);

    $timesheet = Timesheet::findOrFail($request->id);
    $timesheet->update($request->all());

    return response()->json(['success' => true]);
}

// Delete
public function deleteRecordTimeSheets(Request $request)
{
    Timesheet::findOrFail($request->id)->delete();

    return response()->json(['success' => true]);
}
    
    /** Page Overtime */
    public function overTimeIndex()
{
    $overtimes = Overtime::with('employee')->get(); // assume OverTime model exists
    $employees = Employee::all();
    return view('employees.overtime', compact('overtimes', 'employees'));
}

    // Save Record
public function saveRecordOverTime(Request $request)
{
    $request->validate([
        'employee_id' => 'required|exists:employees,id',
        'date'        => 'required|date',
        'hours'       => 'required|numeric',
        'type'        => 'nullable|string',
        'description' => 'nullable|string',
        'status'      => 'required|string',
    ]);

    $ot = Overtime::create($request->all());

    return response()->json([
        'success' => true,
        'data' => $ot,
        'message' => 'Overtime added successfully'
    ]);
}


// Update Record
public function updateRecordOverTime(Request $request)
{
    $request->validate([
        'id'          => 'required|exists:overtimes,id',
        'employee_id' => 'required|exists:employees,id',
        'date'        => 'required|date',
        'hours'       => 'required|numeric',
        'type'        => 'nullable|string',
        'description' => 'nullable|string',
        'status'      => 'required|string',
    ]);

    $ot = Overtime::findOrFail($request->id);
    $ot->update($request->all());

    return response()->json([
        'success' => true,
        'data' => $ot,
        'message' => 'Overtime updated successfully'
    ]);
}

// Delete Record
public function deleteRecordOverTime(Request $request)
{
    $request->validate(['id' => 'required|exists:overtimes,id']);

    $ot = Overtime::findOrFail($request->id);
    $ot->delete();

    return response()->json([
        'success' => true,
        'message' => 'Overtime deleted successfully'
    ]);
}

}