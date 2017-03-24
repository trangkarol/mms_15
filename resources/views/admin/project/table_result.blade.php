<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>{{ trans('project.lbl-stt') }}</th>
            <th>{{ trans('project.lbl-name') }}</th>
            <th>{{ trans('project.lbl-short-name') }}</th>
            <th>{{ trans('project.lbl-start-day') }}</th>
            <th>{{ trans('project.lbl-end-day') }}</th>
            <th>{{ trans('project.lbl-leader') }}</th>
            <th>{{ trans('project.lbl-team') }}</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @if (isset($projects))
            @foreach ($projects as $project)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ $project->project->name }}</a></td>
                    <td>{{ $project->project->short_name }}</a></td>
                    <td>{{ $project->project->start_day }}</a></td>
                    <td>{{ $project->project->end_day }}</a></td>
                    <td>{{ $project->teamUser->user->name }}</a></td>
                    <td>
                        {{ $project->teamUser->team->name }}
                    </td>
                    <td>
                        <div class="col-md-6">
                            <a href ="{{ action('Admin\ProjectController@edit', $project->id ) }}" class="btn btn-primary"><i class="fa fa-pencil-square-o"></i></a>
                        </div>

                        <div class="col-md-6">
                            {{ Form::open(['action' => 'Admin\ProjectController@destroy', 'method' => 'POST']) }}

                            {{ Form::hidden('projectId',$project->id) }}
                            {!! Form::button(trans('admin.lbl-delete'), ['class' => 'btn btn-primary', 'id' => 'updateFeature', 'type' => 'submit']) !!}
                            {{ Form::close() }}
                        </div>
                    </td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>
@if (isset($projects))
    {{ $projects->links() }}
@endif
