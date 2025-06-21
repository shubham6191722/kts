<footer class="dark-footer skin-dark-footer">
    <div>
        <div class="container p-3">
            <div class="row justify-content-space-between align-items-center">

                <div class="col-lg-4 col-md-6 col-12">
                    <div class="footer-widget text-xl-start text-lg-start text-md-center text-sm-center text-center">
                        <img src="{!! site_footer_logo !!}" class="img-footer" alt="" />
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="footer-widget">
                        <p class="m-0 text-xl-end text-lg-end text-md-center text-sm-center text-center">{!! footer_address !!}</p>
                        <div class="footer-add mt-3">
                            <ul class="footer-bottom-social text-xl-end text-lg-end text-md-center text-sm-center text-center">
                                <li><a href="{!! facebook_link !!}" target="_blank"><i class="ti-facebook"></i></a></li>
                                <li><a href="{!! twitter_link !!}" target="_blank"><i class="ti-linkedin"></i></a></li>
                                <li><a href="{!! lnstagram_link !!}" target="_blank"><i class="ti-instagram"></i></a></li>
                            </ul>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="footer-bottom">
        <div class="container">
            <div class="row justify-content-center align-items-center">

                <div class="col-lg-4 col-md-6 col-sm-12 col-12 footer-order-2">
                    <p class="mb-0 text-lg-start text-md-start text-sm-center text-center">Copyright © {!!date('Y')!!} {!! footer_copy_text !!}</p>
                </div>
                <div class="col-lg-8 col-md-6 col-sm-12 col-12 footer-order-1">
                    <div class="text-lg-end text-md-end text-sm-center">
                    <ul class="footer-bottom-link">
                        <li><a href="{!! route('home.termsCondition') !!}">Terms and Condition</a></li>
                        <li><a href="{!! route('home.privacyPolicy') !!}">Privacy Policy</a></li>
                        <li><a href="{!! route('home.getGDPR') !!}">GDPR</a></li>
                    </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
