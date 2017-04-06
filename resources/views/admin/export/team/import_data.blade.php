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
                <h3>{{ trans('team.title-teams') }}</h3>
            </div>
            <div class="title_right">
                <div class="col-md-5 col-sm-5 col-xs-12 form-group">
                     <div class="col-md-6">
                        <a href="#" class="btn btn-primary" id="add-team" data-toggle="tooltip" data-placement="top" title="Add teams"><i class="fa fa-plus " ></i></a>
                        {{ Form::open(['action' => 'Admin\TeamController@saveImport', 'id' => 'form-save-team']) }}

                            {{ Form::hidden('nameFile',$nameFile) }}
                        {{ Form::close() }}
                    </div>
                </div>
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
                                <h2>{{ trans('user.lbl-data-import') }}</h2>
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
            </div>
        </div>
    </div>
@endsection
<!-- js used for page -->
@section('contentJs')
    @parent
    {{ Html::script('admin/js/team.js') }}
    <!-- add trans and action used in file team.js -->
    @include('library.team_trans_javascript')
@endsection
