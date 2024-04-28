<div class="modal-lg modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Modify Leave Application</h4>
            <button type="button" class="close text-danger" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="form-group">
                {{ Form::hidden('leave_id', $leaveId, ['id' => 'leaveId']) }}
                <label for="remarks">@lang('english.REMARKS')<span class="text-danger"> *</span></label>
                {{ Form::textarea('remarks', $data->remarks ?? null, ['id' => 'remarks', 'rows' => '2', 'class' => 'form-control', 'placeholder' => '']) }}
                <span class="help-block text-danger"> {{ $errors->first('remarks') }}</span>
            </div>
            <div class="form-group">
                <label for="statusId">@lang('english.STATUS')<span class="text-danger"> *</span></label>
                {!! Form::select('status', ['2' => __('english.APPROVE'), '3' => __('english.REJECT')], $data->status ?? 2, [
                'class' => 'form-control select2',
                'id' => 'status',
                ]) !!}
                <span class="help-block text-danger">{{ $errors->first('status') }}</span>
            </div>
        </div>
        <div class="modal-footer justify-content-between bg-secondary">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary saveAssignTask">Submit</button>
        </div>
    </div>


    <script>
        $(function() {
            //Initialize Select2 Elements
            $('.select2').select2()
        });
    </script>