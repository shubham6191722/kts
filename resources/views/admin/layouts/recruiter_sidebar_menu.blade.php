<ul class="menu-nav">
    <li class="menu-item {{($routename=='recruiter.dashboard') ? 'menu-item-open':''}}" aria-haspopup="true">
        <a href="{!!route('recruiter.dashboard')!!}" class="menu-link">
            <span class="svg-icon menu-icon">
                <i class="flaticon-layer custom-sidebar-color"></i>
            </span>
            <span class="menu-text">Dashboard</span>
        </a>
    </li>

    @php $menuExpanded = (($routename=='recruiter.vacancyList' || $routename=='recruiter.recruiterViewVacancy' || $routename=='recruiter.recruiterCandidateList' || $routename=='recruiter.recruiterCandidateAdd' || $routename=='recruiter.recruiterCandidateEdit') ? true:false); @endphp

    <li class="menu-item menu-item-submenu {{($menuExpanded) ? ' menu-item-open':''}}" aria-haspopup="true" data-menu-toggle="hover">
        <a href="javascript:;" class="menu-link menu-toggle">
            <span class="svg-icon menu-icon">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <rect x="0" y="0" width="24" height="24" />
                        <polygon fill="#000000" opacity="0.3" points="6 3 18 3 20 6.5 4 6.5" />
                        <path d="M6,5 L18,5 C19.1045695,5 20,5.8954305 20,7 L20,19 C20,20.1045695 19.1045695,21 18,21 L6,21 C4.8954305,21 4,20.1045695 4,19 L4,7 C4,5.8954305 4.8954305,5 6,5 Z M9,9 C8.44771525,9 8,9.44771525 8,10 C8,10.5522847 8.44771525,11 9,11 L15,11 C15.5522847,11 16,10.5522847 16,10 C16,9.44771525 15.5522847,9 15,9 L9,9 Z" fill="#000000" />
                    </g>
                </svg>
            </span>
            <span class="menu-text">Vacancy</span>
            <i class="menu-arrow"></i>
        </a>
        <div class="menu-submenu" kt-hidden-height="80">
            <i class="menu-arrow"></i>
            <ul class="menu-subnav">
                <li class="menu-item menu-item-parent" aria-haspopup="true">
                    <span class="menu-link">
                        <span class="menu-text">Vacancies</span>
                    </span>
                </li>
                <li class="menu-item {{($routename=='recruiter.vacancyList' || $routename=='recruiter.recruiterViewVacancy') ? 'menu-item-active':''}}" aria-haspopup="true">
                    <a href="{{route('recruiter.vacancyList')}}" class="menu-link">
                        <i class="menu-bullet menu-bullet-dot">
                            <span></span>
                        </i>
                        <span class="menu-text">Vacancy List</span>
                    </a>
                </li>
                <li class="menu-item {{($routename=='recruiter.recruiterCandidateList' || $routename=='recruiter.recruiterCandidateAdd' || $routename=='recruiter.recruiterCandidateEdit') ? 'menu-item-active':''}}" aria-haspopup="true">
                    <a href="{{route('recruiter.recruiterCandidateList')}}" class="menu-link">
                        <i class="menu-bullet menu-bullet-dot">
                            <span></span>
                        </i>
                        <span class="menu-text">Candidate List</span>
                    </a>
                </li>
            </ul>
        </div>
    </li>

    <li class="menu-item menu-item-submenu {{($routename=='recruiter.eventList') ? ' menu-item-open':''}}" aria-haspopup="true" data-menu-toggle="hover">
        <a href="{!!route('recruiter.eventList')!!}" class="menu-link menu-toggle">
            <span class="svg-icon menu-icon">
                <i class="far fa-calendar-alt custom-sidebar-color"></i>
            </span>
            {{-- <span class="menu-text">Scheduled Interview</span> --}}
            <span class="menu-text">Calendar</span>
        </a>
    </li>

    <li class="menu-item menu-item-submenu {{($routename=='recruiter.offerList') ? ' menu-item-open':''}}" aria-haspopup="true" data-menu-toggle="hover">
        <a href="{!!route('recruiter.offerList')!!}" class="menu-link menu-toggle">
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

    <li class="menu-item menu-item-submenu {{($routename=='recruiter.indexList') ? ' menu-item-open':''}}" aria-haspopup="true" data-menu-toggle="hover">
        <a href="{!!route('recruiter.indexList')!!}" class="menu-link menu-toggle">
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

    <li class="menu-item menu-item-submenu  {{($routename=='recruiter.showSetting') ? 'menu-item-open':''}}" aria-haspopup="true" data-menu-toggle="hover">
        <a href="{!!route('recruiter.showSetting')!!}" class="menu-link menu-toggle">
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