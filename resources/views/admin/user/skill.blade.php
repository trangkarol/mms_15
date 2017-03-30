<div class="panel panel-primary">
    <div class="panel panel-heading">
        {{ trans('user.lbl-skill') }}
    </div>
    <div class ="panel panel-body">
        {!! Form::open(['class' => 'form-horizontal']) !!}
            {{ Form::hidden('skillId', $skillId, ['id' => 'skillId-skill']) }}
            {{ Form::hidden('userId', $userId, ['id' => 'userId-skill']) }}
            <div class="col-cd-12">
                {{ Form::label('level', trans('user.lbl-level'), ['class' => 'col-md-4 control-label']) }}
                <div class="col-md-6">
                    {{ Form::select('level', $levels, isset($userSkill->level) ? $userSkill->level : null, ['class' => 'form-control level']) }}
                </div>
            </div>

            <div class="col-cd-12">
                {{ Form::label('exper', trans('user.lbl-experiensive'), ['class' => 'col-md-4 control-label']) }}
                <div class="col-md-6">
                    {{ Form::textarea('exeper', isset($userSkill->level) ? $userSkill->experiensive : null, ['class' => 'form-control exeper']) }}
                </div>
            </div>

            <div class="row">
                <div class="col-md-3 col-md-offset-8">
                    @if($flag == 1)
                        {{ Form::button(trans('admin.btn-add'), ['class' => 'btn btn-primary', 'id' => 'btn-add-skill']) }}
                    @endif

                    @if($flag == 0)
                        {{ Form::button(trans('admin.btn-edit'), ['class' => 'btn btn-primary ', 'id' => 'btn-update-skill']) }}
                    @endif

                    @if($flag == 2)
                        {{ Form::button(trans('admin.btn-delete'), ['class' => 'btn btn-primary ', 'id' => 'btn-delete-skill']) }}
                    @endif
                </div>
            </div>
        {{ Form::close() }}
    </div>
</div>
