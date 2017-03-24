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
            @foreach ($members as $member)
                <tr>
                    <td class="hidden userId">{{ $member->user->id}}</td>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ $member->user->name }}</td>
                    <td>
                        @if ($member->positions)
                            @foreach ($member->positions as $positon)
                                {{ $positon->name }} @php echo ',' @endphp
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
            </tbody>
        </table>
    </div>
</div>
