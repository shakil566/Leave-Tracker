<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use URL;
use Redirect;
use Helper;
use Validator;
use Response;
use Session;
use App\Models\User;
use App\Models\UserGroup;
use File;
use Hash;
use Mail;

class UsersController extends Controller
{
    private $controller = 'Users';

    public function __construct()
    {
        $this->middleware('admin');

        Validator::extend('complexPassword', function ($attribute, $value, $parameters) {

            $password = $parameters[1];
            if (preg_match('/^\S*(?=\S{8,})(?=\S*[A-Z])(?=\S*[a-z])(?=\S*[0-9])(?=\S*[`~!?@#$%^&*()\-_=+{}|;:,<.>])(?=\S*[\d])\S*$/', $password)) {
                return true;
            }

            return false;
        });

        //Get program from session
    }

    public function index(Request $request)
    {

        $searchText = $request->search_text;

        $usersArr = User::with(array('UserGroup'));


        $usersArr = $usersArr->whereNot('users.user_group_id', '2')->orderBy('users.id', 'desc')->get();

        // load the view and pass the user index
        return view('admin.users.index')->with(compact('usersArr'));
    }

    public function create()
    {


        //get user group list
        $userGroup = UserGroup::orderBy('id')->where('status', '=', 1)->whereNot('id', '=', 2)->pluck('title', 'id')->toArray();
        $data['groupList'] = array('' => '--Select User Group--') + $userGroup;

        $data['status'] = array('1' => 'Active', '0' => 'Inactive');
        return view('admin.users.create', $data);
    }

    public function store(Request $request)
    {
        $rules = array(
            'user_group_id' => 'required',
            'name' => 'required',
            'employee_id' => 'required',
            'password' => 'Required|min:8|Confirmed|complex_password:,' . $request->password,
            'password_confirmation' => 'required',
            'email' => 'required|email|unique:users',
        );

        if ($request->file('photo')) {
            $rules['photo'] = 'max:2048|mimes:jpeg,png,gif,jpg';
        }

        $message = array(
            'user_group_id.required' => 'Group must be selected!',
            'name.required' => 'Please give the name',
            'employee_id.required' => 'Please give the employee id',
            'email.required' => 'Please give the email',
            'email.unique' => 'That email is already taken',
            'password.complex_password' => trans('english.WEAK_PASSWORD_FOLLOW_PASSWORD_INSTRUCTION'),
        );

        $validator = Validator::make($request->all(), $rules, $message);

        if ($validator->fails()) {
            return Redirect::to('admin/users/create')
                ->withErrors($validator)
                ->withInput($request->except(array('password', 'photo', 'password_confirmation')));
        }

        //User photo upload

        $imageUpload = TRUE;
        $imageName = FALSE;
        if ($request->file('photo')) {
            $file = $request->file('photo');
            $destinationPath = public_path() . '/uploads/user/';
            $filename = uniqid() . $file->getClientOriginalName();

            $uploadSuccess = $request->file('photo')->move($destinationPath, $filename);
            if ($uploadSuccess) {
                $imageName = TRUE;
            } else {
                $imageUpload = FALSE;
            }
        }

        if ($imageUpload === FALSE) {
            Session::flash('error', 'Image Could not be uploaded');
            return Redirect::to('admin/users/create')
                ->withInput($request->except(array('photo', 'password', 'password_confirmation')));
        }


        $user = new User;
        $user->user_group_id = $request->user_group_id;
        $user->name = $request->name;
        $user->employee_id = $request->employee_id;
        $user->password = Hash::make($request->password);

        $user->email = $request->email;
        if ($imageName !== FALSE) {
            $user->photo = $filename;
        }
        $user->status = $request->status;

        if ($user->save()) {
            Session::flash('success', $request->name . trans('english.HAS_BEEN_CREATED_SUCCESSFULLY'));
            return Redirect::to('admin/users');
        } else {
            Session::flash('error', $request->name . trans('english.COULD_NOT_BE_CREATED_SUCCESSFULLY'));
            return Redirect::to('admin/users');
        }
    }


    public function edit(Request $request, $id)
    {
        // get the user
        $user = User::find($id);
        $data['user'] = $user;

        //get user group list
        $userGroup = UserGroup::orderBy('id')->where('status', '=', 1)->whereNot('id', '=', 2)->pluck('title', 'id')->toArray();
        $data['groupList'] = array('' => '--Select User Group--') + $userGroup;

        $data['status'] = array('1' => 'Active', '0' => 'Inactive');

        // show the edit form and pass the usere
        return view('admin.users.edit', $data);
    }

    public function update(Request $request, $id)
    {

        // validate
        $rules = array(
            'user_group_id' => 'required',
            'name' => 'required',
            'employee_id' => 'required',
            'password' => 'Required|min:8|Confirmed|complex_password:,' . $request->password,
            'password_confirmation' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
        );

        if ($request->file('photo')) {
            $rules['photo'] = 'max:2048|mimes:jpeg,png,gif,jpg';
        }

        if (!empty($request->password)) {
            $rules['password'] = 'Required|min:8|Confirmed|complex_password:,' . $request->password;
            $rules['password_confirmation'] = 'required';
        }

        $message = array(
            'user_group_id.required' => 'Group must be selected!',
            'name.required' => 'Please give the name',
            'employee_id.required' => 'Please give the employee id',
            'email.required' => 'Please give the email',
            'email.unique' => 'That email is already taken',
            'password.complex_password' => trans('english.WEAK_PASSWORD_FOLLOW_PASSWORD_INSTRUCTION'),
        );

        $validator = Validator::make($request->all(), $rules, $message);

        if ($validator->fails()) {
            return Redirect::to('admin/users/' . $id . '/edit')
                ->withErrors($validator)
                ->withInput($request->except('password', 'password_confirmation', 'photo'));
        }

        //User photo upload
        $imageUpload = TRUE;
        $imageName = FALSE;
        if ($request->file('photo')) {
            $file = $request->file('photo');
            $destinationPath = public_path() . '/uploads/user/';
            $filename = uniqid() . $file->getClientOriginalName();
            $uploadSuccess = $request->file('photo')->move($destinationPath, $filename);
            if ($uploadSuccess) {
                $imageName = TRUE;
            } else {
                $imageUpload = FALSE;
            }
        }

        if ($imageUpload === FALSE) {
            Session::flash('error', 'Image Could not be uploaded');
            return Redirect::to('admin/users/' . $id . '/edit')
                ->withInput($request->except(array('photo', 'password', 'password_confirmation')));
        }

        $password = $request->password;
        // store
        $user = User::find($id);
        if ($imageName !== FALSE) {
            $userExistsOrginalFile = public_path() . '/uploads/user/' . $user->photo;
            if (file_exists($userExistsOrginalFile)) {
                File::delete($userExistsOrginalFile);
            } //if user uploaded success

        } //if file uploaded success


        $user->user_group_id = $request->user_group_id;
        $user->name = $request->name;
        $user->employee_id = $request->employee_id;
        if (!empty($password)) {
            $user->password = Hash::make($password);
        }
        $user->email = $request->email;

        if ($imageName !== FALSE) {
            $user->photo = $filename;
        }
        $user->status = $request->status;

        if ($user->save()) {
            Session::flash('success', $request->name . trans('english.HAS_BEEN_UPDATED_SUCCESSFULLY'));
            return Redirect::to('admin/users');
        } else {
            Session::flash('error', $request->name . trans('english.COULD_NOT_BE_UPDATED'));
            return Redirect::to('admin/users/' . $id . '/edit');
        }
    }

    //User Active/Inactive Function
    public function active($id, $param = null)
    {
        if (Auth::user()->id == $id) {
            Session::flash('error', trans('english.COULD_NOT_BE_UPDATED'));
            return Redirect::to('admin/users');
        }
        $user = User::find($id);

        if ($user->status == '1') {
            $user->status = '0';
            $msgText = $user->name . trans('english.SUCCESSFULLY_INACTIVATE');
        } else {
            $user->status = '1';
            $msgText = $user->name . trans('english.SUCCESSFULLY_ACTIVATE');
        }
        $user->save();
        // redirect
        Session::flash('success', $msgText);
        return Redirect::to('admin/users');
    }

    public function editProfile(Request $request)
    {

        // validate
        $user = User::find(Auth::user()->id);
        $userExistFile = $user->photo;
        $rules = array(
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . Auth::user()->id,
        );

        if ($request->file('photo')) {
            $rules['photo'] = 'max:2048|mimes:jpeg,png,gif,jpg';
        }

        $message = array(
            'name.required' => 'Please give name',
            'email.email' => 'Invalid Email Address',
        );

        $validator = Validator::make($request->all(), $rules, $message);


        if ($validator->fails()) {
            return Redirect::to('admin/users/profile')
                ->withErrors($validator)
                ->withInput($request->except('photo'));
        } else {
            //User photo upload
            $imageUpload = TRUE;
            $imageName = FALSE;
            if ($request->file('photo')) {
                $file = $request->file('photo');
                $destinationPath = public_path() . '/uploads/user/';
                $filename = uniqid() . $file->getClientOriginalName();
                $uploadSuccess = $request->file('photo')->move($destinationPath, $filename);
                if ($uploadSuccess) {
                    $imageName = TRUE;
                } else {
                    $imageUpload = FALSE;
                }


                //delete original image
                if (!empty($user->photo)) {
                    File::delete('public/uploads/user/' . $user->photo);
                }
            }

            if ($imageUpload === FALSE) {
                Session::flash('error', 'Image Could not be uploaded');
                return Redirect::to('admin/users/profile')
                    ->withInput($request->except(array('photo')));
            }

            // store
            $user->name = $request->name;
            $user->email = $request->email;
            //User photo update
            if ($imageName !== FALSE) {
                $user->photo = $filename;

                $userExistsOrginalFile = public_path() . '/uploads/user/' . $userExistFile;
                if (file_exists($userExistsOrginalFile)) {
                    File::delete($userExistsOrginalFile);
                } //if user uploaded success
            }

            if ($user->save()) {
                Session::flash('success', trans('english.PROFILE_UPDATED_SUCCESSFULLY'));
                return Redirect::to('admin/users/profile');
            } else {
                Session::flash('error', trans('english.PROFILE_COULD_NOT_BE_UPDATED'));
                return Redirect::to('admin/users/profile');
            }
        }
    }

    public function destroy($id)
    {

        // delete user table
        $user = User::where('id', '=', $id)->first();
        $userExistsOrginalFile = public_path() . '/uploads/user/' . $user->photo;
        if (file_exists($userExistsOrginalFile)) {
            File::delete($userExistsOrginalFile);
        } //if user uploaded success


        if ($user->delete()) {
            Session::flash('error', $user->name . trans('english.HAS_BEEN_DELETED_SUCCESSFULLY'));
            return Redirect::to('admin/users');
        } else {
            Session::flash('error', $user->name . trans('english.COULD_NOT_BE_DELETED'));
            return Redirect::to('admin/users');
        }
    }
}
