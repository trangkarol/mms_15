@extends('admin.block.main')
<!-- title off page -->
@section('title')
    {{ trans('admin.title-admin') }}
@endsection
<!-- css used for page -->
<!-- content of page -->
@section('content')
    <div class="row">
        <div class="col-md-3 sub-menu">
            <h4>{{trans('team.title-teams')}}</h4>
        </div>

        <div class="col-md-4 col-md-offset-3 paddingtop">
            <a href="{{ action('Admin\TeamController@create') }}" class="btn btn-primary"><i class="fa fa-plus " ></i></a>
            <a href="{{ action('Admin\TeamController@addMember') }}" class="btn btn-primary"><i class="fa fa-user-plus " ></i></a>
        </div>
    </div>
    <!-- content -->
    <div class="row">
         <div class="col-md-12 paddingtop">
            @include ('common.messages')
            <div class="panel panel-primary ">
                <div class="panel-heading">
                    {{ trans('team.lbl-list-team') }}
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
                                    <th ></th>
                                </tr>
                            </thead>

                            <tbody>
                            @if (!empty($teams))
                                @foreach ($teams as $team)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>{{ $team->name }}</td>
                                        <td>@if ($team->leader) {{ $team->leader->name }} @endif</td>
                                        <td >{{ $team->description }}</td>
                                        <td >
                                            <div class="col-md-5">
                                                <a href ="{{ action('Admin\TeamController@edit', $team->id) }}" class="btn btn-primary"><i class="fa fa-pencil-square-o"></i></a>
                                            </div>
                                            <div class="col-md-5">
                                                {{ Form::open(['action' => 'Admin\TeamController@destroy', 'id' => 'form-delete-team']) }}

                                                {{ Form::hidden('teamId', $team->id) }}
                                                {!! Form::button(trans('admin.lbl-delete'), ['class' => 'btn btn-primary', 'id' => 'btn-delete', 'type' => 'button']) !!}
                                                {{ Form::close() }}
                                            </div>
                                        </td>
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
@endsection
<!-- js used for page -->
@section('contentJs')
    @parent
    {{ Html::script('/admin/js/team.js') }}

@endsection
