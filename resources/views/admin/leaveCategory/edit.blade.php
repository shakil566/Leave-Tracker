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
                    <h1>@lang('english.LEAVE_CATEGORY')</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">@lang('english.HOME')</a></li>
                        <li class="breadcrumb-item active">@lang('english.LEAVE_CATEGORY')</li>
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
                            <h3 class="card-title">@lang('english.UPDATE_LEAVE_CATEGORY')</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        {{ Form::model($leaveCategory, array('route' => array('leaveCategory.update', $leaveCategory->id), 'method' => 'PATCH', 'class' => 'form-horizontal', 'id' => 'leaveCategoryEditForm')) }}

                        <div class="card-body">
                            <div class="form-group">
                                <label for="title">@lang('english.TITLE')<span class="text-danger"> *</span></label>
                                {{ Form::text('title', Request::get('title'), ['id' => 'title', 'class' => 'form-control', 'placeholder' => 'Enter Project Name']) }}
                                <span class="help-block text-danger"> {{ $errors->first('title') }}</span>
                            </div>
                            <div class="form-group">
                                <label for="description">@lang('english.DESCRIPTION')<span class="text-danger"> *</span></label>
                                {{ Form::textarea('description', Request::get('description'), ['id' => 'description', 'rows' => '2', 'class' => 'form-control', 'placeholder' => 'Enter Task Description']) }}
                                <span class="help-block text-danger"> {{ $errors->first('description') }}</span>
                            </div>

                            <div class="form-group">
                                <label for="statusId">@lang('english.STATUS')</label>
                                {!! Form::select('status', ['1' => __('english.ACTIVE'), '2' => __('english.INACTIVE')], Request::get('status'), [
                                'class' => 'form-control select2',
                                'id' => 'statusId',
                                ]) !!}
                                <span class="help-block text-danger">{{ $errors->first('status') }}</span>
                            </div>
                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary float-right"><i class="fas fa-check"></i> @lang('english.SUBMIT')</button>
                            <a href="{{ URL::to('/admin/leaveCategory') }}" class="btn btn-danger"><i class="fas fa-times"></i> @lang('english.CANCEL')</a>
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