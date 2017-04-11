<h2>{{ trans('public.lbl-hello') }}<strong>{{ $name }}</strong>!</h2>
<div class="row">
    <p>{{ trans('public.lbl-name') }}: <strong >{{ $email }}</strong></p>
    <p>{{ trans('public.lbl-password') }}: <strong >{{ $password }}</strong></p>
</div>
<div class="row">
    <a href="{{ action('Auth\LoginController@login') }}">{{ trans('public.lbl-connect') }}</a>
</div>

