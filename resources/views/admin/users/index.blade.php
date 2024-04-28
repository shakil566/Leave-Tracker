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
                <div class="col-12">

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">@lang('english.USER_DETAILS')</h3>
                            <a href="{{ url('admin/users/create') }}" class="btn btn-sm btn-info float-right"><i class="fas fa-plus"></i> @lang('english.CREATE_NEW')</a>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="dataTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr class="text-center">
                                        <th>@lang('english.SL_NO')</th>
                                        <th>@lang('english.USER_GROUP')</th>
                                        <th>@lang('english.NAME')</th>
                                        <th>@lang('english.PHOTO')</th>
                                        <th>@lang('english.EMPLOYEE_ID')</th>
                                        <th>@lang('english.EMAIL')</th>
                                        <th>@lang('english.STATUS')</th>
                                        <th>@lang('english.ACTION')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (!empty($usersArr))
                                    <?php
                                    $sl = 0;
                                    ?>
                                    @foreach ($usersArr as $value)
                                    <tr class="text-center">
                                        <td>{{ ++$sl }}</td>
                                        <td>{{$value->UserGroup->title}}</td>
                                        <td>{{ $value->name }}</td>
                                        <td class="text-center">
                                            @if(isset($value->photo))
                                            <img width="100" height="100" src="{{URL::to('/')}}/uploads/user/{{$value->photo}}" alt="{{ $value->first_name.' '.$value->last_name }}">
                                            @else
                                            <img width="100" height="100" src="{{URL::to('/')}}/img/unknown.png" alt="{{ $value->first_name.' '.$value->last_name }}">
                                            @endif
                                        </td>
                                        <td>{{ $value->employee_id }}</td>
                                        <td>{{ $value->email }}</td>

                                        <td>
                                            @if ($value->status == '1')
                                            <span class="badge badge-success">@lang('english.ACTIVE')</span>
                                            @else
                                            <span class="badge badge-danger">@lang('english.INACTIVE')</span>
                                            @endif
                                        </td>

                                        <td>
                                            {{ Form::open(array('url' => 'admin/users/' . $value->id, 'id' => 'delete')) }}
                                            {{ Form::hidden('_method', 'DELETE') }}

                                            <a class='btn btn-info btn-xs tooltips' href="{{ URL::to('admin/users/activate/' . $value->id ) }}" data-rel="tooltip" title="@if($value->status == '1') Click here to Inactivate @else Click here to Activate @endif" data-container="body" data-trigger="hover" data-placement="top">
                                                @if($value->status == '1')
                                                <i class='fa fa-times'></i>
                                                @else
                                                <i class='fa fa-check-circle'></i>
                                                @endif
                                            </a>
                                            <a class='btn btn-primary btn-xs tooltips' href="{{ URL::to('admin/users/' . $value->id . '/edit') }}" title="Edit User" data-container="body" data-trigger="hover" data-placement="top">
                                                <i class='fa fa-edit'></i>
                                            </a>

                                            @if(Auth::user()->id != $value->id)
                                            <button class="btn btn-danger btn-xs tooltips" type="submit" title="Delete" data-placement="top" data-rel="tooltip" data-original-title="Delete">
                                                <i class='fa fa-trash'></i>
                                            </button>
                                            @endif
                                            {{ Form::close() }}
                                        </td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr>
                                        <td colspan="15">{{ __('english.EMPTY_DATA') }}</td>
                                    </tr>
                                    @endif

                                </tbody>
                                {{-- <tfoot>
                                        <tr>

                                        </tr>
                                    </tfoot> --}}
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->

</div>
<!-- END CONTENT BODY -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

<script type="text/javascript">
    $(function() {
        $("#dataTable").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
        }).buttons().container().appendTo('#dataTable_wrapper .col-md-6:eq(0)');
        $('#example2').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
        });
    });


    $(document).on('click', '#getStudentInfo', function(e) {
        e.preventDefault();
        var userId = $(this).data('id'); // get id of clicked row

        $('#dynamic-content').html(''); // leave this div blank
        $.ajax({
            url: "{{ URL::to('ajaxresponse/user-info') }}",
            type: "GET",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                user_id: userId
            },
            cache: false,
            contentType: false,
            success: function(response) {
                $('#dynamic-content').html(''); // blank before load.
                $('#dynamic-content').html(response.html); // load here
                $('.date-picker').datepicker({
                    autoclose: true
                });
            },
            error: function(jqXhr, ajaxOptions, thrownError) {
                $('#dynamic-content').html('<i class="fa fa-info-sign"></i> Something went wrong, Please try again...');
            }
        });
    });

    $(document).on("submit", '#delete', function(e) {
        //This function use for sweetalert confirm message
        e.preventDefault();
        var form = this;
        Swal.fire({
            title: 'Do you want to Delete?',
            // showDenyButton: true,
            showCancelButton: true,
            confirmButtonText: `DELETE`,
            // denyButtonText: `Don't DELETE`,
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                // Swal.fire('Deleted!', '', 'success')
                form.submit();
            } else if (result.isDenied) {
                // Swal.fire('Not Deleted', '', 'info')
            }
        })
    });
</script>
@stop