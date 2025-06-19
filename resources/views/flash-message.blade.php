@if(count($errors))

<div class="alert alert-danger">
    <ul>
        @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
    <button type="button" class="close fl-right b-none" data-dismiss="alert">×</button>
</div>

@endif
@if ($message = Session::get('success'))
<div class="alert alert-success alert-block">
    <strong>{{ $message }}</strong>
    <button type="button" class="close fl-right b-none" data-dismiss="alert">×</button>
</div>
@endif


@if ($message = Session::get('error'))
<div class="alert alert-danger alert-block">
    <strong>{{ $message }}</strong>
    <button type="button" class="close fl-right b-none" data-dismiss="alert">×</button>
</div>
@endif


@if ($message = Session::get('warning'))
<div class="alert alert-warning alert-block">
    <button type="button" class="close fl-right b-none" data-dismiss="alert">×</button>
    <strong>{{ $message }}</strong>
</div>
@endif


@if ($message = Session::get('info'))
<div class="alert alert-info alert-block">
    <button type="button" class="close fl-right b-none" data-dismiss="alert">×</button>
    <strong>{{ $message }}</strong>
</div>
@endif

@if(session('already_error'))
<div class="alert alert-danger">
    <button type="button" class="close fl-right b-none" data-dismiss="alert">×</button>
    <strong>{{session('already_error')}}</strong>
</div>
@endif