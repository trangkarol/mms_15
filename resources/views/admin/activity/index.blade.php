@extends('common.block.master')
<!-- title off page -->
@section('title')
    {{ trans('activity.title-activities') }}
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
                                <h2>{{ trans('activity.lbl-list-activity') }}</h2>
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
                                                <th >{{ trans('activity.lbl-name-user') }}</th>
                                                <th >{{ trans('activity.lbl-action') }}</th>
                                                <th >{{ trans('activity.lbl-time') }}</th>
                                                <th >{{ trans('activity.lbl-description') }}</th>
                                                <th ></th>
                                            </tr>
                                        </thead>

                                        <tbody>

                                        @foreach ($activities as $activity)
                                            @if($activity->user)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>@if ( $activity->user){{ $activity->user->name }} @endif</td>
                                                    <td>{{ $activity->action }}</td>
                                                    <td>{{ $activity->created_at }}</td>
                                                    <td>
                                                        @if ( $activity->activitiable)
                                                            @if ($activity->activitiable_type == 'App\Models\User' && $activity->action != 'login' && $activity->action != 'logout')
                                                                <a href="{{ action('Member\HomeController@detailMember', $activity->activitiable_id) }}">{{ $activity->description }}</a>
                                                            @elseif ($activity->activitiable_type == 'App\Models\Team')
                                                                <a href="{{ action('Admin\TeamController@show', $activity->activitiable_id) }}">{{ $activity->description }}</a>
                                                            @else
                                                                <a href="">{{ $activity->description }}</a>
                                                            @endif
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="col-md-6">
                                                            {{ Form::open(['action' => 'Admin\ActivityController@destroy', 'class' => 'form-delete-activity']) }}

                                                            {{ Form::hidden('activityId', $activity->id) }}
                                                            {!! Form::button(trans('admin.lbl-delete'), ['class' => 'btn btn-primary btn-delete-activity', 'id' => '', 'type' => 'button']) !!}
                                                            {{ Form::close() }}
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                        </tbody>

                                    </table>
                                    @if (isset($activities))
                                        {{ $activities->links() }}
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
