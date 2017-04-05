@extends('admin.block.main')
<!-- title off page -->
@section('title')
    {{ trans('user.title-update-users') }}
@endsection
<!-- css used for page -->
<!-- content of page -->
@section('content')
    <div class="row">
        <div class="col-md-3 sub-menu">
            <h4>{{ trans('user.title-users') }}</h4>
        </div>
        <div class="col-md-4 col-md-offset-3 paddingtop">
            <a href="{{ action('Admin\UserController@index') }}" class="btn btn-primary"><i class="fa fa-list " ></i></a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 paddingtop">
            @include('common.messages')
            <div class="panel panel-primary ">
                <div class="panel-heading">
                    {{ trans('user.title-update-users') }}
                </div>
                <div class="panel-body">
                    {!! Form::open(['action' => 'Admin\UserController@update', 'class' => 'form-horizontal', 'enctype' => 'multipart/form-data']) !!}
                        {{ Form::hidden('userId', $user->id, ['id' => 'userId']) }}
                        @include('admin.user.form_user')
                        <!-- button -->
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="reset" class="btn btn-primary">
                                    {{ trans('admin.btn-reset') }}
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    {{ trans('admin.btn-update') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
<!-- js used for page -->
@section('contentJs')
    @parent
    {{ Html::script('admin/js/user.js') }}
    <!-- add trans and action used in file user.js -->
    @include('library.user_trans_javascript')
@endsection
