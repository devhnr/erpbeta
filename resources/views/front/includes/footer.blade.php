 <!-- start footer -->
        <footer class="footer-fashion-shop footer-dark bg-extra-dark-gray position-relative overlap-gap-section-bottom sm-padding-50px-top footer-inner-pg-pt0">
            <div class="footer-top padding-five-bottom">
                <div class="container">
                    <div class="row row-cols-1 row-cols-md-4 row-cols-sm-3 justify-content-center">
                        <!-- start footer column -->
                        <div class="col col-lg-3 col-sm-6 offset-sm-2 offset-md-0 order-lg-0 text-md-center text-lg-start last-paragraph-no-margin margin-25px-bottom">
                            <a href="{{url('/')}}" class="footer-logo margin-15px-bottom margin-5px-top d-inline-block">
                                <img src="{{asset('public/site/images/sagar-logo.png')}}" alt=""></a>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor</p>
                        </div>
                        <!-- end footer column -->
                        <!-- start footer column -->
                        <div class="col-6 col-lg offset-xl-1 order-lg-0 md-margin-40px-bottom xs-margin-25px-bottom">
                            <span class="alt-font font-weight-500 d-block text-white margin-15px-bottom xs-margin-10px-bottom">Categories</span>
                            <ul>
                                <li><a href="#">For men</a></li>
                                <li><a href="#">For woman</a></li>
                                <li><a href="#">Accessories</a></li>
                                <li><a href="#">Collections</a></li>
                            </ul>
                        </div>
                        <!-- end footer column -->
                        <!-- start footer column -->
                        <div class="col-6 col-lg order-lg-0 md-margin-40px-bottom xs-margin-25px-bottom">
                            <span class="alt-font font-weight-500 d-block text-white margin-15px-bottom xs-margin-10px-bottom">Quick Links</span>
                            <ul>                           
                                <li><a href="{{url('/about-company')}}">About company</a></li>
                                <li><a href="{{url('/our-services')}}">Our services</a></li>
                                <li><a href="{{url('/latest-blogs')}}">Latest blogs</a></li>
                                <li><a href="{{url('/contact-us')}}">Contact us</a></li>
                            </ul>
                        </div>
                        <!-- end footer column -->
                        <!-- start footer column -->
                        <div class="col-6 col-lg order-lg-0 md-margin-40px-bottom xs-margin-25px-bottom">
                            <span class="alt-font font-weight-500 d-block text-white margin-15px-bottom xs-margin-10px-bottom">About Company</span>
                            <ul>
                                <li><a href="{{url('/terms-conditions')}}">Terms & Conditions</a></li>
                                <li><a href="{{url('/privacy-policy')}}">privacy Policy</a></li>
                                <li><a href="{{url('/what-we-offer')}}">What we offer</a></li>
                                <li><a href="{{url('/return')}}">Return</a></li>
                            </ul>
                        </div>
                        <!-- end footer column -->
                        <!-- start footer column -->
                        <div class="col-6 col-lg order-lg-0 xs-margin-25px-bottom">
                            <span class="alt-font font-weight-500 d-block text-white margin-15px-bottom xs-margin-10px-bottom">Payments</span>
                            <ul>
                                <li><a href="#">Free delivery</a></li>
                                <li><a href="#">100 days refund</a></li>
                                <li><a href="#">Multiple payments</a></li>
                                <li><a href="#">Sustainable</a></li>
                            </ul>
                        </div>
                        <!-- end footer column --> 
                        <div class="col col-lg-12 col-sm-12 offset-sm-2 offset-md-0 order-lg-0 text-md-center text-lg-start last-paragraph-no-margin">
                            <p>&copy; Copyright 2023 Sagar store</p>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- end footer -->
<!-- start scroll to top -->
        <a class="scroll-top-arrow" href="javascript:void(0);"><i class="feather icon-feather-arrow-up"></i></a>
        <!-- end scroll to top -->
        <!-- javascript -->
        <script type="text/javascript" src="{{asset('public/site/js/jquery.min.js')}}"></script>
        <script type="text/javascript" src="{{asset('public/site/js/theme-vendors.min.js')}}"></script>
        <script type="text/javascript" src="{{asset('public/site/js/main.js')}}"></script>

        <!-- revolution js files -->
        <script type="text/javascript" src="{{asset('public/site/revolution/js/jquery.themepunch.tools.min.js')}}"></script>
        <script type="text/javascript" src="{{asset('public/site/revolution/js/jquery.themepunch.revolution.min.js')}}"></script>

        <!-- BUBBLEMORPH ADD-ON FILES -->
        <script type='text/javascript' src="{{asset('public/site/revolution/revolution-addons/bubblemorph/js/revolution.addon.bubblemorph.min.js')}}"></script>


        <script type="text/javascript">
            var revapi263,
                    tpj;
            (function () {
                if (!/loaded|interactive|complete/.test(document.readyState))
                    document.addEventListener("DOMContentLoaded", onLoad);
                else
                    onLoad();
                function onLoad() {
                    if (tpj === undefined) {
                        tpj = jQuery;
                        if ("off" == "on")
                            tpj.noConflict();
                    }
                    if (tpj("#rev_slider_35_1").revolution == undefined) {
                        revslider_showDoubleJqueryError("#rev_slider_35_1");
                    } else {
                        var revOffset = tpj(window).width() <= 767 ? '77px' : '128px';
                        revapi263 = tpj("#rev_slider_35_1").show().revolution({
                            sliderType: "standard",
                            jsFileLocation: "revolution/js/",
                            sliderLayout: "fullwidth",
                            dottedOverlay: "none",
                            delay: 9000,
                            navigation: {
                                keyboardNavigation: "on",
                                keyboard_direction: "horizontal",
                                mouseScrollNavigation: "off",
                                mouseScrollReverse: "default",
                                onHoverStop: "off",
                                touch: {
                                    touchenabled: "on",
                                    touchOnDesktop: "on",
                                    swipe_threshold: 75,
                                    swipe_min_touches: 1,
                                    swipe_direction: "horizontal",
                                    drag_block_vertical: false
                                },
                                tabs: {
                                    enable: true,
                                    style: 'erinyen',
                                    direction: 'horizontal',
                                    h_align: "center",
                                    v_align: "bottom",
                                    h_offset: -480,
                                    v_offset: 80,
                                    space: 25,
                                    hide_onleave: false,
                                    hide_onmobile: false,
                                    wrapper_padding: 0,
                                    width: 20,
                                    height: ['auto'],
                                    wrapper_color: 'transparent',
                                    wrapper_opacity: '0',
                                    tmp: '<span class="alt-font text-extra-dark-gray">param1</span>',
                                }
                            },
                            responsiveLevels: [1240, 1025, 992, 480],
                            visibilityLevels: [1240, 1024, 778, 480],
                            gridwidth: [1140, 1024, 778, 480],
                            gridheight: [870, 640, 910, 868],
                            lazyType: "none",
                            shadow: 0,
                            spinner: "spinner5",
                            stopLoop: "on",
                            stopAfterLoops: 0,
                            stopAtSlide: 1,
                            shuffle: "off",
                            autoHeight: "off",
                            fullScreenAutoWidth: "off",
                            fullScreenAlignForce: "off",
                            fullScreenOffsetContainer: "",
                            fullScreenOffset: revOffset,
                            disableProgressBar: "on",
                            hideThumbsOnMobile: "off",
                            hideSliderAtLimit: 0,
                            hideCaptionAtLimit: 0,
                            hideAllCaptionAtLimit: 0,
                            debugMode: false,
                            fallbacks: {
                                simplifyAll: "off",
                                nextSlideOnWindowFocus: "off",
                                disableFocusListener: false,
                            }
                        });
                    }
                    ; /* END OF revapi call */

                    BubbleMorphAddOn(jQuery, revapi263);
                }
                ; /* END OF ON LOAD FUNCTION */
            }()); /* END OF WRAPPING FUNCTION */
        </script>

        </body>
</html>