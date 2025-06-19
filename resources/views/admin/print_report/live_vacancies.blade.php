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
                                <th>Job Title</th>
                                <th>Job Category</th>
                                <th>Managed by</th>
                                <th>Vacancy Status</th>
                                <th>Vacancy Stage</th>
                            </tr>
                            @if(isset($live_vacancies) && !empty($live_vacancies) && count($live_vacancies))
                            @foreach($live_vacancies as $key => $value)
                                @php
                                    $key = $key + 1;
                                @endphp
                                <tr>
                                    <td>{!! $key !!}</td>
                                    <td>{!! $value['jobtitle'] !!}</td>
                                    <td>{!! App\Models\JobCategory::categoryName($value['categoryid']) !!}</td>
                                    <td>@if($value['managed_by'] == 2) Direct @else Re:Source @endif</td>
                                    <td>{!! $jobvacancystatus[$value['jobvacancystatus']] !!}</td>
                                    <td>{!! $jobvacancystage[$value['jobvacancystage']] !!}</td>
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