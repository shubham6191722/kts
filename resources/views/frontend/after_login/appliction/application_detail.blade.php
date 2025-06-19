@extends('admin.layouts.common')

@section('title', 'Applications')

@section('headerScripts')
    <link rel="stylesheet" href="{!!url('assets/backend')!!}/css/fancybox.css" />
    <link rel="stylesheet" type="text/css" href="{!!url('assets/backend')!!}/plugins/table/datatable/datatables.css" />
    <link href="{!!url('assets/backend')!!}/plugins/animate/animate.css" rel="stylesheet" type="text/css" />
@stop

@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
            <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                <div class="d-flex align-items-center flex-wrap mr-2">
                    <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Applications</h5>
                </div>
            </div>
        </div>
        <div class="d-flex flex-column-fluid">
            <div class="container">
                <div class="card card-custom gutter-b">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-shrink-0 mr-7">
                                <div class="symbol symbol-50 symbol-lg-120">
                                    <img alt="Pic" src="{{url('assets/backend')}}/media//users/300_1.jpg">
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <div class="d-flex align-items-center justify-content-between flex-wrap">
                                    <div class="mr-3">
                                        <div class="d-flex align-items-center mr-3">
                                            <a href="#" class="d-flex align-items-center text-dark text-hover-primary font-size-h5 font-weight-bold mr-3">David Smith</a>
                                        </div>
                                        <div class="d-flex flex-wrap my-2">
                                            <a href="#" class="text-muted text-hover-primary font-weight-bold mr-lg-8 mr-5 mb-lg-0 mb-2">
                                            <span class="svg-icon svg-icon-md svg-icon-gray-500 mr-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <rect x="0" y="0" width="24" height="24"></rect>
                                                        <path d="M21,12.0829584 C20.6747915,12.0283988 20.3407122,12 20,12 C16.6862915,12 14,14.6862915 14,18 C14,18.3407122 14.0283988,18.6747915 14.0829584,19 L5,19 C3.8954305,19 3,18.1045695 3,17 L3,8 C3,6.8954305 3.8954305,6 5,6 L19,6 C20.1045695,6 21,6.8954305 21,8 L21,12.0829584 Z M18.1444251,7.83964668 L12,11.1481833 L5.85557487,7.83964668 C5.4908718,7.6432681 5.03602525,7.77972206 4.83964668,8.14442513 C4.6432681,8.5091282 4.77972206,8.96397475 5.14442513,9.16035332 L11.6444251,12.6603533 C11.8664074,12.7798822 12.1335926,12.7798822 12.3555749,12.6603533 L18.8555749,9.16035332 C19.2202779,8.96397475 19.3567319,8.5091282 19.1603533,8.14442513 C18.9639747,7.77972206 18.5091282,7.6432681 18.1444251,7.83964668 Z" fill="#000000"></path>
                                                        <circle fill="#000000" opacity="0.3" cx="19.5" cy="17.5" r="2.5"></circle>
                                                    </g>
                                                </svg>
                                            </span>david.s@loop.com</a>
                                            <a href="#" class="text-muted text-hover-primary font-weight-bold">
                                            <span class="svg-icon svg-icon-md svg-icon-gray-500 mr-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <rect x="0" y="0" width="24" height="24"></rect>
                                                        <path d="M9.82829464,16.6565893 C7.02541569,15.7427556 5,13.1079084 5,10 C5,6.13400675 8.13400675,3 12,3 C15.8659932,3 19,6.13400675 19,10 C19,13.1079084 16.9745843,15.7427556 14.1717054,16.6565893 L12,21 L9.82829464,16.6565893 Z M12,12 C13.1045695,12 14,11.1045695 14,10 C14,8.8954305 13.1045695,8 12,8 C10.8954305,8 10,8.8954305 10,10 C10,11.1045695 10.8954305,12 12,12 Z" fill="#000000"></path>
                                                    </g>
                                                </svg>
                                            </span>Melbourne</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center flex-wrap justify-content-between">
                                    <div class="flex-grow-1 font-weight-bold text-dark-50 py-2 py-lg-2 mr-5">I distinguish three main text objectives could be merely to inform people. 
                                    <br>A second could be persuade people. You want people to bay objective.</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xl-4">
                        <div class="card card-custom card-stretch gutter-b">
                            <div class="card-header h-auto py-4">
                                <div class="card-title">
                                    <h3 class="card-label">Company 
                                    <span class="d-block text-muted pt-2 font-size-sm">company profile preview</span></h3>
                                </div>
                            </div>
                            <div class="card-body py-4">
                                <div class="form-group row my-2">
                                    <label class="col-4 col-form-label">Name:</label>
                                    <div class="col-8">
                                        <span class="form-control-plaintext font-weight-bolder">Loop Inc.</span>
                                    </div>
                                </div>
                                <div class="form-group row my-2">
                                    <label class="col-4 col-form-label">Location:</label>
                                    <div class="col-8">
                                        <span class="form-control-plaintext font-weight-bolder">London, UK.</span>
                                    </div>
                                </div>
                                <div class="form-group row my-2">
                                    <label class="col-4 col-form-label">Revenue:</label>
                                    <div class="col-8">
                                        <span class="form-control-plaintext">
                                        <span class="font-weight-bolder">345,000M</span>&nbsp; 
                                        <span class="label label-inline label-danger label-bold">Q4, 2019</span></span>
                                    </div>
                                </div>
                                <div class="form-group row my-2">
                                    <label class="col-4 col-form-label">Phone:</label>
                                    <div class="col-8">
                                        <span class="form-control-plaintext font-weight-bolder">+456 7890456</span>
                                    </div>
                                </div>
                                <div class="form-group row my-2">
                                    <label class="col-4 col-form-label">Email:</label>
                                    <div class="col-8">
                                        <span class="form-control-plaintext font-weight-bolder">
                                            <a href="#">info@loop.com</a>
                                        </span>
                                    </div>
                                </div>
                                <div class="form-group row my-2">
                                    <label class="col-4 col-form-label">Website:</label>
                                    <div class="col-8">
                                        <span class="form-control-plaintext font-weight-bolder">
                                            <a href="#">www.loop.com</a>
                                        </span>
                                    </div>
                                </div>
                                <div class="form-group row my-2">
                                    <label class="col-4 col-form-label">Contact Person:</label>
                                    <div class="col-8">
                                        <span class="form-control-plaintext font-weight-bolder">
                                            <a href="#">Nick Bold</a>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-8">
                        <div class="card card-custom card-stretch gutter-b chat-box" data-to_user_id="1" data-show-message="0">
                            <div class="card-header align-items-center px-4 py-3">
                                <div class="text-center flex-grow-1">
                                    <div class="text-dark-75 font-weight-bold font-size-h5">Matt Pears</div>
                                    <div>
                                        <span class="label label-sm label-dot label-success"></span>
                                        <span class="font-weight-bold text-muted font-size-sm">Active</span>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body message-box-body">
                                <div class="user-chat d-flexs align-items-center">
                                    
                                    <div class="user-chat-des d-flex flex-column">
                                        <span class="user-chat-timing"></span>
                                        <p class="mb-0 user-chat-summary" id="user_message_data">
                                            <div class="d-flex flex-column mb-5 align-items-start">
                                                <div class="d-flex align-items-center">
                                                    <div class="symbol symbol-circle symbol-40 mr-3">
                                                        <img alt="Pic" src="{!!url('assets/backend')!!}/media/users/300_12.jpg">
                                                    </div>
                                                    <div>
                                                        <a href="#" class="text-dark-75 text-hover-primary font-weight-bold font-size-h6">Matt Pears</a>
                                                        <span class="text-muted font-size-sm">2 Hours</span>
                                                    </div>
                                                </div>
                                                <div class="mt-2 rounded p-5 bg-light-success text-dark-50 font-weight-bold font-size-lg text-left max-w-400px">How likely are you to recommend our company to your friends and family?</div>
                                            </div>
                                            <div class="d-flex flex-column mb-5 align-items-end">
                                                <div class="d-flex align-items-center">
                                                    <div>
                                                        <span class="text-muted font-size-sm">3 minutes</span>
                                                        <a href="#" class="text-dark-75 text-hover-primary font-weight-bold font-size-h6">You</a>
                                                    </div>
                                                    <div class="symbol symbol-circle symbol-40 ml-3">
                                                        <img alt="Pic" src="{!!url('assets/backend')!!}/media/users/300_21.jpg">
                                                    </div>
                                                </div>
                                                <div class="mt-2 rounded p-5 bg-light-primary text-dark-50 font-weight-bold font-size-lg text-right max-w-400px">Hey there, we’re just writing to let you know that you’ve been subscribed to a repository on GitHub.</div>
                                            </div>
                                            <div class="d-flex flex-column mb-5 align-items-start">
                                                <div class="d-flex align-items-center">
                                                    <div class="symbol symbol-circle symbol-40 mr-3">
                                                        <img alt="Pic" src="{!!url('assets/backend')!!}/media/users/300_12.jpg">
                                                    </div>
                                                    <div>
                                                        <a href="#" class="text-dark-75 text-hover-primary font-weight-bold font-size-h6">Matt Pears</a>
                                                        <span class="text-muted font-size-sm">2 Hours</span>
                                                    </div>
                                                </div>
                                                <div class="mt-2 rounded p-5 bg-light-success text-dark-50 font-weight-bold font-size-lg text-left max-w-400px">How likely are you to recommend our company to your friends and family?</div>
                                            </div>
                                            <div class="d-flex flex-column mb-5 align-items-end">
                                                <div class="d-flex align-items-center">
                                                    <div>
                                                        <span class="text-muted font-size-sm">3 minutes</span>
                                                        <a href="#" class="text-dark-75 text-hover-primary font-weight-bold font-size-h6">You</a>
                                                    </div>
                                                    <div class="symbol symbol-circle symbol-40 ml-3">
                                                        <img alt="Pic" src="{!!url('assets/backend')!!}/media/users/300_21.jpg">
                                                    </div>
                                                </div>
                                                <div class="mt-2 rounded p-5 bg-light-primary text-dark-50 font-weight-bold font-size-lg text-right max-w-400px">Hey there, we’re just writing to let you know that you’ve been subscribed to a repository on GitHub.</div>
                                            </div>
                                            <div class="d-flex flex-column mb-5 align-items-start">
                                                <div class="d-flex align-items-center">
                                                    <div class="symbol symbol-circle symbol-40 mr-3">
                                                        <img alt="Pic" src="{!!url('assets/backend')!!}/media/users/300_12.jpg">
                                                    </div>
                                                    <div>
                                                        <a href="#" class="text-dark-75 text-hover-primary font-weight-bold font-size-h6">Matt Pears</a>
                                                        <span class="text-muted font-size-sm">2 Hours</span>
                                                    </div>
                                                </div>
                                                <div class="mt-2 rounded p-5 bg-light-success text-dark-50 font-weight-bold font-size-lg text-left max-w-400px">How likely are you to recommend our company to your friends and family?</div>
                                            </div>
                                            <div class="d-flex flex-column mb-5 align-items-end">
                                                <div class="d-flex align-items-center">
                                                    <div>
                                                        <span class="text-muted font-size-sm">3 minutes</span>
                                                        <a href="#" class="text-dark-75 text-hover-primary font-weight-bold font-size-h6">You</a>
                                                    </div>
                                                    <div class="symbol symbol-circle symbol-40 ml-3">
                                                        <img alt="Pic" src="{!!url('assets/backend')!!}/media/users/300_21.jpg">
                                                    </div>
                                                </div>
                                                <div class="mt-2 rounded p-5 bg-light-primary text-dark-50 font-weight-bold font-size-lg text-right max-w-400px">Hey there, we’re just writing to let you know that you’ve been subscribed to a repository on GitHub.</div>
                                            </div>
                                            <div class="d-flex flex-column mb-5 align-items-start">
                                                <div class="d-flex align-items-center">
                                                    <div class="symbol symbol-circle symbol-40 mr-3">
                                                        <img alt="Pic" src="{!!url('assets/backend')!!}/media/users/300_12.jpg">
                                                    </div>
                                                    <div>
                                                        <a href="#" class="text-dark-75 text-hover-primary font-weight-bold font-size-h6">Matt Pears</a>
                                                        <span class="text-muted font-size-sm">2 Hours</span>
                                                    </div>
                                                </div>
                                                <div class="mt-2 rounded p-5 bg-light-success text-dark-50 font-weight-bold font-size-lg text-left max-w-400px">How likely are you to recommend our company to your friends and family?</div>
                                            </div>
                                            <div class="d-flex flex-column mb-5 align-items-end">
                                                <div class="d-flex align-items-center">
                                                    <div>
                                                        <span class="text-muted font-size-sm">3 minutes</span>
                                                        <a href="#" class="text-dark-75 text-hover-primary font-weight-bold font-size-h6">You</a>
                                                    </div>
                                                    <div class="symbol symbol-circle symbol-40 ml-3">
                                                        <img alt="Pic" src="{!!url('assets/backend')!!}/media/users/300_21.jpg">
                                                    </div>
                                                </div>
                                                <div class="mt-2 rounded p-5 bg-light-primary text-dark-50 font-weight-bold font-size-lg text-right max-w-400px">Hey there, we’re just writing to let you know that you’ve been subscribed to a repository on GitHub.</div>
                                            </div>
                                            <div class="d-flex flex-column mb-5 align-items-start">
                                                <div class="d-flex align-items-center">
                                                    <div class="symbol symbol-circle symbol-40 mr-3">
                                                        <img alt="Pic" src="{!!url('assets/backend')!!}/media/users/300_12.jpg">
                                                    </div>
                                                    <div>
                                                        <a href="#" class="text-dark-75 text-hover-primary font-weight-bold font-size-h6">Matt Pears</a>
                                                        <span class="text-muted font-size-sm">2 Hours</span>
                                                    </div>
                                                </div>
                                                <div class="mt-2 rounded p-5 bg-light-success text-dark-50 font-weight-bold font-size-lg text-left max-w-400px">How likely are you to recommend our company to your friends and family?</div>
                                            </div>
                                            <div class="d-flex flex-column mb-5 align-items-end">
                                                <div class="d-flex align-items-center">
                                                    <div>
                                                        <span class="text-muted font-size-sm">3 minutes</span>
                                                        <a href="#" class="text-dark-75 text-hover-primary font-weight-bold font-size-h6">You</a>
                                                    </div>
                                                    <div class="symbol symbol-circle symbol-40 ml-3">
                                                        <img alt="Pic" src="{!!url('assets/backend')!!}/media/users/300_21.jpg">
                                                    </div>
                                                </div>
                                                <div class="mt-2 rounded p-5 bg-light-primary text-dark-50 font-weight-bold font-size-lg text-right max-w-400px">Hey there, we’re just writing to let you know that you’ve been subscribed to a repository on GitHub.</div>
                                            </div>
                                        </p>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="card-footer align-items-center">
                                <form class="text-box text-end">
                                    <textarea class="form-control border-0 p-0" id="message_text" rows="2" placeholder="Type message here..."></textarea>
                                    <div class="d-flex align-items-center justify-content-end mt-5">
                                        <button type="button" id="btn_send" class="btn btn-primary btn-md text-uppercase font-weight-bold chat-send py-2 px-6">Send</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
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
        $(".save_user_chat").on('click', function(e){

            e.preventDefault();

            var data = $('#comment').serialize()

            $.ajax({
                type: "POST",
                url: '{{ route("comman.saveUserChat") }}',
                data: data,
                cache: false,
                beforeSend: function () {
                    $(".loading").show();
                },
                success: function(data){
                    if(data.action == 'validator_error'){
                        $.confirm({
                            title: 'Scusa',
                            content: data.msg,
                            type: 'red',
                            typeAnimated: true,
                            buttons: {
                                tryAgain: {
                                    text: 'Ok',
                                    btnClass: 'btn-red',
                                },
                            }
                        });
                    }
                    if(data.action == 'success'){

                        if(data.html == "not_send_msg"){
                            location.reload();
                        }

                        $(".tz_user_message_lists").html(data.html);

                        $(".sel_img_cluster_sub,.sel_img_cluster").html('');
                        $(".selected_level_friend,selected_level").val('');
                        $('#summernote').summernote('reset');

                        $('[data-toggle="tooltip"]').tooltip({
                            html: 'true',
                            container: 'body'
                        });
                    }
                },
                complete: function (data) {
                    $(".loading").hide();
                },
            });

        });
    </script>

@stop 
