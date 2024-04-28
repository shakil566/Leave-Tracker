<?php

namespace App\Http\Controllers;

use App\Models\LeaveManagement;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $leaveApplicationPending = $leaveApplicationApproved = $leaveApplicationRejected = $employeesCount = $leaveApplication = 0;
        $employeesCount = User::where('user_group_id', '2')->where('status', '1')->count();
        $leaveApplication = LeaveManagement::count();
        $leaveApplicationPending = LeaveManagement::where('status', '1')->count();
        $leaveApplicationApproved = LeaveManagement::where('status', '2')->count();
        $leaveApplicationRejected = LeaveManagement::where('status', '3')->count();

        if (Auth::user()->user_group_id == 2) {
            $leaveApplication = LeaveManagement::where('employee_id', Auth::user()->id)->count();
            $leaveApplicationPending = LeaveManagement::where('employee_id', Auth::user()->id)->where('status', '1')->count();
            $leaveApplicationApproved = LeaveManagement::where('employee_id', Auth::user()->id)->where('status', '2')->count();
            $leaveApplicationRejected = LeaveManagement::where('employee_id', Auth::user()->id)->where('status', '3')->count();
        }
        return view('admin.dashboard')->with(compact('employeesCount', 'leaveApplication', 'leaveApplicationPending', 'leaveApplicationApproved', 'leaveApplicationRejected'));
    }
}
