<div class="px-7" id="my_activity">
    <div class="timeline timeline-6 timeline-6-custom mt-3">
        @if(!empty($job_activity))
            @foreach($job_activity as $AKey => $a_value)
                @php
                    $clientData = App\Models\User::clientData($a_value['user_id']);

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
                        $userName = $name.' '.$lname;
                    }

                    if($clientData->role == 1){
                        $text_class = 'text-success';
                    }elseif($clientData->role == 2){
                        $text_class = 'text-primary';
                    }elseif($clientData->role == 3){
                        $text_class = 'text-warning';
                    }elseif($clientData->role == 4){
                        $text_class = 'text-dark';
                    }else{
                        $text_class = 'text-info';
                    }

                    $tooltip_text = "Changed By: ".$userName;
                    if($a_value['text'] === 'Mail Send.'){
                        $tooltip_text = $tooltip_text.'<br/><br/>'.$a_value['description'];
                    }

                @endphp

                <div class="timeline-item align-items-start">
                    @php
                        $time = App\CustomFunction\CustomFunction::get_date_time_forment($a_value['created_at']);
                    @endphp
                    <div class="timeline-label font-weight-bolder text-dark-75 font-size-lg timeline-label-custom" data-toggle="tooltip" data-theme="dark" data-html="true" title="{!! $tooltip_text !!}">{!! $time !!}</div>
                    <div class="timeline-badge" data-toggle="tooltip" data-theme="dark" data-html="true" title="{!! $tooltip_text !!}">
                        <i class="fa fa-genderless {{$text_class}} icon-xl"></i>
                    </div>
                    <div class="font-weight-mormal font-size-lg timeline-content text-muted pl-3" data-placement="left" data-toggle="tooltip" data-theme="dark" data-html="true" title="{!! $tooltip_text !!}">{!! $a_value['text'] !!}</div>
                </div>
            @endforeach
        @endif
    </div>
</div>