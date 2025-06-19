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
        <style>
            table {
              font-family: arial, sans-serif;
              border-collapse: collapse;
              width: 100%;
            }
            
            td, th {
              border: 1px solid #dddddd;
              text-align: left;
              padding: 8px;
            }
            
            tr:nth-child(even) {
              background-color: #dddddd;
            }
        </style>
    </head>
    <body id="kt_body" class="bg-white" onload="window.print()">    
        <div class="d-flex flex-column-fluid">
            <div class="container h-100">
                <div class="row">
                    <div class="col-12 p-3">
                        <table>
                            <tr>
                                <th>Sr No.</th>
                                <th>Candidate Name</th>
                                <th>Job Title</th>
                                <th>Suggested start date</th>
                                <th>Offered salary</th>
                                <th>Status</th>
                            </tr>
                            @if(isset($candidates_waiting) && !empty($candidates_waiting) && count($candidates_waiting))
                            @foreach($candidates_waiting as $key => $value)
                                @php
                                    $key = $key + 1;
                                @endphp
                                <tr>
                                    <td>{!! $key !!}</td>
                                    <td>
                                        @if(isset($value['candidate_id']) && !empty($value['candidate_id']))
                                            @if(isset($value['job_reference']) && !empty($value['job_reference']))
                                                @php 
                                                    $tooltip = App\Models\User::getUserName($value['r_c_id']);

                                                    $clientData = App\Models\User::clientData($value['r_c_id']);
                                                    $companyname = '-';
                                                    if(isset($clientData->company_name) && !empty($clientData->company_name)){
                                                        $companyname = $clientData->company_name;
                                                    }
                                                @endphp
                                                {!! App\Models\RecruiterCandidate::recruiterCandidateName($value['candidate_id']) !!} <span class="label label-lg label-light-info label-inline text-capitalize" style="border: 1px solid #dddddd;">{!! $companyname !!}</span>
                                            @else
                                                {!! App\Models\User::getUserName($value['candidate_id']) !!}
                                            @endif
                                        @endif
                                    </td>
                                    <td>{!! App\Models\JobVacancy::jobName($value['vacancy_id']) !!}</td>
                                    <td>
                                        @php
                                            $newformat = null;
                                            if(isset($value['suggested_date']) && !empty($value['suggested_date'])){
                                                $time = strtotime($value['suggested_date']);

                                                $newformat = date('d-m-Y',$time);
                                            }
                                        @endphp
                                        {!! $newformat !!}
                                    </td>
                                    <td>
                                        @if(isset($value['offered_salary']) && !empty($value['offered_salary']))
                                            £{!! App\CustomFunction\CustomFunction::number_format($value['offered_salary']) !!}
                                        @endif
                                    </td>
                                    <td>In Progress</td>
                                </tr>
                            @endforeach
                            @endif
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>