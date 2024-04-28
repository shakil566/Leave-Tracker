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
                <div class="col-12">

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">@lang('english.LEAVE_APPLICATION_DETAILS')</h3>
                            <a href="{{ url('admin/leaveApplication/create') }}" class="btn btn-sm btn-info float-right"><i class="fas fa-plus"></i> @lang('english.CREATE_NEW_LEAVE_APPLICATION')</a>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="dataTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr class="text-center">
                                        <th>@lang('english.SL_NO')</th>
                                        <th>@lang('english.TITLE')</th>
                                        <th>@lang('english.LEAVE_CATEGORY')</th>
                                        @if(Auth::user()->user_group_id == 1)
                                        <th>@lang('english.EMPLOYEE')</th>
                                        @endif
                                        <th>@lang('english.START_DATE')</th>
                                        <th>@lang('english.END_DATE')</th>
                                        <th>@lang('english.REASON')</th>
                                        <th>@lang('english.STATUS')</th>
                                        <th>@lang('english.REMARKS')</th>
                                        <th>@lang('english.ACTION')</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @if (!empty($leaveApplicationArr))
                                    <?php
                                    $sl = 0;
                                    ?>
                                    @foreach ($leaveApplicationArr as $value)
                                    <tr class="text-center">
                                        <td>{{ ++$sl }}</td>
                                        <td>{{ $value->title ?? '' }}</td>
                                        <td>{{ $value->LeaveCategory->title ?? '' }}</td>
                                        @if(Auth::user()->user_group_id == 1)
                                        <td>{{ $value->User->name ?? '' }}</td>
                                        @endif
                                        <td>{{ $value->description ?? '' }}
                                        </td>
                                        <td>{{ $value->start_date ?? '' }}
                                        </td>
                                        <td>{{ $value->end_date ?? '' }}
                                        </td>
                                        
                                        <td>
                                            @if ($value->status == '1')
                                            <span class="badge badge-info">@lang('english.PENDING')</span>
                                            @elseif ($value->status == '2')
                                            <span class="badge badge-success">@lang('english.APPROVED')</span>
                                            @else
                                            <span class="badge badge-danger">@lang('english.REJECTED')</span>
                                            @endif
                                        </td>
                                        <td>{{ $value->remarks ?? '' }}
                                        </td>
                                        <td>
                                            @if(Auth::user()->user_group_id == 1)
                                            <button type="button" class="btn btn-xs btn-info assign-remarks tooltips" data-toggle="modal" title="Modify Leave Application" data-id="{{ $value->id }}" data-project-id="{{ $value->project_id }}" data-target="#AssignRemarksModal">
                                                <i class="fa fa-plus-circle"></i>
                                            </button>
                                            @endif

                                            @if($value->status == '1')
                                            <a class='btn btn-primary btn-xs' href="{{ URL::to('admin/leaveApplication/' . $value->id . '/edit') }}" title="{{ trans('english.EDIT') }}">
                                                <i class='fa fa-edit'></i>
                                            </a>
                                            @endif

                                        </td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr>
                                        <td colspan="15">{{ __('english.EMPTY_DATA') }}</td>
                                    </tr>
                                    @endif

                                </tbody>

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

<!--Assign task modal start-->
<div id="AssignRemarksModal" class="modal assigntask-modal" tabindex="-1" role="basic" aria-hidden="true">
    <div id="ShowModal"></div>
</div>
<!--Assign task modal start-->

<!-- END CONTENT BODY -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

<script type="text/javascript">
    $(document).on('click', '.assign-remarks', function() {
        var leave_id = $(this).attr("data-id");

        $.ajax({
            url: "{{ URL::to('admin/leaveApplication/remarks') }}",
            type: 'POST',
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                leave_id: leave_id,
            },
            beforeSend: function() {},
            success: function(res) {
                $('#ShowModal').html(res.html);
            },
        });
    });

    $(document).on("click", ".saveAssignTask", function() {
        var leave_id = $('#leaveId').val();
        var remarks = $('#remarks').val();
        var status = $('#status').val();
        var options = {
            closeButton: true,
            debug: false,
            positionClass: "toast-bottom-right",
            onclick: null
        };
        $.ajax({
            url: "{{ URL::to('admin/leaveApplication/saveRemarks') }}",
            type: "POST",
            dataType: "json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                leave_id: leave_id,
                remarks: remarks,
                status: status,
            },
            beforeSend: function() {

            },
            success: function(res) {
                toastr.success(res, res.message, options);
                setTimeout(function() {
                    location.reload();
                }, 100)
            },
            error: function(jqXhr, ajaxOptions, thrownError) {
                if (jqXhr.status == 400) {
                    var errorsHtml = '';
                    var errors = jqXhr.responseJSON.message;
                    var i = 0;
                    var firstId = 0
                    $.each(errors, function(key, value) {
                        errorsHtml += '<li>' + value[0] + '</li>';
                        i++;
                    });

                    toastr.error(errorsHtml, jqXhr.responseJSON.heading, options);
                } else {
                    if (jqXhr.status == 401) {
                        toastr.error(jqXhr.responseJSON.message, options);
                    }
                }
            }
        }); //ajax
    });


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