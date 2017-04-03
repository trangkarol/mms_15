<!DOCTYPE html>
<html>
    <head>
        <title>{{ trans('team.export-team')}}</title>
    </head>
    <body>
        <table>
            <thead>
                <tr>
                    <th>{{ trans('admin.lbl-stt') }}</th>
                    <th>{{ trans('team.lbl-name') }}</th>
                    <th>{{ trans('team.lbl-leader') }}</th>
                    <th>{{ trans('team.lbl-description') }}</th>
                </tr>
            </thead>

            <tbody>
                @if (isset($teams))
                    @foreach ($teams as $team)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $team->name }}</td>
                            <td>{{ $team->leader }}</td>
                            <td>{{ $team->description }}</td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </body>
</html>
