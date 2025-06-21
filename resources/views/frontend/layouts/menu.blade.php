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
        {{-- <ul class="nav navbar-nav navbar-right align-items-center">
            <li class="nav-item dropdown">
                <a class="nav-link d-flex align-items-center" href="#" id="userDropdown" role="button"
                data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="{{url('')}}/uploads/site_setting/usericon.png" alt="User" class="rounded-circle me-1">
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                    <li><a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#login">
                        <i class="fa fa-sign-in me-1"></i> Sign In
                    </a></li>
                    <li><a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#register" id="register_btn">
                        <i class="fa fa-user-plus me-1"></i> Sign Up
                    </a></li>
                </ul>
            </li>
        </ul> --}}
        <ul class="nav navbar-nav navbar-right align-items-center">
  <li class="nav-item dropdown">
    <a class="nav-link d-flex align-items-center" href="#" id="userDropdown" role="button">
      <img src="http://127.0.0.1:8000/uploads/site_setting/usericon.png" alt="User" class="rounded-circle me-1 user-icon">
    </a>

    <!-- Desktop Dropdown -->
    <ul class="dropdown-menu dropdown-menu-end animated" aria-labelledby="userDropdown">
      <li>
        <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#login">
          <i class="fa fa-sign-in me-1"></i> Sign In
        </a>
      </li>
      <li>
        <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#register" id="register_btn">
          <i class="fa fa-user-plus me-1"></i> Sign Up
        </a>
      </li>
    </ul>

    <!-- Mobile Buttons -->
    <div class="mobile-auth-buttons d-block d-md-none mt-3">
      <a href="javascript:void(0)" class="btn btn-light me-2" data-bs-toggle="modal" data-bs-target="#login">Login</a>
      <a href="javascript:void(0)" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#register" id="register_btn_mobile">Register</a>
    </div>
  </li>
</ul>

    @endif
</div>
        