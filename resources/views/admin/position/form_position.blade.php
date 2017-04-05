<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
    {{ Form::label('name', trans('position.lbl-name'), ['class' => 'col-md-4 control-label']) }}
    <div class="col-md-6">
        {{ Form::text('name', isset($position->name) ? $position->name : null, ['class' => 'form-control',  'id' => 'name', 'required']) }}
        @if ($errors->has('name'))
            <span class="help-block">
                <strong>{{ $errors->first('name') }}</strong>
            </span>
        @endif
    </div>
</div>

<div class="form-group{{ $errors->has('short_name') ? ' has-error' : '' }}">
    {{ Form::label('leader', trans('position.lbl-short-name'), ['class' => 'col-md-4 control-label']) }}
    <div class="col-md-6">
       {{ Form::text('short_name', isset($position->short_name) ? $position->short_name : null, ['class' => 'form-control',  'id' => 'name', 'required']) }}

        @if ($errors->has('short_name'))
            <span class="help-block">
                <strong>{{ $errors->first('short_name') }}</strong>
            </span>
        @endif
    </div>
</div>

<div class="form-group{{ $errors->has('type_position') ? ' has-error' : '' }}">
    {{ Form::label('type_position', trans('position.lbl-type-position'), ['class' => 'col-md-4 control-label']) }}
    <div class="col-md-6">
        {{ Form::select('type_position', $type_position, isset($position->type_position) ? $position->type_position : null, ['class' => 'form-control', 'id' => 'role']) }}

        @if ($errors->has('type_position'))
            <span class="help-block">
                <strong>{{ $errors->first('type_position') }}</strong>
            </span>
        @endif
    </div>
</div>
