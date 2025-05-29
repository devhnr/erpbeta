<?php







namespace App\Http\Controllers\admin;







use App\Http\Controllers\Controller;



use Illuminate\Http\Request;



use Illuminate\Support\Facades\Auth;


use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Redirect;
use Session;







class HomeController extends Controller



{



    public function index()



    {   



        return view('admin.dashboard');



    }


    function testmail(Request $request)
    {
        $subject = "erp Test mail";
        $html = "<h1>Test mail</h1>";
        $to ="adarsh.hnrtechnologies@gmail.com";
        //$ccRecipients = ['hello@vendorscity.com','zafar@quickserverelo.com'];

         $ccRecipients = array();
        // $to = $request->email;
        Mail::send([], [], function($message) use($html, $to, $subject,$ccRecipients) {
            $message->to($to);
            $message->subject($subject);
            foreach ($ccRecipients as $ccRecipient) {
                $message->cc($ccRecipient);
            }
            $message->html($html);
        });
    }




    public function logout()



    {



        Session::flush();



        Auth::logout();



        return redirect('login');



    }



}



