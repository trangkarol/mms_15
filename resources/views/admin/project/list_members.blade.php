<div class="panel panel-primary">
    <div class="panel panel-heading">
        {{ trans('project.lbl-list-member') }}
    </div>
     {{ Form::hidden('projectId', $projectId, ['class' => 'form-control', 'id' => 'projectId-member', 'required' => true]) }}
     {{ Form::hidden('teamId', $teamId, ['class' => 'form-control', 'id' => 'teamId-member', 'required' => true]) }}
    <div class="panel panel-body">
        <div class="col-md-12">
            <div class="col-md-6">
                {{ Form::label('member', trans('project.lbl-members'), ['class' => 'col-md-4 control-label']) }}
            </div>
            @foreach ($userTeams as $userTeam)

                @if(in_array($userTeam->user->id, $arrMember))
                    <div class="col-md-6">
                        {{ Form::checkbox('users[]', $userTeam->user->id, true, ['class' => 'users' ]) }} {{ $userTeam->user->name }}
                    </div>
                @else
                    <div class="col-md-6">
                        {{ Form::checkbox('users[]', $userTeam->user->id, null, ['class' => 'users' ]) }} {{ $userTeam->user->name }}
                    </div>
                @endif
            @endforeach
        </div>

        <div class="form-group">
            {{ Form::label('leader', trans('project.lbl-leader'), ['class' => 'col-md-4 control-label']) }}
            <div class="col-md-6">
                {{ Form::select('leader', $members, null, ['class' => 'form-control', 'id' => 'leader']) }}
            </div>
         </div>

        <div class="row">
            <div class="col-md-3 col-md-offset-8">
                @if($flag == 1)
                    {{ Form::button(trans('admin.btn-add'), ['class' => 'btn btn-primary', 'id' => 'btn-add']) }}
                @else
                    {{ Form::button(trans('admin.btn-edit'), ['class' => 'btn btn-primary', 'id' => 'btn-update']) }}
                @endif
            </div>
        </div>
    </div>
</div>
