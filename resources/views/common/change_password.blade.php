@extends('common.master')
<!-- title off page -->
@section('title')
    {{ trans('admin.title-change-password') }}
@endsection
<!-- content of page -->
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-primary div-login">
                    <div class="panel-heading">{{ trans('admin.title-change-password') }}</div>
                    <div class="panel-body">
                        {!! Form::open(['action' => 'Auth\ResetPasswordController@changePassword', 'class' => 'form-horizontal']) !!}
                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                {{ Form::label('password', trans('user.lbl-password'), ['class' => 'col-md-4 control-label']) }}
                                <div class="col-md-6">
                                    {{ Form::password('password', ['class' => 'form-control',  'id' => 'password', 'required']) }}
                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                {{ Form::label('password_confirmation', trans('user.lbl-comfirm_password'), ['class' => 'col-md-4 control-label']) }}
                                <div class="col-md-6">
                                    {{ Form::password('password_confirmation', ['class' => 'form-control',  'id' => 'password_confirmation', 'required']) }}

                                    @if ($errors->has('comfirm_password'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-2 col-md-offset-5">
                                    {{ Form::submit(trans('admin.btn-change'), ['class' => 'btn btn-primary']) }}
                                </div>
                            </div>
                        {{ Form::close() }}
                        <!-- messages -->
                        @include('common.messages')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
