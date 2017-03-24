<div class="panel panel-body">
    <div class="form-group{{ $errors->has('team') ? ' has-error' : '' }}">
        {{ Form::label('team', trans('user.lbl-team'), ['class' => 'col-md-3 control-label']) }}
        <div class="col-md-6">
            {{ Form::select('team', $teams, null, ['class' => 'form-control team']) }}
        </div>
    </div>

    <div class="panel panel-body result-members">

    </div>
</div>
