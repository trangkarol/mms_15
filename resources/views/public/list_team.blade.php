@extends('public.block.main')
<!-- title off page -->
@section('title')
    {{ trans('public.title-public') }}
@endsection
<!-- css used for page -->
<!-- content of page -->
@section('content')
    <div class="panel panel-primary ">
        <div class="panel-heading">
            {{ trans('public.lbl-list-team') }}
        </div>
        <!--  -->
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th >{{ trans('team.lbl-stt') }}</th>
                            <th >{{ trans('team.lbl-name') }}</th>
                            <th >{{ trans('team.lbl-leader') }}</th>
                            <th >{{ trans('team.lbl-description') }}</th>
                        </tr>
                    </thead>

                    <tbody>
                    @foreach ($teams as $team)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>
                                <a href="{{ action('Member\HomeController@listMember', $team->id) }}">{{ $team->name }}</a>
                            </td>
                            <td>{{ $team->leader->name}}</td>
                            <td>{{ $team->description }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                @if (isset($teams))
                    {{ $teams->links() }}
                @endif
            </div>
        </div>
    </div>
@endsection
<!-- js used for page -->
