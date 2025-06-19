@if(isset($noteData) && !empty($noteData) && count($noteData))
    @foreach($noteData as $key => $value)
        <div class="timeline-item">
            <div class="timeline-media">
                <i class="fas fa-sticky-note text-danger"></i>
            </div>
            <div class="timeline-content">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="mr-2">
                        <a href="#" class="text-dark-75 text-hover-primary font-weight-bold">
                            {!! App\Models\User::getUserName($value->created_user_id) !!}
                        </a>
                        <span class="text-muted ml-2">
                            {!! App\CustomFunction\CustomFunction::get_time_difference($value->updated_at) !!}
                        </span>
                    </div>
                </div>
                <div class="note-timeline-comment p-0">
                    {!! $value->note !!}
                </div>
            </div>
        </div>
    @endforeach
@endif