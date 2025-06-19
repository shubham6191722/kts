<ul class="menu-nav">
    <li class="menu-item {{($routename=='home.index') ? 'menu-item-open':''}}" aria-haspopup="true">
        <a href="{!!route('home.index')!!}"
            class="menu-link">
            <span class="svg-icon menu-icon">
                <i class="flaticon-home-1 custom-sidebar-color"></i>
            </span>
            <span class="menu-text">Home</span>
        </a>
    </li>
    <li class="menu-item {{($routename=='candidate.dashboard') ? 'menu-item-open':''}}" aria-haspopup="true">
        <a href="{!!route('candidate.dashboard')!!}"
            class="menu-link">
            <span class="svg-icon menu-icon">
                <i class="flaticon-layer custom-sidebar-color"></i>
            </span>
            <span class="menu-text">Dashboard</span>
        </a>
    </li>
    <li class="menu-item {{($routename=='candidate.applications') ? 'menu-item-open':''}}" aria-haspopup="true">
        <a href="{!!route('candidate.applications')!!}"
            class="menu-link">
            <span class="svg-icon menu-icon">
                <i class="flaticon-squares-1 custom-sidebar-color"></i>
            </span>
            <span class="menu-text">Applications</span>
        </a>
    </li>
    <li class="menu-item {{($routename=='candidate.offerGet') ? 'menu-item-open':''}}" aria-haspopup="true">
        <a href="{!!route('candidate.offerGet')!!}"
            class="menu-link">
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

    <li class="menu-item menu-item-submenu {{($routename=='candidate.indexList') ? ' menu-item-open':''}}" aria-haspopup="true" data-menu-toggle="hover">
        <a href="{!!route('candidate.indexList')!!}" class="menu-link menu-toggle">
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

    @php $menuExpanded = (($routename=='candidate.profileSetting') ? true:false); @endphp
    <li class="menu-item {{($routename=='candidate.profileSetting') ? 'menu-item-open':''}}" aria-haspopup="true">
        <a href="{!!route('candidate.profileSetting')!!}"
            class="menu-link">
            <span class="svg-icon menu-icon">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <polygon points="0 0 24 0 24 24 0 24"/>
                        <path d="M12,11 C9.790861,11 8,9.209139 8,7 C8,4.790861 9.790861,3 12,3 C14.209139,3 16,4.790861 16,7 C16,9.209139 14.209139,11 12,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
                        <path d="M3.00065168,20.1992055 C3.38825852,15.4265159 7.26191235,13 11.9833413,13 C16.7712164,13 20.7048837,15.2931929 20.9979143,20.2 C21.0095879,20.3954741 20.9979143,21 20.2466999,21 C16.541124,21 11.0347247,21 3.72750223,21 C3.47671215,21 2.97953825,20.45918 3.00065168,20.1992055 Z" fill="#000000" fill-rule="nonzero"/>
                    </g>
                </svg>
            </span>
            <span class="menu-text">My Profile</span>
        </a>
    </li>

    @php $menuExpanded = (($routename=='candidate.jobAlertSetting') ? true:false); @endphp
    <li class="menu-item {{($routename=='candidate.jobAlertSetting') ? 'menu-item-open':''}}" aria-haspopup="true">
        <a href="{!!route('candidate.jobAlertSetting')!!}"
            class="menu-link">
            <span class="svg-icon menu-icon">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <path d="M17,12 L18.5,12 C19.3284271,12 20,12.6715729 20,13.5 C20,14.3284271 19.3284271,15 18.5,15 L5.5,15 C4.67157288,15 4,14.3284271 4,13.5 C4,12.6715729 4.67157288,12 5.5,12 L7,12 L7.5582739,6.97553494 C7.80974924,4.71225688 9.72279394,3 12,3 C14.2772061,3 16.1902508,4.71225688 16.4417261,6.97553494 L17,12 Z" fill="#000000"/>
                        <rect fill="#000000" opacity="0.3" x="10" y="16" width="4" height="4" rx="2"/>
                    </g>
                </svg>
            </span>
            <span class="menu-text">Job Alert</span>
        </a>
    </li>
</ul>
