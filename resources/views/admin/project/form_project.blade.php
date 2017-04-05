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
    </div>
</div>

<div class="form-group{{ $errors->has('end_day') ? ' has-error' : '' }}">
    {{ Form::label('end_day', trans('project.lbl-end-day'), ['class' => 'col-md-4 control-label']) }}
    <div class="col-md-6">
        {{ Form::date('end_day', isset($project->end_day) ? $project->end_day : old('end_day'), ['class' => 'form-control', 'id' => 'end_day', 'required' => true]) }}
    </div>
</div>
@if (isset($project))
    {{ Form::hidden('projectId', $project->id, ['class' => 'form-control', 'id' => 'projectId', 'required' => true]) }}
    <div class="form-group ">
        {{ Form::label('team', trans('project.lbl-team'), ['class' => 'col-md-4 control-label']) }}
        <div class="col-md-6 table-result">
            @foreach ($teams as $team)
                @if (!in_array($loop->iteration, $teamIds))
                    <div class="col-md-6">
                        {{ Form::checkbox('teams[]', $loop->iteration, null, ['class' => 'team', 'id' => 'team']) }} {{ $team }}
                    </div>
                @endif
            @endforeach
        </div>
    </div>
    <!-- list team -->
    <div class="panel panel-primary">
        <div class="panel panel-heading">
            {{ trans('project.lbl-team') }}
        </div>
        <div class="panel panel-body">
            <div class="col-md-12">
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th class="hidden"></th>
                    <th >{{ trans('team.lbl-stt') }}</th>
                    <th >{{ trans('team.lbl-team') }}</th>
                    <th ></th>
                </tr>
            </thead>
            <tbody>
            @if (isset($listTeams))
                @foreach ($listTeams as $listTeam)
                    <tr>
                        <td class="hidden teamMemberId">{{ $listTeam->id }}</td>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            @php $members = ''; @endphp
                            @foreach ($listTeam->users as $user)
                                @php $members = $members . $user->name . ' | '; @endphp
                                {{ Form::hidden('members[]', $user->id, ['class' => 'form-control members']) }}
                            @endforeach
                            <a href="#" data-toggle="tooltip" data-placement="top" title="{{ rtrim($members, ' | ') }}">{{ $listTeam->name }}</a>
                        </td>
                        <td>
                            <div class="col-md-6">
                                {!! Form::button(trans('admin.lbl-edit'), ['class' => 'btn btn-primary btn-edit-team', 'id' => '']) !!}
                            </div>
                            <div class="col-md-6">
                                {!! Form::button(trans('admin.lbl-delete'), ['class' => 'btn btn-primary btn-delete-team', 'id' => '']) !!}
                            </div>
                        </td>
                    </tr>
                @endforeach
            @endif
            </tbody>
        </table>
    </div>
</div>
        </div>
    </div>
@endif
