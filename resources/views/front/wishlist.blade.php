@include('front.includes.header')

<!-- start page title -->
        <section class="wow animate__fadeIn bg-light-gray padding-25px-tb page-title-small">
            <div class="container">
                <div class="row align-items-center justify-content-center">
                    <div class="col-12 col-xl-8 col-lg-6">
                        <h1 class="alt-font text-extra-dark-gray font-weight-500 no-margin-bottom text-center text-lg-start">Wishlist</h1>
                    </div>
                    <div class="col-12 col-xl-4 col-lg-6 breadcrumb justify-content-center justify-content-lg-end text-small alt-font md-margin-10px-top">
                        <ul class="xs-text-center">
                            <li><a href="{{url('/')}}">Home</a></li>
                            <li><a href="{{url('product-listing')}}">Shop</a></li>
                            <li>Wishlist</li>
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
                    <div class="col-lg-12 padding-70px-right lg-padding-30px-right md-padding-15px-right">
                        <div class="row align-items-center">
                            <div class="col-12">
                                <table class="table cart-products margin-60px-bottom md-margin-40px-bottom sm-no-margin-bottom">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="alt-font"></th>
                                            <th scope="col" class="alt-font"></th>
                                            <th scope="col" class="alt-font">Product</th>
                                            <th scope="col" class="alt-font">Price</th>
                                            <th scope="col" class="alt-font">Stock Status</th>
                                            <th scope="col" class="alt-font"></th>
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
                                                In Stock
                                            </td> 
                                            <td class="product-subtotal" data-title="Total">
                                <a href="#" class="btn btn-fancy btn-small btn-transparent-light-gray">Add To Cart</a>
                                            </td> 
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
                                                In Stock
                                            </td>
                                            <td class="product-subtotal" data-title="Total">
                                <a href="#" class="btn btn-fancy btn-small btn-transparent-light-gray">Add To Cart</a>
                                            </td> 
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
                                                In Stock
                                            </td>
                                            <td class="product-subtotal" data-title="Total">
                                <a href="#" class="btn btn-fancy btn-small btn-transparent-light-gray">Add To Cart</a>
                                            </td> 
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            
                        </div>
                    </div>
                   
                </div>
            </div>
        </section>
        <!-- end section -->
        
@include('front.includes.footer')