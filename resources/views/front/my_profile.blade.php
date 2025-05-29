@include('front.includes.header')

  <!-- start page title -->
        <section class="wow animate__fadeIn bg-light-gray padding-25px-tb page-title-small">
            <div class="container">
                <div class="row align-items-center justify-content-center">
                    <div class="col-12 col-xl-8 col-lg-6">
                        <h1 class="alt-font text-extra-dark-gray font-weight-500 no-margin-bottom text-center text-lg-start">My Profile</h1>
                    </div>
                    <div class="col-12 col-xl-4 col-lg-6 breadcrumb justify-content-center justify-content-lg-end text-small alt-font md-margin-10px-top">
                        <ul class="xs-text-center">
                            <li><a href="{{url('/')}}">Home</a></li>
                            <li>My Profile</li>
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
                <h4>My Profile</h4>
              </div>
                <!--NSP TITLE SECTION START-->

                 <!--MY PURCHASES SECTION START-->
              
              <div class="my_purchases_box_section">

                <div class="custom-back-g-white">

                  <div class="row">
               
                     <div class="col-lg-12 mb-20">
               
                       <div class="custom-form-text">
               
                       <h4>Profile <span class="forms-edition">
               
                         <a href="{{url('/edit-profile')}}"><i class="fa fa-pencil"></i> Edit</a></span></h4>
               
                       </div>
               
                     </div>
               
                     <div class="col-lg-4 col-md-4 col-sm-6 mb-20">
               
                       <div class="custom-form-labels">
               
                       <p class="custom-forms-label">Full Name</p>
               
                       <h6 class="custom-forms-text">pranali</h6>
               
                       </div>
               
                     </div>
               
                     <div class="col-lg-4 col-md-4 col-sm-6 mb-20">
               
                       <div class="custom-form-labels">
               
                       <p class="custom-forms-label">Gender</p>
               
                                 <h6 class="custom-forms-text">Female</h6>
                       
                       </div>
               
                     </div>
               
                     <div class="col-lg-4 col-md-4 col-sm-6 mb-20">
               
                       <div class="custom-form-labels">
               
                       <p class="custom-forms-label">Mobile Number</p>
               
                       <h6 class="custom-forms-text">9819239263</h6>
               
                       </div>
               
                     </div>
               
                     <div class="col-lg-4 col-md-4 col-sm-6 mb-20">
               
                       <div class="custom-form-labels">
               
                       <p class="custom-forms-label">Email Id</p>
               
                       <h6 class="custom-forms-text">pranali.fiveonline@gmail.com</h6>
               
                       </div>
               
                     </div>
               
                     <div class="col-lg-4 col-md-4 col-sm-6 mb-20">
               
                       <div class="custom-form-labels">
               
                       <p class="custom-forms-label">Password</p>
               
                       <h6 class="custom-forms-text">
                                     <i class="fa fa-circle" aria-hidden="true"></i>
                                     <i class="fa fa-circle" aria-hidden="true"></i>
                                     <i class="fa fa-circle" aria-hidden="true"></i>
                                     <i class="fa fa-circle" aria-hidden="true"></i>
                                     <i class="fa fa-circle" aria-hidden="true"></i>
                                     <i class="fa fa-circle" aria-hidden="true"></i>
                                     <i class="fa fa-circle" aria-hidden="true"></i>
                                     <i class="fa fa-circle" aria-hidden="true"></i>
                                     <i class="fa fa-circle" aria-hidden="true"></i>
                                     <i class="fa fa-circle" aria-hidden="true"></i>
                                     <i class="fa fa-circle" aria-hidden="true"></i>
                                     <i class="fa fa-circle" aria-hidden="true"></i>
                                   <!-- <i class="fa fa-circle" aria-hidden="true"></i>
                         <i class="fa fa-circle" aria-hidden="true"></i>
                         <i class="fa fa-circle" aria-hidden="true"></i>
                         <i class="fa fa-circle" aria-hidden="true"></i>
                         <i class="fa fa-circle" aria-hidden="true"></i> -->
                       </h6>
               
                       </div>
               
                     </div>
               
                     </div></div>
                     <!--  -->

                     <div class="custom-back-g-white">

                      <div class="row">
                   
                         <div class="col-lg-12 mb-20">
                   
                           <div class="custom-form-text">
                   
                           <h4>Delivery Address <span class="forms-edition">
                   
                             <a href="{{url('/add-address')}}"> Add New Address</a></span></h4>
                   
                           </div>
                   
                         </div>
                   
                         <div class="col-lg-6 col-md-6 mb-30">

                          <div class="custom-form-address">
              
                          <h5>Home Address <!--<span>Default</span>--></h5>
              
                          <h6>prnali murukate <br>
              
                            dfvdvdf, dfd df <br>
              
                            Mumbai - 400013</h6>
              
                          <h6>State: Maharashtra</h6>
              
                          <h6>Country: </h6>
              
                          <ul class="custom-form-address-action">
              
                              <li>
                                <a href="{{url('/edit-address')}}"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a>
                              </li>
              
                             <li>
                               <a href="#" class="remove-button desk-remove-cart-button">
                                 <i class="fa fa-trash-o" aria-hidden="true"></i> Remove
                               </a>
                             </li>
              
                          </ul>
              
                          </div>
              
                      </div>

                      <div class="col-lg-6 col-md-6 mb-30">

                        <div class="custom-form-address">
            
                        <h5>Home Address <!--<span>Default</span>--></h5>
            
                        <h6>Pranali Murukate <br>
                          lower parel, mumbai,
                          Mumbai - 400013</h6>
            
                        <h6>State: Maharashtra</h6>
            
                        <h6>Country: </h6>
            
                        <ul class="custom-form-address-action">
            
                            <li>
                              <a href="{{url('/edit-address')}}"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a>
                            </li>
            
                           <li>
                             <a href="#" class="remove-button desk-remove-cart-button">
                               <i class="fa fa-trash-o" aria-hidden="true"></i> Remove
                             </a>
                           </li>
            
                        </ul>
            
                        </div>
            
                    </div>
                         
                   
                         </div></div>
              
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