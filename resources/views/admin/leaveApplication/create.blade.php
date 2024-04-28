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
                    <h1>@lang('english.LEAVE_APPLICATION')</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">@lang('english.HOME')</a></li>
                        <li class="breadcrumb-item active">@lang('english.LEAVE_APPLICATION')</li>
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
                            <h3 class="card-title">@lang('english.CREATE_NEW_LEAVE_APPLICATION')</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        {{ Form::open(['role' => 'form', 'url' => 'admin/leaveApplication', 'class' => 'form-horizontal', 'id' => 'createleaveApplication']) }}

                        <div class="card-body">
                            <div class="form-group">
                                <label for="title">@lang('english.TITLE')<span class="text-danger"> *</span></label>
                                {{ Form::text('title', Request::get('title'), ['id' => 'title', 'class' => 'form-control', 'placeholder' => 'Enter Title']) }}
                                <span class="help-block text-danger"> {{ $errors->first('title') }}</span>
                            </div>

                            <div class="form-group">
                                <label for="category">@lang('english.SELECT_LEAVE_CATEGORY')<span class="text-danger"> *</span></label>
                                {{ Form::select('leave_category_id', $category, Request::old('leave_category_id'), array('class' => 'form-control select2', 'id' => 'category')) }}
                                <span class="help-block text-danger">{{ $errors->first('leave_category_id') }}</span>
                            </div>
                            @if(Auth::user()->user_group_id == 1)
                            <div class="form-group">
                                <label for="employee">@lang('english.SELECT_EMPLOYEE')<span class="text-danger"> *</span></label>
                                {{ Form::select('employee_id', $employee, Request::old('employee_id'), array('class' => 'form-control select2', 'id' => 'employee')) }}
                                <span class="help-block text-danger">{{ $errors->first('employee_id') }}</span>
                            </div>
                            @endif
                            <div class="form-group">
                                <label for="startDate">@lang('english.START_DATE')<span class="text-danger"> *</span></label>
                                {{ Form::date('start_date', Request::get('start_date'), ['id' => 'startDate', 'class' => 'form-control']) }}
                                <span class="help-block text-danger"> {{ $errors->first('start_date') }}</span>
                            </div>
                            <div class="form-group">
                                <label for="endDate">@lang('english.END_DATE')<span class="text-danger"> *</span></label>
                                {{ Form::date('end_date', Request::get('end_date'), ['id' => 'endDate', 'class' => 'form-control']) }}
                                <span class="help-block text-danger"> {{ $errors->first('end_date') }}</span>
                            </div>
                            <div class="form-group">
                                <label for="description">@lang('english.REASON')<span class="text-danger"> *</span></label>
                                {{ Form::textarea('description', Request::get('description'), ['id' => 'description', 'rows' => '2', 'class' => 'form-control', 'placeholder' => 'Enter Reason']) }}
                                <span class="help-block text-danger"> {{ $errors->first('description') }}</span>
                            </div>

                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary float-right"><i class="fas fa-check"></i> @lang('english.SUBMIT')</button>
                                <a href="{{ URL::to('/admin/leaveApplication') }}" class="btn btn-danger"><i class="fas fa-times"></i> @lang('english.CANCEL')</a>
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