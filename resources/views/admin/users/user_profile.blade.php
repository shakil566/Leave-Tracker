@extends('layouts.admin.master')
@section('admin_content')
    <!-- BEGIN CONTENT BODY -->
    <div class="content-wrapper">

        <!-- BEGIN PORTLET-->
        @include('layouts.admin.flash')
        <!-- END PORTLET-->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-8 margin-top-10">
                        <!-- general form elements -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">@lang('english.UPDATE_PROFILE')</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            {{ Form::open(array('role' => 'form', 'url' => 'admin/users/editProfile', 'files'=> true, 'class' => 'form-horizontal', 'id' => 'edit-profile')) }}

                            <div class="card-body">


                                <div class="form-group">
                                    <label for="name">@lang('english.NAME')<span class="text-danger"> *</span></label>
                                    {{ Form::text('name', Auth::user()->name, ['id' => 'name', 'class' => 'form-control', 'placeholder' => 'Enter Name']) }}
                                    <span class="help-block text-danger"> {{ $errors->first('name') }}</span>
                                </div>
                                <div class="form-group">
                                    <label for="email">@lang('english.EMAIL')<span class="text-danger"> *</span></label>
                                    {{ Form::text('email', Auth::user()->email, ['id' => 'email', 'class' => 'form-control', 'placeholder' => 'Enter Official Name']) }}
                                    <span class="help-block text-danger"> {{ $errors->first('email') }}</span>
                                </div>

                                <div class="form-group">
                                    <label for="photo">@lang('english.PHOTO')</label><br>
                                    @if (!empty(Auth::user()->photo))
                                        <img width="100" height="100" src="{{ URL::to('/') }}/uploads/user/{{Auth::user()->photo}}"
                                            alt="{{Auth::user()->name}}">
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
                                <a href="{{ URL::to('/dashboard') }}" class="btn btn-danger"><i class="fas fa-times"></i> @lang('english.CANCEL')</a>
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
