<div class="panel panel-primary">
    <div class="panel-heading">
        {{ trans('team.lbl-insert-position') }}
    </div>
    <div class="panel-body">
        {!! Form::open(['class' => 'form-horizontal']) !!}
            {{ Form::hidden('teamId', $teamId, ['id' => 'teamId-postion']) }}
            {{ Form::hidden('userId', $userId, ['id' => 'userId-postion']) }}
            <div class="panel-body">
                <div class="col-md-12">
                    {{ trans('team.lbl-position') }}
                </div>
                <div class="col-md-12">
                    @foreach ($positions as $position)
                        <div class="col-md-6">
                            {{ Form::checkbox('position[]', $loop->iteration, in_array($loop->iteration, $arrPosition), ['class' => 'position' ]) }} {{ $position }}
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 col-md-offset-8">
                    @php $nameButton = trans('admin.btn-add'); @endphp
                    @if($flag == 1)
                        @php $nameButton = trans('admin.btn-edit'); @endphp
                    @endif
                    @if($flag == 2)
                        @php $nameButton = trans('admin.btn-delete'); @endphp
                    @endif
                </div>
            </div>
        {{ Form::close() }}
    </div>
</div>
