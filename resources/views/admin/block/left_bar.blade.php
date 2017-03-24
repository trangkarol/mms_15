<div class="menu">
    <ul class="menu-left-bar">
         <!-- profile users-->
        <li class="@if(Request::url() == action('Member\HomeController@index')) active @endif" >
            <a href="{{ action('Member\HomeController@index') }}"><i class="fa fa-user"></i><span> {{ trans('public.title-detail-member') }} </span></a>
        </li>
        <!-- list teams-->
        <li class="@if(Request::url() == action('Member\HomeController@listTeam')) active @endif">
            <a href="{{ action('Member\HomeController@listTeam') }}"><i class="fa fa-group"></i><span> {{ trans('public.title-list-team') }} </span></a>
        </li>
        @if(Auth::user()->isAdmin())
            <!-- management users-->
            <li class="@if(Request::url() == action('Admin\UserController@index')) active @endif ">
                <a href="{{ action('Admin\UserController@index') }}"><i class="fa fa-users "></i><span> {{ trans('user.title-users') }} </span></a>
            </li>
            <!-- management teams-->
            <li class="@if(Request::url() == action('Admin\TeamController@index')) active @endif ">
                <a href="{{ action('Admin\TeamController@index') }}"><i class="fa fa-building-o "></i><span> {{ trans('team.title-teams') }} </span></a>
            </li>
            <!-- management position-->
            <li class="@if(Request::url() == action('Admin\PositionController@index')) active @endif ">
                <a href="{{ action('Admin\PositionController@index') }}"><i class="fa fa-map-marker"></i><span> {{ trans('position.title-positions') }} </span></a>
            </li>
            <!-- management skill-->
            <li class="@if(Request::url() == action('Admin\SkillController@index')) active @endif ">

                <a href="{{ action('Admin\SkillController@index') }}"><i class="fa fa-asterisk"></i><span> {{ trans('skill.title-skills') }} </span></a>
            </li>
            <!-- management projects-->
            <li class="@if(Request::url() == action('Admin\ProjectController@index')) active @endif ">

                <a href="{{ action('Admin\ProjectController@index') }}"><i class="fa fa-tasks"></i><span> {{ trans('admin.title-projects') }} </span></a>
            </li>
            <!-- management activities-->
            <li class="@if(Request::url() == action('Admin\ActivityController@index')) active @endif ">

                <a href="{{ action('Admin\ActivityController@index') }}"><i class="fa fa-history"></i><span> {{ trans('admin.title-activities') }} </span></a>
            </li>
        @endif
    </ul>
</div>
