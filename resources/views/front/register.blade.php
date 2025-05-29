@include('front.includes.header')
 <!-- start page title -->
        <section class="wow animate__fadeIn bg-light-gray padding-25px-tb page-title-small">
            <div class="container">
                <div class="row align-items-center justify-content-center">
                    <div class="col-12 col-xl-8 col-lg-6">
                        <h1 class="alt-font text-extra-dark-gray font-weight-500 no-margin-bottom text-center text-lg-start">Register</h1>
                    </div>
                    <div class="col-12 col-xl-4 col-lg-6 breadcrumb justify-content-center justify-content-lg-end text-small alt-font md-margin-10px-top">
                        <ul class="xs-text-center">
                            <li><a href="{{url('/')}}">Home</a></li>
                            <li>Register</li>
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
                   
                    <div class="col-12 col-xl-5 offset-xl-1 col-md-6 lg-padding-30px-lr md-padding-15px-lr">
                        <h6 class="alt-font font-weight-500 text-extra-dark-gray text-center">Register</h6>
                        <form class="border-all border-color-medium-gray padding-4-rem-all lg-margin-35px-top md-padding-2-half-rem-all">
                            <label class="margin-15px-bottom">Username <span class="required-error text-radical-red">*</span></label>
                            <input class="small-input bg-white margin-20px-bottom required" type="text" name="text" placeholder="Enter your username">
                            <label class="margin-15px-bottom">Email address <span class="required-error text-radical-red">*</span></label>
                            <input class="small-input bg-white margin-20px-bottom required" type="email" name="email" placeholder="Enter your email">
                            <label class="margin-15px-bottom">Password <span class="required-error text-radical-red">*</span></label>
                            <input class="small-input bg-white margin-20px-bottom required" type="password" name="password" placeholder="Enter your password">
                            <p class="text-small">Your personal data will be used to support your experience throughout this website, to manage access to your account, and for other purposes described in our <a href="#" class="text-decoration-underline">privacy policy</a>.</p>
                            <button class="btn btn-medium btn-fancy btn-dark-gray w-100 submit" type="submit">Register</button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
        <!-- end section -->
@include('front.includes.footer')