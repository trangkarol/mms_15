<div class="panel panel-default">
    <div class="panel panel-heading">
         {{ trans('admin.lbl-result-search') }}
    </div>

    <div class="panel panel-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>{{ trans('admin.lbl-stt') }}</th>
                        <th>{{ trans('user.lbl-name') }}</th>
                        <th>{{ trans('user.lbl-position') }}</th>
                        <th>{{ trans('user.lbl-position_team') }}</th>
                        <th>{{ trans('project.lbl-leader')}}</th>
                        <th></th>

                    </tr>
                </thead>
                <tbody>
                    @if (!empty($members))
                        @foreach ($members as $member)
                            @if (!in_array($member->id, $arrMember))
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td><a href="{{ action('Member\HomeController@detailMember', $member->id) }}">{{ $member->name }}</a></td>
                                    <td> @if ($member->position) {{ $member->position->name }} @endif</td>
                                    <!-- <td>  </td>-->
                                    <td>
                                        @if ($member->teamUsers)
                                            @foreach ($member->teamUsers as $temUser)
                                                @if ($temUser->positions)
                                                    @php
                                                        $position = '';
                                                    @endphp
                                                    @foreach ($temUser->positions as $positon)
                                                        @php
                                                            $position .= $positon->name . ' | ';
                                                        @endphp
                                                    @endforeach
                                                @endif
                                            @endforeach
                                        @endif
                                        {{ $position }}
                                    </td>
                                    <td>
                                        {{ Form::radio('leader', $member->id, null, ['class' => 'leader' ]) }}
                                    </td>
                                    <td>
                                        <div class="col-md-6">
                                            {{ Form::checkbox('add_user[]', $member->id, null, ['class' => 'add_user' ]) }}
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    @endif
                </tbody>
            </table>
            @if (isset($members))
                {{ $members->links() }}
            @endif
        </div>
    </div>
</div>
