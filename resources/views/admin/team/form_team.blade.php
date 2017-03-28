<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
    {{ Form::label('name', trans('team.lbl-name'), ['class' => 'col-md-4 control-label']) }}

    <div class="col-md-6">
        {{ Form::email('name', isset($team->name) ? $team->name : null, ['class' => 'form-control',  'id' => 'name', 'required']) }}

        @if ($errors->has('name'))
            <span class="help-block">
                <strong>{{ $errors->first('name') }}</strong>
            </span>
        @endif
    </div>
</div>

<div class="form-group{{ $errors->has('leader') ? ' has-error' : '' }}">
    {{ Form::label('leader', trans('team.lbl-leader'), ['class' => 'col-md-4 control-label']) }}
    <div class="col-md-6">
        {{ Form::select('leader', $leader, isset($team->leader->id) ? $team->leader->id : null, ['class' => 'form-control', 'id' => 'role']) }}

        @if ($errors->has('leader'))
            <span class="help-block">
                <strong>{{ $errors->first('leader') }}</strong>
            </span>
        @endif
    </div>
</div>
