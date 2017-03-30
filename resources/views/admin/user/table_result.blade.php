<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>{{ trans('admin.lbl-stt') }}</th>
            <th>{{ trans('user.lbl-name') }}</th>
            <th>{{ trans('user.lbl-position') }}</th>
            <th>{{ trans('user.lbl-team') }}</th>
            <th>{{ trans('user.lbl-position') }}</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @if (!empty($members))
            @foreach ($members as $member)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td><a href="{{ action('Member\HomeController@detailMember', $member->user->id) }}">{{ $member->user->name }}</a></td>
                    <td> @if ($member->user->position) {{ $member->user->position->name }} @endif</td>
                    <!-- <td>  </td>-->
                    <td> @if ($member->team)  {{ $member->team->name }}  @endif</td>
                    <td>
                        @if ($member->positions)
                            @foreach ($member->positions as $positon)
                               {{ $positon->name }} @php echo ',' @endphp
                            @endforeach
                        @endif
                    </td>
                    <td>
                        <div class="col-md-6">
                            <a href ="{{ action('Admin\UserController@edit', $member->user->id ) }}" class="btn btn-primary"><i class="fa fa-pencil-square-o"></i></a>
                        </div>

                        <div class="col-md-6">
                            {{ Form::open(['action' => 'Admin\UserController@destroy', 'method' => 'POST', 'id' => 'delete-form-user']) }}

                            {{ Form::hidden('userId',$member->user->id) }}
                            {!! Form::button(trans('admin.lbl-delete'), ['class' => 'btn btn-primary', 'id' => 'btn-delete', 'type' => 'button']) !!}
                            {{ Form::close() }}
                        </div>
                    </td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>
@if (isset($members))
    {{ $members->links() }}
@endif
