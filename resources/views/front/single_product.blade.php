@include('front.includes.header')
<!-- start section -->
        <section class="big-section wow animate__fadeIn">
            <div class="container">
                <div class="row">
                    <div class="col-12 shopping-content d-flex flex-column flex-lg-row align-items-md-center">
                        <div class="w-60 md-w-100">
                            <div class="product-images-box lightbox-portfolio row">
                                <div class="col-12 col-lg-9 position-relative px-lg-0 order-lg-2 product-image md-margin-10px-bottom">
                                    <div class="swiper-container product-image-slider" data-slider-options='{ "spaceBetween": 10, "watchOverflow": true, "navigation": { "nextEl": ".slider-product-next", "prevEl": ".slider-product-prev" }, "thumbs": { "swiper": { "el": ".product-image-thumb", "slidesPerView": "auto", "spaceBetween": 15, "direction": "vertical", "navigation": { "nextEl": ".swiper-thumb-next", "prevEl": ".swiper-thumb-prev" } } } }' data-thumb-slider-md-direction="horizontal">
                                        <div class="swiper-wrapper">
                                            <!-- start slider item -->
                                            <div class="swiper-slide">
                                                <a class="gallery-link" href="#"><img class="w-100" src="{{asset('public/site/images/product-image-26.jpg')}}" alt=""></a>
                                            </div>
                                            <!-- end slider item -->
                                            <!-- start slider item -->
                                            <div class="swiper-slide">
                                                <a class="gallery-link" href="#"><img class="w-100" src="{{asset('public/site/images/product-image-27.jpg')}}" alt=""></a>
                                            </div>
                                            <!-- end slider item -->
                                            <!-- start slider item -->
                                            <div class="swiper-slide">
                                                <a class="gallery-link" href="#"><img class="w-100" src="{{asset('public/site/images/product-image-28.jpg')}}" alt=""></a>
                                            </div>
                                            <!-- end slider item -->
                                            <!-- start slider item -->
                                            <div class="swiper-slide">
                                                <a class="gallery-link" href="#"><img class="w-100" src="{{asset('public/site/images/product-image-29.jpg')}}" alt=""></a>
                                            </div>
                                            <!-- end slider item -->
                                            <!-- start slider item -->
                                            <div class="swiper-slide">
                                                <a class="gallery-link" href="#"><img class="w-100" src="{{asset('public/site/images/product-image-30.jpg')}}" alt=""></a>
                                            </div>
                                            <!-- end slider item -->
                                            <!-- start slider item -->
                                            <div class="swiper-slide">
                                                <a class="gallery-link" href="#"><img class="w-100" src="{{asset('public/site/images/product-image-26.jpg')}}" alt=""></a>
                                            </div>
                                            <!-- end slider item -->
                                        </div>
                                    </div>
                                    <div class="slider-product-next swiper-button-next text-extra-dark-gray"><i class="fa fa-chevron-right"></i></div>
                                    <div class="slider-product-prev swiper-button-prev text-extra-dark-gray"><i class="fa fa-chevron-left"></i></div>
                                </div>
                                <div class="col-12 col-lg-3 order-lg-1 position-relative single-product-thumb md-margin-50px-bottom sm-margin-40px-bottom">
                                    <div class="swiper-container product-image-thumb slider-vertical padding-15px-lr padding-45px-bottom md-no-padding left-0px">
                                        <div class="swiper-wrapper">
                                            <div class="swiper-slide"><img class="w-100" src="{{asset('public/site/images/product-image-26.jpg')}}" alt=""></div>
                                            <div class="swiper-slide"><img class="w-100" src="{{asset('public/site/images/product-image-27.jpg')}}" alt=""></div>
                                            <div class="swiper-slide"><img class="w-100" src="{{asset('public/site/images/product-image-28.jpg')}}" alt=""></div>
                                            <div class="swiper-slide"><img class="w-100" src="{{asset('public/site/images/product-image-29.jpg')}}" alt=""></div>
                                            <div class="swiper-slide"><img class="w-100" src="{{asset('public/site/images/product-image-30.jpg')}}" alt=""></div>
                                            <div class="swiper-slide"><img class="w-100" src="{{asset('public/site/images/product-image-26.jpg')}}" alt=""></div>
                                        </div>
                                    </div>
                                    <div class="swiper-thumb-next-prev text-center">
                                        <div class="swiper-button-prev swiper-thumb-prev"><i class="fa fa-chevron-up"></i></div>
                                        <div class="swiper-button-next swiper-thumb-next"><i class="fa fa-chevron-down"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="w-40 md-w-100 product-summary padding-7-rem-left lg-padding-5-rem-left md-no-padding-left">
                            <div class="breadcrumb text-small p-0">
                                <!-- start breadcrumb -->
                                <ul>
                                    <li><a href="{{url('/')}}">Home</a></li>
                                    <li><a href="product-listing.html">Shop</a></li>
                                    <li>Men T-shirt</li>
                                </ul>
                                <!-- end breadcrumb -->
                            </div>
                            <div class="d-flex align-items-center margin-3-half-rem-tb md-margin-1-half-rem-tb">
                                <div class="flex-grow-1">
                                    <div class="text-extra-dark-gray font-weight-500 text-extra-large alt-font margin-5px-bottom">Men T-shirt</div>
                                    <span class="product-price text-extra-medium"><del>&#8377;480</del>&#8377;400</span>
                                </div>
                                <div class="text-end line-height-30px">
                                    <div><a href="#" class="letter-spacing-3px"><i class="fas fa-star text-very-small text-golden-yellow"></i><i class="fas fa-star text-very-small text-golden-yellow"></i><i class="fas fa-star text-very-small text-golden-yellow"></i><i class="fas fa-star text-very-small text-golden-yellow"></i><i class="fas fa-star text-very-small text-golden-yellow"></i></a></div>
                                    <span class="text-small"><span class="text-extra-dark-gray">SKU: </span>8552635</span>
                                </div>
                            </div>
                            <div class="last-paragraph-no-margin">
                                <p>Lorem ipsum is simply dummy text of the printing and typesetting industry lorem ipsum has been the standard dummy text typesetting industry.</p>
                            </div>
                            <div class="margin-4-rem-top">
                                <div class="margin-20px-bottom">
                                    <label class="text-extra-dark-gray text-extra-small font-weight-500 alt-font text-uppercase w-60px">color</label>
                                    <ul class="alt-font shop-color">
                                        <li>
                                            <input class="d-none" type="radio" id="color-1" name="color" checked />
                                            <label for="color-1"><span style="background-color: #363636"></span></label>
                                        </li>
                                        <li>
                                            <input class="d-none" type="radio" id="color-2" name="color" />
                                            <label for="color-2"><span style="background-color: #657fa8"></span></label>
                                        </li>
                                        <li>
                                            <input class="d-none" type="radio" id="color-3" name="color" />
                                            <label for="color-3"><span style="background-color: #936f5e"></span></label>
                                        </li>
                                        <li>
                                            <input class="d-none" type="radio" id="color-4" name="color" />
                                            <label for="color-4"><span style="background-color: #97a27f"></span></label>
                                        </li>
                                    </ul>
                                </div>
                                <div class="margin-4-rem-bottom">
                                    <label class="text-extra-dark-gray text-extra-small font-weight-500 alt-font text-uppercase w-60px">Size</label>
                                    <ul class="text-extra-small shop-size">
                                        <li>
                                            <input class="d-none" type="radio" id="size-1" name="size" checked />
                                            <label for="size-1" class="width-80"><span>S</span></label>
                                        </li>
                                        <li>
                                            <input class="d-none" type="radio" id="size-2" name="size" />
                                            <label for="size-2" class="width-80"><span>M</span></label>
                                        </li>
                                        <li>
                                            <input class="d-none" type="radio" id="size-3" name="size" />
                                            <label for="size-3" class="width-80"><span>L</span></label>
                                        </li>
                                    </ul>
                                    <label class="size-chart text-uppercase w-60px margin-10px-left">
                                        <a class="modal-popup alt-font text-extra-small text-decoration-line-bottom" href="#modal-popup">Size Guide</a>
                                    </label>
                                    <div id="modal-popup" class="white-popup-block mfp-hide w-55 mx-auto position-relative bg-white modal-popup-main padding-5-rem-all xl-w-70 md-w-80 md-padding-4-rem-all xs-w-95 xs-padding-3-rem-all">
                                        <div class="table-style-01">
                                            <table>
                                                <tbody>
                                                    <tr class="alt-font bg-extra-dark-gray font-weight-500 text-white">
                                                        <th>SIZE</th>
                                                        <th>S</th>
                                                        <th>M</th>
                                                        <th>L</th>
                                                        <th>XL</th>
                                                        <th>XXL</th>
                                                        <th>2XL</th>
                                                        <th>3XL</th>
                                                    </tr>
                                                    <tr>
                                                        <td>Collar</td>
                                                        <td>14</td>
                                                        <td>15</td>
                                                        <td>16</td>
                                                        <td>17</td>
                                                        <td>18</td>
                                                        <td>19</td>
                                                        <td>20</td>
                                                    </tr>
                                                    <tr class="bg-light-gray">
                                                        <td>Shoulder</td>
                                                        <td>16</td>
                                                        <td>17</td>
                                                        <td>18</td>
                                                        <td>19</td>
                                                        <td>20</td>
                                                        <td>21</td>
                                                        <td>22</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Chest, waist, hips</td>
                                                        <td>28-29</td>
                                                        <td>30-31</td>
                                                        <td>32-33</td>
                                                        <td>34-35</td>
                                                        <td>36-37</td>
                                                        <td>38-39</td>
                                                        <td>40-41</td>
                                                    </tr>
                                                    <tr class="bg-light-gray">
                                                        <td>Cuff</td>
                                                        <td>9</td>
                                                        <td>9.5</td>
                                                        <td>10</td>
                                                        <td>10.5</td>
                                                        <td>11</td>
                                                        <td>11.5</td>
                                                        <td>12</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Short-sleeve length</td>
                                                        <td>10</td>
                                                        <td>10.5</td>
                                                        <td>11</td>
                                                        <td>11.5</td>
                                                        <td>12</td>
                                                        <td>12.5</td>
                                                        <td>13</td>
                                                    </tr>
                                                    <tr class="bg-light-gray">
                                                        <td>Long-sleeve length</td>
                                                        <td>23</td>
                                                        <td>23.5</td>
                                                        <td>24</td>
                                                        <td>24.5</td>
                                                        <td>25</td>
                                                        <td>25.5</td>
                                                        <td>26</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Arm Hole</td>
                                                        <td>22</td>
                                                        <td>22.5</td>
                                                        <td>32</td>
                                                        <td>23.5</td>
                                                        <td>24</td>
                                                        <td>24.5</td>
                                                        <td>25</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div class="quantity margin-15px-right">
                                    <label class="screen-reader-text">Quantity</label>
                                    <input type="button" value="-" class="qty-minus qty-btn" data-quantity="minus" data-field="quantity">
                                    <input class="input-text qty-text" type="number" name="quantity" value="1">
                                    <input type="button" value="+" class="qty-plus qty-btn" data-quantity="plus" data-field="quantity">
                                </div>
                                <a href="#" class="btn btn-dark-gray btn-medium">Add to cart</a>
                                <div class="margin-25px-top">
                                    <a href="#" class="text-uppercase text-extra-small alt-font margin-20px-right font-weight-500 "><i class="feather icon-feather-heart align-middle margin-5px-right"></i>Add to wishlist</a>
                                    <!-- <a href="#" class="text-uppercase text-extra-small alt-font margin-20px-right font-weight-500 "><i class="feather icon-feather-shuffle align-middle margin-5px-right"></i>Add to compare</a> -->
                                </div>
                            </div>
                            <div class="d-flex alt-font margin-4-rem-top align-items-center">
                                <div class="flex-grow-1">
                                    <span class="text-uppercase text-extra-small font-weight-500 text-extra-dark-gray d-block">Tags: <a href="#" class="font-weight-400">T-shirt</a></span>
                                </div>
                                <div class="text-end social-icon-style-02 w-50">
                                    <ul class="extra-small-icon">
                                        <li><a class="text-extra-dark-gray facebook" href="https://www.facebook.com/" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
                                        <li><a class="text-extra-dark-gray twitter" href="http://www.twitter.com" target="_blank"><i class="fab fa-twitter"></i></a></li>
                                        <li><a class="text-extra-dark-gray linkedin" href="http://www.linkedin.com" target="_blank"><i class="fab fa-linkedin-in"></i></a></li>
                                        <li><a class="text-extra-dark-gray flickr" href="https://www.pinterest.com/" target="_blank"><i class="fab fa-pinterest-p"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- end section -->
        <!-- start section -->
        <section class="border-top border-width-1px border-color-medium-gray pt-0 wow animate__fadeIn">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 p-0 tab-style-07">
                        <ul class="nav nav-tabs justify-content-center text-center alt-font font-weight-500 text-uppercase margin-9-rem-bottom border-bottom border-color-medium-gray md-margin-50px-bottom sm-margin-35px-bottom">
                            <li class="nav-item"><a data-bs-toggle="tab" href="#description" class="nav-link active">Description</a></li>
                            <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#additionalinformation">Additional information</a></li>
                            <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#reviews">Reviews (2)</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="tab-content">
                    <!-- start tab item -->
                    <div id="description" class="tab-pane fade in active show">
                        <div class="row align-items-center">
                            <div class="col-12 col-xl-5 col-lg-6 md-margin-50px-bottom">
                                <p>Lorem ipsum is simply dummy text of the printing and typesetting industry. Lorem ipsum has been the ‘s standard dummy text. Lorem ipsum has been the industry’s standard dummy text ever since. Lorem ipsum is simply dummy text. Lorem ipsum is simply dummy text of the printing and typesetting industry.</p>
                                <ul class="list-style-03">
                                    <li>Made from soft yet durable 100% organic cotton twill</li>
                                    <li>Front and back yoke seams allow a full range of motion</li>
                                    <li>Comfortable nylon-bound elastic cuffs seal in warmth</li> 
                                    <li>Hem adjusts by pulling cord in handwarmer pockets</li> 
                                    <li>Interior storm flap and zipper garage at chin for comfort</li> 
                                </ul>
                            </div>
                            <div class="col-12 col-lg-6 offset-xl-1">
                                <img src="{{asset('public/site/images/product-image-26.jpg')}}" alt="">
                            </div>
                        </div>
                    </div>
                    <!-- end tab item -->
                    <!-- start tab item -->
                    <div id="additionalinformation" class="tab-pane fade">
                        <div class="row align-items-center">
                            <div class="col-12">
                                <table class="table-style-02">
                                    <tbody>
                                        <tr>
                                            <th class="text-extra-dark-gray font-weight-500">Color</th>
                                            <td>Black, Blue, Brown, Red, Silver</td>
                                        </tr>
                                        <tr class="bg-light-gray">
                                            <th class="text-extra-dark-gray font-weight-500">Size</th>
                                            <td>L, M, S, XL</td>
                                        </tr>
                                        <tr>
                                            <th class="text-extra-dark-gray font-weight-500">Style/Type</th>
                                            <td>Sports, Formal</td>
                                        </tr>
                                        <tr class="bg-light-gray">
                                            <th class="text-extra-dark-gray font-weight-500">Lining</th>
                                            <td>100% polyester taffeta with a DWR finish</td>
                                        </tr>
                                        <tr>
                                            <th class="text-extra-dark-gray font-weight-500">Material</th>
                                            <td>Lather, Cotton, Silk</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>                                
                        </div>
                    </div>
                    <!-- end tab item -->
                    <!-- start tab item -->
                    <div id="reviews" class="tab-pane fade">
                        <div class="row align-items-center justify-content-center">
                            <div class="col-12 col-lg-10">
                                <ul class="blog-comment margin-5-half-rem-bottom">
                                    <li>
                                        <div class="d-block d-md-flex w-100 align-items-center align-items-md-start">
                                            <div class="w-75px sm-w-50px sm-margin-10px-bottom">
                                                <img src="https://via.placeholder.com/125x125" class="rounded-circle w-95 sm-w-100" alt=""/>
                                            </div>
                                            <div class="w-100 padding-25px-left last-paragraph-no-margin sm-no-padding-left">
                                                <a href="#" class="text-extra-dark-gray text-fast-blue-hover alt-font font-weight-500 text-medium">Lorem Ipsum</a>
                                                <span class="text-orange text-extra-small float-end letter-spacing-2px"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></span>
                                                <div class="text-medium text-medium-gray margin-15px-bottom">17 July 2020, 6:05 PM</div>
                                                <p class="w-85">Lorem ipsum is simply dummy text of the printing and typesetting industry. Lorem ipsum has been the industry's standard dummy text ever since the make a type specimen book.</p>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>                            
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-12 col-lg-10 margin-4-rem-bottom ">
                                <h6 class="alt-font text-extra-dark-gray font-weight-500 margin-5px-bottom">Add a review</h6>
                                <div class="margin-5px-bottom">Your email address will not be published. Required fields are marked <span class="text-radical-red">*</span></div>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-12 col-lg-10">
                                <form action="#" method="post">
                                    <div class="row align-items-center">
                                        <div class="col-md-6 col-sm-12 col-xs-12">
                                            <label class="margin-15px-bottom" for="basic-name">Your name <span class="text-radical-red">*</span></label>
                                            <input id="basic-name" class="medium-input border-radius-4px bg-white margin-30px-bottom" type="text" name="name" placeholder="Enter your name">
                                        </div>
                                        <div class="col-md-6 col-sm-12 col-xs-12">
                                            <label class="margin-15px-bottom">Your email address <span class="text-radical-red">*</span></label>                                    
                                            <input class="medium-input border-radius-4px bg-white margin-30px-bottom" type="text" name="email" placeholder="Enter your email">
                                        </div>
                                        <div class="col-md-12 col-sm-12 col-xs-12 margin-30px-bottom">
                                            <label class="margin-15px-bottom">Your rating <span class="text-radical-red">*</span></label>                                    
                                            <span class="text-orange text-extra-small d-block"><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i></span>
                                        </div>
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <div class="margin-15px-bottom">Your comment</div>
                                            <textarea class="medium-textarea border-radius-4px bg-white h-120px margin-2-half-rem-bottom" rows="6" name="comment" placeholder="Enter your comment"></textarea>
                                        </div>
                                        <div class="col-12 sm-margin-20px-bottom">
                                            <input class="btn btn-medium btn-dark-gray mb-0 btn-round-edge-small" type="button" name="submit" value="Submit">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- end tab item -->
                </div>
            </div>
        </section>
        <!-- end section -->
        <!-- start section -->
        <section class="border-top border-width-1px border-color-medium-gray wow animate__fadeIn">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-12 col-lg-5 col-md-6 text-center margin-4-rem-bottom sm-margin-2-rem-bottom">
                        <span class="alt-font font-weight-500 text-uppercase d-inline-block margin-5px-bottom">You may also like</span>
                        <h5 class="alt-font font-weight-500 text-extra-dark-gray letter-spacing-minus-1px">Related products</h5>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <ul class="product-listing shop-wrapper grid grid-loading grid-4col xl-grid-4col lg-grid-3col md-grid-2col sm-grid-2col xs-grid-1col gutter-extra-large text-center">
                            <li class="grid-sizer"></li>
                            <!-- start shop item -->
                            <li class="grid-item">
                                <div class="product-box">
                                    <!-- start product image -->
                                    <div class="product-image border-radius-6px">
                                        <a href="#">
                                            <img class="default-image" src="{{asset('public/site/images/F2.jpg')}}" alt=""/>
                                            <img class="hover-image" src="{{asset('public/site/images/1.webp')}}" alt=""/>
                                        </a>
                                        <div class="product-overlay bg-gradient-extra-midium-gray-transparent"></div>
                                        <div class="product-hover-bottom text-center padding-30px-tb">
                                            <a href="#" class="product-link-icon move-top-bottom" data-bs-toggle="tooltip" data-placement="top" title="" data-original-title="Add to cart"><i class="feather icon-feather-shopping-cart"></i></a>
                                            <a href="#" class="product-link-icon move-top-bottom" data-bs-toggle="tooltip" data-placement="top" title="" data-original-title="Quick shop"><i class="feather icon-feather-zoom-in"></i></a>
                                            <a href="#" class="product-link-icon move-top-bottom" data-bs-toggle="tooltip" data-placement="top" title="" data-original-title="Add to wishlist"><i class="feather icon-feather-heart"></i></a>
                                        </div>
                                    </div>
                                    <!-- end product image -->
                                    <!-- start product footer -->
                                    <div class="product-footer text-center padding-25px-top xs-padding-10px-top">
                                        <a href="#" class="text-extra-dark-gray font-weight-500 d-inline-block">Merlon Jeans</a>
                                        <div class="product-price text-medium">&#8377;470</div>
                                    </div>
                                    <!-- end product footer -->
                                </div>
                            </li>
                            <!-- end shop item -->
                            <!-- start shop item -->
                            <li class="grid-item">
                                <div class="product-box">
                                    <!-- start product image -->
                                    <div class="product-image border-radius-6px">
                                        <a href="#">
                                            <img class="default-image" src="{{asset('public/site/images/F1.jpg')}}" alt=""/>
                                            <img class="hover-image" src="{{asset('public/site/images/1_1.webp')}}" alt=""/>
                                        </a>
                                        <div class="product-overlay bg-gradient-extra-midium-gray-transparent"></div>
                                        <div class="product-hover-bottom text-center padding-35px-tb">
                                            <a href="#" class="product-link-icon move-top-bottom" data-bs-toggle="tooltip" data-placement="top" title="" data-original-title="Add to cart"><i class="feather icon-feather-shopping-cart"></i></a>
                                            <a href="#" class="product-link-icon move-top-bottom" data-bs-toggle="tooltip" data-placement="top" title="" data-original-title="Quick shop"><i class="feather icon-feather-zoom-in"></i></a>
                                            <a href="#" class="product-link-icon move-top-bottom" data-bs-toggle="tooltip" data-placement="top" title="" data-original-title="Add to wishlist"><i class="feather icon-feather-heart"></i></a>
                                        </div>
                                    </div>
                                    <!-- end product image -->
                                    <!-- start product footer -->
                                    <div class="product-footer text-center padding-25px-top xs-padding-10px-top">
                                        <a href="#" class="text-extra-dark-gray font-weight-500 d-inline-block">Cotton Jacket</a>
                                        <div class="product-price text-medium">&#8377;370</div>
                                    </div>
                                    <!-- end product footer -->
                                </div>
                            </li>
                            <!-- end shop item -->
                            <!-- start shop item -->
                            <li class="grid-item">
                                <div class="product-box">
                                    <!-- start product image -->
                                    <div class="product-image border-radius-6px">
                                        <a href="#">
                                            <img class="default-image" src="{{asset('public/site/images/F3.jpg')}}" alt=""/>
                                            <img class="hover-image" src="{{asset('public/site/images/1_2.webp')}}" alt=""/>
                                            <span class="product-badge orange">hot</span>
                                        </a>
                                        <div class="product-overlay bg-gradient-extra-midium-gray-transparent"></div>
                                        <div class="product-hover-bottom text-center padding-35px-tb">
                                            <a href="#" class="product-link-icon move-top-bottom" data-bs-toggle="tooltip" data-placement="top" title="" data-original-title="Add to cart"><i class="feather icon-feather-shopping-cart"></i></a>
                                            <a href="#" class="product-link-icon move-top-bottom" data-bs-toggle="tooltip" data-placement="top" title="" data-original-title="Quick shop"><i class="feather icon-feather-zoom-in"></i></a>
                                            <a href="#" class="product-link-icon move-top-bottom" data-bs-toggle="tooltip" data-placement="top" title="" data-original-title="Add to wishlist"><i class="feather icon-feather-heart"></i></a>
                                        </div>
                                    </div>
                                    <!-- end product image -->
                                    <!-- start product footer -->
                                    <div class="product-footer text-center padding-25px-top xs-padding-10px-top">
                                        <a href="#" class="text-extra-dark-gray font-weight-500 d-inline-block">Outlaw Jacket</a>
                                        <div class="product-price text-medium">&#8377;400</div>
                                    </div>
                                    <!-- end product footer -->
                                </div>
                            </li>
                            <!-- end shop item -->
                            <!-- start shop item -->
                            <li class="grid-item">
                                <div class="product-box">
                                    <!-- start product image -->
                                    <div class="product-image border-radius-6px">
                                        <a href="#">
                                            <img class="default-image" src="{{asset('public/site/images/F4.jpg')}}" alt=""/>
                                            <img class="hover-image" src="{{asset('public/site/images/1_4.webp')}}" alt=""/>
                                            <span class="product-badge green">sale</span>
                                        </a>
                                        <div class="product-overlay bg-gradient-extra-midium-gray-transparent"></div>
                                        <div class="product-hover-bottom text-center padding-35px-tb">
                                            <a href="#" class="product-link-icon move-top-bottom" data-bs-toggle="tooltip" data-placement="top" title="" data-original-title="Add to cart"><i class="feather icon-feather-shopping-cart"></i></a>
                                            <a href="#" class="product-link-icon move-top-bottom" data-bs-toggle="tooltip" data-placement="top" title="" data-original-title="Quick shop"><i class="feather icon-feather-zoom-in"></i></a>
                                            <a href="#" class="product-link-icon move-top-bottom" data-bs-toggle="tooltip" data-placement="top" title="" data-original-title="Add to wishlist"><i class="feather icon-feather-heart"></i></a>
                                        </div>
                                    </div>
                                    <!-- end product image -->
                                    <!-- start product footer -->
                                    <div class="product-footer text-center padding-25px-top xs-padding-10px-top">
                                        <a href="single-product.html" class="text-extra-dark-gray font-weight-500 d-inline-block">Cotton Dark Shirt</a>
                                        <div class="product-price text-medium">&#8377;370</div>
                                    </div>
                                    <!-- end product footer -->
                                </div>
                            </li>
                            <!-- end shop item -->
                        </ul>
                    </div>
                </div>
            </div>
        </section>
        <!-- end section -->
@include('front.includes.footer')