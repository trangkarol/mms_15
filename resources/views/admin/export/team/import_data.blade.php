@extends('admin.block.main')
<!-- title off page -->
@section('title')
    {{ trans('team.title-teams') }}
@endsection
<!-- css used for page -->
<!-- content of page -->
@section('content')
    <div class="row">
        <div class="col-md-3 sub-menu">
            <h4>{{trans('team.title-teams')}}</h4>
        </div>

        <div class="col-md-4 col-md-offset-3 paddingtop">
            <a href="#" class="btn btn-primary" id="add-team"><i class="fa fa-plus " ></i></a>
            {{ Form::open(['action' => 'Admin\TeamController@saveImport', 'id' => 'form-save-team']) }}

                {{ Form::hidden('nameFile',$nameFile) }}
            {{ Form::close() }}

        </div>
    </div>
    <!-- content -->
    <div class="row">
        <div class="col-md-12 paddingtop">
            <div class="panel panel-primary ">
            </div>
            @include('common.messages')
            <div class="panel panel-primary ">
                <div class="panel-heading">
                    {{ trans('admin.lbl-result-search') }}
                </div>
                <!--  -->
                <div class="panel-body">
                    <div class="table-responsive" id ="result-users">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>{{ trans('admin.lbl-stt') }}</th>
                                    <th>{{ trans('team.lbl-name') }}</th>
                                    <th>{{ trans('team.lbl-leader') }}</th>
                                    <th>{{ trans('team.lbl-description') }}</th>
                                </tr>
                            </thead>

                            <tbody>
                                @if (isset($teams))
                                    @foreach ($teams as $team)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $team->name }}</td>
                                            <td>{{ $team->leader }}</td>
                                            <td>{{ $team->description }}</td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
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
