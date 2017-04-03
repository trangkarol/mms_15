@extends('admin.block.main')
<!-- title off page -->
@section('title')
    {{ trans('activity.title-activities') }}
@endsection
<!-- css used for page -->
<!-- content of page -->
@section('content')
    <div class="row">
        <div class="col-md-3 sub-menu">
            <h4>{{trans('activity.title-activities')}}</h4>
        </div>
    </div>
    <!-- content -->
    <div class="row">
         <div class="col-md-12 paddingtop">
            @include('common.messages')
            <div class="panel panel-primary ">
                <div class="panel-heading">
                    {{ trans('admin.lbl-result-search') }}
                </div>
                <!--  -->
                <div class="panel-body">
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
@endsection
