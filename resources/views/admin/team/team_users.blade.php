@extends('common.block.master')
<!-- title off page -->
@section('title')
    {{ trans('team.title-members-teams') }}
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
                    <div class="col-md-4">
                        <a href="{{ action('Admin\TeamController@index') }}" class="btn btn-success"  class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="List teams"><i class="fa fa-list " ></i></a>
                    </div>
                </div>
            </div>
        </div>
        <!-- end title -->
        <div class="clearfix"></div>
        <!-- form search -->
        @include('common.messages')
        <div class="row">
                <div class="x_content">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2> {{ trans('admin.lbl-search') }} </h2>
                                        <ul class="nav navbar-right panel_toolbox">
                                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                            </li>
                                        </ul>
                                    <div class="clearfix"></div>
                                </div>
                                    <div class="x_content">
                                        <div class="row">
                                            {{ Form::label('skill', trans('team.lbl-skill'), ['class' => 'col-md-3 control-label']) }}
                                            <div class="col-md-6 table-result">
                                                @foreach ($skills as $key => $skill)
                                                    <div class="col-md-6">
                                                        {{ Form::checkbox('skills[]', $key, null, ['class' => 'skills' ]) }} {{ $skill }}
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>

                                        <div class="row div-level">
                                            {{ Form::label('levels', trans('team.lbl-levels'), ['class' => 'col-md-3 control-label']) }}
                                            <div class="col-md-6">
                                                <div class="col-md-5">
                                                    {{ Form::checkbox('levels[]', config('setting.level.junior'), null, ['class' => 'levels']) }} {{ trans('team.lbl-junior') }}
                                                </div>

                                                <div class="col-md-5">
                                                    {{ Form::checkbox('levels[]', config('setting.level.senior'), null, ['class' => 'levels'] ) }} {{ trans('team.lbl-senior') }}
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-3 col-md-offset-8">
                                                {{ Form::button(trans('admin.lbl-search'), ['class' => 'btn btn-success', 'id' => 'btn-search']) }}
                                            </div>
                                        </div>
                                    </div>

                                    <div id="result-member">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- list member -->
                    <div class="x_content">
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="x_panel">
                                    <div class="x_title">
                                        <h2> {{ trans('team.title-members-teams') }} </h2>
                                            <ul class="nav navbar-right panel_toolbox">
                                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                                </li>
                                            </ul>
                                        <div class="clearfix"></div>
                                    </div>

                                    <div class="x_content">
                                        <div class="col-md-5">
                                            {{ Form::select('teamId', $teams, isset($team->leader->id) ? $team->leader->id : null, ['class' => 'form-control', 'id' => 'teamId']) }}
                                        </div>

                                    </div>

                                    <div class="x_content" id="result-list-member">
                                        @if (isset($members))
                                            @include('admin.team.list_member')
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
<!-- js used for page -->
@section('contentJs')
    @parent
    {{ Html::script('admin/js/team.js') }}
    <!-- add trans and action used in file team.js -->
    @include('library.team_trans_javascript')
@endsection
