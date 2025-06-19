@extends('frontend.layouts.common')

@section('title', $title)

@section('headerscripts')
@stop

@section('content')
    <div class="clearfix"></div>
    <section class="inner-header-title lazyload" data-src="{{url('assets/frontend')}}/img/bn2.jpg" data-overlay="6">
        <div class="container">
            <h1>@if(isset($title) && !empty($title)){!! $title !!}@endif</h1>
        </div>
    </section>
    <div class="clearfix"></div>
    <section >
        <div class="container">
            <div class="row justify-content-center align-items-center">
                <div class="col-md-8 col-sm-12">
                    <div>
                        @if(isset($description) && !empty($description))
                        {!! $description !!}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop

@section('footerscripts')
@stop