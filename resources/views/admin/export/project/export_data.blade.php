<!DOCTYPE html>
<html>
    <head>
        <title>{{ trans('admin.lbl-project')}}</title>
    </head>
    <body>
         <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>{{ trans('project.lbl-stt') }}</th>
                    <th>{{ trans('project.lbl-name') }}</th>
                    <th>{{ trans('project.lbl-short-name') }}</th>
                    <th>{{ trans('project.lbl-start-day') }}</th>
                    <th>{{ trans('project.lbl-end-day') }}</th>
                </tr>
            </thead>

            <tbody>
                @if (isset($projects))
                    @foreach ($projects as $project)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $project->name }}</td>
                            <td>{{ $project->short_name }}</td>
                            <td>{{ $project->start_day }}</td>
                            <td>{{ $project->end_day }}</td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </body>
</html>
