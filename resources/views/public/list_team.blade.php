@extends('public.block.main')
<!-- title off page -->
@section('title')
    {{ trans('public.title-public') }}
@endsection
<!-- css used for page -->
<!-- content of page -->
@section('content')
    <div class="row">
        <div class="col-md-5 sub-menu">
            <h4>  {{ trans('public.lbl-list-team') }} </h4>
        </div>
    </div>
    <div class="panel panel-primary" style="margin-top:10px;">
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
                    @if (!empty($team))
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
                    @endif
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
