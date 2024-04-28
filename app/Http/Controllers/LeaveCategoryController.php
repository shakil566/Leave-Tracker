<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use DB;
use URL;
use Redirect;
use Helper;
use Validator;
use Response;
use Session;
use App\Models\LeaveCategory;

class LeaveCategoryController extends Controller
{
    private $controller = "LeaveCategory";

    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        $categoryArr = LeaveCategory::orderBy('id', 'desc')->get();
        // load the view and pass the nerds
        return view('admin.leaveCategory.index')->with(compact('categoryArr'));
    }

    public function create(Request $request)
    {
        return view('admin.leaveCategory.create');
    }

    public function store(Request $request)
    {
        $rules = array(
            'title' => 'required',
        );

        $message = array(
            'title.required' => 'Please give the title!',
        );

        $validator = Validator::make($request->all(), $rules, $message);

        if ($validator->fails()) {
            return Redirect::to('admin/leaveCategory/create')
                ->withErrors($validator)
                ->withInput($request->all());
        }

        $leaveCategory = new LeaveCategory();
        $leaveCategory->title = $request->title;
        $leaveCategory->description =  $request->description;
        $leaveCategory->status =  $request->status;
        if ($leaveCategory->save()) {
            Session::flash('success',  $request->title . trans('english.HAS_BEEN_CREATED_SUCCESSFULLY'));
            return Redirect::to('admin/leaveCategory');
        } else {
            Session::flash('error',  $request->title . trans('english.COULD_NOT_BE_CREATED_SUCCESSFULLY'));
            return Redirect::to('admin/leaveCategory/create');
        }
    }

    public function edit($id)
    {
        // get the leaveCategory
        $leaveCategory = LeaveCategory::find($id);

        // show the edit form and pass the leaveCategory
        return view('admin.leaveCategory.edit')->with(compact('leaveCategory'));
    }

    public function update(Request $request, $id)
    {
        $rules = array(
            'title' => 'required',
        );
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {

            return Redirect::to('admin/leaveCategory/' . $id . '/edit')
                ->withErrors($validator)
                ->withInput($request->all());
        } else {
            // store
            $leaveCategory = LeaveCategory::find($id);

            $leaveCategory->title = $request->title;
            $leaveCategory->description =  $request->description;
            $leaveCategory->status =  $request->status;
            $result = $leaveCategory->save();

            // redirect
            if ($result === TRUE) {
                Session::flash('success', $request->title . trans('english.HAS_BEEN_UPDATED_SUCCESSFULLY'));
                return Redirect::to('admin/leaveCategory');
            } else {
                Session::flash('error', $request->title . trans('english.COULD_NOT_BE_UPDATED'));
                return Redirect::to('admin/leaveCategory/' . $id . '/edit');
            }
        }
    }

    public function destroy(Request $request, $id)
    {

        $leaveCategory = LeaveCategory::find($id);

        //Check Dependency before deletion

        $dependencyArr = ['LeaveManagement' => 'leave_category_id'];


        foreach ($dependencyArr as $model => $key) {
            $namespacedModel = '\\App\\Models\\' . $model;
            $dependentData = $namespacedModel::where($key, $id)->first();
            if (!empty($dependentData)) {
                Session::flash('error', __('english.COULD_NOT_DELETE_DATA_HAS_RELATION_WITH_MODEL') . $model);
                return redirect('admin/leaveCategory');
            }
        }


        if ($leaveCategory->delete()) {
            Session::flash('error', $leaveCategory->title . trans('english.HAS_BEEN_DELETED_SUCCESSFULLY'));
            return Redirect::to('admin/leaveCategory');
        } else {
            Session::flash('error', $leaveCategory->title . trans('english.COULD_NOT_BE_DELETED'));
            return Redirect::to('admin/leaveCategory');
        }
    }
}
