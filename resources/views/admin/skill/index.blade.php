@extends('common.block.master')
<!-- title off page -->
@section('title')
    {{ trans('skill.title-skills') }}
@endsection
<!-- css used for page -->
<!-- content of page -->
@section('content')
    <div class="">
        <!-- title -->
        <div class="page-title">
            <div class="title_left">
                <h3>{{ trans('skill.title-skills') }}</h3>
            </div>
            <div class="title_right">
                <div class="col-md-5 col-sm-5 col-xs-12 form-group">
                    <div class="col-md-6">
                        <a href="{{ action('Admin\SkillController@create') }}" class="btn btn-primary" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Create skill"><i class="fa fa-plus " ></i></a>
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
                                <h2>{{ trans('skill.lbl-list-skill') }}</h2>
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
                                                <th >{{ trans('skill.lbl-name') }}</th>
                                                <th ></th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                        @if (!empty($skills))
                                            @foreach ($skills as $skill)
                                                <tr>
                                                    <td class="text-center">{{ $loop->iteration }}</td>
                                                    <td >{{ $skill->name }}</td>
                                                    <td class="col-md-3">
                                                        <div class="col-md-6">
                                                            <a href ="{{ action('Admin\SkillController@edit', $skill->id) }}" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Edit skill"><i class="fa fa-pencil-square-o"></i></a>
                                                        </div>
                                                        <div class="col-md-6">
                                                            {{ Form::open(['action' => 'Admin\SkillController@destroy', 'class' => 'form-delete-skill']) }}

                                                            {{ Form::hidden('skillId', $skill->id) }}
                                                            {!! Form::button(trans('admin.lbl-delete'), ['class' => 'btn btn-primary btn-delete-skill', 'type' => 'submit', 'data-toggle' => 'tooltip', 'title' => 'Delete skill']) !!}
                                                            {{ Form::close() }}
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                        </tbody>
                                    </table>
                                    @if (isset($skills))
                                        {{ $skills->links() }}
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
