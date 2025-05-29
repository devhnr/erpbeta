@include('front.includes.header')
<!-- start page title -->
        <section class="wow animate__fadeIn bg-light-gray padding-25px-tb page-title-small">
            <div class="container">
                <div class="row align-items-center justify-content-center">
                    <div class="col-12 col-xl-8 col-lg-6">
                        <h1 class="alt-font text-extra-dark-gray font-weight-500 no-margin-bottom text-center text-lg-start">My account</h1>
                    </div>
                    <div class="col-12 col-xl-4 col-lg-6 breadcrumb justify-content-center justify-content-lg-end text-small alt-font md-margin-10px-top">
                        <ul class="xs-text-center">
                            <li><a href="{{url('/')}}">Home</a></li>
                            <li>My account</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
        <!-- end page title -->
        <!-- start section -->
        <section class="wow animate__fadeIn orders_ss">
                <div class="container-fluid">
                    <div class="row flex-drc">
              
                  <div class="col-lg-9">
                    <!--NSP TITLE SECTION START-->
              <div class="SS_title_section">
                <h4>Add Address</h4>
              </div>
                <!--NSP TITLE SECTION START-->

                 <!--MY PURCHASES SECTION START-->
              
              <div class="my_purchases_box_section">

                <div class="custom-back-g-white">

                    <div class="col-lg-8">

                        <form role="form" id="edit_profile" method="post" action="">

                            <div class="row">

                                <div class="col-lg-6 col-md-6 mb-10">

                                    <div class="form-fields">

                                        <input type="text" name="first_name" id="first_name" placeholder="Enter First Name">

                                    </div>

                                </div>

                                <div class="col-lg-6 col-md-6 mb-10">

                                    <div class="form-fields">

                                        <input type="text" name="last_name" id="last_name" placeholder="Enter Last Name">

                                    </div>

                                </div>

                                <div class="col-lg-12 col-md-12">

                                    <div class="form-fields">

                                        <input type="text" name="address1" id="address1" placeholder="Address line 1" maxlength="70">
                                        <!-- <p class="form-password-sug-text">Block, Building name, Street</p> -->
                                    </div>

                                    

                                </div>

                                <div class="col-lg-12 col-md-12">

                                    <div class="form-fields">

                                        <input type="text" name="address2" id="address2" placeholder="Address line 2" maxlength="50">
                                        <!-- <p class="form-password-sug-text">Landmark, Area etc</p> -->
                                    </div>

                                 

                                </div>

                                <div class="col-lg-6 col-md-6">

                                    <div class="form-fields">

                                        <input type="text" name="phone" id="phone" placeholder="Enter Phone Number">

                                    </div>

                                </div>

                                <div class="col-lg-6 col-md-6">

                                    <div class="form-fields">

                                        <input type="text" name="email" id="email" placeholder="Enter Email Address">

                                    </div>

                                </div>

                                <div class="col-lg-6 col-md-6">

                                    <div class="form-fields">

                                        <input type="text" name="city" id="city" placeholder="Enter City">

                                    </div>

                                </div>

                                <div class="col-lg-6 col-md-6">

                                    <div class="form-fields">

                                        <input type="text" name="pincode" id="pincode" placeholder="Enter Pin Code">

                                    </div>

                                </div>

                                <div class="col-lg-6 col-md-6">

                                    <div class="form-fields">

                                        <select id="state" name="state" class="country-options">

                                            <option value="" selected="">Select State</option>

                                            <option value="Maharashtra">Maharashtra</option>

                                        </select>

                                    </div>

                                </div>

                                <div class="col-lg-6 col-md-6">

                                    <div class="form-fields">

                                        <select id="country" name="country" class="country-options">

                                            <option value="" selected="">Select Country</option>

                                            <option value="India">India</option>

                                        </select>

                                    </div>

                                </div>

                                <span id="validation_error" class="error alert-message valierror" style="display: none;"></span>


                                <!-- <div class="col-box12 mb-0">

                                    <div class="form-field-radio">

                                        <p class="form-fields-text">Delivery address type</p>

                                        <label class="custom-radio-button">Home

                                            <input type="radio" value="0" name="address_type" id="address_type">

                                            <span class="checkmark"></span>

                                        </label>

                                        <label class="custom-radio-button">Office

                                            <input type="radio" name="address_type" id="address_type" value="1" checked="checked">

                                            <span class="checkmark"></span>

                                        </label>

                                        <label class="custom-radio-button">Other

                                            <input type="radio" name="address_type" id="address_type" value="2">

                                            <span class="checkmark"></span>

                                        </label>

                                    </div>

                                </div> -->

          

         <!--  <div class="col-box12">

              <div class="form-field-radio">

                  <label class="custom-checkbox save-address">Make this Default

                      <input type="checkbox" value="1" id="default_address" name="default_address">

                      <span class="checkmark"></span>

                  </label>

              </div>

          </div> -->

                                <div class="col-box10 mb-20">

                                    <div class="form-fields-button">

                                        <button type="button" class="form-field-button update-btn">Add Address</button>

                                    </div>

                                </div>

                            </div>

                        </form>

                    </div>

                </div>
                     <!--  -->

              
              </div>
              
                 <!--MY PURCHASES SECTION CLOSE-->
              
                  </div>
              
              
                  <div class="col-lg-3">
                    @include('front.sidebar')
                  </div>
              
                </div>
              </div>
              
              
              
        </section>
        <!-- end section -->
@include('front.includes.footer')