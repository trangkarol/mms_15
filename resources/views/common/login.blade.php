@extends('common.master')
<!-- title off page -->
@section('title')
    {{ trans('admin.title-login') }}
@endsection
<!-- content of page -->
@section('content')
    <div class="login">
        <h1>{{ trans('admin.title-login') }}</h1>
        {!! Form::open(['action' => 'Auth\LoginController@login', 'method' => 'POST', 'class' => 'form-horizontal']) !!}

            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                {{ Form::text('email', old('email'), ['id' => 'email', 'required', 'placeholder' => 'someone@gmail.com']) }}

                @if ($errors->has('email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    {{ Form::password('password', ['id' => 'password', 'required', 'placeholder' => '****************']) }}

                    @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
            </div>

            <div class="col-md-4 col-md-offset-7">
                {{ Form::submit(trans('admin.title-login'), ['class' => 'btn btn-success btn-block btn-large']) }}
            </div>
        {{ Form::close() }}
        <!-- messages -->
        @include('common.messages')
    </div>
@endsection
