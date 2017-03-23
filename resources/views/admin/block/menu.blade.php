<nav class="navbar navbar-inverse backgroup-menu">
    <div class="container-fluid col-md-12">
        <div class="navbar-header">
            <a class="navbar-brand" href="#"> {{ trans('admin.title-web') }} </a>
        </div>
        <!-- information of user -->
        @if (Auth::guard()->check())
            <ul class="nav  navbar-right col-md-3">
                <li class="col-md-6">
                    <a href="#">{{ Auth::user()->name }}</a>
                </li>

                <li class="col-md-4">
                    <a href="{{ action('Auth\LoginController@logout') }}" id="btn-logout">
                        {{ trans('admin.title-logout') }}
                    </a>
                    {!! Form::open(['action' => 'Auth\LoginController@logout', 'method' => 'POST', 'class' => 'form-horizontal']) !!}
                    {{ Form::close() }}
                </li>
            </ul>
        @endif
    </div>
</nav>
