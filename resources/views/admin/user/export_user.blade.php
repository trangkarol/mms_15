<!DOCTYPE html>
<html>
<head>
    <title>{{ trans('user.export-user')}}</title>
</head>
<body>
    <table>
        <thead>
        <tr>
            <th>{{ trans('admin.lbl-stt') }}</th>
            <th>{{ trans('user.lbl-name') }}</th>
            <th>{{ trans('user.lbl-email') }}</th>
            <th>{{ trans('user.lbl-birthday') }}</th>
            <th>{{ trans('user.lbl-position') }}</th>
            <th>{{ trans('user.lbl-team') }}</th>
        </tr>
    </thead>
    <tbody>
        @if (!empty($data))
            @foreach ($data as $member)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ $member->name }}</td>
                    <td>{{ $member->email }}</td>
                    <td>{{ $member->birthday }}</td>
                    <td>{{ $member->position->name ?: '' }}</td>
                    <td>
                        @if ($member->teamUsers)
                            @foreach ($member->teamUsers as $temUser)
                                @php
                                    $position = '';
                                @endphp

                                @if ($temUser->positions)
                                    @foreach ($temUser->positions as $positon)
                                        @php
                                            $position = $position . $positon->name . ' | ';
                                        @endphp
                                    @endforeach
                                @endif
                                {{ $temUser->team->name . '(' . rtrim($position, ' | ') . ' | ' }}
                            @endforeach
                        @endif
                    </td>
                </tr>
            @endforeach
        @endif
    </tbody>
    </table>
</body>
</html>
