@include('front.includes.header')

 <!-- start page title -->
        <section class="wow animate__fadeIn bg-light-gray padding-25px-tb page-title-small">
            <div class="container">
                <div class="row align-items-center justify-content-center">
                    <div class="col-12 col-xl-8 col-lg-6">
                        <h1 class="alt-font text-extra-dark-gray font-weight-500 no-margin-bottom text-center text-lg-start">Forgot Password</h1>
                    </div>
                    <div class="col-12 col-xl-4 col-lg-6 breadcrumb justify-content-center justify-content-lg-end text-small alt-font md-margin-10px-top">
                        <ul class="xs-text-center">
                            <li><a href="{{url('/')}}">Home</a></li>
                            <li>Forgot Password</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
        <!-- end page title -->

        <!-- start section -->
        <section class="wow animate__fadeIn">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-12 col-xl-5 col-md-6 lg-padding-30px-lr md-padding-15px-lr sm-margin-40px-bottom">
                        <h6 class="alt-font font-weight-500 text-extra-dark-gray text-center">Forgot Password</h6>
                        <form class="bg-light-gray padding-4-rem-all lg-margin-35px-top md-padding-2-half-rem-all">
                            <label class="margin-15px-bottom">Email Address <span class="required-error text-radical-red">*</span></label>
                            <input class="small-input bg-white margin-20px-bottom required" type="text" name="text" placeholder="Enter your email">
                            
                            <button class="btn btn-medium btn-fancy btn-dark-gray w-100 submit" type="submit">Submit</button>
                            <!-- <p class="text-end margin-20px-top mb-0"><a href="#" class="btn btn-link  btn-medium text-extra-dark-gray">Lost your password?</a></p> -->
                        </form>
                    </div>
                   
                </div>
            </div>
        </section>
        <!-- end section -->
        
@include('front.includes.footer')