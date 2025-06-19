@extends('layouts.common')

@section('title', 'Setting')

@section('headerScripts')
    <link href="{{assets}}/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css"/>
@stop

@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
            <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                <div class="d-flex align-items-center flex-wrap mr-2">
                    <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Setting</h5>
                </div>
            </div>
        </div>
        <div class="d-flex flex-column-fluid">
            <div class="container">
                <div class="card card-custom">
                    <div class="card-header card-header-tabs-line nav-tabs-line-3x">
                        <div class="card-toolbar">
                            <ul class="nav nav-tabs nav-bold nav-tabs-line nav-tabs-line-3x">
                                <li class="nav-item mr-3">
                                    <a class="nav-link active" data-toggle="tab" href="#kt_tab_my_account_setting">
                                        <span class="nav-icon">
                                            <span class="svg-icon">
                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <rect x="0" y="0" width="24" height="24"/>
                                                        <path
                                                            d="M4,4 L11.6314229,2.5691082 C11.8750185,2.52343403 12.1249815,2.52343403 12.3685771,2.5691082 L20,4 L20,13.2830094 C20,16.2173861 18.4883464,18.9447835 16,20.5 L12.5299989,22.6687507 C12.2057287,22.8714196 11.7942713,22.8714196 11.4700011,22.6687507 L8,20.5 C5.51165358,18.9447835 4,16.2173861 4,13.2830094 L4,4 Z"
                                                            fill="#000000" opacity="0.3"/>
                                                        <path d="M12,11 C10.8954305,11 10,10.1045695 10,9 C10,7.8954305 10.8954305,7 12,7 C13.1045695,7 14,7.8954305 14,9 C14,10.1045695 13.1045695,11 12,11 Z" fill="#000000" opacity="0.3"/>
                                                        <path
                                                            d="M7.00036205,16.4995035 C7.21569918,13.5165724 9.36772908,12 11.9907452,12 C14.6506758,12 16.8360465,13.4332455 16.9988413,16.5 C17.0053266,16.6221713 16.9988413,17 16.5815,17 C14.5228466,17 11.463736,17 7.4041679,17 C7.26484009,17 6.98863236,16.6619875 7.00036205,16.4995035 Z"
                                                            fill="#000000" opacity="0.3"/>
                                                    </g>
                                                </svg>
                                            </span>
                                        </span>
                                        <span class="nav-text font-size-lg">My Account</span>
                                    </a>
                                </li>
                                <li class="nav-item mr-3">
                                    <a class="nav-link" data-toggle="tab" href="#kt_tab_user_change_password">
                                        <span class="nav-icon">
                                            <span class="svg-icon">
                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <rect x="0" y="0" width="24" height="24"/>
                                                        <path
                                                            d="M4,4 L11.6314229,2.5691082 C11.8750185,2.52343403 12.1249815,2.52343403 12.3685771,2.5691082 L20,4 L20,13.2830094 C20,16.2173861 18.4883464,18.9447835 16,20.5 L12.5299989,22.6687507 C12.2057287,22.8714196 11.7942713,22.8714196 11.4700011,22.6687507 L8,20.5 C5.51165358,18.9447835 4,16.2173861 4,13.2830094 L4,4 Z"
                                                            fill="#000000" opacity="0.3"/>
                                                        <path d="M12,11 C10.8954305,11 10,10.1045695 10,9 C10,7.8954305 10.8954305,7 12,7 C13.1045695,7 14,7.8954305 14,9 C14,10.1045695 13.1045695,11 12,11 Z" fill="#000000" opacity="0.3"/>
                                                        <path
                                                            d="M7.00036205,16.4995035 C7.21569918,13.5165724 9.36772908,12 11.9907452,12 C14.6506758,12 16.8360465,13.4332455 16.9988413,16.5 C17.0053266,16.6221713 16.9988413,17 16.5815,17 C14.5228466,17 11.463736,17 7.4041679,17 C7.26484009,17 6.98863236,16.6619875 7.00036205,16.4995035 Z"
                                                            fill="#000000" opacity="0.3"/>
                                                    </g>
                                                </svg>
                                            </span>
                                        </span>
                                        <span class="nav-text font-size-lg">Change Password</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-body">

                        <div class="tab-content">
                            <div class="show active tab-pane px-7" id="kt_tab_my_account_setting" role="tabpanel">
                                <form class="form" method="POST" action="{{url(admin_side.'account-setting')}}">
                                    @csrf
                                    <div class="row">
                                        <div class="col-xl-7">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>First Name</label>
                                                        <div>
                                                            <input type="text" class="form-control form-control-lg form-control-solid mb-2" name="fname" value="{!! old('fname',Auth::user()->fname) !!}" placeholder="First Name"/>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Last Name</label>
                                                        <div>
                                                            <input type="text" class="form-control form-control-lg form-control-solid mb-2" name="lname" value="{!! old('lname',Auth::user()->lname) !!}" placeholder="Last Name"/>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Email Address</label>
                                                        <div class="input-group input-group-lg input-group-solid">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text">
                                                                    <i class="la la-at"></i>
                                                                </span>
                                                            </div>
                                                            @if(is_super_admin)
                                                            <input type="email" name="email" class="form-control form-control-lg form-control-solid" value="{!! old('email',Auth::user()->email) !!}" placeholder="Email"/>
                                                            @else
                                                            <input type="email" name="email" class="form-control form-control-lg form-control-solid" value="{!! old('email',Auth::user()->email) !!}" placeholder="Email" readonly/>
                                                            @endif
                                                        </div>
                                                        <span class="form-text text-muted">Email will not be publicly displayed.</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer pb-0 mt-10 pl-0">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-6">
                                                <button type="submit" class="btn btn-light-primary font-weight-bold">Save changes</button>
                                                <button type="reset" class="btn btn-light btn-hover-primary font-weight-bold">Cancel</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane px-7" id="kt_tab_user_change_password" role="tabpanel">
                                <form class="form" method="POST" action="{{url(admin_side.'change-password')}}">
                                    @csrf
                                    <div class="row">
                                        <div class="col-xl-7">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>Current Password</label>
                                                        <div>
                                                            <input type="password" class="form-control form-control-lg form-control-solid mb-2" name="current_password" placeholder="Current password"/>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>New Password</label>
                                                        <div>
                                                            <input type="password" class="form-control form-control-lg form-control-solid" name="new_password" placeholder="New password"/>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Confirm Password</label>
                                                        <div>
                                                            <input type="password" class="form-control form-control-lg form-control-solid" name="confirm_password" placeholder="Confirm Password"/>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer pb-0 mt-10 pl-0">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-6">
                                                <button type="submit" class="btn btn-light-primary font-weight-bold">Save changes</button>
                                                <button type="reset" class="btn btn-clean font-weight-bold">Cancel</button>
                                            </div>
                                        </div>
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
    <script src="{{assets}}/plugins/custom/datatables/datatables.bundle.js"></script>
    <script src="{{assets}}/js/pages/features/miscellaneous/sweetalert2.js"></script>
    <script>
    $(function () {
        $('#social_media_datatable').DataTable({
            responsive: true,
            columnDefs: [{orderable: false, targets: -1}]
        });
        $('body').on('click', '.delete-cloud-accounts-btn', function () {

            var deleteForms = $(this).parent();

            Swal.fire({
                title: "Are you sure?",
                text: "You want to delete this record!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, Delete it!"
            }).then(function (result) {
                if (result.value) {
                    deleteForms.submit();
                } else {
                    return false;
                }
            });
        });
    });

    function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 46 || charCode > 57)) {
            return false;
        }
        return true;
    }

    $('body').on('click', '.deactivate_account', function () {
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, desativate it!"
        }).then(function (result) {
            if (result.value) {

                $.ajax({
                    url: "{{ url(admin_side.'deactivate_my_account') }}",
                    dataType: 'json',
                    type: 'post',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (result) {
                        if (result) {
                            Swal.fire("Deactivated!", "Your account has been Deactivate.", "success").then(function (rslt) {
                                if (rslt.value) {
                                    window.location.reload();
                                }
                            });
                        }

                    }
                });
            }
        });
    });
    </script>
@stop
