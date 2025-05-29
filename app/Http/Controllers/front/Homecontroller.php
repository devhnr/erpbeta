<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Homecontroller extends Controller
{
    public function index(){

    	return view('front.index');
    }

    public function login(){

    	return view('front.login');
    }

    public function register(){

    	return view('front.register');
    }

    public function product_listing(){

    	return view('front.product_listing');
    }

    public function single_product(){

        return view('front.single_product');
    }

    public function cart(){

        return view('front.cart');
    }

    public function checkout(){

        return view('front.checkout');
    }

    public function lost_password(){

        return view('front.lost_password');
    }
    public function wishlist(){

        return view('front.wishlist');
    }
    public function my_profile(){

        return view('front.my_profile');
    } 
    public function my_orders(){

        return view('front.my_orders');
    }

    public function edit_profile(){

        return view('front.edit_profile');
    }

    public function edit_address(){

        return view('front.edit_address');
    } 

    public function add_address(){

        return view('front.add_address');
    }


    public function about_company(){

        return view('front.about_company');
    }

    public function our_services(){

        return view('front.our_services');
    }

    public function latest_blogs(){

        return view('front.latest_blogs');
    }

    public function contact_us(){

        return view('front.contact_us');
    }

    public function terms_conditions(){

        return view('front.terms_conditions');
    }

    public function privacy_policy(){

        return view('front.privacy_policy');
    }

    public function what_we_offer(){

        return view('front.what_we_offer');
    }

    public function return(){

        return view('front.return');
    }


    
}
