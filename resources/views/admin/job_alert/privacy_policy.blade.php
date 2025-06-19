@extends('admin.layouts.common')

@section('title', 'Privacy Policy')

@section('headerScripts')
<link rel="stylesheet" href="{!!url('assets/backend')!!}/css/fancybox.css" />
@stop

@section('content')

@php
    $route_name = App\CustomFunction\CustomFunction::role_name();
@endphp
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="d-flex flex-column-fluid">
        <div class="container">
            <div class="card card-custom">
                <div class="card-body">

                    <div class="show active tab-pane px-7" id="kt_tab_my_account_setting" role="tabpanel">
                        <form class="form" method="POST" action="{{ route($route_name.'.privacyPolicyCreate')}}">
                            @csrf
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Title</label>
                                                <div>
                                                    @php
                                                        $site_favicon = $site_notification_email = null;
                                                        if(isset($siteSetting->site_favicon) && !empty($siteSetting->site_favicon)){
                                                            $site_favicon = $siteSetting->site_favicon;
                                                        }
                                                        if(isset($siteSetting->site_notification_email) && !empty($siteSetting->site_notification_email)){
                                                            $site_notification_email = $siteSetting->site_notification_email;
                                                        }
                                                    @endphp
                                                    <input type="text" class="form-control form-control-lg mb-2" name="site_favicon" value="{!! old('site_favicon',$site_favicon) !!}" placeholder="Title" />
                                                    <input type="hidden" name="id" value="@if(isset($siteSetting->id) && !empty($siteSetting->id)) {!! $siteSetting->id !!}@endif"/>
                                                </div>
                                                {{-- <small class="text-dark-50 font-size-base">Note: Use the <code class="text-dark-50 font-size-base">{company-name}</code> keywords for a dynamic subject.</small> --}}
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Description</label>
                                                <div>
                                                    <textarea type="text" class="form-control form-control-lg mb-2 summernote" name="site_notification_email" placeholder="Description">{!! old('site_notification_email',$site_notification_email) !!}</textarea>
                                                </div>
                                                {{-- <small class="text-dark-50 font-size-base">Note: Use following variable for dynamic value</small>
                                                <div>
                                                    <ul class="mail-dynamic-tag">
                                                        <li>
                                                            <code class="text-dark-50 font-size-base">{company-name}</code>
                                                        </li>
                                                    </ul>
                                                </div> --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer pb-0 mt-10 pl-0">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-6">
                                        <button type="submit" class="btn btn-light-primary font-weight-bold">
                                            <span class="indicator-label">Submit</span>
                                            <span class="indicator-progress">Please wait... 
                                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                        </button>
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
@stop

@section('footerScripts')
<script src="{!!url('assets/backend')!!}/js/fancybox.umd.js"></script>
<script>
    var KTSelect2 = function() {
        var demos = function() {
            $('.summernote').summernote({
                height: 250,
                disableDragAndDrop:true,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['table', ['table']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['insert', ['link']],
                ],
                callbacks: {
                    onPaste: function (e) {
                        var bufferText = ((e.originalEvent || e).clipboardData || window.clipboardData).getData('Text');
                        e.preventDefault();
                        document.execCommand('insertText', false, bufferText);
                    }
                }
            });
        }

        return {
            init: function() {
                demos();
            }
        };
    }();

    jQuery(document).ready(function() {
        KTSelect2.init();
    });
</script>
@stop
