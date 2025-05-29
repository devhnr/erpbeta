@include('front.includes.header')
<!-- start page title -->
        <section class="wow animate__fadeIn bg-light-gray padding-25px-tb page-title-small">
            <div class="container">
                <div class="row align-items-center justify-content-center">
                    <div class="col-12 col-xl-8 col-lg-6">
                        <h1 class="alt-font text-extra-dark-gray font-weight-500 no-margin-bottom text-center text-lg-start">Shopping cart</h1>
                    </div>
                    <div class="col-12 col-xl-4 col-lg-6 breadcrumb justify-content-center justify-content-lg-end text-small alt-font md-margin-10px-top">
                        <ul class="xs-text-center">
                            <li><a href="{{url('/')}}">Home</a></li>
                            <li><a href="{{url('product-listing')}}">Shop</a></li>
                            <li>Shopping cart</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
        <!-- end page title -->
        <!-- start section -->
        <section class="wow animate__fadeIn">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 padding-70px-right lg-padding-30px-right md-padding-15px-right">
                        <div class="row align-items-center">
                            <div class="col-12">
                                <table class="table cart-products margin-60px-bottom md-margin-40px-bottom sm-no-margin-bottom">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="alt-font"></th>
                                            <th scope="col" class="alt-font"></th>
                                            <th scope="col" class="alt-font">Product</th>
                                            <th scope="col" class="alt-font">Price</th>
                                            <th scope="col" class="alt-font">Quantity</th>
                                            <th scope="col" class="alt-font">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr> 
                                            <td class="product-remove">
                                                <a href="#" class="btn-default text-large">&times;</a>
                                            </td>
                                            <td class="product-thumbnail"><a href="#"><img class="cart-product-image" src="{{asset('public/site/images/product-image-1.jpg')}}" alt=""></a></td>
                                            <td class="product-name">
                                                <a href="#">Burberry London</a>
                                                <span class="variation"> Size: L</span>
                                            </td>
                                            <td class="product-price" data-title="Price">&#8377;350</td>
                                            <td class="product-quantity" data-title="Quantity">
                                                <div class="quantity">
                                                    <label class="screen-reader-text">Quantity</label>
                                                    <input type="button" value="-" class="qty-minus qty-btn" data-quantity="minus" data-field="quantity">
                                                    <input class="input-text qty-text" type="number" name="quantity" value="1">
                                                    <input type="button" value="+" class="qty-plus qty-btn" data-quantity="plus" data-field="quantity">
                                                </div>
                                            </td> 
                                            <td class="product-subtotal" data-title="Total">&#8377;350</td> 
                                        </tr>
                                        <tr> 
                                            <td class="product-remove">
                                                <a href="#" class="btn-default text-large">&times;</a>
                                            </td>
                                            <td class="product-thumbnail"><a href="#"><img class="cart-product-image" src="{{asset('public/site/images/product-image-8.jpg')}}" alt=""></a></td>
                                            <td class="product-name">
                                                <a href="#">Down Bomber</a>
                                                <span class="variation">Size: L</span>
                                            </td>
                                            <td class="product-price" data-title="Price">&#8377;510</td>
                                            <td class="product-quantity" data-title="Quantity">
                                                <div class="quantity">
                                                    <label class="screen-reader-text">Quantity</label>
                                                    <input type="button" value="-" class="qty-minus qty-btn" data-quantity="minus" data-field="quantity">
                                                    <input class="input-text qty-text" type="number" name="quantity" value="1">
                                                    <input type="button" value="+" class="qty-plus qty-btn" data-quantity="plus" data-field="quantity">
                                                </div>
                                            </td>
                                            <td class="product-subtotal" data-title="Total">&#8377;1000</td> 
                                        </tr>
                                        <tr>
                                            <td class="product-remove">
                                                <a href="#" class="btn-default text-large">&times;</a> 
                                            </td>
                                            <td class="product-thumbnail"><a href="#"><img class="cart-product-image" src="{{asset('public/site/images/product-image-1.jpg')}}" alt=""></a></td>
                                            <td class="product-name">
                                                <a href="single-product.html">Isabel Marant</a>
                                                <span class="variation">Size: L</span>
                                            </td>
                                            <td class="product-price" data-title="Price">&#8377;2990</td>
                                            <td class="product-quantity" data-title="Quantity">
                                                <div class="quantity">
                                                    <label class="screen-reader-text">Quantity</label>
                                                    <input type="button" value="-" class="qty-minus qty-btn" data-quantity="minus" data-field="quantity">
                                                    <input class="input-text qty-text" type="number" name="quantity" value="1">
                                                    <input type="button" value="+" class="qty-plus qty-btn" data-quantity="plus" data-field="quantity">
                                                </div>
                                            </td>
                                            <td class="product-subtotal" data-title="Total">&#8377;2990</td> 
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-6 md-margin-50px-bottom sm-margin-20px-bottom"> 
                                <div class="coupon-code-panel">
                                    <input type="text" placeholder="Coupon code">
                                    <a href="#" class="btn apply-coupon-btn text-uppercase">Apply</a>
                                </div>
                            </div>
                            <div class="col-md-6 text-center text-md-end md-margin-50px-bottom btn-dual">
                                <a href="#" class="btn btn-fancy btn-small btn-transparent-light-gray">Empty cart</a>
                                <a href="#" class="btn btn-fancy btn-small btn-transparent-light-gray me-0">Update cart</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="bg-light-gray padding-50px-all lg-padding-30px-tb lg-padding-20px-lr md-padding-20px-tb">
                            <span class="alt-font text-large text-extra-dark-gray margin-15px-bottom d-inline-block font-weight-500">Cart totals</span>
                            <table class="w-100 total-price-table">
                                <tbody>
                                    <tr>
                                        <th class="w-50 font-weight-500 text-extra-dark-gray">Subtotal</th>
                                        <td class="text-extra-dark-gray">&#8377;4050</td>
                                    </tr>
                                    <tr class="shipping">
                                        <th class="font-weight-500 text-extra-dark-gray">Shipping</th>
                                        <td data-title="Shipping">
                                            <ul class="float-lg-start float-end text-start line-height-36px">
                                                <li class="d-flex align-items-center md-margin-15px-bottom">
                                                    <input id="free_shipping" type="radio" name="shipping-option" class="d-block w-auto margin-10px-right mb-0" checked="checked">
                                                    <label class="md-line-height-18px" for="free_shipping">Free shipping</label>
                                                </li>
                                                <li class="d-flex align-items-center md-margin-15px-bottom">
                                                    <input id="flat" type="radio" name="shipping-option" class="d-block w-auto margin-10px-right mb-0">
                                                    <label class="md-line-height-18px" for="flat">Flat: &#8377;1200</label>
                                                </li>
                                                <li class="d-flex align-items-center">
                                                    <input id="local_pickup" type="radio" name="shipping-option" class="d-block w-auto margin-10px-right mb-0">
                                                    <label class="md-line-height-18px" for="local_pickup">Local pickup</label>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr class="calculate-shipping">
                                        <th colspan="2" class="font-weight-500">
                                            <a class="d-block calculate-shipping-title accordion-toggle" data-bs-toggle="collapse" href="#shipping-accordion" aria-expanded="false">
                                                <p class="w-100 mb-0 text-start">Calculate shipping</p>
                                            </a>
                                            <div id="shipping-accordion" class="address-block collapse">
                                                <div class="margin-15px-top">
                                                    <select>
                                                        <option>Select a Country...</option>
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
                                                    <select>
                                                        <option>State</option>
                                                    </select>
                                                    <input type="text" name="city" placeholder="Town/City">
                                                    <input type="text" name="zip" placeholder="ZIP">
                                                    <a href="#" class="btn btn-dark-gray btn-small d-block">Update</a>
                                                </div>
                                            </div>
                                        </th>
                                    </tr>
                                    <tr class="total-amount">
                                        <th class="font-weight-500 text-extra-dark-gray">Total</th>
                                        <td data-title="Total">
                                            <h6 class="d-block font-weight-500 mb-0 text-extra-dark-gray">&#8377;4050</h6>
                                            <span class="text-small text-extra-medium-gray">(Includes &#8377;199 tax)</span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div><a href="{{url('/checkout')}}" class="btn btn-dark-gray btn-large d-block btn-fancy margin-15px-top">Proceed to checkout</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- end section -->
@include('front.includes.footer')