<div class="menu">
    <ul class="menu-left-bar">
        <!-- profile users-->
        <li class="active" >
            <a href="{{ action('Member\HomeController@index') }}"><i class="fa fa-user"></i><span> {{ trans('public.title-detail-member') }} </span></a>
        </li>
        <!-- list teams-->
        <li>
            <a href="{{ action('Member\HomeController@listTeam') }}"><i class="fa fa-group"></i><span> {{ trans('public.title-list-team') }} </span></a>
        </li>
    </ul>
</div>
