@if ($message = Session::get('success'))
<div class="alert alert-success alert-block">
    <strong>{{ $message }}</strong>
    <button type="button" class="close fl-right b-none" data-dismiss="alert">×</button>
</div>
@endif