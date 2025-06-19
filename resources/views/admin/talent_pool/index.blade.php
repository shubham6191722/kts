@extends('admin.layouts.common')

@section('title', 'Talent Pool')

@section('headerScripts')

@stop

@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
            <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                <div class="d-flex align-items-center flex-wrap mr-2">
                    <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Talent Pool</h5>
                </div>
            </div>
        </div>
        <div class="d-flex flex-column-fluid">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-custom gutter-b card-stretch pt-8 pb-8">
                            <div class="container">
                                <div class="row justify-content-center">
                                    <div class="col-md-3 col-sm-3">
                                        <label>&nbsp;</label>
                                        <div>
                                            <input type="text" class="form-control form-control-lg custom-form-control-lg mb-2" id="talent_name" placeholder="Candidate Name or Skill">
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-3">
                                        <label>Job Specialism</label>
                                        <div>
                                            <select class="form-control select2" id="s_category">
                                                <option value="" selected>Please Select</option>
                                                @foreach($job_skill as $SKey => $job_skill_value)
                                                    <option value="{!! $job_skill_value->id !!}">{!! $job_skill_value->sector !!}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-3">
                                        <label>Region</label>
                                        <div>
                                            <select class="form-control select2" id="r_category">
                                                <option value="" selected>Please Select</option>
                                                @foreach($region as $SKey => $r_value)
                                                    <option value="{!! $r_value->region_id !!}">{!! $r_value->region !!}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-sm-2">
                                        <label>&nbsp;</label>
                                        <div>
                                            <button type="submit" id="talent_submit" class="btn btn-primary full-width">Search</button>
                                            <button type="reset" id="talent_reset" class="btn btn-primary full-width">Reset</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex flex-column-fluid">
            <div class="container">
                <div id="talent_pool_data" class="row"></div>
            </div>
        </div>
    </div>
@stop

@section('footerScripts')
    <script>
        var KTSelect2 = function() {
            var demos = function() {
                $('.select2').select2({placeholder: "Please Select"});
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
    <script>
        $(document).ready(function () {

            var job_skill = null;
            var region = null;
            searchSubmit(job_skill,region);

            $('body').on('click', '#talent_submit', function() {
                var region = $('#r_category').val();
                var job_skill = $('#s_category').val();
                var talent_name = $('#talent_name').val();
                searchSubmit(job_skill,region,talent_name);
            });
            
            $('body').on('click', '#talent_reset', function() {
                location.reload();
            });

            function searchSubmit(job_skill,region,talent_name) {

                $.ajaxSetup({headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{route('comman.talentSearch')}}",
                    dataType: 'json',
                    type: 'post',
                    data: {
                        job_skill: job_skill,
                        region: region,
                        talent_name: talent_name,
                    },
                    beforeSend: function () {
                        $.LoadingOverlay("show");
                    },
                    success: function (data) {
                        if (data.code == 1) {
                            if(data.page){
                                $('#talent_pool_data').html(data.page);
                            }else{
                                $('#talent_pool_data').html('<h4 class="text-center" style="width: 100%;">No Data found</h4>');
                            }
                        } else {
                            $('#talent_pool_data').html('<h4 class="text-center" style="width: 100%;">No Data found</h4>');
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

        });
    </script>
@stop