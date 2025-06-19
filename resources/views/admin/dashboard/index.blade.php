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
                                                <i class="fas fa-user text-primary"></i>
                                            </span>
                                        </span>
                                    </span>
                                    <div class="d-flex flex-column text-right">
                                        <a href="#"><span class="text-dark-75 font-weight-bolder font-size-h3">0</span></a>
                                        <span class="text-muted font-weight-bold mt-2">Total Users </span>
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
