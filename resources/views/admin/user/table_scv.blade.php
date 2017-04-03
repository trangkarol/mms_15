@extends('admin.block.main')
<!-- title off page -->
@section('title')
    {{ trans('user.title-users') }}
@endsection
<!-- css used for page -->
<!-- content of page -->
@section('content')
    <div class="row">
        <div class="col-md-3 sub-menu">
            <h4>{{trans('user.title-users')}}</h4>
        </div>

        <div class="col-md-4 col-md-offset-3 paddingtop">
            <a href="#" class="btn btn-primary" id="add-user"><i class="fa fa-user-plus " ></i></a>
            {{ Form::open(['action' => 'Admin\UserController@saveImport', 'method' => 'POST', 'id' => 'form-save-user']) }}

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
                                    <th>{{ trans('user.lbl-name') }}</th>
                                    <th>{{ trans('user.lbl-email') }}</th>
                                    <th>{{ trans('user.lbl-birthday') }}</th>
                                    <th>{{ trans('user.lbl-role') }}</th>
                                    <th>{{ trans('user.lbl-position') }}</th>
                                </tr>
                            </thead>

                            <tbody>
                                @if (isset($members))
                                    @foreach ($members as $user)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->email }}</td>
                                                <td>{{ $user->birthday }}</td>
                                                <td>@if($user->role == config('settind.role.admin')) {{ trans('admin.lbl-admin') }} @else {{ trans('admin.lbl-user') }} @endif</td>
                                                <td>{{ $user->position }}</td>
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
    {{ Html::script('/admin/js/user.js') }}
@endsection
