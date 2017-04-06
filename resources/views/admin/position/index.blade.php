@extends('common.block.master')
<!-- title off page -->
@section('title')
     {{ trans('position.title-positons') }}
@endsection
<!-- css used for page -->
<!-- content of page -->
@section('content')
    <div class="">
        <!-- title -->
        <div class="page-title">
            <div class="title_left">
                <h3>{{ trans('position.title-positons') }}</h3>
            </div>
            <div class="title_right">
                <div class="col-md-5 col-sm-5 col-xs-12 form-group">
                    <div class="col-md-6">
                        <a href="{{ action('Admin\PositionController@create') }}" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Create position"><i class="fa fa-plus " ></i></a>
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
                                <h2>{{ trans('position.lbl-list-position') }}</h2>
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
                                                <th >{{ trans('position.lbl-name') }}</th>
                                                <th >{{ trans('position.lbl-short-name') }}</th>
                                                <th >{{ trans('position.lbl-type-position') }}</th>
                                                <th ></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (!empty($positions))
                                                @foreach ($positions as $position)
                                                    <tr>
                                                        <td class="text-center">{{ $loop->iteration }}</td>
                                                        <td>{{ $position->name }}</td>
                                                        <td>{{ $position->short_name }}</td>
                                                        <td>
                                                            @if ($position->type_position == config('setting.type_position.position'))
                                                                {{ trans('position.lbl-position') }}</td>
                                                            @else
                                                                {{ trans('position.lbl-position-team') }}
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <div class="col-md-6">
                                                                <a href ="{{ action('Admin\PositionController@edit', $position->id) }}" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Edit position"><i class="fa fa-pencil-square-o"></i></a>
                                                            </div>
                                                            <div class="col-md-6">
                                                                {{ Form::open(['action' => 'Admin\PositionController@destroy', 'class' => 'form-delete-position']) }}
                                                                    {{ Form::hidden('positionId', $position->id) }}
                                                                    {!! Form::button(trans('admin.lbl-delete'), ['class' => 'btn btn-primary btn-delete-position', 'id' => '', 'type' => 'button', 'data-toggle' => 'tooltip', 'title' => 'Delete position']) !!}
                                                                {{ Form::close() }}
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                    @if (isset($positions))
                                        {{ $positions->links() }}
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
