<div class="table-responsive">
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th class="hidden"></th>
                <th >{{ trans('admin.lbl-stt') }}</th>
                <th >{{ trans('user.lbl-skill') }}</th>
                <th >{{ trans('user.lbl-experiensive')}}</th>
                <th >{{ trans('user.lbl-level') }}</th>
                <th ></th>
            </tr>
        </thead>

        <tbody>
        @if(isset($skillUsers))
            @foreach ($skillUsers as $skillUser)
                <tr>
                    <td class="hidden skillId">{{ $skillUser->skill->id }}
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ $skillUser->skill->name }}</td>
                    <td>
                        {{ Form::text('exeper', $skillUser->experiensive, ['class' => 'form-control exeper', 'id' => 'name']) }}
                    </td>
                    <td>
                        {{ Form::select('level]', $levels, $skillUser->level, ['class' => 'form-control level', 'id' => 'level']) }}
                    </td>
                    <td>
                        <div class="col-md-6">
                            {!! Form::button(trans('admin.lbl-edit'), ['class' => 'btn btn-primary btn-edit-skill', 'id' => '']) !!}
                        </div>
                        <div class="col-md-6">
                            {!! Form::button(trans('admin.lbl-delete'), ['class' => 'btn btn-primary btn-delete-skill', 'id' => '']) !!}
                        </div>
                    </td>
                </tr>
            @endforeach
        @endif

        </tbody>
    </table>
</div>
