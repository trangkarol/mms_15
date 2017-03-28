@extends('admin.block.main')
<!-- title off page -->
@section('title')
    {{ trans('team.title-update-teams') }}
@endsection
<!-- css used for page -->
<!-- content of page -->
@section('content')
    <div class="row">
         <div class="col-md-3 sub-menu">
            <h4>{{ trans('team.lbl-detail') }} </h4>
        </div>
        <div class="col-md-4 col-md-offset-3 paddingtop">
            <a href="{{ action('Admin\TeamController@index') }}" class="btn btn-primary"><i class="fa fa-list " ></i></a>
        </div>
    </div>

    <div class="panel panel-primary" style="margin-top:10px;">
        <div class="panel-body">
            <div class="col-md-7 col-md-offset-2">
                <div class="row">
                    {{ Form::label('name', trans('team.lbl-name'), ['class' => 'col-md-4 control-label']) }}
                    {{ Form::label('name', $teams->name, ['class' => 'col-md-8']) }}
                </div>

                 <div class="row">
                    {{ Form::label('email', trans('team.lbl-leader'), ['class' => 'col-md-4 control-label']) }}
                    {{ Form::label('email', $teams->leader->name, ['class' => 'col-md-4']) }}
                </div>

                <div class="row">
                    {{ Form::label('name', trans('team.lbl-description'), ['class' => 'col-md-4 control-label']) }}
                    {{ Form::label('name', $teams->description, ['class' => 'col-md-4']) }}
                </div>
            </div>

            <div class="col-md-12">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>{{ trans('admin.lbl-stt') }}</th>
                            <th>{{ trans('user.lbl-name') }}</th>
                            <th>{{ trans('user.lbl-position') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($teams->teamUsers as $teamUser)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td><a href="{{ action('Member\HomeController@detailMember', $teamUser->user->id) }}">{{ $teamUser->user->name }}</a></td>
                                <td>
                                    @if ($teamUser->positions)
                                        @php
                                            $position = '';
                                        @endphp

                                        @if ($teamUser->positions)
                                            @foreach ($teamUser->positions as $positon)
                                                @php
                                                    $position = $position.$positon->name . ' | ';
                                                @endphp
                                            @endforeach
                                        @endif
                                        {{ rtrim($position, ' | ') }}
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
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
