<div class="panel panel-primary">
    <div class="panel-heading">
        {{ trans ('team.lbl-insert-position') }}
    </div>

    <div class="panel-body">
        {!! Form::open (['class' => 'form-horizontal']) !!}
            {{ Form::hidden ('teamId', $teamId, ['id' => 'teamId-postion']) }}
            {{ Form::hidden ('userId', $userId, ['id' => 'userId-postion']) }}

            <div class="col-md-12">
                @foreach ($positions as $position)
                    <div class="col-md-6">
                        {{ Form::checkbox('position[]', $loop->iteration, in_array($loop->iteration, $arrPosition), ['class' => 'position' ]) }} {{ $position }}
                    </div>
                @endforeach
            </div>

            <div class="row">
                <div class="col-md-3 col-md-offset-8">
                    {{ Form::button( $teamUser ? trans('admin.btn-edit') : trans('admin.btn-add'), ['class' => 'btn btn-primary', 'id' => 'btn-add']) }}
                </div>
            </div>
        {{ Form::close() }}
    </div>
</div>
