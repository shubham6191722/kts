<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Reoprt | {!!site_title!!}</title>

        <meta name="csrf-token" content="{{ csrf_token() }}" />

        <link rel="shortcut icon" href="{!!site_favicon!!}"/>

        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700"/>
        <link href="{{url('assets/backend')}}/plugins/custom/fullcalendar/fullcalendar.bundle.css" rel="stylesheet" type="text/css"/>
        <link href="{{url('assets/backend')}}/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css"/>
        <link href="{{url('assets/backend')}}/plugins/custom/prismjs/prismjs.bundle.css" rel="stylesheet" type="text/css"/>
        <link href="{{url('assets/backend')}}/css/style.bundle.css" rel="stylesheet" type="text/css"/>
        <link href="{{url('assets/backend')}}/css/themes/layout/header/base/dark.css" rel="stylesheet" type="text/css"/>
        <link href="{{url('assets/backend')}}/css/themes/layout/header/menu/dark.css" rel="stylesheet" type="text/css"/>
        <link href="{{url('assets/backend')}}/css/themes/layout/brand/dark.css" rel="stylesheet" type="text/css"/>
        <link href="{{url('assets/backend')}}/css/themes/layout/aside/dark.css" rel="stylesheet" type="text/css"/>
        <link href="{{url('assets/backend')}}/css/custom.css" rel="stylesheet" type="text/css"/>


        
        @yield('headerScripts')
    </head>
    <body id="kt_body" class="bg-white" onload="window.print()">    
        <div class="d-flex flex-column-fluid" id="divToPrint">
            <div class="container h-100">
                {{-- <div class="d-flex justify-content-center align-items-center h-100"> --}}
                    <div class="row">
                        
                        <div class="col-4">
                            <div class="card  card-stretch gutter-b">
                                <div class="card-body p-0">
                                    <div class="d-flex align-items-center justify-content-between card-spacer flex-grow-1">
                                        <span class="symbol symbol-50 symbol-light-primary mr-2">
                                            <span class="symbol-label" style="border: 1px solid #EBEDF3;">
                                                <span class="svg-icon svg-icon-xl svg-icon-primary">
                                                    <i class="fas fa-archive icon-lg text-primary"></i>
                                                </span>
                                            </span>
                                        </span>
                                        <div class="d-flex flex-column text-right">
                                            <span class="text-dark-75 font-weight-bolder font-size-h3" id="live_vacancies">{!! $live_vacancies !!}</span>
                                            <span class="text-muted font-weight-bold mt-2">Live vacancies</span>
                                        </div>
                                    </div>
                                </div> 
                            </div>
                        </div>
                        
                        <div class="col-4">
                            <div class="card  card-stretch gutter-b">
                                <div class="card-body p-0">
                                    <div class="d-flex align-items-center justify-content-between card-spacer flex-grow-1">
                                        <span class="symbol symbol-50 symbol-light-primary mr-2">
                                            <span class="symbol-label" style="border: 1px solid #EBEDF3;">
                                                <span class="svg-icon svg-icon-xl svg-icon-primary">
                                                    <i class="fas fa-user-tie icon-lg text-primary"></i>
                                                </span>
                                            </span>
                                        </span>
                                        <div class="d-flex flex-column text-right">
                                            <span class="text-dark-75 font-weight-bolder font-size-h3" id="live_interviews">{!! $live_interviews !!}</span>
                                            <span class="text-muted font-weight-bold mt-2">Live interviews</span>
                                        </div>
                                    </div>
                                </div> 
                            </div>
                        </div>
                        
                        <div class="col-4">
                            <div class="card  card-stretch gutter-b">
                                <div class="card-body p-0">
                                    <div class="d-flex align-items-center justify-content-between card-spacer flex-grow-1">
                                        <span class="symbol symbol-50 symbol-light-primary mr-2">
                                            <span class="symbol-label" style="border: 1px solid #EBEDF3;">
                                                <span class="svg-icon svg-icon-xl svg-icon-primary">
                                                    <i class="fas fa-pound-sign icon-lg text-primary"></i>
                                                </span>
                                            </span>
                                        </span>
                                        <div class="d-flex flex-column text-right">
                                            <span class="text-dark-75 font-weight-bolder font-size-h3" id="offers_pending">{!! $offers_pending !!}</span>
                                            <span class="text-muted font-weight-bold mt-2">Offers pending</span>
                                        </div>
                                    </div>
                                </div> 
                            </div>
                        </div>
                        
                        <div class="col-4">
                            <div class="card  card-stretch gutter-b">
                                <div class="card-body p-0">
                                    <div class="d-flex align-items-center justify-content-between card-spacer flex-grow-1">
                                        <span class="symbol symbol-50 symbol-light-primary mr-2">
                                            <span class="symbol-label" style="border: 1px solid #EBEDF3;">
                                                <span class="svg-icon svg-icon-xl svg-icon-primary">
                                                    <i class="fas fa-window-close icon-lg text-primary"></i>
                                                </span>
                                            </span>
                                        </span>
                                        <div class="d-flex flex-column text-right">
                                            <span class="text-dark-75 font-weight-bolder font-size-h3" id="jobs_filled">{!! $jobs_filled !!}</span>
                                            <span class="text-muted font-weight-bold mt-2">Jobs filled</span>
                                        </div>
                                    </div>
                                </div> 
                            </div>
                        </div>
                        
                        <div class="col-4">
                            <div class="card  card-stretch gutter-b">
                                <div class="card-body p-0">
                                    <div class="d-flex align-items-center justify-content-between card-spacer flex-grow-1">
                                        <span class="symbol symbol-50 symbol-light-primary mr-2">
                                            <span class="symbol-label" style="border: 1px solid #EBEDF3;">
                                                <span class="svg-icon svg-icon-xl svg-icon-primary">
                                                    <i class="fas fa-user-clock icon-lg text-primary"></i>
                                                </span>
                                            </span>
                                        </span>
                                        <div class="d-flex flex-column text-right">
                                            <span class="text-dark-75 font-weight-bolder font-size-h3" id="candidates_waiting">{!! $candidates_waiting !!}</span>
                                            <span class="text-muted font-weight-bold mt-2">Candidates waiting</span>
                                        </div>
                                    </div>
                                </div> 
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="card  card-stretch gutter-b">
                                <div class="card-body p-0">
                                    <div class="d-flex align-items-center justify-content-between card-spacer flex-grow-1">
                                        <span class="symbol symbol-50 symbol-light-primary mr-2">
                                            <span class="symbol-label" style="border: 1px solid #EBEDF3;">
                                                <span class="svg-icon svg-icon-xl svg-icon-primary">
                                                    <i class="far fa-clipboard icon-lg text-primary"></i>
                                                </span>
                                            </span>
                                        </span>
                                        <div class="d-flex flex-column text-right">
                                            <span class="text-dark-75 font-weight-bolder font-size-h3" id="jobs_on_hold">{!! $jobs_on_hold !!}</span>
                                            <span class="text-muted font-weight-bold mt-2">Jobs on hold</span>
                                        </div>
                                    </div>
                                </div> 
                            </div>
                        </div>
                        
                        <div class="col-4">
                            <div class="card  card-stretch gutter-b">
                                <div class="card-body p-0">
                                    <div class="d-flex align-items-center justify-content-between card-spacer flex-grow-1">
                                        <span class="symbol symbol-50 symbol-light-primary mr-2">
                                            <span class="symbol-label" style="border: 1px solid #EBEDF3;">
                                                <span class="svg-icon svg-icon-xl svg-icon-primary">
                                                    <i class="fas fa-ban icon-lg text-primary"></i>
                                                </span>
                                            </span>
                                        </span>
                                        <div class="d-flex flex-column text-right">
                                            <span class="text-dark-75 font-weight-bolder font-size-h3" id="jobs_cancelled">{!! $jobs_cancelled !!}</span>
                                            <span class="text-muted font-weight-bold mt-2">Jobs cancelled</span>
                                        </div>
                                    </div>
                                </div> 
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="card  card-stretch gutter-b">
                                <div class="card-body p-0">
                                    <div class="d-flex align-items-center justify-content-between card-spacer flex-grow-1">
                                        <span class="symbol symbol-50 symbol-light-primary mr-2">
                                            <span class="symbol-label" style="border: 1px solid #EBEDF3;">
                                                <span class="svg-icon svg-icon-xl svg-icon-primary">
                                                    <i class="fas fa-users-slash icon-lg text-primary"></i>
                                                </span>
                                            </span>
                                        </span>
                                        <div class="d-flex flex-column text-right">
                                            <span class="text-dark-75 font-weight-bolder font-size-h3" id="candidates_left">{!! $candidates_left !!}</span>
                                            <span class="text-muted font-weight-bold mt-2">Candidates left</span>
                                        </div>
                                    </div>
                                </div> 
                            </div>
                        </div>

                    </div>
                {{-- </div> --}}
            </div>
        </div>
    </body>
</html>