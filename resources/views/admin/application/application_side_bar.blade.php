@if(!empty($data))
    @foreach($data as $key => $value)
        <div class="chekbox-item-caption d-flex align-items-start @if($loop->first) active-application @endif">
            @php
                $user_id = $value->user_id;
                if($value->job_reference == '0'){
                    $check_user = App\Models\User::checkUserActiveDeactive($user_id);
                }else{
                    $check_user = true;
                }
            @endphp
            {{-- @if($check_user) --}}
            <label class="checkbox checkbox-success">
                <input type="checkbox" name="chnage_status_stage" value="{{$value->id}}">
                <span></span>
            </label>
            {{-- @else
            <label class="checkbox-w-28px">
                <span></span>
            </label>
            @endif --}}
            <div class="checkbox-content d-flex flex-row gap-10" data-id="{{$value->id}}">
                @php
                    if($value->job_reference == "1"){

                        $userName = '<span>'.App\Models\RecruiterCandidate::recruiterCandidateName($value->user_id).'</span>';

                        $getId = App\Models\RecruiterCandidate::getId($value->user_id);

                        $clientData = App\Models\User::clientData($getId);

                        if(isset($clientData->name) && !empty($clientData->name)){
                            $name = $clientData->name;
                        }
                        if(isset($clientData->lname) && !empty($clientData->lname)){
                            $lname = $clientData->lname;
                        }
                        if(isset($name) && !empty($name)){
                            $recruitere_name = $name;
                        }
                        if((isset($lname) && !empty($lname)) && (isset($name) && !empty($name))){
                            $recruitere_name = $name.' '.$lname;
                        }

                        if(isset($clientData->company_name) && !empty($clientData->company_name)){
                            $recruitere_name = $clientData->company_name;
                        }


                        $town = '<span class="label label-lg label-light-dark label-inline">'.$recruitere_name.'</span>';

                        if(isset($value->managed_by) && !empty($value->managed_by)){
                            if($value->managed_by == 1){
                                $managed_by = '<span class="label label-lg label-light-primary label-inline">Re:Source</span> <span class="label label-lg label-light-info label-inline">Recruiter</span>';
                            }else{
                                $managed_by = '<span class="label label-lg label-light-warning label-inline">Direct</span> <span class="label label-lg label-light-info label-inline">Recruiter</span>';
                            }
                        }

                    }else{

                        $clientData = App\Models\User::clientData($value->user_id);
                        if(isset($clientData->name) && !empty($clientData->name)){
                            $name = $clientData->name;
                        }
                        if(isset($clientData->lname) && !empty($clientData->lname)){
                            $lname = $clientData->lname;
                        }
                        if(isset($name) && !empty($name)){
                            $userName = $name;
                        }
                        if((isset($lname) && !empty($lname)) && (isset($name) && !empty($name))){
                            $userName = '<span>'.$name.' '.$lname.'</span>';
                        }
                        $town = $clientData->town;

                        if(isset($value->managed_by) && !empty($value->managed_by)){
                            if($value->managed_by == 1){
                                $managed_by = '<span class="label label-lg label-light-primary label-inline">Re:Source</span>';
                            }else{
                                $managed_by = '<span class="label label-lg label-light-warning label-inline">Direct</span>';
                            }
                        }
                    }

                    $newformat = null;

                    if(isset($value->created_at) && !empty($value->created_at)){
                        $time = strtotime($value->created_at);
                        $newformat = date('d-m-Y',$time);
                    }
                    $unsuccessful = null;
                    if(isset($value->unsuccessful_mail_send) && !empty($value->unsuccessful_mail_send)){
                        $unsuccessful = '<span class="label label-lg label-light-warning label-inline">Unsuccessful email sent</span>';
                    }

                @endphp
                <div class="checkbox-content d-flex flex-column checkbox_cursor_pointer" data-id="{{$value->id}}">
                    <p class="mb-0 name text-capitalize d-flex justify-content-space-between">{!! $userName !!}{!! $unsuccessful !!}</p>
                    <p class="mb-0 location">{!! $town !!}</p>
                    <p class="mb-0">{!! $newformat !!}</p>
                    <div class="bot-des mt-2 d-flex justify-content-between align-items-center">
                        <p class="mb-0 source">{!! $managed_by !!}</p>
                        {{-- <p class="mb-0 date">{!! $newformat !!}</p> --}}
                    </div>
                </div>

                <div class="d-flex justify-content-space-around m-t-0 thumbs-main-div flex-column p-0 border-none position-relative">
                    <div class="onclick_thumbs_status thumbs-yes position-relative add_class_remove_{{$value->id}} add_class_active_1_{{$value->id}} @if($value->thumbs_status == 1) active @endif" data-id="{{$value->id}}" data-value="1" data-class="add_class_active_1_{{$value->id}}" data-remove-class="add_class_remove_{{$value->id}}" data-toggle="tooltip" data-theme="dark" data-html="true" title="Yes">
                        <i class="fas fa-thumbs-up"></i>
                    </div>
                    <div class="onclick_thumbs_status thumbs-maybe position-relative add_class_remove_{{$value->id}} add_class_active_2_{{$value->id}} @if($value->thumbs_status == 2) active @endif" data-id="{{$value->id}}" data-value="2" data-class="add_class_active_2_{{$value->id}}" data-remove-class="add_class_remove_{{$value->id}}" data-toggle="tooltip" data-theme="dark" data-html="true" title="Maybe">
                        <i class="fas fa-thumbs-up fa-flip-horizontal"></i>
                    </div>
                    <div class="onclick_thumbs_status thumbs-no position-relative add_class_remove_{{$value->id}} add_class_active_3_{{$value->id}} @if($value->thumbs_status == 3) active @endif" data-id="{{$value->id}}" data-value="3" data-class="add_class_active_3_{{$value->id}}" data-remove-class="add_class_remove_{{$value->id}}" data-toggle="tooltip" data-theme="dark" data-html="true" title="No">
                        <i class="fas fa-thumbs-down"></i>
                    </div>
                    <div class="onclick_thumbs_status thumbs-interview position-relative add_class_remove_{{$value->id}} add_class_active_4_{{$value->id}} @if($value->thumbs_status == 4) active @endif" data-id="{{$value->id}}" data-value="4" data-class="add_class_active_4_{{$value->id}}" data-remove-class="add_class_remove_{{$value->id}}" data-toggle="tooltip" data-theme="dark" data-html="true" title="Keen to interview?">
                        <i class="fas fa-user-check"></i>
                    </div>
                    <div class="thumbs-note position-relative open-modal-note @if($value->note_status == 1) active @endif" data-id="{{$value->id}}" data-toggle="tooltip" data-theme="dark" data-html="true" title="Note">
                        <i class="fas fa-sticky-note"></i>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endif
