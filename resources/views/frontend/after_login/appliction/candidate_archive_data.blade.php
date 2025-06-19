@extends('admin.layouts.common')

@section('title', 'Applications')

@section('headerScripts')
    <link rel="stylesheet" href="{!!url('assets/backend')!!}/css/fancybox.css" />
    <link rel="stylesheet" type="text/css" href="{!!url('assets/backend')!!}/plugins/table/datatable/datatables.css" />
    <link href="{!!url('assets/backend')!!}/plugins/animate/animate.css" rel="stylesheet" type="text/css" />
@stop

@section('content')
    <input type="hidden" id="user_id" value="{!! Auth::user()->id !!}">
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
            <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                <div class="d-flex align-items-center flex-wrap mr-2">
                    <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Past Applications</h5>
                </div>
                <div class="d-flex align-items-center flex-wrap mr-2">
                    <a href="{{route('candidate.applications')}}" class="btn btn-primary font-weight-bolder">
                        <span class="svg-icon svg-icon-md">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect x="0" y="0" width="24" height="24"/>
                                    <path d="M10.5,5 L19.5,5 C20.3284271,5 21,5.67157288 21,6.5 C21,7.32842712 20.3284271,8 19.5,8 L10.5,8 C9.67157288,8 9,7.32842712 9,6.5 C9,5.67157288 9.67157288,5 10.5,5 Z M10.5,10 L19.5,10 C20.3284271,10 21,10.6715729 21,11.5 C21,12.3284271 20.3284271,13 19.5,13 L10.5,13 C9.67157288,13 9,12.3284271 9,11.5 C9,10.6715729 9.67157288,10 10.5,10 Z M10.5,15 L19.5,15 C20.3284271,15 21,15.6715729 21,16.5 C21,17.3284271 20.3284271,18 19.5,18 L10.5,18 C9.67157288,18 9,17.3284271 9,16.5 C9,15.6715729 9.67157288,15 10.5,15 Z" fill="#000000"/>
                                    <path d="M5.5,8 C4.67157288,8 4,7.32842712 4,6.5 C4,5.67157288 4.67157288,5 5.5,5 C6.32842712,5 7,5.67157288 7,6.5 C7,7.32842712 6.32842712,8 5.5,8 Z M5.5,13 C4.67157288,13 4,12.3284271 4,11.5 C4,10.6715729 4.67157288,10 5.5,10 C6.32842712,10 7,10.6715729 7,11.5 C7,12.3284271 6.32842712,13 5.5,13 Z M5.5,18 C4.67157288,18 4,17.3284271 4,16.5 C4,15.6715729 4.67157288,15 5.5,15 C6.32842712,15 7,15.6715729 7,16.5 C7,17.3284271 6.32842712,18 5.5,18 Z" fill="#000000" opacity="0.3"/>
                                </g>
                            </svg>
                        </span>
                        Applications
                    </a>
                </div>
            </div>
        </div>
        <div class="d-flex flex-column-fluid">
            <div class="container">
                <div class="row" id="candidate_application_data">
                    
                </div>
            </div>
        </div>
    </div>
@stop

@section('footerScripts')
    <script src="{!!url('assets/backend')!!}/js/fancybox.umd.js"></script>
    <script src="{{url('assets/backend')}}/plugins/custom/ckeditor/ckeditor-classic.bundle.js"></script>

    <script src="{!!url('assets/backend')!!}/plugins/sweetalerts/promise-polyfill.js"></script>
    <script src="{!!url('assets/backend')!!}/js/scrollspyNav.js"></script>

    <script>
        $(function () {
            
            "use strict";
            var user_id = $('#user_id').val();
            applicationData(user_id);

        });

        function applicationData(user_id) {

            var csrf_token = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url: "{{route('candidate.applicationArchiveData')}}",
                dataType: 'json',
                type: 'post',
                data: {
                    id: user_id,
                    _token: csrf_token,
                },
                beforeSend: function () {
                    $.LoadingOverlay("show");
                },
                success: function (data) {
                    if (data.code == 1) {
                        if(data.page){
                            $('#candidate_application_data').html(data.page);
                        }else{
                            $('#candidate_application_data').html('<h4 class="text-center" style="width: 100%;">No Data found</h4>');
                        }
                        
                    } else {

                        $('#candidate_application_data').html('<h4 class="text-center" style="width: 100%;">No Data found</h4>');

                    }
                    setTimeout(function () {
                        $.LoadingOverlay("hide");
                    }, 200);
                },
                error: function (jqXhr, textStatus, errorThrown) {
                    show_toastr('error', 'Please try again!','');
                }
            });

        }
    </script>

@stop 
