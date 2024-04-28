<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\LeaveCategory;
use App\Models\LeaveManagement;
use Illuminate\Http\Request;
use Auth;
use DB;
use URL;
use Redirect;
use Helper;
use Validator;
use Response;
use Session;
use App\Models\Task;
use App\Models\User;

class LeaveApplicationController extends Controller
{
    private $controller = "LeaveApplication";

    public function __construct()
    {
        // $this->middleware('admin');
    }

    public function index()
    {
        if (Auth::user()->user_group_id == 2) {
            $leaveApplicationArr =  LeaveManagement::with(array('LeaveCategory'))
                ->where('employee_id', Auth::user()->id)->orderBy('id', 'desc')->get();
        } else {
            $leaveApplicationArr = LeaveManagement::with(array('LeaveCategory', 'User'))->orderBy('id', 'desc')->get();
        }
        // dd($leaveApplicationArr);
        // load the view and pass the nerds
        return view('admin.leaveApplication.index')->with(compact('leaveApplicationArr'));
    }

    public function create(Request $request)
    {
        $employee = [];
        //get category list
        $category = LeaveCategory::orderBy('id')->where('status', '=', 1)->pluck('title', 'id')->toArray();
        $category = array('' => '--Select Leave Category--') + $category;

        if (Auth::user()->user_group_id == 1) {
            //get employee list
            $employee = User::orderBy('id')->where('status', '=', 1)->where('user_group_id', '2')->pluck('name', 'id')->toArray();
            $employee = array('' => '--Select Employee--') + $employee;
        }

        return view('admin.leaveApplication.create')->with(compact('category', 'employee'));
    }

    public function store(Request $request)
    {
        $rules = array(
            'title' => 'required',
            'description' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'leave_category_id' => 'required|not_in:0',
        );

        $message = array(
            'title.required' => 'Please give the title!',
            'description.required' => 'Please give the description!',
            'leave_category_id.required' => 'Please select leave category!',
        );

        if (Auth::user()->user_group_id == 1) {
            $rules = array(
                'title' => 'required',
                'description' => 'required',
                'leave_category_id' => 'required|not_in:0',
                'employee_id' => 'required|not_in:0',
            );

            $message = array(
                'title.required' => 'Please give the title!',
                'description.required' => 'Please give the description!',
                'leave_category_id.required' => 'Please select leave category!',
                'employee_id.required' => 'Please select employee!',
            );
        }

        $validator = Validator::make($request->all(), $rules, $message);

        if ($validator->fails()) {
            return Redirect::to('admin/leaveApplication/create')
                ->withErrors($validator)
                ->withInput($request->all());
        }

        $task = new LeaveManagement();
        $task->title = $request->title;
        if (Auth::user()->user_group_id == 1) {
            $task->employee_id = $request->employee_id;
        } else {
            $task->employee_id = Auth::user()->id;
        }
        $task->leave_category_id = $request->leave_category_id;
        $task->start_date = $request->start_date;
        $task->end_date = $request->end_date;
        $task->description =  $request->description;
        $task->status =  1;
        if ($task->save()) {
            Session::flash('success',  trans('english.LEAVE_APPLICATION') . trans('english.HAS_BEEN_CREATED_SUCCESSFULLY'));
            return Redirect::to('admin/leaveApplication');
        } else {
            Session::flash('error',  trans('english.LEAVE_APPLICATION') . trans('english.COULD_NOT_BE_CREATED_SUCCESSFULLY'));
            return Redirect::to('admin/leaveApplication/create');
        }
    }

    public function edit($id)
    {
        $leave = LeaveManagement::find($id);

        $employee = [];
        //get category list
        $category = LeaveCategory::orderBy('id')->where('status', '=', 1)->pluck('title', 'id')->toArray();
        $category = array('' => '--Select Leave Category--') + $category;

        if (Auth::user()->user_group_id == 1) {
            //get employee list
            $employee = User::orderBy('id')->where('status', '=', 1)->where('user_group_id', '2')->pluck('name', 'id')->toArray();
            $employee = array('' => '--Select Employee--') + $employee;
        }


        // show the edit form and pass the task
        return view('admin.leaveApplication.edit')->with(compact('leave', 'category', 'employee'));
    }

    public function update(Request $request, $id)
    {
        $rules = array(
            'title' => 'required',
            'description' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'leave_category_id' => 'required|not_in:0',
        );

        $message = array(
            'title.required' => 'Please give the title!',
            'description.required' => 'Please give the description!',
            'leave_category_id.required' => 'Please select leave category!',
        );


        if (Auth::user()->user_group_id == 1) {
            $rules = array(
                'title' => 'required',
                'description' => 'required',
                'leave_category_id' => 'required|not_in:0',
                'employee_id' => 'required|not_in:0',
            );

            $message = array(
                'title.required' => 'Please give the title!',
                'description.required' => 'Please give the description!',
                'leave_category_id.required' => 'Please select leave category!',
                'employee_id.required' => 'Please select employee!',
            );
        }

        $validator = Validator::make($request->all(), $rules, $message);


        if ($validator->fails()) {

            return Redirect::to('admin/leaveApplication/' . $id . '/edit')
                ->withErrors($validator)
                ->withInput($request->all());
        } else {
            // store
            $task = LeaveManagement::find($id);

            $task->title = $request->title;
            $task->leave_category_id = $request->leave_category_id;
            if (Auth::user()->user_group_id == 1) {
                $task->employee_id = $request->employee_id;
            } else {
                $task->employee_id = Auth::user()->id;
            }
            $task->description =  $request->description;
            $task->start_date = $request->start_date;
            $task->end_date = $request->end_date;

            $result = $task->save();

            // redirect
            if ($result === TRUE) {
                Session::flash('success', trans('english.LEAVE_APPLICATION') . trans('english.HAS_BEEN_UPDATED_SUCCESSFULLY'));
                return Redirect::to('admin/leaveApplication');
            } else {
                Session::flash('error', trans('english.LEAVE_APPLICATION') . trans('english.COULD_NOT_BE_UPDATED'));
                return Redirect::to('admin/leaveApplication/' . $id . '/edit');
            }
        }
    }


    // public function approve($id, $param = null)
    // {

    //     $data = LeaveManagement::find($id);

    //     $data->status = '2';
    //     $msgText = $data->title . trans('english.SUCCESSFULLY_APPROVED');

    //     $data->save();
    //     // redirect
    //     Session::flash('success', $msgText);
    //     return Redirect::to('admin/leaveApplication');
    // }
    // public function reject($id, $param = null)
    // {

    //     $data = LeaveManagement::find($id);

    //     $data->status = '3';
    //     $msgText = $data->title . trans('english.SUCCESSFULLY_REJECTED');

    //     $data->save();
    //     // redirect
    //     Session::flash('success', $msgText);
    //     return Redirect::to('admin/leaveApplication');
    // }

    public function remarks(Request $request)
    {
        $leaveId = $request->leave_id;
        $data = LeaveManagement::find($leaveId);
        $view = view('admin.leaveApplication.remarks', compact('leaveId','data'))->render();
        return response()->json(['html' => $view]);
    }
    public function saveRemarks(Request $request)
    {

        $rules['remarks'] = 'required';
        $message = array(
            'remarks.required' => 'Please add remarks!',
        );
        $validator = Validator::make($request->all(), $rules, $message);
        if ($validator->fails()) {
            return Response::json(array('success' => false, 'heading' => 'Validation Error', 'message' => $validator->errors()), 400);
        }

        $data = LeaveManagement::find($request->leave_id);

        $data->status = $request->status;
        $data->remarks = $request->remarks;

        if ($data->save()) {
            return Response::json(['success' => true, 'message' => 'Successfully Leave Application Modify'], 200);
        } else {
            return Response::json(['success' => false, 'message' => 'Something Wrong'], 401);
        }
    }
}
