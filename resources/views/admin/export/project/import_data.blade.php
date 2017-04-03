@extends('admin.block.main')
<!-- title off page -->
@section('title')
    {{ trans('project.title-projects') }}
@endsection
<!-- css used for page -->
<!-- content of page -->
@section('content')
    <div class="row">
        <div class="col-md-3 sub-menu">
            <h4>{{ trans('project.title-projects') }}</h4>
        </div>

        <div class="col-md-4 col-md-offset-3 paddingtop">
            <a href="#" class="btn btn-primary" id="add-project"><i class="fa fa-user-plus " ></i></a>
            {{ Form::open(['action' => 'Admin\ProjectController@saveImport', 'id' => 'form-save-project']) }}

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
                                    <th>{{ trans('project.lbl-stt') }}</th>
                                    <th>{{ trans('project.lbl-name') }}</th>
                                    <th>{{ trans('project.lbl-short-name') }}</th>
                                    <th>{{ trans('project.lbl-start-day') }}</th>
                                    <th>{{ trans('project.lbl-end-day') }}</th>
                                </tr>
                            </thead>

                            <tbody>
                                @if (isset($projects))
                                    @foreach ($projects as $project)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>{{ $project->name }}</td>
                                            <td>{{ $project->short_name }}</td>
                                            <td>{{ $project->startday }}</td>
                                            <td>{{ $project->enday }}</td>
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
    {{ Html::script('/admin/js/project.js') }}
@endsection
