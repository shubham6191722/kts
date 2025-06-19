<ul class="menu-nav">
    <li class="menu-item {{($routename=='staff.dashboard') ? 'menu-item-open':''}}" aria-haspopup="true">
        <a href="{!!route('staff.dashboard')!!}" class="menu-link">
            <span class="svg-icon menu-icon">
                <i class="flaticon-layer custom-sidebar-color"></i>
            </span>
            <span class="menu-text">Dashboard</span>
        </a>
    </li>

    @php $menuExpanded = (($routename=='staff.vacancyList' || $routename=='staff.vacancyAdd' || $routename=='staff.vacancyEdit'
                        || $routename=='staff.jobApplied' ) ? true:false); @endphp

    <li class="menu-item menu-item-submenu {{($menuExpanded) ? ' menu-item-open':''}}" aria-haspopup="true" data-menu-toggle="hover">
        <a href="{!!route('staff.vacancyList')!!}" class="menu-link menu-toggle">
            <span class="svg-icon menu-icon">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <rect x="0" y="0" width="24" height="24" />
                        <polygon fill="#000000" opacity="0.3" points="6 3 18 3 20 6.5 4 6.5" />
                        <path d="M6,5 L18,5 C19.1045695,5 20,5.8954305 20,7 L20,19 C20,20.1045695 19.1045695,21 18,21 L6,21 C4.8954305,21 4,20.1045695 4,19 L4,7 C4,5.8954305 4.8954305,5 6,5 Z M9,9 C8.44771525,9 8,9.44771525 8,10 C8,10.5522847 8.44771525,11 9,11 L15,11 C15.5522847,11 16,10.5522847 16,10 C16,9.44771525 15.5522847,9 15,9 L9,9 Z" fill="#000000" />
                    </g>
                </svg>
            </span>
            <span class="menu-text">Vacancies</span>
        </a>
    </li>

    {{-- <li class="menu-item menu-item-submenu {{($routename=='staff.eventList') ? ' menu-item-open':''}}" aria-haspopup="true" data-menu-toggle="hover">
        <a href="{!!route('staff.eventList')!!}" class="menu-link menu-toggle">
            <span class="svg-icon menu-icon">
                <i class="far fa-calendar-alt custom-sidebar-color"></i>
            </span>
            <span class="menu-text">Scheduled Events</span>
        </a>
    </li> --}}

    @php $menuExpanded = (($routename=='staff.eventList' || $routename=='staff.pendingEventGet') ? true:false); @endphp
    <li class="menu-item menu-item-submenu  {{($menuExpanded) ? ' menu-item-open':''}}" aria-haspopup="true" data-menu-toggle="hover">
        <a href="javascript:;" class="menu-link menu-toggle">
            <span class="svg-icon menu-icon">
                <i class="far fa-calendar-alt custom-sidebar-color"></i>
            </span>
            <span class="menu-text">Interviews</span>
            <i class="menu-arrow"></i>
        </a>
        <div class="menu-submenu" kt-hidden-height="80">
            <i class="menu-arrow"></i>
            <ul class="menu-subnav">
                <li class="menu-item menu-item-parent" aria-haspopup="true">
                    <span class="menu-link">
                        <span class="menu-text">Interviews</span>
                    </span>
                </li>
                <li class="menu-item {{( $routename=='staff.pendingEventGet' ) ? 'menu-item-active':''}}" aria-haspopup="true">
                    <a href="{{route('staff.pendingEventGet')}}" class="menu-link">
                        <i class="menu-bullet menu-bullet-dot">
                            <span></span>
                        </i>
                        <span class="menu-text">Interview List</span>
                    </a>
                </li>
                <li class="menu-item {{( $routename=='staff.eventList' ) ? 'menu-item-active':''}}" aria-haspopup="true">
                    <a href="{{route('staff.eventList')}}" class="menu-link">
                        <i class="menu-bullet menu-bullet-dot">
                            <span></span>
                        </i>
                        {{-- <span class="menu-text">Scheduled Interview</span> --}}
                        <span class="menu-text">Calendar</span>
                    </a>
                </li>
            </ul>
        </div>
    </li>

    <li class="menu-item menu-item-submenu {{($routename=='staff.offerList') ? ' menu-item-open':''}}" aria-haspopup="true" data-menu-toggle="hover">
        <a href="{!!route('staff.offerList')!!}" class="menu-link menu-toggle">
            <span class="svg-icon menu-icon">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <rect x="0" y="0" width="24" height="24"/>
                        <path d="M7.825,10.225 C7.2,9.475 6.85,8.4 6.85,7.375 C6.85,4.55 9.15,2.05 12.35,2.05 C15.45,2.05 17.8,4.45 17.875,7.425 L15.075,7.425 C15.075,5.85 13.975,4.6 12.35,4.6 C10.75,4.6 9.6,5.775 9.6,7.375 C9.6,8.26626781 10.0162926,9.06146809 10.6676674,9.58392078 C10.7130614,9.62033024 10.7238389,12.2340233 10.7,17.425 L17.5444449,17.425 C17.8205873,17.425 18.0444449,17.6488576 18.0444449,17.925 C18.0444449,17.9869142 18.0329457,18.0482899 18.0105321,18.1060047 L17.3988817,19.6810047 C17.3242018,19.8733052 17.1390868,20 16.9327944,20 L6.3,20 C6.02385763,20 5.8,19.7761424 5.8,19.5 L5.8,17.925 C5.8,17.6488576 6.02385763,17.425 6.3,17.425 L7.925,17.425 L7.925,12.475 L7.825,10.225 Z" fill="#000000"/>
                        <path d="M4.3618034,11.2763932 L4.8618034,10.2763932 C4.94649941,10.1070012 5.11963097,10 5.30901699,10 L15.190983,10 C15.4671254,10 15.690983,10.2238576 15.690983,10.5 C15.690983,10.5776225 15.6729105,10.6541791 15.6381966,10.7236068 L15.1381966,11.7236068 C15.0535006,11.8929988 14.880369,12 14.690983,12 L4.80901699,12 C4.53287462,12 4.30901699,11.7761424 4.30901699,11.5 C4.30901699,11.4223775 4.32708954,11.3458209 4.3618034,11.2763932 Z" fill="#000000" opacity="0.3"/>
                    </g>
                </svg>
            </span>
            <span class="menu-text">Offers</span>
        </a>
    </li>

    {{-- <li class="menu-item menu-item-submenu  {{($routename=='staff.mediaList') ? 'menu-item-open':''}}" aria-haspopup="true" data-menu-toggle="hover">
        <a href="{!!route('staff.mediaList')!!}" class="menu-link menu-toggle">
            <span class="svg-icon menu-icon">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <rect x="0" y="0" width="24" height="24"></rect>
                        <path d="M2,13 C2,12.5 2.5,12 3,12 C3.5,12 4,12.5 4,13 C4,13.3333333 4,15 4,18 C4,19.1045695 4.8954305,20 6,20 L18,20 C19.1045695,20 20,19.1045695 20,18 L20,13 C20,12.4477153 20.4477153,12 21,12 C21.5522847,12 22,12.4477153 22,13 L22,18 C22,20.209139 20.209139,22 18,22 L6,22 C3.790861,22 2,20.209139 2,18 C2,15 2,13.3333333 2,13 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"></path>
                        <rect fill="#000000" opacity="0.3" x="11" y="2" width="2" height="14" rx="1"></rect>
                        <path d="M12.0362375,3.37797611 L7.70710678,7.70710678 C7.31658249,8.09763107 6.68341751,8.09763107 6.29289322,7.70710678 C5.90236893,7.31658249 5.90236893,6.68341751 6.29289322,6.29289322 L11.2928932,1.29289322 C11.6689749,0.916811528 12.2736364,0.900910387 12.6689647,1.25670585 L17.6689647,5.75670585 C18.0794748,6.12616487 18.1127532,6.75845471 17.7432941,7.16896473 C17.3738351,7.57947475 16.7415453,7.61275317 16.3310353,7.24329415 L12.0362375,3.37797611 Z" fill="#000000" fill-rule="nonzero"></path>
                    </g>
                </svg>
            </span>
            <span class="menu-text">Media</span>
        </a>
    </li> --}}

    {{-- @php $menuExpanded = (($routename=='staff.telantPootList' || $routename=='staff.telantPootDetail') ? true:false); @endphp
    <li class="menu-item menu-item-submenu  {{($menuExpanded) ? 'menu-item-open':''}}" aria-haspopup="true" data-menu-toggle="hover">
        <a href="{!!route('staff.telantPootList')!!}" class="menu-link menu-toggle">
            <span class="svg-icon menu-icon">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <rect x="0" y="0" width="24" height="24"/>
                        <circle fill="#000000" opacity="0.3" cx="12" cy="12" r="10"/>
                        <path d="M12,11 C10.8954305,11 10,10.1045695 10,9 C10,7.8954305 10.8954305,7 12,7 C13.1045695,7 14,7.8954305 14,9 C14,10.1045695 13.1045695,11 12,11 Z M7.00036205,16.4995035 C7.21569918,13.5165724 9.36772908,12 11.9907452,12 C14.6506758,12 16.8360465,13.4332455 16.9988413,16.5 C17.0053266,16.6221713 16.9988413,17 16.5815,17 L7.4041679,17 C7.26484009,17 6.98863236,16.6619875 7.00036205,16.4995035 Z" fill="#000000" opacity="0.3"/>
                    </g>
                </svg>
            </span>
            <span class="menu-text">Talent pool</span>
        </a>
    </li> --}}

    <li class="menu-item menu-item-submenu {{($routename=='staff.indexList') ? ' menu-item-open':''}}" aria-haspopup="true" data-menu-toggle="hover">
        <a href="{!!route('staff.indexList')!!}" class="menu-link menu-toggle">
            <span class="svg-icon menu-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path opacity="0.3" d="M20 3H4C2.89543 3 2 3.89543 2 5V16C2 17.1046 2.89543 18 4 18H4.5C5.05228 18 5.5 18.4477 5.5 19V21.5052C5.5 22.1441 6.21212 22.5253 6.74376 22.1708L11.4885 19.0077C12.4741 18.3506 13.6321 18 14.8167 18H20C21.1046 18 22 17.1046 22 16V5C22 3.89543 21.1046 3 20 3Z" fill="currentColor"></path>
                    <rect x="6" y="12" width="7" height="2" rx="1" fill="currentColor"></rect>
                    <rect x="6" y="7" width="12" height="2" rx="1" fill="currentColor"></rect>
                </svg>
            </span>
            <span class="menu-text">Messages</span>
        </a>
    </li>

    <li class="menu-item menu-item-submenu  {{($routename=='staff.showSetting') ? 'menu-item-open':''}}" aria-haspopup="true" data-menu-toggle="hover">
        <a href="{!!route('staff.showSetting')!!}" class="menu-link menu-toggle">
            <span class="svg-icon menu-icon">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <rect x="0" y="0" width="24" height="24"/>
                        <path d="M5,8.6862915 L5,5 L8.6862915,5 L11.5857864,2.10050506 L14.4852814,5 L19,5 L19,9.51471863 L21.4852814,12 L19,14.4852814 L19,19 L14.4852814,19 L11.5857864,21.8994949 L8.6862915,19 L5,19 L5,15.3137085 L1.6862915,12 L5,8.6862915 Z M12,15 C13.6568542,15 15,13.6568542 15,12 C15,10.3431458 13.6568542,9 12,9 C10.3431458,9 9,10.3431458 9,12 C9,13.6568542 10.3431458,15 12,15 Z" fill="#000000"/>
                    </g>
                </svg>
            </span>
            <span class="menu-text">Settings</span>
        </a>
    </li>
</ul>