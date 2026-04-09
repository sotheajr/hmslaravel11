<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;
use DB;

class ExpenseReportsController extends Controller
{
    // view page
    public function index()
    {
        return view('reports.expensereport');
    }

    // view page
    public function invoiceReports()
    {
        return view('reports.invoicereports');
    }
    
    // daily report page
    public function dailyReport()
    {
        return view('reports.dailyreports');
    }

    // leave reports page
    public function leaveReport()
    {
        $leaves = DB::table('leaves_admins')
                ->join('users', 'users.user_id','leaves_admins.user_id')
                ->select('leaves_admins.*', 'users.*')
                ->get();
        return view('reports.leavereports',compact('leaves'));
    }

    /** payment report index page */
    public function paymentsReportIndex()
    {
        return view('reports.payments-reports');
    }

    /** employee-reports page */
    public function employeeReportsIndex()
    {
        $employees = \App\Models\Employee::with(['department', 'designation'])->get();
        return view('reports.employee-reports', compact('employees'));
    }

    /** Payslip Reports */
    public function payslipReports()
    {
        return view('reports.payslipreports');
    }

   
    public function attendanceReports()
    {
        $attendances = \App\Models\Attendance::with('employee')->get();
        return view('reports.attendance-reports', compact('attendances'));
    }
}
