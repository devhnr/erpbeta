@include('front.includes.header')
 <!-- start page title -->
        <section class="wow animate__fadeIn bg-light-gray padding-25px-tb page-title-small">
            <div class="container">
                <div class="row align-items-center justify-content-center">
                    <div class="col-12 col-xl-8 col-lg-6">
                        <h1 class="alt-font text-extra-dark-gray font-weight-500 no-margin-bottom text-center text-lg-start">Checkout</h1>
                    </div>
                    <div class="col-12 col-xl-4 col-lg-6 breadcrumb justify-content-center justify-content-lg-end text-small alt-font md-margin-10px-top">
                        <ul class="xs-text-center">
                            <li><a href="{{url('/')}}">Home</a></li>
                            <li><a href="{{url('product-listing')}}">Shop</a></li>
                            <li>Checkout</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
        <!-- end page title -->
        <!-- start section -->
        <section class="wow animate__fadeIn checkout">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-12" id="accordion1">
                        <!--start tab content -->
                        <div class="d-sm-flex justify-content-center align-items-center padding-10px-bottom text-center">
                            <i class="feather icon-feather-user text-fast-blue margin-10px-right"></i>
                            <span class="text-extra-dark-gray alt-font">Returning customer?&nbsp;</span><a class="accordion-toggle text-extra-dark-gray text-decoration-underline" data-bs-toggle="collapse" data-bs-parent="#accordion1" href="#collapseOne"><span class="alt-font">Click here to login</span></a>
                        </div>
                        <div id="collapseOne" class="collapse text-center" data-bs-parent="#accordion1">
                            <div class="w-40 mx-auto margin-4-half-rem-tb text-start lg-w-50 sm-w-100">
                                <p>If you have shopped with us before, please enter your details below. If you are a new customer, please proceed to the billing section.</p>
                                <div class="row margin-10px-bottom text-start">
                                    <div class="col-6">
                                        <label class="margin-15px-bottom">Username or email <span class="text-radical-red">*</span></label>
                                        <input class="small-input" type="email" name="email" placeholder="Enter your email">
                                    </div>
                                    <div class="col-6">
                                        <label class="margin-15px-bottom">Password <span class="text-radical-red">*</span></label>
                                        <input class="small-input" type="password" name="password" placeholder="Enter your password">
                                    </div>
                                </div>
                                <span class="d-block w-100 d-flex align-items-center margin-25px-bottom">
                                    <input class="d-inline w-auto mb-0 margin-10px-right" type="checkbox" name="checkbox">
                                    <span>Remember me</span>    
                                </span>
                                <a href="#" class="btn btn-medium btn-dark-gray d-block margin-20px-bottom">Login</a>
                                <p class="text-end"><a href="#" class="btn btn-link  btn-medium text-extra-dark-gray margin-20px-bottom">Lost your password?</a></p>
                            </div>
                        </div>
                    </div>
                    <!-- end tab content -->
                    <div class="col-md-12">
                        <!-- start tab content -->
                        <div class="bg-transparent">
                            <div class="d-sm-flex justify-content-center align-items-center text-center">
                                <i class="feather icon-feather-scissors text-fast-blue margin-10px-right"></i>
                                <span class="text-extra-dark-gray alt-font">Have a coupon?&nbsp;</span><a class="accordion-toggle text-extra-dark-gray text-decoration-underline" data-bs-toggle="collapse" data-bs-parent="#accordion1" href="#collapseTwo"><span class="alt-font">Click here to enter your code</span></a>
                            </div>
                            <div id="collapseTwo" class="collapse">
                                <div class="w-40 mx-auto margin-4-half-rem-tb text-start lg-w-50 sm-w-100">
                                    <label class="margin-15px-bottom">If you have a coupon code, please apply it below. <span class="text-radical-red">*</span></label>
                                    <input class="small-input margin-25px-bottom" type="text" placeholder="Enter coupon code">
                                    <a href="#" class="btn btn-medium btn-dark-gray d-block margin-20px-bottom">Apply coupon</a>
                                </div>
                            </div>
                        </div>
                        <!-- end tab content -->
                    </div>
                </div>
            </div>
        </section>
        <!-- end section -->
        <!-- start section -->
        <section class="pt-0 wow animate__fadeIn">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-lg-7 col-md-6 padding-70px-right lg-padding-40px-right md-padding-15px-right">
                        <span class="alt-font text-large text-extra-dark-gray margin-40px-bottom d-inline-block font-weight-500">Billing details</span>
                        <form class="">
                            <div class="row">
                                <div class="col-md-6 margin-10px-bottom">
                                    <label class="margin-15px-bottom">First name <span class="text-radical-red">*</span></label>
                                    <input class="small-input" type="text" required>
                                </div>
                                <div class="col-md-6 margin-10px-bottom">
                                    <label class="margin-15px-bottom">Last name <span class="text-radical-red">*</span></label>
                                    <input class="small-input" type="text" required>
                                </div>    
                                <div class="col-12 margin-10px-bottom">
                                    <label class="margin-15px-bottom">Company name (optional)</label>
                                    <input class="small-input" type="text">
                                </div>
                                <div class="col-12 margin-10px-bottom">
                                    <label class="margin-15px-bottom" for="contry">Country <span class="text-radical-red">*</span></label>
                                    <select name="contry" id="contry" class="small-input">
                                        <option>Select a country</option>
                                        <option value="Afganistan">Afghanistan</option>
                                        <option value="Albania">Albania</option>
                                        <option value="Algeria">Algeria</option>
                                        <option value="American Samoa">American Samoa</option>
                                        <option value="Andorra">Andorra</option>
                                        <option value="Angola">Angola</option>
                                        <option value="Anguilla">Anguilla</option>
                                        <option value="Antigua & Barbuda">Antigua & Barbuda</option>
                                        <option value="Argentina">Argentina</option>
                                        <option value="Armenia">Armenia</option>
                                        <option value="Aruba">Aruba</option>
                                        <option value="Australia">Australia</option>
                                        <option value="Austria">Austria</option>
                                        <option value="Azerbaijan">Azerbaijan</option>
                                        <option value="Bahamas">Bahamas</option>
                                        <option value="Bahrain">Bahrain</option>
                                        <option value="Bangladesh">Bangladesh</option>
                                        <option value="Barbados">Barbados</option>
                                        <option value="Belarus">Belarus</option>
                                        <option value="Belgium">Belgium</option>
                                        <option value="Belize">Belize</option>
                                        <option value="Benin">Benin</option>
                                        <option value="Bermuda">Bermuda</option>
                                        <option value="Bhutan">Bhutan</option>
                                        <option value="Bolivia">Bolivia</option>
                                        <option value="Bonaire">Bonaire</option>
                                        <option value="Bosnia & Herzegovina">Bosnia & Herzegovina</option>
                                        <option value="Botswana">Botswana</option>
                                        <option value="Brazil">Brazil</option>
                                        <option value="British Indian Ocean Ter">British Indian Ocean Ter</option>
                                        <option value="Brunei">Brunei</option>
                                        <option value="Bulgaria">Bulgaria</option>
                                        <option value="Burkina Faso">Burkina Faso</option>
                                        <option value="Burundi">Burundi</option>
                                        <option value="Cambodia">Cambodia</option>
                                        <option value="Cameroon">Cameroon</option>
                                        <option value="Canada">Canada</option>
                                        <option value="Canary Islands">Canary Islands</option>
                                        <option value="Cape Verde">Cape Verde</option>
                                        <option value="Cayman Islands">Cayman Islands</option>
                                        <option value="Central African Republic">Central African Republic</option>
                                        <option value="Chad">Chad</option>
                                        <option value="Channel Islands">Channel Islands</option>
                                        <option value="Chile">Chile</option>
                                        <option value="China">China</option>
                                        <option value="Christmas Island">Christmas Island</option>
                                        <option value="Cocos Island">Cocos Island</option>
                                        <option value="Colombia">Colombia</option>
                                        <option value="Comoros">Comoros</option>
                                        <option value="Congo">Congo</option>
                                        <option value="Cook Islands">Cook Islands</option>
                                        <option value="Costa Rica">Costa Rica</option>
                                        <option value="Cote DIvoire">Cote DIvoire</option>
                                        <option value="Croatia">Croatia</option>
                                        <option value="Cuba">Cuba</option>
                                        <option value="Curaco">Curacao</option>
                                        <option value="Cyprus">Cyprus</option>
                                        <option value="Czech Republic">Czech Republic</option>
                                        <option value="Denmark">Denmark</option>
                                        <option value="Djibouti">Djibouti</option>
                                        <option value="Dominica">Dominica</option>
                                        <option value="Dominican Republic">Dominican Republic</option>
                                        <option value="East Timor">East Timor</option>
                                        <option value="Ecuador">Ecuador</option>
                                        <option value="Egypt">Egypt</option>
                                        <option value="El Salvador">El Salvador</option>
                                        <option value="Equatorial Guinea">Equatorial Guinea</option>
                                        <option value="Eritrea">Eritrea</option>
                                        <option value="Estonia">Estonia</option>
                                        <option value="Ethiopia">Ethiopia</option>
                                        <option value="Falkland Islands">Falkland Islands</option>
                                        <option value="Faroe Islands">Faroe Islands</option>
                                        <option value="Fiji">Fiji</option>
                                        <option value="Finland">Finland</option>
                                        <option value="France">France</option>
                                        <option value="French Guiana">French Guiana</option>
                                        <option value="French Polynesia">French Polynesia</option>
                                        <option value="French Southern Ter">French Southern Ter</option>
                                        <option value="Gabon">Gabon</option>
                                        <option value="Gambia">Gambia</option>
                                        <option value="Georgia">Georgia</option>
                                        <option value="Germany">Germany</option>
                                        <option value="Ghana">Ghana</option>
                                        <option value="Gibraltar">Gibraltar</option>
                                        <option value="Great Britain">Great Britain</option>
                                        <option value="Greece">Greece</option>
                                        <option value="Greenland">Greenland</option>
                                        <option value="Grenada">Grenada</option>
                                        <option value="Guadeloupe">Guadeloupe</option>
                                        <option value="Guam">Guam</option>
                                        <option value="Guatemala">Guatemala</option>
                                        <option value="Guinea">Guinea</option>
                                        <option value="Guyana">Guyana</option>
                                        <option value="Haiti">Haiti</option>
                                        <option value="Hawaii">Hawaii</option>
                                        <option value="Honduras">Honduras</option>
                                        <option value="Hong Kong">Hong Kong</option>
                                        <option value="Hungary">Hungary</option>
                                        <option value="Iceland">Iceland</option>
                                        <option value="Indonesia">Indonesia</option>
                                        <option value="India">India</option>
                                        <option value="Iran">Iran</option>
                                        <option value="Iraq">Iraq</option>
                                        <option value="Ireland">Ireland</option>
                                        <option value="Isle of Man">Isle of Man</option>
                                        <option value="Israel">Israel</option>
                                        <option value="Italy">Italy</option>
                                        <option value="Jamaica">Jamaica</option>
                                        <option value="Japan">Japan</option>
                                        <option value="Jordan">Jordan</option>
                                        <option value="Kazakhstan">Kazakhstan</option>
                                        <option value="Kenya">Kenya</option>
                                        <option value="Kiribati">Kiribati</option>
                                        <option value="Korea North">Korea North</option>
                                        <option value="Korea Sout">Korea South</option>
                                        <option value="Kuwait">Kuwait</option>
                                        <option value="Kyrgyzstan">Kyrgyzstan</option>
                                        <option value="Laos">Laos</option>
                                        <option value="Latvia">Latvia</option>
                                        <option value="Lebanon">Lebanon</option>
                                        <option value="Lesotho">Lesotho</option>
                                        <option value="Liberia">Liberia</option>
                                        <option value="Libya">Libya</option>
                                        <option value="Liechtenstein">Liechtenstein</option>
                                        <option value="Lithuania">Lithuania</option>
                                        <option value="Luxembourg">Luxembourg</option>
                                        <option value="Macau">Macau</option>
                                        <option value="Macedonia">Macedonia</option>
                                        <option value="Madagascar">Madagascar</option>
                                        <option value="Malaysia">Malaysia</option>
                                        <option value="Malawi">Malawi</option>
                                        <option value="Maldives">Maldives</option>
                                        <option value="Mali">Mali</option>
                                        <option value="Malta">Malta</option>
                                        <option value="Marshall Islands">Marshall Islands</option>
                                        <option value="Martinique">Martinique</option>
                                        <option value="Mauritania">Mauritania</option>
                                        <option value="Mauritius">Mauritius</option>
                                        <option value="Mayotte">Mayotte</option>
                                        <option value="Mexico">Mexico</option>
                                        <option value="Midway Islands">Midway Islands</option>
                                        <option value="Moldova">Moldova</option>
                                        <option value="Monaco">Monaco</option>
                                        <option value="Mongolia">Mongolia</option>
                                        <option value="Montserrat">Montserrat</option>
                                        <option value="Morocco">Morocco</option>
                                        <option value="Mozambique">Mozambique</option>
                                        <option value="Myanmar">Myanmar</option>
                                        <option value="Nambia">Nambia</option>
                                        <option value="Nauru">Nauru</option>
                                        <option value="Nepal">Nepal</option>
                                        <option value="Netherland Antilles">Netherland Antilles</option>
                                        <option value="Netherlands">Netherlands (Holland, Europe)</option>
                                        <option value="Nevis">Nevis</option>
                                        <option value="New Caledonia">New Caledonia</option>
                                        <option value="New Zealand">New Zealand</option>
                                        <option value="Nicaragua">Nicaragua</option>
                                        <option value="Niger">Niger</option>
                                        <option value="Nigeria">Nigeria</option>
                                        <option value="Niue">Niue</option>
                                        <option value="Norfolk Island">Norfolk Island</option>
                                        <option value="Norway">Norway</option>
                                        <option value="Oman">Oman</option>
                                        <option value="Pakistan">Pakistan</option>
                                        <option value="Palau Island">Palau Island</option>
                                        <option value="Palestine">Palestine</option>
                                        <option value="Panama">Panama</option>
                                        <option value="Papua New Guinea">Papua New Guinea</option>
                                        <option value="Paraguay">Paraguay</option>
                                        <option value="Peru">Peru</option>
                                        <option value="Phillipines">Philippines</option>
                                        <option value="Pitcairn Island">Pitcairn Island</option>
                                        <option value="Poland">Poland</option>
                                        <option value="Portugal">Portugal</option>
                                        <option value="Puerto Rico">Puerto Rico</option>
                                        <option value="Qatar">Qatar</option>
                                        <option value="Republic of Montenegro">Republic of Montenegro</option>
                                        <option value="Republic of Serbia">Republic of Serbia</option>
                                        <option value="Reunion">Reunion</option>
                                        <option value="Romania">Romania</option>
                                        <option value="Russia">Russia</option>
                                        <option value="Rwanda">Rwanda</option>
                                        <option value="St Barthelemy">St Barthelemy</option>
                                        <option value="St Eustatius">St Eustatius</option>
                                        <option value="St Helena">St Helena</option>
                                        <option value="St Kitts-Nevis">St Kitts-Nevis</option>
                                        <option value="St Lucia">St Lucia</option>
                                        <option value="St Maarten">St Maarten</option>
                                        <option value="St Pierre & Miquelon">St Pierre & Miquelon</option>
                                        <option value="St Vincent & Grenadines">St Vincent & Grenadines</option>
                                        <option value="Saipan">Saipan</option>
                                        <option value="Samoa">Samoa</option>
                                        <option value="Samoa American">Samoa American</option>
                                        <option value="San Marino">San Marino</option>
                                        <option value="Sao Tome & Principe">Sao Tome & Principe</option>
                                        <option value="Saudi Arabia">Saudi Arabia</option>
                                        <option value="Senegal">Senegal</option>
                                        <option value="Seychelles">Seychelles</option>
                                        <option value="Sierra Leone">Sierra Leone</option>
                                        <option value="Singapore">Singapore</option>
                                        <option value="Slovakia">Slovakia</option>
                                        <option value="Slovenia">Slovenia</option>
                                        <option value="Solomon Islands">Solomon Islands</option>
                                        <option value="Somalia">Somalia</option>
                                        <option value="South Africa">South Africa</option>
                                        <option value="Spain">Spain</option>
                                        <option value="Sri Lanka">Sri Lanka</option>
                                        <option value="Sudan">Sudan</option>
                                        <option value="Suriname">Suriname</option>
                                        <option value="Swaziland">Swaziland</option>
                                        <option value="Sweden">Sweden</option>
                                        <option value="Switzerland">Switzerland</option>
                                        <option value="Syria">Syria</option>
                                        <option value="Tahiti">Tahiti</option>
                                        <option value="Taiwan">Taiwan</option>
                                        <option value="Tajikistan">Tajikistan</option>
                                        <option value="Tanzania">Tanzania</option>
                                        <option value="Thailand">Thailand</option>
                                        <option value="Togo">Togo</option>
                                        <option value="Tokelau">Tokelau</option>
                                        <option value="Tonga">Tonga</option>
                                        <option value="Trinidad & Tobago">Trinidad & Tobago</option>
                                        <option value="Tunisia">Tunisia</option>
                                        <option value="Turkey">Turkey</option>
                                        <option value="Turkmenistan">Turkmenistan</option>
                                        <option value="Turks & Caicos Is">Turks & Caicos Is</option>
                                        <option value="Tuvalu">Tuvalu</option>
                                        <option value="Uganda">Uganda</option>
                                        <option value="United Kingdom">United Kingdom</option>
                                        <option value="Ukraine">Ukraine</option>
                                        <option value="United Arab Erimates">United Arab Emirates</option>
                                        <option value="United States of America">United States of America</option>
                                        <option value="Uraguay">Uruguay</option>
                                        <option value="Uzbekistan">Uzbekistan</option>
                                        <option value="Vanuatu">Vanuatu</option>
                                        <option value="Vatican City State">Vatican City State</option>
                                        <option value="Venezuela">Venezuela</option>
                                        <option value="Vietnam">Vietnam</option>
                                        <option value="Virgin Islands (Brit)">Virgin Islands (Brit)</option>
                                        <option value="Virgin Islands (USA)">Virgin Islands (USA)</option>
                                        <option value="Wake Island">Wake Island</option>
                                        <option value="Wallis & Futana Is">Wallis & Futana Is</option>
                                        <option value="Yemen">Yemen</option>
                                        <option value="Zaire">Zaire</option>
                                        <option value="Zambia">Zambia</option>
                                        <option value="Zimbabwe">Zimbabwe</option>
                                    </select>
                                </div>
                                <div class="col-12 margin-10px-bottom">
                                    <label class="margin-15px-bottom">Street address <span class="text-radical-red">*</span></label>
                                    <input class="small-input" type="text" placeholder="House number and street name">
                                    <input class="small-input" type="text" placeholder="Apartment,suite,unit etc. (optional)">
                                </div>
                                <div class="col-12 margin-10px-bottom">
                                    <label class="margin-15px-bottom">Town / City <span class="text-radical-red">*</span></label>
                                    <input class="small-input" type="text" required>
                                </div>
                                <div class="col-12 margin-10px-bottom">
                                    <label class="margin-15px-bottom" for="state">State <span class="text-radical-red">*</span></label>
                                    <select name="state" id="state" class="small-input">
                                        <option>Select a state</option>
                                    </select>
                                </div>
                                <div class="col-12 margin-10px-bottom">
                                    <label class="margin-15px-bottom">ZIP <span class="text-radical-red">*</span></label>
                                    <input class="small-input" type="text" required>
                                </div>
                                <div class="col-12 margin-10px-bottom">
                                    <label class="margin-15px-bottom">Phone <span class="text-radical-red">*</span></label>
                                    <input class="small-input" type="text" required>
                                </div>
                                <div class="col-12 margin-10px-bottom">
                                    <label class="margin-15px-bottom">Email address <span class="text-radical-red">*</span></label>
                                    <input class="small-input" type="text" required>
                                </div>
                                <!-- start tab content -->    
                                <div class="col-md-12 position-relative checkout-accordion">
                                    <p class="title mb-2 d-flex">
                                        <label class="margin-5px-bottom">
                                            <input class="d-inline w-auto mb-0 me-2 mt-1" type="checkbox" name="account">
                                            <span class=" d-inline-block text-decoration-none">Create an account?</span> 
                                            <a class="accordion-toggle text-black" data-bs-toggle="collapse" data-bs-parent="#accordion1" href="#collapseThree"></a>
                                        </label>
                                    </p>
                                    <div id="collapseThree" class="collapse">
                                        <div class="padding-25px-left margin-2-half-rem-bottom md-no-padding-left">
                                            <label class="margin-15px-bottom">Account username <span class="text-radical-red">*</span></label>
                                            <input class="small-input" type="text" placeholder="Enter username" required>
                                            <label class="margin-15px-bottom">Create account password <span class="text-radical-red">*</span></label>
                                            <input class="small-input" type="password" placeholder="Enter password" required>      
                                        </div>
                                    </div>
                                </div>
                                <!-- end tab content -->
                                <!-- start tab content -->
                                <div class="col-md-12 checkout-accordion">
                                    <p class="title mb-2 d-flex">
                                        <label class="margin-5px-bottom">
                                            <input class="d-inline w-auto mb-0 me-2 mt-1" type="checkbox" name="account">
                                            <span class=" d-inline-block text-decoration-none">Ship to a different address?</span> 
                                            <a class="accordion-toggle text-black" data-bs-toggle="collapse" data-bs-parent="#accordion1" href="#collapseFour"></a>
                                        </label>
                                    </p>
                                    <div id="collapseFour" class="collapse">
                                        <div class="padding-25px-left margin-2-half-rem-bottom md-no-padding-left">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label class="margin-15px-bottom">First name <span class="text-radical-red">*</span></label>
                                                    <input class="small-input" type="text" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="margin-15px-bottom">Last name <span class="text-radical-red">*</span></label>
                                                    <input class="small-input" type="text" required>
                                                </div>    
                                                <div class="col-12">
                                                    <label class="margin-15px-bottom">Company name (optional)</label>
                                                    <input class="small-input" type="text">
                                                </div>
                                                <div class="col-12">
                                                    <label class="margin-15px-bottom" for="shipping-contry">Country <span class="text-radical-red">*</span></label>
                                                    <select name="contry" id="shipping-contry" class="small-input">
                                                        <option>Select a Country</option>
                                                        <option value="Afganistan">Afghanistan</option>
                                                        <option value="Albania">Albania</option>
                                                        <option value="Algeria">Algeria</option>
                                                        <option value="American Samoa">American Samoa</option>
                                                        <option value="Andorra">Andorra</option>
                                                        <option value="Angola">Angola</option>
                                                        <option value="Anguilla">Anguilla</option>
                                                        <option value="Antigua & Barbuda">Antigua & Barbuda</option>
                                                        <option value="Argentina">Argentina</option>
                                                        <option value="Armenia">Armenia</option>
                                                        <option value="Aruba">Aruba</option>
                                                        <option value="Australia">Australia</option>
                                                        <option value="Austria">Austria</option>
                                                        <option value="Azerbaijan">Azerbaijan</option>
                                                        <option value="Bahamas">Bahamas</option>
                                                        <option value="Bahrain">Bahrain</option>
                                                        <option value="Bangladesh">Bangladesh</option>
                                                        <option value="Barbados">Barbados</option>
                                                        <option value="Belarus">Belarus</option>
                                                        <option value="Belgium">Belgium</option>
                                                        <option value="Belize">Belize</option>
                                                        <option value="Benin">Benin</option>
                                                        <option value="Bermuda">Bermuda</option>
                                                        <option value="Bhutan">Bhutan</option>
                                                        <option value="Bolivia">Bolivia</option>
                                                        <option value="Bonaire">Bonaire</option>
                                                        <option value="Bosnia & Herzegovina">Bosnia & Herzegovina</option>
                                                        <option value="Botswana">Botswana</option>
                                                        <option value="Brazil">Brazil</option>
                                                        <option value="British Indian Ocean Ter">British Indian Ocean Ter</option>
                                                        <option value="Brunei">Brunei</option>
                                                        <option value="Bulgaria">Bulgaria</option>
                                                        <option value="Burkina Faso">Burkina Faso</option>
                                                        <option value="Burundi">Burundi</option>
                                                        <option value="Cambodia">Cambodia</option>
                                                        <option value="Cameroon">Cameroon</option>
                                                        <option value="Canada">Canada</option>
                                                        <option value="Canary Islands">Canary Islands</option>
                                                        <option value="Cape Verde">Cape Verde</option>
                                                        <option value="Cayman Islands">Cayman Islands</option>
                                                        <option value="Central African Republic">Central African Republic</option>
                                                        <option value="Chad">Chad</option>
                                                        <option value="Channel Islands">Channel Islands</option>
                                                        <option value="Chile">Chile</option>
                                                        <option value="China">China</option>
                                                        <option value="Christmas Island">Christmas Island</option>
                                                        <option value="Cocos Island">Cocos Island</option>
                                                        <option value="Colombia">Colombia</option>
                                                        <option value="Comoros">Comoros</option>
                                                        <option value="Congo">Congo</option>
                                                        <option value="Cook Islands">Cook Islands</option>
                                                        <option value="Costa Rica">Costa Rica</option>
                                                        <option value="Cote DIvoire">Cote DIvoire</option>
                                                        <option value="Croatia">Croatia</option>
                                                        <option value="Cuba">Cuba</option>
                                                        <option value="Curaco">Curacao</option>
                                                        <option value="Cyprus">Cyprus</option>
                                                        <option value="Czech Republic">Czech Republic</option>
                                                        <option value="Denmark">Denmark</option>
                                                        <option value="Djibouti">Djibouti</option>
                                                        <option value="Dominica">Dominica</option>
                                                        <option value="Dominican Republic">Dominican Republic</option>
                                                        <option value="East Timor">East Timor</option>
                                                        <option value="Ecuador">Ecuador</option>
                                                        <option value="Egypt">Egypt</option>
                                                        <option value="El Salvador">El Salvador</option>
                                                        <option value="Equatorial Guinea">Equatorial Guinea</option>
                                                        <option value="Eritrea">Eritrea</option>
                                                        <option value="Estonia">Estonia</option>
                                                        <option value="Ethiopia">Ethiopia</option>
                                                        <option value="Falkland Islands">Falkland Islands</option>
                                                        <option value="Faroe Islands">Faroe Islands</option>
                                                        <option value="Fiji">Fiji</option>
                                                        <option value="Finland">Finland</option>
                                                        <option value="France">France</option>
                                                        <option value="French Guiana">French Guiana</option>
                                                        <option value="French Polynesia">French Polynesia</option>
                                                        <option value="French Southern Ter">French Southern Ter</option>
                                                        <option value="Gabon">Gabon</option>
                                                        <option value="Gambia">Gambia</option>
                                                        <option value="Georgia">Georgia</option>
                                                        <option value="Germany">Germany</option>
                                                        <option value="Ghana">Ghana</option>
                                                        <option value="Gibraltar">Gibraltar</option>
                                                        <option value="Great Britain">Great Britain</option>
                                                        <option value="Greece">Greece</option>
                                                        <option value="Greenland">Greenland</option>
                                                        <option value="Grenada">Grenada</option>
                                                        <option value="Guadeloupe">Guadeloupe</option>
                                                        <option value="Guam">Guam</option>
                                                        <option value="Guatemala">Guatemala</option>
                                                        <option value="Guinea">Guinea</option>
                                                        <option value="Guyana">Guyana</option>
                                                        <option value="Haiti">Haiti</option>
                                                        <option value="Hawaii">Hawaii</option>
                                                        <option value="Honduras">Honduras</option>
                                                        <option value="Hong Kong">Hong Kong</option>
                                                        <option value="Hungary">Hungary</option>
                                                        <option value="Iceland">Iceland</option>
                                                        <option value="Indonesia">Indonesia</option>
                                                        <option value="India">India</option>
                                                        <option value="Iran">Iran</option>
                                                        <option value="Iraq">Iraq</option>
                                                        <option value="Ireland">Ireland</option>
                                                        <option value="Isle of Man">Isle of Man</option>
                                                        <option value="Israel">Israel</option>
                                                        <option value="Italy">Italy</option>
                                                        <option value="Jamaica">Jamaica</option>
                                                        <option value="Japan">Japan</option>
                                                        <option value="Jordan">Jordan</option>
                                                        <option value="Kazakhstan">Kazakhstan</option>
                                                        <option value="Kenya">Kenya</option>
                                                        <option value="Kiribati">Kiribati</option>
                                                        <option value="Korea North">Korea North</option>
                                                        <option value="Korea Sout">Korea South</option>
                                                        <option value="Kuwait">Kuwait</option>
                                                        <option value="Kyrgyzstan">Kyrgyzstan</option>
                                                        <option value="Laos">Laos</option>
                                                        <option value="Latvia">Latvia</option>
                                                        <option value="Lebanon">Lebanon</option>
                                                        <option value="Lesotho">Lesotho</option>
                                                        <option value="Liberia">Liberia</option>
                                                        <option value="Libya">Libya</option>
                                                        <option value="Liechtenstein">Liechtenstein</option>
                                                        <option value="Lithuania">Lithuania</option>
                                                        <option value="Luxembourg">Luxembourg</option>
                                                        <option value="Macau">Macau</option>
                                                        <option value="Macedonia">Macedonia</option>
                                                        <option value="Madagascar">Madagascar</option>
                                                        <option value="Malaysia">Malaysia</option>
                                                        <option value="Malawi">Malawi</option>
                                                        <option value="Maldives">Maldives</option>
                                                        <option value="Mali">Mali</option>
                                                        <option value="Malta">Malta</option>
                                                        <option value="Marshall Islands">Marshall Islands</option>
                                                        <option value="Martinique">Martinique</option>
                                                        <option value="Mauritania">Mauritania</option>
                                                        <option value="Mauritius">Mauritius</option>
                                                        <option value="Mayotte">Mayotte</option>
                                                        <option value="Mexico">Mexico</option>
                                                        <option value="Midway Islands">Midway Islands</option>
                                                        <option value="Moldova">Moldova</option>
                                                        <option value="Monaco">Monaco</option>
                                                        <option value="Mongolia">Mongolia</option>
                                                        <option value="Montserrat">Montserrat</option>
                                                        <option value="Morocco">Morocco</option>
                                                        <option value="Mozambique">Mozambique</option>
                                                        <option value="Myanmar">Myanmar</option>
                                                        <option value="Nambia">Nambia</option>
                                                        <option value="Nauru">Nauru</option>
                                                        <option value="Nepal">Nepal</option>
                                                        <option value="Netherland Antilles">Netherland Antilles</option>
                                                        <option value="Netherlands">Netherlands (Holland, Europe)</option>
                                                        <option value="Nevis">Nevis</option>
                                                        <option value="New Caledonia">New Caledonia</option>
                                                        <option value="New Zealand">New Zealand</option>
                                                        <option value="Nicaragua">Nicaragua</option>
                                                        <option value="Niger">Niger</option>
                                                        <option value="Nigeria">Nigeria</option>
                                                        <option value="Niue">Niue</option>
                                                        <option value="Norfolk Island">Norfolk Island</option>
                                                        <option value="Norway">Norway</option>
                                                        <option value="Oman">Oman</option>
                                                        <option value="Pakistan">Pakistan</option>
                                                        <option value="Palau Island">Palau Island</option>
                                                        <option value="Palestine">Palestine</option>
                                                        <option value="Panama">Panama</option>
                                                        <option value="Papua New Guinea">Papua New Guinea</option>
                                                        <option value="Paraguay">Paraguay</option>
                                                        <option value="Peru">Peru</option>
                                                        <option value="Phillipines">Philippines</option>
                                                        <option value="Pitcairn Island">Pitcairn Island</option>
                                                        <option value="Poland">Poland</option>
                                                        <option value="Portugal">Portugal</option>
                                                        <option value="Puerto Rico">Puerto Rico</option>
                                                        <option value="Qatar">Qatar</option>
                                                        <option value="Republic of Montenegro">Republic of Montenegro</option>
                                                        <option value="Republic of Serbia">Republic of Serbia</option>
                                                        <option value="Reunion">Reunion</option>
                                                        <option value="Romania">Romania</option>
                                                        <option value="Russia">Russia</option>
                                                        <option value="Rwanda">Rwanda</option>
                                                        <option value="St Barthelemy">St Barthelemy</option>
                                                        <option value="St Eustatius">St Eustatius</option>
                                                        <option value="St Helena">St Helena</option>
                                                        <option value="St Kitts-Nevis">St Kitts-Nevis</option>
                                                        <option value="St Lucia">St Lucia</option>
                                                        <option value="St Maarten">St Maarten</option>
                                                        <option value="St Pierre & Miquelon">St Pierre & Miquelon</option>
                                                        <option value="St Vincent & Grenadines">St Vincent & Grenadines</option>
                                                        <option value="Saipan">Saipan</option>
                                                        <option value="Samoa">Samoa</option>
                                                        <option value="Samoa American">Samoa American</option>
                                                        <option value="San Marino">San Marino</option>
                                                        <option value="Sao Tome & Principe">Sao Tome & Principe</option>
                                                        <option value="Saudi Arabia">Saudi Arabia</option>
                                                        <option value="Senegal">Senegal</option>
                                                        <option value="Seychelles">Seychelles</option>
                                                        <option value="Sierra Leone">Sierra Leone</option>
                                                        <option value="Singapore">Singapore</option>
                                                        <option value="Slovakia">Slovakia</option>
                                                        <option value="Slovenia">Slovenia</option>
                                                        <option value="Solomon Islands">Solomon Islands</option>
                                                        <option value="Somalia">Somalia</option>
                                                        <option value="South Africa">South Africa</option>
                                                        <option value="Spain">Spain</option>
                                                        <option value="Sri Lanka">Sri Lanka</option>
                                                        <option value="Sudan">Sudan</option>
                                                        <option value="Suriname">Suriname</option>
                                                        <option value="Swaziland">Swaziland</option>
                                                        <option value="Sweden">Sweden</option>
                                                        <option value="Switzerland">Switzerland</option>
                                                        <option value="Syria">Syria</option>
                                                        <option value="Tahiti">Tahiti</option>
                                                        <option value="Taiwan">Taiwan</option>
                                                        <option value="Tajikistan">Tajikistan</option>
                                                        <option value="Tanzania">Tanzania</option>
                                                        <option value="Thailand">Thailand</option>
                                                        <option value="Togo">Togo</option>
                                                        <option value="Tokelau">Tokelau</option>
                                                        <option value="Tonga">Tonga</option>
                                                        <option value="Trinidad & Tobago">Trinidad & Tobago</option>
                                                        <option value="Tunisia">Tunisia</option>
                                                        <option value="Turkey">Turkey</option>
                                                        <option value="Turkmenistan">Turkmenistan</option>
                                                        <option value="Turks & Caicos Is">Turks & Caicos Is</option>
                                                        <option value="Tuvalu">Tuvalu</option>
                                                        <option value="Uganda">Uganda</option>
                                                        <option value="United Kingdom">United Kingdom</option>
                                                        <option value="Ukraine">Ukraine</option>
                                                        <option value="United Arab Erimates">United Arab Emirates</option>
                                                        <option value="United States of America">United States of America</option>
                                                        <option value="Uraguay">Uruguay</option>
                                                        <option value="Uzbekistan">Uzbekistan</option>
                                                        <option value="Vanuatu">Vanuatu</option>
                                                        <option value="Vatican City State">Vatican City State</option>
                                                        <option value="Venezuela">Venezuela</option>
                                                        <option value="Vietnam">Vietnam</option>
                                                        <option value="Virgin Islands (Brit)">Virgin Islands (Brit)</option>
                                                        <option value="Virgin Islands (USA)">Virgin Islands (USA)</option>
                                                        <option value="Wake Island">Wake Island</option>
                                                        <option value="Wallis & Futana Is">Wallis & Futana Is</option>
                                                        <option value="Yemen">Yemen</option>
                                                        <option value="Zaire">Zaire</option>
                                                        <option value="Zambia">Zambia</option>
                                                        <option value="Zimbabwe">Zimbabwe</option>
                                                    </select>
                                                </div>
                                                <div class="col-12">
                                                    <label class="margin-15px-bottom">Street address <span class="text-radical-red">*</span></label>
                                                    <input class="small-input" type="text" placeholder="House number and street name">
                                                    <input class="small-input" type="text" placeholder="Apartment,suite,unit etc. (optional)">
                                                </div>
                                                <div class="col-12">
                                                    <label class="margin-15px-bottom">Town / City <span class="text-radical-red">*</span></label>
                                                    <input class="small-input" type="text" required>
                                                </div>
                                                <div class="col-12">
                                                    <label class="margin-15px-bottom" for="shipping-state">State <span class="text-radical-red">*</span></label>
                                                    <select name="state" id="shipping-state" class="small-input">
                                                        <option>Select a state</option>
                                                    </select>
                                                </div>
                                                <div class="col-12">
                                                    <label class="margin-15px-bottom">ZIP <span class="text-radical-red">*</span></label>
                                                    <input class="small-input" type="text" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end tab content -->
                                <div class="col-12 margin-15px-top">
                                    <label class="margin-15px-bottom">Order notes (optional)</label>
                                    <textarea class="medium-input" rows="5" cols="5" placeholder="Notes about your order, e.g. special notes for delivery."></textarea>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-12 col-lg-5 col-md-6">
                        <div class="bg-light-gray padding-45px-all lg-padding-30px-all sm-padding-20px-all">
                            <span class="alt-font text-large text-extra-dark-gray margin-25px-bottom d-inline-block font-weight-500">Your order</span>
                            <table class="total-price-table checkout-total-price-table">
                                <thead class="border-bottom border-color-medium-gray text-extra-dark-gray">
                                    <tr>
                                        <th class="product-name font-weight-500 w-60">Product</th>
                                        <th class="product-total pe-0 font-weight-500">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Cotton Jacket - Black × 1<span class="d-block w-100">Size:XL</span></td>
                                        <td>&#8377;2599</td>
                                    </tr>
                                    <tr>
                                        <td>Tennis Shorts - White × 1<span class="d-block w-100">Size:M</span></td>
                                        <td>&#8377;2599</td>
                                    </tr>
                                    <tr>
                                        <td>Cashmere Sweater × 1<span class="d-block w-100">Size:S</span></td>
                                        <td>&#8377;1000</td>
                                    </tr>
                                    <tr>
                                        <th class="font-weight-500 text-extra-dark-gray">Subtotal</th>
                                        <td class="text-extra-dark-gray">&#8377;9999</td>
                                    </tr>
                                    <tr class="shipping">
                                        <th class="font-weight-500 text-extra-dark-gray">Shipping</th>
                                        <td>
                                            <ul class="margin-15px-bottom">
                                                <li class="d-flex align-items-center md-margin-15px-bottom">
                                                    <input id="free_shipping" type="radio" name="shipping-option" class="d-block w-auto margin-10px-right mb-0" checked="checked">
                                                    <label class="md-line-height-18px" for="free_shipping">Free shipping</label>
                                                </li>
                                                <li class="d-flex align-items-center md-margin-15px-bottom">
                                                    <input id="flat" type="radio" name="shipping-option" class="d-block w-auto margin-10px-right mb-0">
                                                    <label class="md-line-height-18px" for="flat">Flat: &#8377;299</label>
                                                </li>
                                                <li class="d-flex align-items-center">
                                                    <input id="local_pickup" type="radio" name="shipping-option" class="d-block w-auto margin-10px-right mb-0">
                                                    <label class="md-line-height-18px" for="local_pickup">Local pickup</label>
                                                </li>
                                            </ul>
                                            <p class="text-start text-small mb-0">Shipping options will be updated during checkout.</p>
                                        </td>
                                    </tr>
                                    <tr class="total-amount">
                                        <th class="font-weight-500 text-extra-dark-gray">Total</th>
                                        <td>
                                            <h6 class="d-block font-weight-500 mb-0 text-extra-dark-gray">&#8377;9999</h6>
                                            <span class="text-small">(Includes &#8377;199 tax)</span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="padding-40px-all bg-white box-shadow-large margin-20px-top margin-40px-bottom checkout-accordion lg-padding-30px-all md-padding-20px-all sm-padding-15px-lr">
                                <div class="w-100" id="accordion-style-05">
                                    <!-- start tab content -->
                                    <div class="heading active-accordion">
                                        <label class="margin-5px-bottom">
                                            <input class="d-inline w-auto margin-10px-right mb-0" type="radio" name="payment-option" checked="checked">
                                            <span class="d-inline-block">Direct bank transfer</span>
                                            <a class="accordion-toggle" data-bs-toggle="collapse" data-bs-parent="#accordion-style-05" href="#style-5-collapse-1"></a>
                                        </label>
                                    </div>
                                    <div id="style-5-collapse-1" class="collapse show" data-bs-parent="#accordion-style-05">
                                        <div class="padding-30px-all text-small bg-light-gray margin-20px-tb sm-padding-20px-lr sm-padding-25px-tb">Make your payment directly into our bank account. Please use your Order ID as the payment reference. Your order will not be shipped until the funds have cleared in our account.</div>
                                    </div>
                                    <!-- end tab content -->
                                    <!-- start tab content -->
                                    <div class="heading active-accordion">
                                        <label class="margin-5px-bottom">
                                            <input class="d-inline w-auto margin-10px-right mb-0" type="radio" name="payment-option">
                                            <span class="d-inline-block">Check payments</span>
                                            <a class="accordion-toggle" data-bs-toggle="collapse" data-bs-parent="#accordion-style-05" href="#style-5-collapse-2"></a>
                                        </label>
                                    </div>
                                    <div id="style-5-collapse-2" class="collapse collapse" data-bs-parent="#accordion-style-05">
                                        <div class="padding-30px-all text-small bg-light-gray margin-20px-tb sm-padding-20px-lr sm-padding-25px-tb">Please send a check to store name, store street, store town, store state / county, store postcode.</div>
                                    </div>
                                    <!-- end tab content -->
                                    <!-- start tab content -->
                                    <div class="heading active-accordion">
                                        <label class="margin-5px-bottom">
                                            <input class="d-inline w-auto margin-10px-right mb-0" type="radio" name="payment-option">
                                            <span class="d-inline-block">Cash on delivery</span>
                                            <a class="accordion-toggle" data-bs-toggle="collapse" data-bs-parent="#accordion-style-05" href="#style-5-collapse-3"></a>
                                        </label>
                                    </div>
                                    <div id="style-5-collapse-3" class="collapse collapse" data-bs-parent="#accordion-style-05">
                                        <div class="padding-30px-all text-small bg-light-gray margin-20px-tb sm-padding-20px-lr sm-padding-25px-tb">Pay with cash upon delivery.</div>
                                    </div>
                                    <!-- end tab content -->
                                    <!-- start tab content -->
                                    <div class="heading active-accordion">
                                        <label class="margin-5px-bottom">
                                            <input class="d-inline w-auto margin-10px-right mb-0" type="radio" name="payment-option">
                                            <span class="d-inline-block">PayPal <img src="{{asset('public/site/images/paypal-logo.jpg')}}" alt="" class="w-120px margin-10px-left" ></span>
                                            <a class="accordion-toggle" data-bs-toggle="collapse" data-bs-parent="#accordion-style-05" href="#style-5-collapse-4"></a>
                                        </label>
                                    </div>
                                    <div id="style-5-collapse-4" class="collapse collapse" data-bs-parent="#accordion-style-05">
                                        <div class="padding-30px-all text-small bg-light-gray margin-20px-tb sm-padding-20px-lr sm-padding-25px-tb">You can pay with your credit card if you don’t have a PayPal account.</div>
                                    </div>
                                    <!-- end tab content -->
                                </div>
                            </div>
                            <p class="text-small">Your personal data will be used to process your order, support your experience throughout this website, and for other purposes described in our <a class="text-decoration-underline" href="#">privacy policy.</a></p>
                            <p class="d-flex align-items-center">
                                <input class="d-inline w-auto mb-0 margin-10px-right" type="checkbox" name="terms-and-condition">
                                <span class="text-small">I have read and agree to the website <a class="text-decoration-underline" href="#">terms and conditions</a><span class="text-red ms-1">*</span></span>
                            </p>
                            <button type="submit" class="btn btn-fancy btn-dark-gray btn-extra-large w-100 margin-15px-top">Place order</button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- end section -->
@include('front.includes.footer')