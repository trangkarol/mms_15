<div class="col-md-12">
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th class="hidden"></th>
                    <th >{{ trans('team.lbl-stt') }}</th>
                    <th >{{ trans('team.lbl-name') }}</th>
                    <th >{{ trans('team.lbl-position') }}</th>
                    <th ></th>
                </tr>
            </thead>

            <tbody>
                @if (!empty($members))
                    @foreach ($members as $member)
                        <tr>
                            <td class="hidden userId"> $member->user ?: $member->user->id </td>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $member->user ? $member->user->name : '' }}</td>
                            <td>
                                @if ($member->positions)
                                    @foreach ($member->positions as $positon)
                                        {{ $positon->name . ' | ' }}
                                    @endforeach
                                @endif
                            </td>
                            <td>
                                <div class="col-md-6">
                                    {!! Form::button(trans('admin.lbl-edit'), ['class' => 'btn btn-primary', 'id' => 'btn-edit-member']) !!}
                                </div>
                                <div class="col-md-6">
                                    {!! Form::button(trans('admin.lbl-delete'), ['class' => 'btn btn-primary', 'id' => 'btn-delete']) !!}
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>
