@if(!empty($message))
    <div class="d-flex flex-column mb-5 align-items-end">
        <div class="d-flex align-items-center">
            <div>
                <span class="text-muted font-size-sm">Just now</span>
                <a href="javascript:void(0);" class="text-dark-75 text-hover-primary font-weight-bold font-size-h6">{!! $chat_name !!} {!! $chat_c_name !!}</a>
            </div>
            <div class="symbol symbol-circle symbol-40 ml-3">
                <span class="symbol-label font-size-h5 font-weight-bold">{!! $chat_image !!}</span>
            </div>
        </div>
        <div class="mt-2 rounded p-5 bg-light-primary text-dark-50 font-weight-bold font-size-lg text-right max-w-400px">{!! $message !!}</div>
    </div>
@endif