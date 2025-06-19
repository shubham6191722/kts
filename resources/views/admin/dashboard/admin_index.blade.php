@extends('admin.layouts.common')

@section('title', 'Dashboard')

@section('headerScripts')
@stop

@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
            <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                <div class="d-flex align-items-center flex-wrap mr-2">
                    <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Dashboard</h5>
                </div>
            </div>
        </div>
        <div class="d-flex flex-column-fluid">
            <div class="container">
                <div class="row">
                    
                    <div class="col-md-3">
                        <div class="card card-custom card-stretch gutter-b">
                            <div class="card-body p-0">
                                <div class="d-flex align-items-center justify-content-between card-spacer flex-grow-1">
                                    <span class="symbol symbol-50 symbol-light-primary mr-2">
                                        <span class="symbol-label">
                                            <span class="svg-icon svg-icon-xl svg-icon-primary">
                                                <i class="fas fa-user icon-lg text-primary"></i>
                                            </span>
                                        </span>
                                    </span>
                                    <div class="d-flex flex-column text-right">
                                        <span class="text-dark-75 font-weight-bolder font-size-h3">{!! $active_candidate !!}</span>
                                        <span class="text-muted font-weight-bold mt-2">Total Active Candidate </span>
                                    </div>
                                </div>
                            </div> 
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="card card-custom card-stretch gutter-b">
                            <div class="card-body p-0">
                                <div class="d-flex align-items-center justify-content-between card-spacer flex-grow-1">
                                    <span class="symbol symbol-50 symbol-light-primary mr-2">
                                        <span class="symbol-label">
                                            <span class="svg-icon svg-icon-xl svg-icon-primary">
                                                <i class="fas fa-user-alt-slash icon-lg text-primary"></i>
                                            </span>
                                        </span>
                                    </span>
                                    <div class="d-flex flex-column text-right">
                                        <span class="text-dark-75 font-weight-bolder font-size-h3">{!! $deactive_candidate !!}</span>
                                        <span class="text-muted font-weight-bold mt-2">Total De-Active Candidate </span>
                                    </div>
                                </div>
                            </div> 
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="card card-custom card-stretch gutter-b">
                            <div class="card-body p-0">
                                <div class="d-flex align-items-center justify-content-between card-spacer flex-grow-1">
                                    <span class="symbol symbol-50 symbol-light-primary mr-2">
                                        <span class="symbol-label">
                                            <span class="svg-icon svg-icon-xl svg-icon-primary">
                                                <i class="fas fa-user-friends icon-lg text-primary"></i>
                                            </span>
                                        </span>
                                    </span>
                                    <div class="d-flex flex-column text-right">
                                        <span class="text-dark-75 font-weight-bolder font-size-h3">{!! $active_client !!}</span>
                                        <span class="text-muted font-weight-bold mt-2">Total Active Client </span>
                                    </div>
                                </div>
                            </div> 
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="card card-custom card-stretch gutter-b">
                            <div class="card-body p-0">
                                <div class="d-flex align-items-center justify-content-between card-spacer flex-grow-1">
                                    <span class="symbol symbol-50 symbol-light-primary mr-2">
                                        <span class="symbol-label">
                                            <span class="svg-icon svg-icon-xl svg-icon-primary">
                                                <i class="fas fa-users-slash icon-lg text-primary"></i>
                                            </span>
                                        </span>
                                    </span>
                                    <div class="d-flex flex-column text-right">
                                        <span class="text-dark-75 font-weight-bolder font-size-h3">{!! $deactive_client !!}</span>
                                        <span class="text-muted font-weight-bold mt-2">Total De-Active Client </span>
                                    </div>
                                </div>
                            </div> 
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="card card-custom card-stretch gutter-b">
                            <div class="card-body p-0">
                                <div class="d-flex align-items-center justify-content-between card-spacer flex-grow-1">
                                    <span class="symbol symbol-50 symbol-light-primary mr-2">
                                        <span class="symbol-label">
                                            <span class="svg-icon svg-icon-xl svg-icon-primary">
                                                <i class="fas fa-book-reader icon-lg text-primary"></i>
                                            </span>
                                        </span>
                                    </span>
                                    <div class="d-flex flex-column text-right">
                                        <span class="text-dark-75 font-weight-bolder font-size-h3">{!! $manage_by_direct !!}</span>
                                        <span class="text-muted font-weight-bold mt-2">Total Manage by Direct </span>
                                    </div>
                                </div>
                            </div> 
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card card-custom card-stretch gutter-b">
                            <div class="card-body p-0">
                                <div class="d-flex align-items-center justify-content-between card-spacer flex-grow-1">
                                    <span class="symbol symbol-50 symbol-light-primary mr-2">
                                        <span class="symbol-label">
                                            <span class="svg-icon svg-icon-xl svg-icon-primary">
                                                <i class="fas fa-book-open icon-lg text-primary"></i>
                                            </span>
                                        </span>
                                    </span>
                                    <div class="d-flex flex-column text-right">
                                        <span class="text-dark-75 font-weight-bolder font-size-h3">{!! $manage_by_re_source !!}</span>
                                        <span class="text-muted font-weight-bold mt-2">Total Manage by Re:Source </span>
                                    </div>
                                </div>
                            </div> 
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="card card-custom card-stretch gutter-b">
                            <div class="card-body p-0">
                                <div class="d-flex align-items-center justify-content-between card-spacer flex-grow-1">
                                    <span class="symbol symbol-50 symbol-light-primary mr-2">
                                        <span class="symbol-label">
                                            <span class="svg-icon svg-icon-xl svg-icon-primary">
                                                <i class="far fa-calendar-alt icon-lg text-primary"></i>
                                            </span>
                                        </span>
                                    </span>
                                    <div class="d-flex flex-column text-right">
                                        <span class="text-dark-75 font-weight-bolder font-size-h3">{!! $event !!}</span>
                                        <span class="text-muted font-weight-bold mt-2">Total Interview </span>
                                    </div>
                                </div>
                            </div> 
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card card-custom card-stretch gutter-b">
                            <div class="card-body p-0">
                                <div class="d-flex align-items-center justify-content-between card-spacer flex-grow-1">
                                    <span class="symbol symbol-50 symbol-light-primary mr-2">
                                        <span class="symbol-label">
                                            <span class="svg-icon svg-icon-xl svg-icon-primary">
                                                <i class="fas fa-pound-sign icon-lg text-primary"></i>
                                            </span>
                                        </span>
                                    </span>
                                    <div class="d-flex flex-column text-right">
                                        <span class="text-dark-75 font-weight-bolder font-size-h3">{!! $success_offer !!}</span>
                                        <span class="text-muted font-weight-bold mt-2">Total Offer Accepted</span>
                                    </div>
                                </div>
                            </div> 
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card card-custom card-stretch gutter-b">
                            <div class="card-body p-0">
                                <div class="d-flex align-items-center justify-content-between card-spacer flex-grow-1">
                                    <span class="symbol symbol-50 symbol-light-primary mr-2">
                                        <span class="symbol-label">
                                            <span class="svg-icon svg-icon-xl svg-icon-primary">
                                                <i class="ki ki-outline-info icon-lg text-primary"></i>
                                            </span>
                                        </span>
                                    </span>
                                    <div class="d-flex flex-column text-right">
                                        <span class="text-dark-75 font-weight-bolder font-size-h3">{!! $reject_offer !!}</span>
                                        <span class="text-muted font-weight-bold mt-2">Total Offer Declined</span>
                                    </div>
                                </div>
                            </div> 
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@stop

@section('footerScripts')
@stop 
