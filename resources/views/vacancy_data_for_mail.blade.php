<table role="presentation" border="0" cellpadding="10" cellspacing="0" width="100%">
    <tr>
      <td valign="top" style="width:100%;padding: 0 15px;">
          <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
                <tr>
                    <td valign="top" width="100%">
                        @if(!empty($data))
                            @foreach($data as $key => $value)

                                @php
                                    // $client_data = App\Models\User::clientData($value->user_select);
                                    if(isset($value->sub_company) && !empty($value->sub_company)){
                                        $client_data = App\Models\SubCompany::getSubCompanyData($value->sub_company);
                                    }else{
                                        $client_data = App\Models\User::clientData($value->user_select);
                                    }

                                    $company_name = 'Company Name';
                                    $company_logo = $siteHeaderLogo;
                                    
                                    if(isset($client_data->company_name) && !empty($client_data->company_name)){
                                        $company_name = $client_data->company_name;
                                    }
                                    if(isset($client_data->company_logo) && !empty($client_data->company_logo)){
                                        $company_logo = url('uploads').'/client_profile/'.$client_data->company_logo;
                                    }
                                @endphp
                                <div class="topic">
                                    <div class="text">
                                        <div class="company_main">
                                            <img src="{!!$company_logo!!}" style="width: 75px;height: 75px;object-fit: contain;">
                                            <p style="margin: 0;font-size: 14px;margin: 0px;margin-top: 10px;margin-bottom: 10px;line-height: 1.2;"><strong>Company</strong>:- {{$company_name}}</p>
                                        </div>
                                        <p style="font-size: 14px;margin: 0px;margin-bottom: 15px;line-height: 1.2;">@if(isset($value->jobtitle) && !empty($value->jobtitle)) <strong>Job Title</strong>:- {!! $value->jobtitle !!}@endif</p>
                                        @if(isset($value->rateupper) && !empty($value->rateupper))
                                            <p style="margin-top: 5px;"><strong>Offered Salary</strong>: £{!! App\CustomFunction\CustomFunction::number_format($value->rateupper) !!}</p>
                                        @endif
                                        @if(isset($value->jobcategory1) && !empty($value->jobcategory1))
                                            <p style="margin-top: 5px;"><strong>Sector</strong>: {!! App\Models\JobSectors::JobSectorsName($value->jobcategory1) !!}</p>
                                        @endif
                                        @if(isset($value->work_base_preference) && !empty($value->work_base_preference))
                                            @php
                                                $work_base_preference_data = $work_base_preference = '';
                                                $work_base_data = array();
                                                $work_base_preference  = $value->work_base_preference;
                                                $work_base_preference_v = explode(",", $work_base_preference);
                                                foreach ($work_base_preference_v as $work_base_preference_v_1){
                                                    $work_base_data[] = $work_base_preference_v_1;
                                                }
                                                $work_base_preference_data = implode(", ", $work_base_data);
                                            @endphp
                                            <p style="margin-top: 5px;"><strong>Work base preference</strong>: {!! $work_base_preference_data !!}</p>
                                        @endif
                                        @if(isset($value->skillsrequired) && !empty($value->skillsrequired))
                                            @php
                                                $skillsrequired_data = $skillsrequired = '';
                                                $JobSkill = array();
                                                $skillsrequired  = $value->skillsrequired;
                                                $skillsrequired_v = explode(",", $skillsrequired);
                                                foreach ($skillsrequired_v as $skillsrequired_v_1){
                                                    $JobSkill[] = App\Models\JobSkill::getSkillName($skillsrequired_v_1);
                                                }
                                                $skillsrequired_data = implode(", ", $JobSkill);
                                            @endphp
                                            <p style="margin-top: 5px;"><strong>Key Skills</strong>: {!! $skillsrequired_data !!}</p>
                                        @endif
                                        @if(isset($value->jobdescription) && !empty($value->jobdescription))
                                            <p>{!!  trim(substr(strip_tags($value->jobdescription), 0, 150)); !!}...</p>
                                        @endif
                                        <p style="margin-top: 5px;"><a href="{{route('getJobDetail',['id' => $value->slug])}}" class="btn btn-primary">Apply</a></p>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </td>
                </tr>
          </table>
      </td>
    </tr>
</table>