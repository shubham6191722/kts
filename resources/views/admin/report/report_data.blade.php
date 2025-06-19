<div class="col-sm-12">
    <h2><span class="timetohireCount">{!! $timeToHireCount !!} Days</span></h2>
    <p class="m-0">Average time taken to hire successful candidate.</p>
</div>
<div class="col-sm-12">
    <table class="table dt-table-hover" id="zero-config" role="grid" aria-describedby="kt_datatable_info" style="width: 100%;">
        <thead>
            <tr role="row">
                <th>Job</th>
                <th>Job Category</th>
                <th>Hired</th>
                <th>Open Date</th>
                <th>Close Date</th>
                <th>Time to hire</th>
            </tr>
        </thead>
        <tbody>
            @if(isset($timeToHireData) && !empty($timeToHireData) && count($timeToHireData))
                @foreach($timeToHireData as $Tkey => $t_value)
                    @php
                        $usre_name = App\CustomFunction\CustomFunction::getCandidateName($t_value['id']);
                    @endphp
                
                    <tr>
                        <td>{!! $t_value['jobtitle'] !!}</td>
                        <td>{!! App\Models\JobCategory::categoryName($t_value['categoryid']) !!}</td>
                        <td>
                            {!! $usre_name !!}
                            {{-- @foreach($usre_name as $key => $value) 
                                @php
                                    $key = $key + 1;
                                @endphp
                                {{$key}} ) {!! $value !!}<br>
                            @endforeach --}}
                        </td>
                        <td>{!! App\CustomFunction\CustomFunction::get_date_forment($t_value['created_at']) !!}</td>
                        <td>{!! App\CustomFunction\CustomFunction::get_date_forment($t_value['updated_at']) !!}</td>
                        <td><span class="label label-lg label-light-success label-inline lable-custom-w-h">{!! $t_value['date_difference'] !!} Days</span></td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>