<!-- content -->
<div class="row">
    <div class="col-md-12 paddingtop">
        <div class="panel panel-primary ">
            <div class="panel-heading"> {{ trans('public.lbl-profile') }} <strong>{{ $user->name }}</strong> </div>
            <div class="panel-body">
                <div class="col-md-7 col-md-offset-2">
                    <div class="row">
                        {{ Form::label('name', trans('user.lbl-name'), ['class' => 'col-md-4 control-label']) }}
                        {{ Form::label('name', $user->name, ['class' => 'col-md-8']) }}
                    </div>

                     <div class="row">
                        {{ Form::label('email', trans('user.lbl-email'), ['class' => 'col-md-4 control-label']) }}
                        {{ Form::label('email', $user->email, ['class' => 'col-md-4']) }}
                    </div>

                    <div class="row">
                        {{ Form::label('name', trans('user.lbl-birthday'), ['class' => 'col-md-4 control-label']) }}
                        {{ Form::label('name', $user->birthday, ['class' => 'col-md-4']) }}
                    </div>
                    @php
                        $position = '';
                        if(!is_null($user->position)) {
                             $position = $user->position->name;
                        }
                    @endphp
                    <div class="row">
                        {{ Form::label('position', trans('user.lbl-position'), ['class' => 'col-md-4 control-label']) }}
                        {{ Form::label('name', $position , ['class' => 'col-md-4']) }}
                    </div>
                </div>
            </div>

            <!-- skill-->
            <div class="panel-body">
                     {{ Form::label('name', trans('user.lbl-skill'), ['class' => 'col-md-2 control-label']) }}
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th >{{ trans('admin.lbl-stt') }}</th>
                                <th >{{ trans('public.lbl-name') }}</th>
                                <th >{{ trans('public.lbl-level') }}</th>
                                <th >{{ trans('public.lbl-experiensive') }}</th>
                            </tr>
                        </thead>

                        <tbody>
                        @foreach ($user->skills as $skill)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $skill->name }}</td>
                                <td>
                                    @if($skill->level == config('setting.level.senior'))
                                        {{ trans('public.lbl-senior') }}
                                    @else
                                         {{ trans('public.lbl-junior') }}
                                    @endif
                                </td>
                                <td>{{ $skill->pivot->experiensive }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

           <!-- current team -->
            <div class="panel-body">
                {{ Form::label('name', trans('public.lbl-team'), ['class' => 'col-md-2 control-label']) }}
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th >{{ trans('admin.lbl-stt') }}</th>
                                <th >{{ trans('public.lbl-name') }}</th>
                                <th >{{ trans('public.lbl-position') }}</th>
                            </tr>
                        </thead>

                        <tbody>
                        @foreach ($teamUsers as $teamUser)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $teamUser->team->name }}</td>
                                <td>
                                    @foreach($teamUser->positions as $position)
                                        {{ $position->name }}
                                    @endforeach
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- project joined -->
            <div class="panel-body">
                {{ Form::label('name', trans('public.lbl-project'), ['class' => 'col-md-2 control-label']) }}
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th >{{ trans('admin.lbl-stt') }}</th>
                                <th >{{ trans('public.lbl-name') }}</th>
                                <th >{{ trans('public.lbl-leader') }}</th>
                                <th >{{ trans('public.lbl-team') }}</th>
                            </tr>
                        </thead>

                        <tbody>
                        @foreach ($projects as $project)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $project->project->name }}</td>
                                <td>
                                    @if($project->is_leader == config('setting.is_leader.leader'))
                                        have
                                    @endif
                                </td>
                                <td>
                                   {{ $project->teamUser->team->name }}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
