<?php
    $routename = \Request::route()->getName();
    $role_name = App\CustomFunction\CustomFunction::role_name();
?>
<header id="header">
    <nav class="navbar sticky-top navbar-light navbar-expand-lg bootsnav nav-tzanfer white vkcustomnav">
        <div class="container">
            <a class="navbar-brand" href="{{route('home.index')}}"><img src="{!!site_header_logo!!}" class="logo  img-" alt=""></a>
            @include('frontend.layouts.menu')
        </div>
    </nav>
</header>
