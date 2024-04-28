@extends('layouts.admin.master')

@section('admin_content')
<div class="register-page">
    <div class="register-box">
        <!-- /.register-logo -->
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="#" class="h1"><b>@lang('english.PROJECT_TITLE')</b></a>
            </div>
            <div class="card-body">
                <p class="register-box-msg">@lang('english.REGISTER')</p>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="row mb-3">
                        <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>
                        
                        <div class="col-md-6">
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}">
                            
                            <span class="help-block text-danger"> {{ $errors->first('name') }}</span>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="employeeId" class="col-md-4 col-form-label text-md-end">@lang('english.EMPLOYEE_ID')</label>
                        
                        <div class="col-md-6">
                            <input id="employeeId" type="text" class="form-control @error('employee_id') is-invalid @enderror" name="employee_id" value="{{ old('employee_id') }}">
                            <span class="help-block text-danger"> {{ $errors->first('employee_id') }}</span>

                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>
                        
                        <div class="col-md-6">
                            <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}">
                            <span class="help-block text-danger"> {{ $errors->first('email') }}</span>

                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>
                        
                        <div class="col-md-6">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" value="{{ old('password') }}" autocomplete="new-password">
                            <span class="help-block text-danger"> {{ $errors->first('password') }}</span>

                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>
                        
                        <div class="col-md-6">
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" value="{{ old('password_confirmation') }}" autocomplete="new-password">
                            <span class="help-block text-danger"> {{ $errors->first('password_confirmation') }}</span>
                        </div>
                    </div>

                    <div class="row mb-0">
                        <div class="col-md-6 offset-md-5">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Register') }}
                            </button>
                        </div>
                    </div>
                    <div class="row mb-0">
                        <div class="col-md-6 offset-md-4">

                            <p class="mb-0">
                                <a href="{{ route('login') }}" class="text-center">Already have account? Login now</a>
                            </p>
                        </div>
                    </div>
                </form>

            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
</div>
@endsection