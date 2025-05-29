<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\admin\Followup;
use App\Models\admin\Source_lead;
use App\Models\admin\Service;
use App\Models\admin\Duration;
use App\Models\admin\Frequency;
use Illuminate\Support\Facades\DB;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Auth;
use App\Models\admin\Code;

class AcceptedQuotationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $startdate = $request->s_date;
        $enddate = $request->e_date;
        $salesmanname = $request->salesmanname;
        $servicename = $request->servicename;
        $user_data = Auth::user();
        $query = DB::table('followups')->where('accept_reject',0);
        if($user_data->role_id != 1 && $user_data->role_id != 7){
            $query = $query->where('salesman_id', $user_data->id);
        }

         if($user_data->role_id != 1){
            $query = $query->where('assign_to', $user_data->id);
        }
        
        // if($user_data->role_id == 7){
        //     $query = $query->where('surveyor', $user_data->id);
        // }
        // echo"<pre>";print_r($user_data->id);echo"</pre>";exit;
        if ($startdate !='')
        {
            $query = $query->where('added_date', '>=', date('Y-m-d', strtotime($startdate)));
            //$query=$query->where('created_at', $startdate);
        }
        if ($enddate !='')
        {
            $query = $query->where('added_date', '<=', date('Y-m-d', strtotime($enddate)));
            //$query=$query->where('created_at', $startdate);
        }
        $data['startdate'] =$startdate;
        $data['enddate'] =$enddate;
        if ($salesmanname !='')
        {
            $query=$query->where('salesman_id', $salesmanname);
        }
        if ($servicename !='')
        {
            $query=$query->where('service_id', $servicename);
        }
        $data['filter_salep_id'] =$salesmanname;
        $data['filter_service_id'] =$servicename;
        // $data['salesman_data'] = DB::table('users')->Where('role_id',7)->get();
        $data['salesman_data'] = DB::table('users')->Where('id','!=', 1)->get();
        $data['service_data'] = DB::table('services')->get();
        $data['followup_status'] = DB::table('followup_status')->get();
        $data['followup_data']= $query->where('enquiry_level','=',1)
                                        ->where('survey_level','=',1)
                                        ->where('costing_level','=',1)
                                        ->where('quote_level','=',1)
                                        ->where('accept_quote_level','=',0)
                                        ->where('accepted_quotation','=',1)
                                        ->orderBy('id','DESC')
                                        ->get();
        $data['moduleName'] = $this->getCurrentRouteName();
        /* $data['enquiry_status'] = DB::table('enquiry_status_remark')
                                    ->where('enquiry_level', '=',1)
                                    ->where('survey_level', '=',1)
                                    ->where('costing_level', '=',1)
                                    ->where('quote_level', '=',1)
                                    ->where('accept_quote_level', '=',0)
                                    ->where('status', '!=',2)
                                    ->orderBy('id', 'DESC')
                                    ->first() ?? (object) ['status' => null]; */

        $data['routeMapping'] = [
            'survey.index' => 'survey.detail',
            'costing.index' => 'costing.detail',
            'quote.index' => 'quote.detail',
            'accepted-quotation.index' => 'quote.detail',
        ];
        $data['currentRoute'] = Route::currentRouteName();
        return view('admin.list_survey', $data);
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
        //echo "<pre>";print_r($request->all());exit;
        $survey = Followup::find($id);
        if($request->agent_id !=''){
            $survey->agent_id     = $request->agent_id;
        }
        if($request->agent_attr_id !=''){
            $survey->agent_attr_id = $request->agent_attr_id;
        }
        $survey->quote_no= $request->quote_no;
        $survey->customer_type= $request->customer_type;
        $survey->branch= $request->branch;
        $survey->enquiry_date= date('Y-m-d', strtotime($request->enquiry_date));
        if($request->client_box != ''){
            $survey->client_box      = '0';
        }else{
            $survey->client_box      = '1';
        }
        $survey->company_name_id      = $request->company_name_id;
        $survey->company_name      = $request->company_name;
        // $followup->company_name      = $request->search_company;
        $survey->title_rank      = $request->title_rank;
        // $followup->agent_attr_data      = $request->agent_attr_data ?? "";
        // $survey->customer_name      = $request->customer_name;
        $survey->customer_phone1      = $request->customer_phone1;
        $survey->customer_phone2      = $request->customer_phone2;
        $survey->customer_email      = $request->customer_email;
        // $followup->salesman_id      = $request->salesman_id ?? "";
        $survey->address      = $request->address;
        $survey->associate      = $request->associate;
        if($request->customer_form != ''){
            $survey->customer_form      = '0';
        }else{
            $survey->customer_form      = '1';
        }
        $survey->customer_title_rank      = $request->customer_title_rank;
        $survey->f_name      = $request->f_name;
        $survey->m_name      = $request->m_name;
        $survey->l_name      = $request->l_name;
        $survey->c_mobile      = $request->c_mobile;
        $survey->c_phone      = $request->c_phone;
        $survey->c_email      = $request->c_email;
        $survey->c_add      = $request->c_add;
        $survey->c_country      = $request->c_country;
        $survey->c_city      = $request->c_city;
        if($request->origin_desti_move != ''){
            $survey->origin_desti_move      = '0';
        }else{
            $survey->origin_desti_move      = '1';
        }
        $survey->service_id      = $request->service_id;
        $survey->service_required      = $request->service_required;
       /*  $survey->service_req_val      = $request->service_req_val;*/
        $survey->desc_of_goods      = $request->desc_of_goods;
        $survey->input_goods      = $request->input_goods;
        if($request->survey_req != ''){
            $survey->survey_req      = '0';
        }else{
            $survey->survey_req      = '1';
        }
        $survey->survey_type      = $request->survey_type;
        if($request->s_date != "0000-00-00"){
            $survey->s_date      = date('Y-m-d', strtotime($request->s_date));
        }else{
            $survey->s_date      = "0000-00-00";
        }

        $survey->origin_add      = $request->origin_add;
        $survey->origin_country      = $request->origin_country;
        $survey->origin_state      = $request->origin_state;
        $survey->origin_city      = $request->origin_city;
        $survey->origin_location      = $request->origin_location;
        $survey->origin_zip_post      = $request->origin_zip_post;
        $survey->desti_add      = $request->desti_add;
        $survey->desti_country      = $request->desti_country;
        $survey->desti_state      = $request->desti_state;
        $survey->desti_city      = $request->desti_city;
        $survey->desti_location      = $request->desti_location;
        $survey->desti_zip_post      = $request->desti_zip_post;
        if($request->storage_details != ''){
            $survey->storage_details      = '0';
        }else{
            $survey->storage_details      = '1';
        }
        $survey->storage_id      = $request->storage_id;
        $survey->frequency      = $request->frequency;
        $survey->duration      = $request->duration;
        $survey->billing_mode      = $request->billing_mode;
        $survey->duration      = $request->duration;
        $survey->storage_mode      = $request->storage_mode;
        $survey->storage_product_type      = $request->storage_product_type;
        if($request->allowance_details != ''){
            $survey->allowance_details      = '0';
        }else{
            $survey->allowance_details      = '1';
        }
        $survey->road_input      = $request->road_input;
        $survey->road_cft_net      = $request->road_cft_net;
        $survey->air_input      = $request->air_input;
        $survey->air_lbs_net      = $request->air_lbs_net;
        $survey->sea_input      = $request->sea_input;
        $survey->sea_cft_net      = $request->sea_cft_net;
        $survey->rail_input      = $request->rail_input;
        $survey->rail_cft_net      = $request->rail_cft_net;
        if($request->general_info_details != ''){
            $survey->general_info_details      = '0';
        }else{
            $survey->general_info_details      = '1';
        }
        $survey->payment_by     = $request->payment_by;
        $survey->sourcelead_id  = $request->sourcelead_id;
        $survey->enquiry_mode   = $request->enquiry_mode;
        // $survey->status_id      = $request->status_id;

        // if($request->status_id == 2){
        //     $survey->completed_date  = date('Y-m-d');
        // }
        $survey->rmc            = $request->rmc;
        $survey->assign_to      = $request->assign_to;
        $survey->sales_notes    = $request->sales_notes;
        $survey->surveyor       = $request->surveyor;
        $survey->inquiry_type   = $request->inquiry_type;
        $survey->inquiry_value  = $request->inquiry_value;
        $survey->inquiry_date   = date('Y-m-d', strtotime($request->inquiry_date));
        $survey->move_type      = $request->move_type;
        $survey->move_value     = $request->move_value;
        $survey->move_date      = date('Y-m-d', strtotime($request->move_date));
        $survey->volume         = $request->volume;
        $survey->added_date     = date('Y-m-d');

        /* if($request->status_id == 2){
            $enquiryId = sprintf('%06d', $id);
            $currentYear = date('Y');
            if($request->status_id == 2){
                $survey->survey_id  = 'SUR-'.$currentYear.'-'.$enquiryId;
            }
        } */
        $survey->save();
        $segment  = $request->segment(2);
        //  echo"<pre>";print_r($segment);echo"</pre>";exit;
         if($segment == "survey"){
            return  redirect()->route('survey.index')->with('success', 'Survey has been added successfully');
         }elseif($segment == "costing"){
            return  redirect()->route('costing.index')->with('success', 'Costing has been added successfully');

         }elseif($segment == "quotation"){
            return  redirect()->route('quote.index')->with('success', 'Quotation has been added successfully');

         }
         elseif($segment == "accepted-quotation"){
            return  redirect()->route('accepted-quotation.index')->with('success', 'Quotation has been added successfully');

         }
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

    function getCurrentRouteName(){
        $moduleName = "";
        if(Route::currentRouteName() === "survey.index"){
            return "Survey";
        }else if(Route::currentRouteName() === "costing.index"){
            return "Costing";
        }else if(Route::currentRouteName() === "accepted-quotation.index"){
            return "Accepted Quotation";
        }
    }

    public function accept_status_change(Request $request){

        try{
            // echo "<pre>";print_r($request->all());exit;
            $status = $request->status_id ?? 0;
            $enquiry_id = $request->enquiry_id;

            $enquiryId = sprintf('%06d', $enquiry_id);
            $currentYear = date('Y');
            $jobOrderId  = 'JO-'.$currentYear.'-'.$enquiryId;

            if($status == 2){
                $followup = Followup::find($enquiry_id);
                $followup->job_order_id = $jobOrderId;
                $followup->accept_quote_level = 1;
                $followup->save();
            }
            $userId = Auth::id();
            $data_status['user_id']             = $userId;
            $data_status['enquiry_id']          = $enquiry_id;
            $data_status['status']              = $status;
            $data_status['created_at']          = date('Y-m-d');
            $data_status['enquiry_level']       = 1;
            $data_status['survey_level']        = 1;
            $data_status['costing_level']         = 1;
            $data_status['quote_level']         = 1;
            if($status === 2){
                $data_status['accept_quote_level']  = 1;
            }else{
                $data_status['accept_quote_level']  = 0;
            }
            DB::table('enquiry_status_remark')->insert($data_status);

            if($status == 2){
                return response()->json(['status'=> 2,'success' => 'Status changed successfully']);
            }else{
                return response()->json(['status'=> 0,'success' => 'Status changed successfully']);
            }

        }
        catch(\Exception $e){
            return response()->json(['error' => 'Something went wrong']);
        }

    }
}
