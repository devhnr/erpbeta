<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;


class Cbm_pricingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['service'] = DB::table('movingcosts')->get();

        $data['cbm'] = DB::table('cbms')->get();


       return view('admin.list_cbm_pricing',$data);   
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    function cbm_pricing_store(){


      //echo"<pre>";print_r($_POST);echo"</pre>";exit;

        $service_array = $_POST['service_id'];
        $cbm_array = $_POST['cbm_id'];
        // $total = 0;

        foreach($service_array as $service_array_data){
         // echo"<pre>";print_r($service_array_data);echo"</pre>";

            foreach($cbm_array as $cbm_array_data){
                // echo"<pre>";print_r($cbm_array_data);echo"</pre>";

                $data['service_id'] = $service_array_data;
                $data['cbm_id'] = $cbm_array_data;
                $data['cbm_value'] = $_POST['cbm_' . $service_array_data . '_' . $cbm_array_data];
               $data['markup_percentage'] = $_POST['markup_percentage'];

               $check_value =  DB::table('cbm_price')->where('service_id',$service_array_data)->where('cbm_id',$cbm_array_data)->first();

               
            //    $total += (int) $data['cbm_value'];




              

               if(isset($check_value)){
                DB::table('cbm_price')->where('id',$check_value->id)->update($data);
               }else{
                DB::table('cbm_price')->insert($data);
               }

              


                

        

                //echo"<pre>";print_r($data);echo"</pre>";
            }
            // echo"<pre>";print_r($total);echo"</pre>";exit;

        }

        return redirect()->route('cbm-pricing.index')->with('success','Price update successfully.');
        exit;
    }
}
