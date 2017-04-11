@extends('admin.block.main')
<!-- title off page -->
@section('title')
    {{ trans('position.title-positons') }}
@endsection
<!-- css used for page -->
<!-- content of page -->
@section('content')
    <div class="row">
        <div class="col-md-3 sub-menu">
            <h4>{{ trans('position.title-positions' ) }}</h4>
        </div>
        <div class="col-md-4 col-md-offset-3 paddingtop">
            <a href="{{ action('Admin\PositionController@create') }}" class="btn btn-primary"><i class="fa fa-plus " ></i></a>
        </div>
    </div>
    <!-- content -->
    <div class="row">
         <div class="col-md-12 paddingtop">
            @include ('common.messages')
            <div class="panel panel-primary ">
                <div class="panel-heading">
                    {{ trans('admin.lbl-result-search') }}
                </div>
                <div class="panel-body">
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
                                                    {{ trans('position.lbl-position') }}
                                                @else
                                                    {{ trans('position.lbl-position-team') }}
                                                @endif
                                            </td>
                                            <td>
                                                <div class="col-md-6">
                                                    <a href ="{{ action('Admin\PositionController@edit', $position->id) }}" class="btn btn-primary"><i class="fa fa-pencil-square-o"></i></a>
                                                </div>
                                                <div class="col-md-6">
                                                    {{ Form::open(['action' => 'Admin\PositionController@destroy', 'class' => 'form-delete-position']) }}
                                                        {{ Form::hidden('positionId', $position->id) }}
                                                        {!! Form::button(trans('admin.lbl-delete'), ['class' => 'btn btn-primary btn-delete-position', 'id' => '', 'type' => 'button']) !!}
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
@endsection
