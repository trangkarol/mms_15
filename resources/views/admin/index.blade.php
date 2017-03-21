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
            <h4> {{ trans('user.title-users') }} </h4>
        </div>
        <div class="col-md-4 col-md-offset-3 paddingtop">
            <a href="{{ route('user.create') }}" class="btn btn-primary"><i class="fa fa-plus " ></i></a>
        </div>
    </div>
    <!-- content -->
    <div class="row">
        <div class="col-md-12 paddingtop">
            <div class="panel panel-primary ">
                <div class="panel-heading"> {{ trans('user.lbl-search') }} </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-borded table-striped">
                            <thead>
                                <tr>
                                    <th> {{ trans('user.lbl-stt') }} </th>
                                    <th> {{ trans('user.lbl-name') }} </th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
<!-- js used for page -->
