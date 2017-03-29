@extends('common.master')
<!-- title off page -->
@section('title')
    {{ trans('admin.title-login') }}
@endsection
<!-- content of page -->
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-primary div-login">
                    <div class="panel-heading">{{ trans('admin.title-login') }}</div>
                    <div class="panel-body">
                        {!! Form::open(['action' => 'Auth\LoginController@login', 'method' => 'POST', 'class' => 'form-horizontal']) !!}

                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                {{ Form::label('email', trans('user.lbl-email'), ['class' => 'col-md-4 control-label']) }}

                                <div class="col-md-6">
                                    {{ Form::text('email', old('email'), ['class' => 'form-control',  'id' => 'email', 'required']) }}

                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

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

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    {{ Form::checkbox('remember', old('remember') ? 'checked' : '') }} {{ trans('user.lbl-remember') }}
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-8 col-md-offset-4">
                                    {{ Form::submit(trans('admin.title-login'), ['class' => 'btn btn-primary']) }}
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
