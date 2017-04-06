<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
      {{ Form::label('name', trans('project.lbl-name'), ['class' => 'col-md-4 control-label']) }}
    <div class="col-md-6">
        {{ Form::text('name', isset($project->name) ? $project->name : old('name'), ['class' => 'form-control', 'id' => 'name', 'required' => true, 'autofocus' => true]) }}

        @if ($errors->has('name'))
            <span class="help-block">
                <strong>{{ $errors->first('name') }}</strong>
            </span>
        @endif
    </div>
</div>

<div class="form-group{{ $errors->has('short_name') ? ' has-error' : '' }}">
    {{ Form::label('short_name', trans('project.lbl-short-name'), ['class' => 'col-md-4 control-label']) }}

    <div class="col-md-6">
        {{ Form::text('short_name', isset($project->short_name) ? $project->short_name : old('short_name'), ['class' => 'form-control',  'id' => 'email', 'required' => true]) }}

        @if ($errors->has('short_name'))
            <span class="help-block">
                <strong>{{ $errors->first('short_name') }}</strong>
            </span>
        @endif
    </div>
</div>

<div class="form-group{{ $errors->has('start_day') ? ' has-error' : '' }}">
    {{ Form::label('start_day', trans('project.lbl-start-day'), ['class' => 'col-md-4 control-label']) }}
    <div class="col-md-6">
        {{ Form::date('start_day', isset($project->start_day) ? $project->start_day : old('start_day'), ['class' => 'form-control', 'id' => 'start_day', 'required' => true]) }}
        {{ Form::hidden('index', 1, ['id' => 'index']) }}
    </div>

    @if ($errors->has('start_day'))
        <span class="help-block">
            <strong>{{ $errors->first('start_day') }}</strong>
        </span>
    @endif
</div>

<div class="form-group{{ $errors->has('end_day') ? ' has-error' : '' }}">
    {{ Form::label('end_day', trans('project.lbl-end-day'), ['class' => 'col-md-4 control-label']) }}
    <div class="col-md-6">
        {{ Form::date('end_day', isset($project->end_day) ? $project->end_day : old('end_day'), ['class' => 'form-control', 'id' => 'end_day', 'required' => true]) }}
    </div>

    @if ($errors->has('end_day'))
        <span class="help-block">
            <strong>{{ $errors->first('end_day') }}</strong>
        </span>
    @endif
</div>

@if(isset($project))
    {{ Form::hidden('projectId', $project->id, ['class' => 'form-control', 'id' => 'projectId', 'required' => true]) }}
    <div class="form-group ">
        {{ Form::label('team', trans('project.lbl-team'), ['class' => 'col-md-4 control-label']) }}
        <div class="col-md-6 table-result">
            @foreach ($teams as $key => $team)
                @if(!in_array($key, $arrTeam))
                    <div class="col-md-6">
                        {{ Form::checkbox('teams[]', $key, null, ['class' => 'team', 'id' => 'team']) }} {{ $team }}
                    </div>
                @endif
            @endforeach
        </div>
    </div>
@endif
