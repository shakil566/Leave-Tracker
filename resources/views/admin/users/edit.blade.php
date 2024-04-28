@extends('layouts.admin.master')
@section('admin_content')
    <!-- BEGIN CONTENT BODY -->
    <div class="content-wrapper">

        <!-- BEGIN PORTLET-->
        @include('layouts.admin.flash')
        <!-- END PORTLET-->

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>@lang('english.USER')</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">@lang('english.HOME')</a></li>
                        <li class="breadcrumb-item active">@lang('english.USER')</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-8 margin-top-10">
                        <!-- general form elements -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">@lang('english.EDIT_USER')</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            {{ Form::model($user, ['route' => ['users.update', $user->id], 'method' => 'PUT', 'files' => true, 'class' => 'form-horizontal', 'id' => 'userId']) }}

                            <div class="card-body">

                                <div class="form-group">
                                    <label for="userGroupId">@lang('english.SELECT_GROUP')<span class="text-danger"> *</span></label>
                                    {{ Form::select('user_group_id', $groupList, Request::get('user_group_id'), ['class' => 'form-control select2', 'id' => 'userGroupId']) }}
                                    <span class="help-block text-danger">{{ $errors->first('user_group_id') }}</span>
                                </div>
                                <div class="form-group">
                                    <label for="name">@lang('english.NAME')<span class="text-danger"> *</span></label>
                                    {{ Form::text('name', Request::get('name'), ['id' => 'name', 'class' => 'form-control', 'placeholder' => 'Enter First Name']) }}
                                    <span class="help-block text-danger"> {{ $errors->first('name') }}</span>
                                </div>
                                <div class="form-group">
                                    <label for="employeeId">@lang('english.EMPLOYEE_ID')<span class="text-danger"> *</span></label>
                                    {{ Form::text('employee_id', Request::get('employee_id'), ['id' => 'employeeId', 'placeholder' => 'Enter Employee Id', 'class' => 'form-control']) }}
                                    <span class="help-block text-danger"> {{ $errors->first('employee_id') }}</span>
                                </div>
                                <div class="form-group">
                                    <label for="UserPassword">@lang('english.PASSWORD')</label>
                                    {{ Form::password('password', ['id' => 'UserPassword', 'class' => 'form-control', 'placeholder' => 'Password']) }}
                                    <span class="input-group-addon">
                                        <i class="fa fa-key"></i>
                                    </span>
                                    <span class="help-block">{{ trans('english.COMPLEX_PASSWORD_INSTRUCTION') }}</span>
                                    <span class="help-block text-danger"> {{ $errors->first('password') }}</span>
                                </div>

                                <div class="form-group">
                                    <label for="UserPassword">@lang('english.CONFIRM_PASSWORD')</label>
                                    {{ Form::password('password_confirmation', ['id' => 'UserConfirmPassword', 'class' => 'form-control', 'placeholder' => 'Confirm Password']) }}
                                    <span class="input-group-addon">
                                        <i class="fa fa-key"></i>
                                    </span>
                                    <span class="help-block text-danger">
                                        {{ $errors->first('password_confirmation') }}</span>

                                </div>

                                <div class="form-group">
                                    <label for="UserEmail">@lang('english.EMAIL')<span class="text-danger"> *</span></label>

                                    {{ Form::email('email', Request::get('email'), ['id' => 'UserEmail', 'placeholder' => 'Email Address', 'class' => 'form-control']) }}

                                    <span class="help-block text-danger"> {{ $errors->first('email') }}</span>
                                </div>

                                <div class="form-group">
                                    <label for="userStatus">@lang('english.STATUS')</label>
                                    {{ Form::select('status', $status, Request::get('status'), ['class' => 'form-control select2', 'id' => 'userStatus']) }}
                                    <span class="help-block text-danger">{{ $errors->first('status') }}</span>
                                </div>

                                <div class="form-group">
                                    <label for="photo">@lang('english.PHOTO')</label><br>
                                    @if (!empty($user->photo))
                                        <img width="100" height="100" src="{{ URL::to('/') }}/uploads/user/{{ $user->photo }}"
                                            alt="{{ $user->official_name }}">
                                    @else
                                        <img width="100" height="100" src="{{ URL::to('/') }}/img/no_image.png" alt="">
                                    @endif
                                    {{ Form::file('photo', Request::get('photo'), ['class' => 'form-control', 'id' => 'photo', 'files' => 'true']) }}

                                    <span class="help-block text-danger">{{ $errors->first('photo') }}</span>
                                    <div class="clearfix margin-top-10">
                                        <span class="label label-danger">{{ trans('english.NOTE') }}</span>
                                        {{ trans('english.USER_IMAGE_DESCRIPTION') }}
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary float-right"><i class="fas fa-check"></i> @lang('english.SUBMIT')</button>
                                <a href="{{ URL::to('/admin/users') }}" class="btn btn-danger"><i class="fas fa-times"></i> @lang('english.CANCEL')</a>
                            </div>
                            {{ Form::close() }}
                        </div>
                        <!-- /.card -->

                    </div>
                    <!-- /.row -->
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- END CONTENT BODY -->


@stop
