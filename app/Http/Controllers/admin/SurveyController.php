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

class SurveyController extends Controller
{
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
        $data['followup_data']= $query->where('enquiry_level','=',1)->where('survey_level','=',0)->orderBy('id','DESC')->get();
        $data['moduleName'] = $this->getCurrentRouteName();
        // echo"<pre>";print_r($data['moduleName']);echo"</pre>";exit;
        $data['enquiry_status'] = DB::table('enquiry_status_remark')
                                            ->where('enquiry_level', '=',1)
                                            ->where('survey_level', '=',1)
                                            ->where('costing_level', '=',1)
                                            ->where('quote_level', '=',0)
                                            ->where('status', '!=',2)
                                            ->orderBy('id', 'DESC')
                                            ->first() ?? (object) ['status' => null];

        $data['routeMapping'] = [
            'survey.index' => 'survey.detail',
            'costing.index' => 'costing.detail',
            'quote.index' => 'quote.detail',
            'accepted-quotation.index' => 'quote.detail',
        ];
        $data['currentRoute'] = Route::currentRouteName();
        return view('admin.list_survey', $data);
    }
    public function costing_listing(Request $request)
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
                                      ->where('costing_level','=',0)
                                      ->orderBy('id','DESC')->get();
        $data['moduleName'] = $this->getCurrentRouteName();
        $data['enquiry_status'] = DB::table('enquiry_status_remark')
                                            ->where('enquiry_level', '=',1)
                                            ->where('survey_level', '=',1)
                                            ->where('costing_level', '=',1)
                                            ->where('quote_level', '=',0)
                                            ->where('status', '!=',2)
                                            ->orderBy('id', 'DESC')
                                            ->first() ?? (object) ['status' => null];

        $data['routeMapping'] = [
            'survey.index' => 'survey.detail',
            'costing.index' => 'costing.detail',
            'quote.index' => 'quote.detail',
            'accepted-quotation.index' => 'quote.detail',
        ];
        $data['currentRoute'] = Route::currentRouteName();
        return view('admin.list_survey', $data);
    }

    public function edit($id)
    {
       // echo"<pre>";print_r($id);echo"</pre>";exit;
        $followup = Followup::findOrFail($id);
        $data['sourcelead_data']= Source_lead::orderBy('id','DESC')->get();
        $data['service_data']= Service::orderBy('id','DESC')->get();
        $data['salesman_data'] = DB::table('users')->Where('id','!=', 1)->get();
        $data['country_data']= DB::table('countries')->get();
        $data['branch_data']= DB::table('branch')->get();
        $data['services_required'] = DB::table('services_required')->get();
        $data['goods_description'] = DB::table('goods_description')->get();
        $data['surveyor'] = DB::table('users')->where('role_id','=',7)->where('surveyor','1')->get();
        $data['surveyor_type'] = DB::table('surveyor_type')->get();
        $data['customer_type'] = DB::table('customer_type')->get();
        $data['title_rank'] = DB::table('title_rank')->get();
        $data['storage_type'] = DB::table('storage_type')->get();
        $data['storage_mode'] = DB::table('storage_mode')->get();
        $data['enquiry_mode'] = DB::table('enquiry_mode')->get();
        $data['duration_data'] = Duration::all();
        $data['frequency_data'] = Frequency::all();
        $data['organization_name'] = DB::table('agents')->where('is_approved',1)->get();
        $data['agent_data'] = DB::table('agents_attribute')->where('agent_id',$followup->agent_id)->get();
        $data['product_type_data'] = DB::table('product_type')->get();
        $data['salesperson_data'] = DB::table('users')->Where('role_id','=', 7)->where('surveyor','=',NULL)->get();

        //  echo"<pre>";print_r($data['followup']);echo"</pre>";exit;
        return view('admin.edit_survey',compact('followup'),$data);
    }

    public function update(Request $request, $id)
    {
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

         }

       
    }

    public function costing($id)
    {
        $data['inquiry_id'] = $id;
        $data['branch_data'] = DB::table('branch')->get();
        $data['service_data']= Service::orderBy('id','DESC')->get();
        $data['shipment_type']=  DB::table('shipment_type')->get();
        $data['services_required'] = DB::table('services_required')->get();
        $data['goods_description'] = DB::table('goods_description')->get();
        $data['followup_data'] = $followup_data = DB::table('followups')->where('id',$id)->first();
        $data['survey_data'] = DB::table('survey_assign')->where('enquiry_id', $id)->first();
        $data['costing_attribute'] = DB::table('costing_attribute')->where('enquiry_id',$id)->get();
        $data['similar_rate_data'] = DB::table('followups')
                                            ->where('id','!=',$id)
                                            ->where('enquiry_level', '=', 1)
                                            ->where('survey_level', '=', 1)
                                            ->where('costing_level', '=', 0)
                                            ->where('desti_country', '=', $followup_data->desti_country)
                                            ->where('desti_city', '=', $followup_data->desti_city)
                                            ->get();

        $data['enquiry_status'] = DB::table('enquiry_status_remark')
                                            ->where('enquiry_id', '=', $id)
                                            ->where('enquiry_level', '=',1)
                                            ->where('survey_level', '=',1)
                                            ->where('costing_level', '=',0)
                                            ->where('status', '!=',2)
                                            ->orderBy('id', 'DESC')
                                            ->first() ?? (object) ['status' => null];

        $data['code_data'] = Code::pluck('name');
        $data["action"] = "";

       /*  $data['similar_rate_data'] = DB::table('followups')
                                            ->where('id','!=',$id)
                                            ->where('enquiry_level', '=', 1)
                                            ->where('service_id', '=', $followup_data->service_id)
                                            ->where('survey_level', '=', 1)
                                            ->where('costing_level', '=', 0)
                                            ->where('desti_country', '=', $followup_data->desti_country)
                                            ->where('desti_city', '=', $followup_data->desti_city)
                                            ->get(); */

        // echo"<pre>";print_r($data['code_data']);echo"</pre>";exit;
        return view('admin.add_costing_info',$data);
    }

    public function costing_information(Request $request){
        $countOfCode = 0;
        // echo"<pre>";print_r($request->all());echo"</pre>";exit;
        $enquiry_id              = $enquiry_id = $request->enquiry_hidden_id;
        $inquiry_id              = $request->inquiry_id;
        $costing_id              = $request->costing_id;
        $enquiry_format_id       = $request->inquiry_id;
        $survey_id               = $request->survey_id;
        $data['costing_date']    = $request->costing_date;
        $data['branch']          = $request->branch;
        $data['costing_address'] = $request->costing_address;
        $data['shipment_type']   = $request->shipment_type;
        $data['value_1']         = $request->value_1;
        $data['option_1']        = $request->option_1;
        $data['value_2']         = $request->value_2;
        $data['option_2']        = $request->option_2;
        $data['vendor_rate']     = $request->vendor_rate;
        $data['description']     = $request->head_description;
        $data['prov_sum']        = $request->grand_prov_sum;
        $data['grand_total']     = $request->grand_total;
        $data['grand_total_with_vat']     = $request->newgrandtotal;
        $data['survey_vol']      = $request->survey_vol;
        $data['quote_vol']       = $request->quote_vol;
        $data['quote_weight']    = $request->quote_weight;
        $data['margin_percent']  = $request->margin;
        $data['margin_amount']   = $request->margin_amount;
        $data['selling_amount']  = $request->with_margin_amount;
        $data['total_sum']       = $request->total_sum;
        $data['prepared_by']       = $request->prepared_by;
        $data['est_time_to_complete']       = $request->est_time_to_complete;
        $data['estimated_volume']       = $request->estimated_volume;
        $data['transport_mode']       = $request->transport_mode;
        // $data['status_id'] = $request->status_id;

        //echo"<pre>";print_r($data);echo"</pre>";exit;

        if($request->action === "revise-quotation" && !empty($request->action) && $request->action != ""){
            $followup_data = Followup::findOrfail($enquiry_id);

            $reviseRequestPlus = $followup_data->revise_quotation_count += 1;

            $data['revise_quotation_count'] = $reviseRequestPlus;
            // echo "<pre>";print_r($reviseRequestPlus);echo "</pre>";exit;
        }

        if($request->status_id == 2){

                $userId = Auth::id();
                $data_status['user_id']         = $userId;
                $data_status['enquiry_id']      = $enquiry_id;
                $data_status['status']          = $request->status_id ?? 0;
                $enquiryRowdata = DB::table('followups')->where('id',$enquiry_id)->first();

                if($request->status_id == 2 && $enquiryRowdata->costing_level == 0){
                    $data_status['costing_level']   = 1;
                }

                $data_status['created_at']      = date('Y-m-d');
                DB::table('enquiry_status_remark')->insert($data_status);

                $enquiryId = sprintf('%06d', $enquiry_id);
                $currentYear = date('Y');
                $dataUpdate['quote_id']  = 'QUO-'.$currentYear.'-'.$enquiryId;
                $dataUpdate['costing_level']   = 1;
                DB::table('followups')->where('id',$enquiry_id)->update($dataUpdate);
                $isEnquiryExits = DB::table("quotation_attribute")->where('enquiry_id',$enquiry_id)->first();


                // echo"<pre>";print_r($isEnquiryExits);echo"</pre>";

                if($isEnquiryExits =="" && empty($isEnquiryExits)){
                    DB::table('quotation_attribute')->insert(['enquiry_id' => $enquiry_id]);
                }

        }else{
            $userId = Auth::id();
            $data_status['user_id']            = $userId;
            $data_status['enquiry_id']         = $enquiry_id;
            $data_status['status']             = $request->status_id ?? 0;
            $data_status['created_at']         = date('Y-m-d');
            $data_status['enquiry_level']      = 1;
            $data_status['survey_level']       = 1;
            DB::table('enquiry_status_remark')->insert($data_status);
        }

        DB::table('followups')->where('id',$enquiry_id)->update($data);
        if($request->qty !="" && !empty($request->qty)){
            if (count($request->qty) > 0 && $request->qty != '') {

                for ($i = 0; $i < count($request->qty); $i++) {

                    if($request->qty[$i] != ''){

                        $content['enquiry_id']              = $enquiry_id;
                        $content['enquiry_format_id']       = $enquiry_format_id;
                        $content['survey_id']               = $survey_id;
                        $content['costing_id']              = $costing_id;
                        $content['qty']                     = $request->qty[$i] ? : 0;
                        $content['code']                    = $request->code[$i] ? : NULL;
                        $content['description']             = $request->description[$i] ? : NULL;
                        $content['unit']                    = $request->unit[$i] ? : NULL;
                        $content['prov']                    = $request->prov[$i] ? : 0;
                        $content['egp']                     = $request->egp[$i] ? : 0;
                        $content['egp_percent']             = $request->egp_percentage[$i] ? : 0;
                        $content['selling']                 = $request->selling[$i] ? : 0;
                        $content['prov_sum']                = $request->prov_sum[$i] ? : 0;
                        $content['selling_sum']             = $request->selling_sum[$i] ? : 0;
                        $content['total']                   = $request->total[$i] ? : 0;
                        $content['egp_sum']                 = $request->egp_sum[$i] ? : 0;
                        $this->insert_attribute($content);
                    }
                }
            }
        }


        if ($request->codeu != '' && count($request->codeu) > 0  && count($request->updateid1xxx) > 0 ) {
            $countOfCode = count($request->codeu);
            for ($i = 0; $i < $countOfCode; $i++) {
                if($request->qtyu[$i] != ''){

                    $contentUpdate['enquiry_id']              = $enquiry_id;
                    $contentUpdate['enquiry_format_id']       = $enquiry_format_id;
                    $contentUpdate['survey_id']               = $survey_id;
                    $contentUpdate['costing_id']              = $costing_id;
                    $contentUpdate['updateid1xxx']            = $request->updateid1xxx[$i] ? : 0;
                    $contentUpdate['qtyu']                    = $request->qtyu[$i] ? : 0;
                    $contentUpdate['codeu']                   = $request->codeu[$i] ? : NULL;
                    $contentUpdate['descriptionu']            = $request->descriptionu[$i] ? : NULL;
                    $contentUpdate['unitu']                   = $request->unitu[$i] ? : NULL;
                    $contentUpdate['provu']                   = $request->provu[$i] ? : 0;
                    $contentUpdate['egpu']                    = $request->egpu[$i] ? : 0;
                    $contentUpdate['egp_percentageu']         = $request->egp_percentageu[$i] ? : 0;
                    $contentUpdate['sellingu']                = $request->sellingu[$i] ? : 0;
                    $contentUpdate['prov_sumu']               = $request->prov_sumu[$i] ? : 0;
                    $contentUpdate['selling_sumu']            = $request->selling_sumu[$i] ? : 0;
                    $contentUpdate['totalu']                  = $request->totalu[$i] ? : 0;
                    $contentUpdate['egp_sumu']                = $request->egp_sumu[$i] ? : 0;
                    $this->update_attribute($contentUpdate);
                }
            }
        }
        if($request->status_id == 2){
            if($request->updatefrom == "revise.accepted-quotation"){
               return redirect()->route('accepted-quotation.index')->with('success','Quotation has been updated successfully');            
            }elseif($request->updatefrom == "quotation"){
                return redirect()->route('quote.index')->with('success','Quotation has been updated successfully');
            }elseif($request->updatefrom == "costing"){
                return redirect()->route('costing.index')->with('success','Quotation has been updated successfully');
            }elseif($request->updatefrom == "job-order"){
                return redirect()->route('job-order.index')->with('success','Quotation has been updated successfully');
            }elseif($request->updatefrom == "operation"){
                return redirect()->route('operation.index')->with('success','Quotation has been updated successfully');
            }elseif($request->updatefrom == "billing-invoice"){
                return redirect()->route('billing-invoice.index')->with('success','Quotation has been updated successfully');
            }
            else{
                return redirect()->route('quote.index')->with('success','Quotation has been updated successfully');
            }
            //return redirect()->route('quote.index')->with('success','Quotation has been added successfully');
        }else{

            if($request->action === "revise-quotation" && !empty($request->action) && $request->action != ""){

                //return redirect()->route('quote.index')->with('success','Revise Quotation has been updated successfully');

                if($request->updatefrom == "revise.accepted-quotation"){
                    return redirect()->route('accepted-quotation.index')->with('success','Quotation has been updated successfully');            
                 }elseif($request->updatefrom == "quotation"){
                     return redirect()->route('quote.index')->with('success','Quotation has been updated successfully');
                 }elseif($request->updatefrom == "costing"){
                     return redirect()->route('costing.index')->with('success','Quotation has been updated successfully');
                 }elseif($request->updatefrom == "job-order"){
                    return redirect()->route('job-order.index')->with('success','Quotation has been updated successfully');
                }elseif($request->updatefrom == "operation"){
                    return redirect()->route('operation.index')->with('success','Quotation has been updated successfully');
                }elseif($request->updatefrom == "shipment"){
                    return redirect()->route('shipment.index')->with('success','Quotation has been updated successfully');
                }elseif($request->updatefrom == "billing-invoice"){
                    return redirect()->route('billing-invoice.index')->with('success','Quotation has been updated successfully');
                }
                else{
                     return redirect()->route('quote.index')->with('success','Quotation has been updated successfully');
                 }

            }else{

                return redirect()->route('costing.index')->with('success','Costing has been updated successfully');
            }

        }
    }

    function insert_attribute($content){
        // Map the incoming content to the database fields
        $data['enquiry_id']              = $content['enquiry_id'];
        $data['enquiry_format_id']       = $content['enquiry_format_id'];
        $data['survey_id']               = $content['survey_id'];
        $data['costing_id']              = $content['costing_id'];
        $data['qty']                     = $content['qty'];
        $data['code']                    = $content['code'];
        $data['description']             = $content['description'];
        $data['unit']                    = $content['unit'];
        $data['prov']                    = $content['prov'];
        $data['egp']                     = $content['egp'];
        $data['egp_percent']             = $content['egp_percent'];
        $data['selling']                 = $content['selling'];
        $data['prov_sum']                = $content['prov_sum'];
        $data['selling_sum']             = $content['selling_sum'];
        $data['total']                   = $content['total'];
        $data['egp_sum']                 = $content['egp_sum'];
        DB::table('costing_attribute')->insertGetId($data);
    }

    public function update_attribute($content)
    {
       // echo"<pre>";print_r($content);echo"</pre>";exit;
        // Map the incoming content to the database fields
        $data = [
            'enquiry_id'          => $content['enquiry_id'] ?? null,
            'enquiry_format_id'   => $content['enquiry_format_id'] ?? null,
            'survey_id'           => $content['survey_id'] ?? null,
            'costing_id'          => $content['costing_id'] ?? null,
            'qty'                 => $content['qtyu'] ?? 0,
            'code'                => $content['codeu'] ?? null,
            'description'         => $content['descriptionu'] ?? null,
            'unit'                => $content['unitu'] ?? null,
            'prov'                => $content['provu'] ?? 0,
            'egp'                 => $content['egpu'] ?? 0,
            'egp_percent'         => $content['egp_percentageu'] ?? 0,
            'selling'             => $content['sellingu'] ?? 0,
            'prov_sum'            => $content['prov_sumu'] ?? 0,
            'selling_sum'         => $content['selling_sumu'] ?? 0,
            'total'               => $content['totalu'] ?? 0,
            'egp_sum'             => $content['egp_sumu'] ?? 0,
        ];

        // Perform the update operation using the provided ID
        if (!empty($content['updateid1xxx'])) {
            DB::table('costing_attribute')
                ->where('id', $content['updateid1xxx'])
                ->update($data);
        } else {
            throw new \Exception('Missing or invalid ID for update operation');
        }
    }


    public function costing_remove(Request $request){
        // echo"<pre>";print_r($request->all());echo"</pre>";exit;
        $enquiryId = $request->enquiry_id;
        $id = $request->id;
        $updatefrom = $request->updatefrom;
        $result = DB::table('costing_attribute')->where('enquiry_id', '=',$enquiryId)->where('id', '=',$id)->delete();

        if($updatefrom == 'accepted-quotation'){
            return redirect()->route('accepted-quotation.index')->with('success','Costing Attribute has been deleted successfully');

        }elseif($updatefrom == 'costing'){
            return redirect()->route('costing.index')->with('success','Costing Attribute has been deleted successfully');
        }elseif($updatefrom == 'job-order'){
            return redirect()->route('job-order.index')->with('success','Costing Attribute has been deleted successfully');
        }elseif($updatefrom == 'operation'){
            return redirect()->route('operation.index')->with('success','Costing Attribute has been deleted successfully');
        }elseif($request->updatefrom == "shipment"){
            return redirect()->route('shipment.index')->with('success','Quotation has been updated successfully');
        }elseif($request->updatefrom == "billing-invoice"){
            return redirect()->route('billing-invoice.index')->with('success','Quotation has been updated successfully');
        }
        return redirect()->route('costing.add',$enquiryId)->with('success','Costing Attribute has been deleted successfully');
    }


    function getCurrentRouteName(){
        $moduleName = "";
        if(Route::currentRouteName() === "survey.index"){
            return "Survey";
        }else if(Route::currentRouteName() === "costing.index"){
            return "Costing";
        }
    }

    public function similar_rate(Request $request){
        try{

            $enquiry_id = $request->enquiry_id;
            $similar_rate_data = DB::table('costing_attribute')->where('enquiry_id',$enquiry_id)->get();
            $popupModal = "";
            if(count($similar_rate_data) > 0){
                foreach($similar_rate_data as $key => $value){
                    $popupModal .= '<tr>';
                    $popupModal .= '<td colspan="2">'.$value->description.'</td>';
                    $popupModal .= '<td>'.$value->prov.'</td>';
                    $popupModal .= '<td>'.$value->selling.'</td>';
                    $popupModal .= '<td>'.$value->qty.'</td>';
                    $popupModal .= '<td>'.$value->prov_sum.'</td>';
                    $popupModal .= '<td>'.$value->selling_sum.'</td>';
                    $popupModal .= '<td>'.$value->total.'</td>';
                    $popupModal .= '<td>'.$value->egp.'</td>';
                    $popupModal .= '<td>'.$value->egp_percent.'</td>';
                    $popupModal .= '</tr>';
                }

                $popupModal .= '</tr>';
                $popupModal .= '<tr class="no-hover">';
                $popupModal .= '<td colspan="10"><button class="btn btn-primary btn-sm" type="button" onclick="add_similar_data('.$value->enquiry_id.');">Add</button>
                                    <button class="btn btn-danger btn-sm" onclick="closePopupModal();" type="button">Close</button></td>
                                    </td>';
                $popupModal .= '</tr>';
            }else{
                $popupModal .= '<td colspan="12">No data found</td>';
            }


            return response()->json(['status' => 'success', 'data' => $popupModal]);

        }catch(\Exception $e){
            return response()->json(['status' => 'fail', 'data' => $e->getMessage()]);
        }

    }

    public function store_similar_rate(Request $request)
    {
        try {
            $enquiryIdFrom = $request->enquiry_id_from;
            $enquiryIdTo = $request->enquiry_id_to;

            // Fetch data
            $fetchConstingSimilarData = DB::table('costing_attribute')->where('enquiry_id', $enquiryIdFrom)->get();
            $enquiryData = Followup::where('id', $enquiryIdTo)->first();
            $enquiryUpdateData = Followup::where('id', $enquiryIdFrom)->first();
            $enquiryIdToExists = DB::table('costing_attribute')->where('enquiry_id', $enquiryIdTo)->exists();

            // Delete existing data for enquiry_id_to
            DB::table('costing_attribute')->where('enquiry_id', $enquiryIdTo)->delete();



            if ($fetchConstingSimilarData->isNotEmpty()) {
                $dataToInsert = [];

                foreach ($fetchConstingSimilarData as $item) {
                    if (!empty($item->qty)) {
                        $dataToInsert[] = [
                            'enquiry_id'        => $enquiryIdTo,
                            'enquiry_format_id' => $enquiryData->quote_no,
                            'survey_id'         => $enquiryData->survey_id,
                            'costing_id'        => $enquiryData->costing_id,
                            'qty'               => $item->qty ?: 0,
                            'code'              => $item->code ?: null,
                            'description'       => $item->description ?: null,
                            'unit'              => $item->unit ?: null,
                            'prov'              => $item->prov ?: 0,
                            'egp'               => $item->egp ?: 0,
                            'egp_percent'       => $item->egp_percent ?: 0,
                            'selling'           => $item->selling ?: 0,
                            'prov_sum'          => $item->prov_sum ?: 0,
                            'selling_sum'       => $item->selling_sum ?: 0,
                            'total'             => $item->total ?: 0,
                            'egp_sum'           => $item->egp_sum ?: 0,
                        ];
                    }
                }

                // Bulk insert data
                DB::table('costing_attribute')->insert($dataToInsert);

                $data['description']    = $enquiryUpdateData->description;
                $data['prov_sum']       = $enquiryUpdateData->prov_sum;
                $data['grand_total']    = $enquiryUpdateData->grand_total;
                $data['survey_vol']     = $enquiryUpdateData->survey_vol;
                $data['quote_vol']      = $enquiryUpdateData->quote_vol;
                $data['quote_weight']   = $enquiryUpdateData->quote_weight;
                $data['margin_percent'] = $enquiryUpdateData->margin_percent;
                $data['margin_amount']  = $enquiryUpdateData->margin_amount;
                $data['selling_amount'] = $enquiryUpdateData->selling_amount;
                $data['total_sum']      = $enquiryUpdateData->total_sum;
                Followup::where('id', $enquiryIdTo)->update($data);
            }

            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'data' => $e->getMessage()]);
        }
    }





}
