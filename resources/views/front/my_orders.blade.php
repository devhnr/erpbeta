@include('front.includes.header')

 <!-- start page title -->
        <section class="wow animate__fadeIn bg-light-gray padding-25px-tb page-title-small">
            <div class="container">
                <div class="row align-items-center justify-content-center">
                    <div class="col-12 col-xl-8 col-lg-6">
                        <h1 class="alt-font text-extra-dark-gray font-weight-500 no-margin-bottom text-center text-lg-start">My Orders</h1>
                    </div>
                    <div class="col-12 col-xl-4 col-lg-6 breadcrumb justify-content-center justify-content-lg-end text-small alt-font md-margin-10px-top">
                        <ul class="xs-text-center">
                            <li><a href="{{url('/')}}">Home</a></li>
                            <li>My Orders</li>
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
                <h4>My Orders</h4>
              </div>
                <!--NSP TITLE SECTION START-->

                 <!--MY PURCHASES SECTION START-->
              
              <div class="my_purchases_box_section">

                <!--  -->
                <div class="my_purchases_box_inner custom-back-g-white">
              
                  <div class="purchases_top_part">
                    <div class="row">
                  <div class="col-lg-3 col-6">
                    <div class="store_order_no_ship">
                      <h6>Order No.</h6>
                      <p>119070583714581000</p>
                    </div>
                  </div>
                  <div class="col-lg-2 col-6">
                    <div class="store_order_no_ship">
                      <h6>Order Placed</h6>
                      <p>Mar 03, 2021</p>
                    </div>
                  </div>
                  <div class="col-lg-2 col-6">
                    <div class="store_order_no_ship">
                      <h6>Total</h6>
                      <p>&#8377; 1,010</p>
                    </div>
                  </div>
                  <div class="col-lg-2 col-6">
                    <div class="store_order_no_ship">
                      <h6>Ship To</h6>
                      <p>Suraj Kumar</p>
                    </div>
                  </div>
                  <div class="col-lg-3 col-6">
                    <div class="track_order">
                      <a href="#">Track Order</a>
                    </div>
                  </div></div>
              </div>
              
              <div class="purchases_bottom_part">
              <div class="purchases_item_box"><div class="row">
              
                <div class="col-lg-6">
                  <div class="puchases_item_inner">
                    <ul class="purchaseul">
                      <li class="purchaseli">
                        <div class="purchase_img">
                          <img src="{{asset('public/site/images/purchase-item.jpg')}}">
                        </div>
                      </li>
                      <li class="purchaseli">
                        <div class="purchase_info">
                          <h5>Amet minim mollit</h5>
                          <span class="price">&#8377; 1694</span>
                          <div class="size_color_qty">
                            <ul>
                              <li>Size: L</li>
                              <li>Colour: Black</li>
                              <li>Qty: 1</li>
                            </ul>
                          </div>
                          <p>Ordered On: Mar 13, 2021</p>
              
                          <div class="cancel_return"><span>Cancel Item</span>
                          
                        </div>
              
                        </div>
                      </li>
                    </ul>
                  </div>
                </div>
              
                <div class="col-lg-6">
                  <div class="puchases_item_inner">
                    <ul class="purchaseul">
                      <li class="purchaseli">
                        <div class="purchase_img">
                          <img src="{{asset('public/site/images/purchase-item.jpg')}}">
                        </div>
                      </li>
                      <li class="purchaseli">
                        <div class="purchase_info">
                          <h5>Amet minim mollit</h5>
                          <span class="price">&#8377; 1694</span>
                          <div class="size_color_qty">
                            <ul>
                              <li>Size: L</li>
                              <li>Colour: Black</li>
                              <li>Qty: 1</li>
                            </ul>
                          </div>
                          <p>Ordered On: Mar 13, 2021</p>
              
                          <div class="cancel_return"><span>Return Order</span>
                          <p>Return acceptable till: Jul 22, 2020</p>
                          <p>Read our <a href="#">Return Policy</a></p>
                        </div>
              
                        </div>
                      </li>
                    </ul>
                  </div>
                </div>
              
              </div>
              </div></div>
              
              
                </div>
              <!--  -->

              <!--  -->
              <div class="my_purchases_box_inner custom-back-g-white">
              
                <div class="purchases_top_part">
                  <div class="row">
                <div class="col-lg-3 col-6">
                  <div class="store_order_no_ship">
                    <h6>Order No.</h6>
                    <p>119070583714581000</p>
                  </div>
                </div>
                <div class="col-lg-2 col-6">
                  <div class="store_order_no_ship">
                    <h6>Order Placed</h6>
                    <p>Mar 03, 2021</p>
                  </div>
                </div>
                <div class="col-lg-2 col-6">
                  <div class="store_order_no_ship">
                    <h6>Total</h6>
                    <p>&#8377; 1,010</p>
                  </div>
                </div>
                <div class="col-lg-2 col-6">
                  <div class="store_order_no_ship">
                    <h6>Ship To</h6>
                    <p>Suraj Kumar</p>
                  </div>
                </div>
                <div class="col-lg-3 col-6">
                  <div class="track_order">
                    <a href="#">Track Order</a>
                  </div>
                </div></div>
            </div>
            
            <div class="purchases_bottom_part">
            <div class="purchases_item_box"><div class="row">
            
              <div class="col-lg-6">
                <div class="puchases_item_inner">
                  <ul class="purchaseul">
                    <li class="purchaseli">
                      <div class="purchase_img">
                        <img src="{{asset('public/site/images/purchase-item.jpg')}}">
                      </div>
                    </li>
                    <li class="purchaseli">
                      <div class="purchase_info">
                        <h5>Amet minim mollit</h5>
                        <span class="price">&#8377; 1694</span>
                        <div class="size_color_qty">
                          <ul>
                            <li>Size: L</li>
                            <li>Colour: Black</li>
                            <li>Qty: 1</li>
                          </ul>
                        </div>
                        <p>Ordered On: Mar 13, 2021</p>
            
                        <div class="cancel_return"><span>Cancel Item</span>
                        
                      </div>
            
                      </div>
                    </li>
                  </ul>
                </div>
              </div>
            
              <div class="col-lg-6">
                <div class="puchases_item_inner">
                  <ul class="purchaseul">
                    <li class="purchaseli">
                      <div class="purchase_img">
                        <img src="{{asset('public/site/images/purchase-item.jpg')}}">
                      </div>
                    </li>
                    <li class="purchaseli">
                      <div class="purchase_info">
                        <h5>Amet minim mollit</h5>
                        <span class="price">&#8377; 1694</span>
                        <div class="size_color_qty">
                          <ul>
                            <li>Size: L</li>
                            <li>Colour: Black</li>
                            <li>Qty: 1</li>
                          </ul>
                        </div>
                        <p>Ordered On: Mar 13, 2021</p>
            
                        <div class="cancel_return"><span>Return Order</span>
                        <p>Return acceptable till: Jul 22, 2020</p>
                        <p>Read our <a href="#">Return Policy</a></p>
                      </div>
            
                      </div>
                    </li>
                  </ul>
                </div>
              </div>
            
            </div>
            </div></div>
            
            
              </div>
            <!--  -->
              
              
                <!-- <div class="show_older_orders">
                  <a href="#"> Show Older Orders </a>
                </div> -->
              
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