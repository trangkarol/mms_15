<div class="panel panel-primary">
    <div class="panel panel-heading">
        {{ trans('project.lbl-list-member') }}
    </div>
     {{ Form::hidden('projectId', $projectId, ['class' => 'form-control', 'id' => 'projectId-member', 'required' => true]) }}
     {{ Form::hidden('teamId', $teamId, ['class' => 'form-control', 'id' => 'teamId-member', 'required' => true]) }}
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
                                            @php
                                                $position = '';
                                            @endphp

                                            @if ($temUser->positions)
                                                @foreach ($temUser->positions as $positon)
                                                    @php
                                                        $position = $position.$positon->name.' | ';
                                                    @endphp
                                                @endforeach
                                            @endif
                                           {{ $position. ' | ' }}
                                        @endforeach
                                    @endif
                                </td>
                                <td>
                                    {{ Form::radio('leader', $member->id, null, ['class' => 'leader' ]) }}
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
