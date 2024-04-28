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
use App\Models\UserGroup;

class UserGroupController extends Controller
{
    private $controller = "UserGroup";

    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        $userGroupArr = UserGroup::orderBy('id', 'asc')->get();
        // load the view and pass the nerds
        return view('admin.userGroup.index')->with(compact('userGroupArr'));
    }

    public function create(Request $request)
    {
        return view('admin.userGroup.create');
    }

    public function store(Request $request)
    {
        $rules = array(
            'title' => 'required|Unique:user_group',
        );

        $message = array(
            'title.required' => 'Please give the User Group title!',
            'title.unique' => 'That userGroup is already taken',
        );

        $validator = Validator::make($request->all(), $rules, $message);

        if ($validator->fails()) {
            return Redirect::to('admin/userGroup/create')
                ->withErrors($validator)
                ->withInput($request->all());
        }

        $userGroup = new UserGroup();
        $userGroup->title = $request->title;
        $userGroup->status =  $request->status;
        if ($userGroup->save()) {
            Session::flash('success',  $request->title . trans('english.HAS_BEEN_CREATED_SUCCESSFULLY'));
            return Redirect::to('admin/userGroup');
        } else {
            Session::flash('error',  $request->title . trans('english.COULD_NOT_BE_CREATED_SUCCESSFULLY'));
            return Redirect::to('admin/userGroup/create');
        }
    }

    public function edit($id)
    {
        // get the User Group
        $userGroup = UserGroup::find($id);

        // show the edit form and pass the user group
        return view('admin.userGroup.edit')->with(compact('userGroup'));
    }

    public function update(Request $request, $id)
    {
        $rules = array(
            'title' => 'required'
        );
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {

            return Redirect::to('admin/userGroup/' . $id . '/edit')
                ->withErrors($validator)
                ->withInput($request->all());
        } else {
            // store
            $userGroup = UserGroup::find($id);

            $userGroup->title = $request->title;
            $userGroup->status =  $request->status;
            $result = $userGroup->save();

            // redirect
            if ($result === TRUE) {
                Session::flash('success', $request->title . trans('english.HAS_BEEN_UPDATED_SUCCESSFULLY'));
                return Redirect::to('admin/userGroup');
            } else {
                Session::flash('error', $request->title . trans('english.COULD_NOT_BE_UPDATED'));
                return Redirect::to('admin/userGroup/' . $id . '/edit');
            }
        }
    }

    public function destroy(Request $request, $id)
    {

        $userGroup = UserGroup::find($id);

        //Check Dependency before deletion

        $dependencyArr = ['User' => 'user_group_id'];


        foreach ($dependencyArr as $model => $key) {
            $namespacedModel = '\\App\\Models\\' . $model;
            $dependentData = $namespacedModel::where($key, $id)->first();
            if (!empty($dependentData)) {
                Session::flash('error', __('english.COULD_NOT_DELETE_DATA_HAS_RELATION_WITH_MODEL') . $model);
                return redirect('admin/userGroup');
            }
        }


        if ($userGroup->delete()) {
            Session::flash('error', $userGroup->title . trans('english.HAS_BEEN_DELETED_SUCCESSFULLY'));
            return Redirect::to('admin/userGroup');
        } else {
            Session::flash('error', $userGroup->title . trans('english.COULD_NOT_BE_DELETED'));
            return Redirect::to('admin/userGroup');
        }
    }
}
