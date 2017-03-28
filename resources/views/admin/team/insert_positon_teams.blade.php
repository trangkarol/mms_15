<div class="panel panel-primary">
    <div class="panel-heading">
        {{ trans('team.lbl-insert-position') }}
    </div>

    <div class="panel-body">
        {!! Form::open(['class' => 'form-horizontal']) !!}
            {{ Form::hidden('teamId', $teamId, ['id' => 'teamId-postion']) }}
            {{ Form::hidden('userId', $userId, ['id' => 'userId-postion']) }}

            <div class="col-md-12">
                @foreach ($positions as $key => $position)
                    <div class="col-md-6">
                        @if(in_array($key, $arrPosition))
                            {{ Form::checkbox('position[]', $key, true, ['class' => 'position' ]) }} {{ $position }}
                        @else
                            {{ Form::checkbox('position[]', $key, null, ['class' => 'position' ]) }} {{ $position }}
                        @endif
                    </div>
                @endforeach
            </div>

            <div class="row">
                <div class="col-md-3 col-md-offset-8">
                    @if(empty($teamUser))
                        {{ Form::button(trans('admin.btn-add'), ['class' => 'btn btn-primary', 'id' => 'btn-add']) }}
                    @else
                        {{ Form::button(trans('admin.btn-edit'), ['class' => 'btn btn-primary', 'id' => 'btn-update']) }}
                    @endif
                </div>
            </div>
        {{ Form::close() }}
    </div>
</div>
