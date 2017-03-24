<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
    {{ Form::label('name', trans('skill.lbl-name'), ['class' => 'col-md-4 control-label']) }}

    <div class="col-md-6">
        {{ Form::text('name', isset($skill->name) ? $skill->name : null, ['class' => 'form-control',  'id' => 'name', 'required']) }}

        @if ($errors->has('name'))
            <span class="help-block">
                <strong>{{ $errors->first('name') }}</strong>
            </span>
        @endif
    </div>
</div>
