
<h2>Hello <strong>{{$name}}</strong>!</h2>

<div class="row">
    <p>Username: <strong >{{$email}}</strong></p>
    <p>Password: <strong >{{$password}}</strong></p>
</div>

<div class="row">
    <a href="{{ action('Auth\LoginController@login') }}">Connect</a>
</div>

