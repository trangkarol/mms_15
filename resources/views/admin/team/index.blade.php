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
        </div>

        <div class="col-md-4 col-md-offset-3 paddingtop">
            <a href="{{ action('Admin\TeamController@addMember') }}" class="btn btn-primary"><i class="fa fa-plus " ></i></a>
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
                        <table class="table table-borded table-striped">
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
                            @foreach ($teams as $team)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $team->name }}</td>
                                    <td>{{ $team->leader->name}}</td>
                                    <td>{{ $team->description }}</td>
                                    <td>
                                        <div class="col-md-6">
                                            <a href ="{{ action('Admin\TeamController@edit', $team->id) }}" class="btn btn-primary"><i class="fa fa-pencil-square-o"></i></a>
                                        </div>
                                        <div class="col-md-6">
                                            {{ Form::open(['action' => 'Admin\TeamController@destroy', 'method' => 'POST']) }}

                                            {{ Form::hidden('teamId', $team->id) }}
                                            {!! Form::button(trans('team.lbl-stt'), ['class' => 'btn btn-primary', 'id' => 'updateFeature', 'type' => 'submit']) !!}
                                            {{ Form::close() }}
                                        </div>
                                    </td>
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
        </div>
    </div>
@endsection
