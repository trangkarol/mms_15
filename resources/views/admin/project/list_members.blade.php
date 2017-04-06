<div class="panel panel-primary">
    <div class="panel panel-heading">
        {{ trans('project.lbl-list-member') }}
    </div>
     {{ Form::hidden('projectId', $projectId, ['class' => 'form-control', 'id' => 'projectId-member']) }}
     {{ Form::hidden('teamId', $teamId, ['class' => 'form-control', 'id' => 'teamId-member']) }}
     {{ Form::hidden('flag', $flag, ['class' => 'form-control', 'id' => 'flag']) }}
    <div class="panel panel-body">
            <div class="row">
                {{ Form::label('skill', trans('team.lbl-skill'), ['class' => 'col-md-3 control-label']) }}
                <div class="col-md-6 table-result">
                    @foreach ($skills as $key => $skill)
                        <div class="col-md-6">
                            {{ Form::checkbox('skills[]', $key, null, ['class' => 'skills' ]) }} {{ $skill }}
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="row div-level">
                {{ Form::label('levels', trans('team.lbl-levels'), ['class' => 'col-md-3 control-label']) }}
                <div class="col-md-6">
                    <div class="col-md-5">
                        {{ Form::checkbox('levels[]', config('setting.level.junior'), null, ['class' => 'levels']) }} {{ trans('team.lbl-junior') }}
                    </div>

                    <div class="col-md-5">
                        {{ Form::checkbox('levels[]', config('setting.level.senior'), null, ['class' => 'levels'] ) }} {{ trans('team.lbl-senior') }}
                    </div>

                </div>
            </div>

            <div class="row div-level">
                {{ Form::label('levels', trans('team.lbl-position'), ['class' => 'col-md-3 control-label']) }}
                <div class="col-md-6">
                    {{ Form::select('position_team', $positionTeam, null, ['class' => 'form-control search', 'id' => 'position-team']) }}
                </div>
            </div>

            <div class="row">
                <div class="col-md-3 col-md-offset-8">
                    {{ Form::button(trans('admin.lbl-search'), ['class' => 'btn btn-primary', 'id' => 'btn-search-member']) }}
                </div>
            </div>
        </div>
        <div class="row " id="result-members">

        </div>
        <div class="row">
            <span class="help-block has-error">
                <strong class="err-leader"></strong>
            </span>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-3 col-md-offset-8">
                    {{ Form::button(($flag) ? trans('admin.btn-add') : trans('admin.btn-edit'), ['class' => 'btn btn-primary', 'id' => ($flag) ? 'btn-add-member' : 'btn-update-member']) }}
                </div>
            </div>
        </div>
        <div class="row ">
             <div class="panel panel-default">
                <div class="panel panel-heading">
                     {{ trans('admin.lbl-result-search') }}
                </div>

                <div class="panel panel-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>{{ trans('admin.lbl-stt') }}</th>
                                    <th>{{ trans('user.lbl-name') }}</th>
                                    <th>{{ trans('user.lbl-position') }}</th>
                                    <th>{{ trans('user.lbl-position_team') }}</th>
                                    <th>{{ trans('project.lbl-leader')}}</th>
                                    <th> </th>

                                </tr>
                            </thead>
                            <tbody>
                                @if (!empty($members))
                                    @foreach ($members as $member)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td><a href="{{ action('Member\HomeController@detailMember', $member->id) }}">{{ $member->name }}</a></td>
                                            <td> @if ($member->position) {{ $member->position->name }} @endif</td>
                                            <!-- <td>  </td>-->
                                            <td>
                                                @if ($member->teamUsers)
                                                    @foreach ($member->teamUsers as $temUser)
                                                        @if ($temUser->positions)
                                                            @php
                                                                $position = '';
                                                            @endphp
                                                            @foreach ($temUser->positions as $positon)

                                                                @php
                                                                    $position .= $positon->name.' | ';
                                                                @endphp
                                                            @endforeach
                                                        @endif
                                                    @endforeach
                                                @endif
                                               {{ $position }}
                                            </td>
                                            <td>
                                                @php $index = 1; @endphp
                                                @foreach ($member->teamUsers as $team_user)
                                                    @foreach ($team_user->projects as $project)
                                                        @if($index == 1)
                                                            @php $index = $index + 1; @endphp
                                                            {{ Form::radio('leader', $member->id, ($project->pivot->is_leader) ? true : false , ['class' => 'leader' ]) }}
                                                        @endif
                                                    @endforeach
                                                @endforeach
                                            </td>
                                            <td>
                                                <div class="col-md-6">
                                                    {{ Form::checkbox('add_user[]', $member->id, true, ['class' => 'add_user' ]) }}
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
