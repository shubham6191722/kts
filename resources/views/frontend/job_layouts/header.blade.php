<?php
    $routename = \Request::route()->getName();
    $role_name = App\CustomFunction\CustomFunction::role_name();
?>
<header id="header">
    <nav class="navbar sticky-top navbar-light navbar-expand-lg bootsnav nav-tzanfer white py-xl-4 py-lg-4 py-md-3 position-relative">
        <div class="container justify-content-end">
            <a class="navbar-brand d-xxl-none d-xl-none d-lg-none d-md-none d-none" href="{{route('home.index')}}"><img src="{!!$company_logo!!}" class="logo  img-" alt=""></a>
            @include('frontend.layouts.menu')
        </div>
    </nav>
</header>
