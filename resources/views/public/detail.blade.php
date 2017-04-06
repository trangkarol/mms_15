@extends('common.block.master')
<!-- title off page -->
@section('title')
    {{ trans('admin.title-admin') }}
@endsection
<!-- css used for page -->
<!-- content of page -->
@section('content')
    <div class="">
        <!-- title -->
        <div class="page-title">
            <div class="title_left">
                <h3> {{ trans('public.lbl-profile') }} <strong>{{ $user->name }}</strong> </h3>
            </div>
        </div>
        <!-- end title -->
        <div class="clearfix"></div>
        <div class="row">
            <div class="x_content">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <!-- profile -->
                        <div class="x_panel">
                            <div class="x_title">
                                <h2> {{ trans('public.lbl-profile') }} </h2>
                                <ul class="nav navbar-right panel_toolbox">
                                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                    </li>
                                </ul>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <div class="col-md-5">
                                    <img src="{{ url('/Upload', $user->avatar) }}" width="300px" height="250px">
                                </div>
                                <div class="col-md-7">
                                        @if (($user->id == Auth::user()->id) || Auth::user()->isAdmin() )
                                            @include('public.form_member')
                                        @else
                                            @include('public.member_review')
                                        @endif
                                </div>
                            </div>
                        </div>
                        <!-- skill -->
                        <div class="x_panel">
                            <div class="x_title">
                                <h2> {{ trans('user.lbl-skill') }} </h2>
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
                                                <th >{{ trans('admin.lbl-stt') }}</th>
                                                <th >{{ trans('public.lbl-name') }}</th>
                                                <th >{{ trans('public.lbl-level') }}</th>
                                                <th >{{ trans('public.lbl-experiensive') }}</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                        @foreach ($user->skills as $skill)
                                            <tr>
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td>{{ $skill->name }}</td>
                                                <td>
                                                    @if($skill->level == config('setting.level.senior'))
                                                        {{ trans('public.lbl-senior') }}
                                                    @else
                                                         {{ trans('public.lbl-junior') }}
                                                    @endif
                                                </td>
                                                <td>{{ $skill->pivot->experiensive }}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- team -->
                        <div class="x_panel">
                            <div class="x_title">
                                <h2> {{ trans('public.lbl-team') }} </h2>
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
                                                <th >{{ trans('admin.lbl-stt') }}</th>
                                                <th >{{ trans('public.lbl-name') }}</th>
                                                <th >{{ trans('public.lbl-position') }}</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                        @foreach ($teamUsers as $teamUser)
                                            <tr>
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td>{{ $teamUser->team->name }}</td>
                                                <td>
                                                    @foreach($teamUser->positions as $position)
                                                        {{ $position->name }}
                                                    @endforeach
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- project -->
                        <div class="x_panel">
                            <div class="x_title">
                                <h2> {{ trans('public.lbl-project') }} </h2>
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
                                                <th >{{ trans('admin.lbl-stt') }}</th>
                                                <th >{{ trans('public.lbl-name') }}</th>
                                                <th >{{ trans('public.lbl-leader') }}</th>
                                                <th >{{ trans('public.lbl-team') }}</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                        @foreach ($projects as $project)
                                            <tr>
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td>{{ $project->project->name }}</td>
                                                <td>
                                                    @if($project->is_leader == config('setting.is_leader.leader'))
                                                        have
                                                    @endif
                                                </td>
                                                <td>
                                                   {{ $project->teamUser->team->name }}
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
<!-- js used for page -->
@section('contentJs')
    @parent
    {{ Html::script('/admin/js/user.js') }}
    <!-- add trans and action used in file user.js -->
    @include('library.user_trans_javascript')
@endsection
