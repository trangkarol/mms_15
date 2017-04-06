@extends('common.block.master')
<!-- title off page -->
@section('title')
    {{ trans('public.title-public') }}
@endsection
<!-- css used for page -->
<!-- content of page -->
@section('content')
    <div class="">
        <!-- title -->
        <div class="page-title">
            <div class="title_left">
                <h3>{{ trans('activity.title-activities') }}</h3>
            </div>
        </div>
        <!-- end title -->
        <div class="clearfix"></div>
        @include ('common.messages')
        <div class="row">
            <div class="x_content">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="x_panel">
                            <div class="x_title">
                                <h2>{{ trans('activity.title-activities') }}</h2>
                                <ul class="nav navbar-right panel_toolbox">
                                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                    </li>
                                </ul>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
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
                                        @if (!empty($teams))
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
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
