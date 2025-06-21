<?php
    $routename = \Request::route()->getName();
    $role_name = App\CustomFunction\CustomFunction::role_name();
?>
<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-menu" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <i class="fa fa-bars"></i>
</button>

<div class="collapse navbar-collapse justify-content-end" id="navbar-menu">
    <ul class="nav navbar-nav navbar-left align-items-center" data-in="fadeInDown" data-out="fadeOutUp">
        <li class="">
            <a href="{{route('home.index')}}">Home</a>
        </li>

        <li class="">
            <a href="{!! route('home.jobList') !!}">Search Vacancies</a>
        </li>

        @if(Auth::check())
            @php
                $route_name = $role_name.'.dashboard';
            @endphp
            <li class="dashboard-bg-header">
                <a href="{{route($route_name)}}">dashboard</a>
            </li>
        @endif
    </ul>
    @if(Auth::check())
        <ul class="nav navbar-nav navbar-right align-items-center" data-in="fadeInDown" data-out="fadeOutUp">
            <li><a href="{{route('logout')}}"><i class="fa fa-sign-in"></i>Logout</a></li>
        </ul>
    @else
        <ul class="nav navbar-nav navbar-right align-items-center" data-in="fadeInDown" data-out="fadeOutUp">
            <li><a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#login"><i class="fa fa-sign-in"></i>Sign In</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right align-items-center" data-in="fadeInDown" data-out="fadeOutUp">
            <li><a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#register" id="register_btn"><i class="fa fa-sign-in"></i>Sign Up</a></li>
        </ul>
    @endif
</div>
        