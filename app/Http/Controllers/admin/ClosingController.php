<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Route;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Image;
use PDF;
use Mail;

use App\Models\admin\Followup;
use App\Models\admin\Closingamount;
use App\Models\admin\Source_lead;
use App\Models\admin\Service;
use App\Models\admin\Duration;
use App\Models\admin\Frequency;
use App\Models\admin\Code;
use App\Models\admin\Supervisor as SupervisorAssign;
use App\Models\admin\MenPower as ManPowerAssign;
use App\Models\admin\Vehicale;
use App\Models\admin\VehicalAttribute;
use App\Models\admin\VehiclesAssignOperation;
use App\Models\admin\Materials;
use App\Models\admin\Godown;
use App\Models\admin\MaterialAttribute;
use App\Models\admin\MaterialStocks;
use App\Models\admin\QuotationPackingMaterial;
use App\Models\admin\OperationPackingMaterialReturn;
use App\Models\admin\UploadDocuments;
use App\Models\admin\CompanyAccountDetails;
use App\Models\admin\Invoice;
use Illuminate\Validation\Rule;

class ClosingController extends Controller
{
    public function index(Request $request){
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
        if ($startdate !='')
        {
            $query = $query->where('added_date', '>=', date('Y-m-d', strtotime($startdate)));
        }
        if ($enddate !='')
        {
            $query = $query->where('added_date', '<=', date('Y-m-d', strtotime($enddate)));
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
                                      ->where('costing_level', '=',1)
                                      ->where('quote_level', '=',1)
                                      ->where('accept_quote_level', '=',1)
                                      ->where('job_order_level', '=',1)
                                      ->where('operation_level', '=',1)
                                      ->where('shipment_level', '=',1)
                                      ->where('billing_level', '=',1)
                                      ->where('closing_level', '=',0)
                                      ->orderBy('id','DESC')
                                      ->get();
        
        $data['moduleName'] = $this->getCurrentRouteName();
        $data['currentRoute'] = Route::currentRouteName();

        
        return view('admin.list_closing', $data);
    }

    function getCurrentRouteName(){

        $moduleName = "";
        if(Route::currentRouteName() === "survey.index"){
            return "Survey";
        }else if(Route::currentRouteName() === "costing.index"){
            return "Costing";
        }else if(Route::currentRouteName() === "accepted-quotation.index"){
            return "Accepted Quotation";
        }else if(Route::currentRouteName() === "job-order.index"){
            return "Job Order";
        }else if(Route::currentRouteName() === "operation.index"){
            return "Operation";
        }else if(Route::currentRouteName() === "shipment.index"){
            return "Shipment";
        }else if(Route::currentRouteName() === "billing-invoice.index"){
            return "Invoice";
        }else if(Route::currentRouteName() === "closing.index"){
            return "Closing";
        }
    }

    public function closing_status_update(Request $request){

        try{

            $status = $request->status_id ?? 0;
            $enquiry_id = $request->enquiry_id;

            $enquiryId = sprintf('%06d', $enquiry_id);
            $currentYear = date('Y');
            // $orderNumber  = 'IN-'.$currentYear.'-'.$enquiryId;

            if($status == 2){
                $followup = Followup::find($enquiry_id);
                $followup->closing_level = 1;
                $followup->save();
            }
            $userId = Auth::id();
            $data_status['user_id']             = $userId;
            $data_status['enquiry_id']          = $enquiry_id;
            $data_status['status']              = $status;
            $data_status['created_at']          = date('Y-m-d');
            $data_status['enquiry_level']       = 1;
            $data_status['survey_level']        = 1;
            $data_status['costing_level']       = 1;
            $data_status['quote_level']         = 1;
            $data_status['accept_quote_level']  = 1;
            $data_status['job_order_level']     = 1;
            $data_status['operation_level']     = 1;
            $data_status['shipment_level']      = 1;
            $data_status['billing_level']       = 1;
            $data_status['closing_level']       = 1;

            if($status === 2){

                $data_status['receipt_voucher_level']  = 1;
            }else{
                
                $data_status['receipt_voucher_level']  = 0;
            }

            DB::table('enquiry_status_remark')->insert($data_status);

            if($status == 2){

                return response()->json([ 'status'=> 2, 'success' => 'Status changed successfully' ]);

            }else{

                return response()->json([ 'status'=> 0, 'success' => 'Status changed successfully' ]);
            }

        }
        catch(\Exception $e){
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    function closing_add_amount ($enquiry_id){

        $data['enquiry_id'] = $enquiry_id;

        return view('admin.add_closing_amount', $data);
        //echo $enquiry_id;exit;
    }

    function add_amount(Request $request){

       
        $rules = [
            'payment_mode' => ['required', Rule::in(['Cheque', 'Cash', 'Online'])],
            'total_amount_receive' => 'required',
        ];

        
        if ($request->payment_mode === 'Cheque') {
            $rules += [
                'cheque_bank' => 'required|string|max:255',
                'cheque_no_bank' => 'required|numeric',
                'cheque_date' => 'required|date',
                'cheque_reconciliation_date' => 'nullable|date',
                'cheque_description' => 'nullable|string',
            ];
        } elseif ($request->payment_mode === 'Cash') {
            $rules += [
                'cash_receive_by' => 'required|string|max:255',
                'cash_receive_date' => 'required|date',
                'cash_receive_description' => 'nullable|string',
            ];
        } elseif ($request->payment_mode === 'Online') {
            $rules += [
                'online_receive_by' => 'required|in:Bank,Upi',
                'online_bank' => 'required',
                'online_trn_upi_no' => 'required',
                'online_receive_date' => 'required|date',
                'online_receive_description' => 'nullable|string',
            ];
        }

       
        $request->validate($rules);


        $currentYear = date('Y');

        $lastReceiptVoucher = Closingamount::where('receipt_voucher_id', 'LIKE', 'RV-'.$currentYear.'-%')
            ->orderBy('id', 'DESC')
            ->first();

        if ($lastReceiptVoucher) {
            $lastNumber = (int) substr($lastReceiptVoucher->receipt_voucher_id, -6);
            $nextNumber = $lastNumber + 1;
        } else {
            $nextNumber = 1;
        }

        $nextReceiptVoucher = 'RV-' . $currentYear . '-' . sprintf('%06d', $nextNumber);

        $followupdata = Followup::where('id',$request->enquiry_id)->first();

        $orderTotal = $followupdata->grand_total;

        $totalReceived = Closingamount::where('enquiry_id', $request->enquiry_id)->sum('total_amount_receive');

        $newAmount = $request->total_amount_receive;

        if (($totalReceived + $newAmount) > $orderTotal) {

            return response()->json(['message' => 'GRATER']);
            //return response()->json(['error' => 'Total received amount exceeds the order total.'], 422);
        }


        $closing_amount = new Closingamount();
        $closing_amount->enquiry_id = $request->enquiry_id;
        $closing_amount->agent_id = $followupdata->agent_id;
        $closing_amount->agent_attr_id = $followupdata->agent_attr_id;
        $closing_amount->quote_no = $followupdata->quote_no;
        $closing_amount->survey_id = $followupdata->survey_id;
        $closing_amount->costing_id = $followupdata->costing_id;
        $closing_amount->quote_id = $followupdata->quote_id;
        $closing_amount->job_order_id = $followupdata->job_order_id;
        $closing_amount->order_number = $followupdata->order_number;
        $closing_amount->receipt_voucher_id = $nextReceiptVoucher;
        $closing_amount->payment_mode = $request->payment_mode;
        $closing_amount->total_amount_receive = $request->total_amount_receive;
        $closing_amount->voucher_date = date('Y-m-d', strtotime($request->voucher_date));
        $closing_amount->message_note = $request->message_note;
        //$closing_amount->created_by = Auth::user()->id;
        $closing_amount->created_at = date('Y-m-d H:i:s');
        $closing_amount->updated_at = date('Y-m-d H:i:s');
        if ($request->payment_mode === 'Cheque') {
            $closing_amount->cheque_bank = $request->cheque_bank;
            $closing_amount->cheque_no_bank = $request->cheque_no_bank;
            $closing_amount->cheque_date = date('Y-m-d', strtotime($request->cheque_date));
            $closing_amount->cheque_reconciliation_date = date('Y-m-d', strtotime($request->cheque_reconciliation_date));
            $closing_amount->cheque_description = $request->cheque_description;
        } elseif ($request->payment_mode === 'Cash') {
            $closing_amount->cash_receive_by = $request->cash_receive_by;
            $closing_amount->cash_receive_date = date('Y-m-d', strtotime($request->cash_receive_date));
            $closing_amount->cash_receive_description = $request->cash_receive_description;
        } elseif ($request->payment_mode === 'Online') {
            $closing_amount->online_receive_by = $request->online_receive_by;
            $closing_amount->online_bank = $request->online_bank;
            $closing_amount->online_trn_upi_no = $request->online_trn_upi_no;
            $closing_amount->online_receive_date = date('Y-m-d', strtotime($request->online_receive_date));
            $closing_amount->online_receive_description = $request->online_receive_description;

        }
        $closing_amount->save();

        return response()->json([
            'message' => 'TRUE',
            'redirect' => route('closing.index') // Change to your actual route
        ]);

        // return response()->json(['message' => 'TRUE']);
        return redirect()->route('closing.index')->with('error','Receipt Voucher Added Successfully');
    }

    function copyenquiry($enquiry_id){

        $data['followup'] = $followup =  Followup::where('id',$enquiry_id)->first();
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
        $data['enquiry_status'] = DB::table('enquiry_status_remark')
                                        ->where('enquiry_id', '=', $followup->id)
                                        ->where('enquiry_level', '=',0)
                                        ->where('survey_level', '=',0)
                                        ->orderBy('id', 'DESC')
                                        ->first() ?? (object) ['status' => null];

        //echo"<pre>";print_r($data);echo"</pre>";exit;
        return view('admin.copyenquiry',$data);
    }

    function insertcopyenquiry(Request $request, $id){
        //echo"<pre>";print_r($request->all());echo"</pre>";exit;
        $followup = new Followup();
        if($request->agent_id !=''){
            $data['agent_id'] = $request->agent_id;
        }
        if($request->agent_attr_id !=''){
            $data['agent_attr_id'] = $request->agent_attr_id;
        }
        //$followup->quote_no= $request->quote_no;
        $data['customer_type'] = $request->customer_type;
        $data['branch'] = $request->branch;
        $data['enquiry_date'] = date('Y-m-d', strtotime($request->enquiry_date));
        if($request->client_box != ''){
            $data['client_box']      = '0';
        }else{
            $data['client_box']      = '1';
        }
        $data['company_name_id']      = $request->company_name_id;
        $data['company_name']      = $request->company_name;
        // $followup->company_name      = $request->search_company;
        $data['title_rank']      = $request->title_rank;
        // $followup->agent_attr_data      = $request->agent_attr_data ?? "";
        // $followup->customer_name      = $request->customer_name;
        $data['customer_phone1']      = $request->customer_phone1;
        $data['customer_phone2']      = $request->customer_phone2;
        $data['customer_email']      = $request->customer_email;

        $data['contact_perosn_email']      = $request->contact_perosn_email;
        $data['contact_perosn_mobile']      = $request->contact_perosn_mobile;
        // $followup->salesman_id      = $request->salesman_id ?? "";
        $data['address']      = $request->address;
        $data['associate']      = $request->associate;
        if($request->customer_form != ''){
            $data['customer_form']      = '0';
        }else{
            $data['customer_form']      = '1';
        }
        $data['customer_title_rank']     = $request->customer_title_rank;
        $data['f_name']      = $request->f_name;
        $data['m_name']      = $request->m_name;
        $data['l_name']      = $request->l_name;
        $data['c_mobile']      = $request->c_mobile;
        $data['c_phone']      = $request->c_phone;
        $data['c_email']      = $request->c_email;
        $data['c_add']      = $request->c_add;
        $data['c_country']      = $request->c_country;
        $data['c_city']      = $request->c_city;
        if($request->origin_desti_move != ''){
            $data['origin_desti_move']      = '0';
        }else{
            $data['origin_desti_move']      = '1';
        }
        $data['service_id']      = $request->service_id;
        $data['service_required']      = $request->service_required;
       /*  $followup->service_req_val      = $request->service_req_val;*/
       $data['desc_of_goods']      = $request->desc_of_goods;
       $data['input_goods']      = $request->input_goods;
        if($request->survey_req != ''){
            $data['survey_req']       = '0';
        }else{
            $data['survey_req']       = '1';
        }
        $data['survey_type']      = $request->survey_type;
        if($request->s_date != "" && !empty($request->s_date)){
            $data['s_date']      = date('Y-m-d', strtotime($request->s_date));
        }else{
            $data['s_date'] = "0000-00-00";
        }
        // echo"<pre>";print_r($followup->s_date);echo"</pre>";exit;
        $data['origin_add']       = $request->origin_add;
        $data['origin_country']      = $request->origin_country;
        $data['origin_state']      = $request->origin_state;
        $data['origin_city']      = $request->origin_city;
        $data['origin_location']      = $request->origin_location;
        $data['origin_zip_post']      = $request->origin_zip_post;
        $data['desti_add']       = $request->desti_add;
        $data['desti_country']      = $request->desti_country;
        $data['desti_state']      = $request->desti_state;
        $data['desti_city']      = $request->desti_city;
        $data['desti_location']      = $request->desti_location;
        $data['desti_zip_post']      = $request->desti_zip_post;
        if($request->storage_details != ''){
            $data['storage_details']      = '0';
        }else{
            $data['storage_details']      = '1';
        }
        $data['storage_id']      = $request->storage_id;
        $data['frequency']      = $request->frequency;
        $data['duration']      = $request->duration;
        $data['billing_mode']      = $request->billing_mode;
        $data['duration']      = $request->duration;
        $data['storage_mode']      = $request->storage_mode;
        $data['storage_product_type']      = $request->storage_product_type;
        if($request->allowance_details != ''){
            $data['allowance_details']     = '0';
        }else{
            $data['allowance_details']     = '1';
        }
        $data['road_input']      = $request->road_input;
        $data['road_cft_net']       = $request->road_cft_net;
        $data['air_input']      = $request->air_input;
        $data['air_lbs_net']      = $request->air_lbs_net;
        $data['sea_input']      = $request->sea_input;
        $data['sea_cft_net']      = $request->sea_cft_net;
        $data['rail_input']      = $request->rail_input;
        $data['rail_cft_net']      = $request->rail_cft_net;
        if($request->general_info_details != ''){
            $data['general_info_details']      = '0';
        }else{
            $data['general_info_details']      = '1';
        }
        $data['payment_by']     = $request->payment_by;
        $data['sourcelead_id']  = $request->sourcelead_id;
        $data['enquiry_mode']   = $request->enquiry_mode;
        // $followup->status_id      = $request->status_id;
        $data['rmc']            = $request->rmc;
        $data['assign_to']      = $request->assign_to;
        $data['sales_notes']   = $request->sales_notes;
        $data['surveyor']      = $request->surveyor;
        $data['inquiry_type']   = $request->inquiry_type;
        $data['inquiry_value']  = $request->inquiry_value;
        $data['inquiry_date']   = date('Y-m-d', strtotime($request->inquiry_date));
        $data['move_type']      = $request->move_type;
        $data['move_value']      = $request->move_value;
        $data['move_date']      = date('Y-m-d', strtotime($request->move_date));
        $data['volume']         = $request->volume;
        $data['added_date']     = date('Y-m-d');

        if($request->status_id == 2){
            $data['completed_date']      = date('Y-m-d');
            $data['enquiry_level']      = 0;
        }

        $id = DB::table('followups')->insertGetId($data);
        if($id !=""){
            $enquiryId = sprintf('%06d', $id);
            $currentYear = date('Y');
            $datau['quote_no']      = 'ENQ-'.$currentYear.'-'.$enquiryId;

            $userId = Auth::id();
            $data_status['user_id']         = $userId;
            $data_status['enquiry_id']      = $id;
            $data_status['status']          = $request->status_id ?? 0;

            if($request->status_id == 2 && $request->enquiry_level == 0){
                $data_status['enquiry_level']   = 0;
            }
            $data_status['created_at']      = date('Y-m-d');
            DB::table('enquiry_status_remark')->insert($data_status);

            if($request->status_id == 2){
                // Entered Survey Module
                $enquiryId = sprintf('%06d', $id);
                $currentYear = date('Y');
                $datau['survey_id']      = 'SUR-'.$currentYear.'-'.$enquiryId;
                $datau['completed_date']  = date('Y-m-d');
                $datau['enquiry_level']   = 0;
            }
            DB::table('followups')->where('id',$id)->update($datau);
        }


        // $userId = Auth::id();
        // $data_status['user_id']         = $userId;
        // $data_status['enquiry_id']      = $id;
        // $data_status['status']          = $request->status_id ?? 0;

        // $enquiryRowdata = DB::table('followups')->where('id',$id)->first();

        // if($request->status_id == 2 && $enquiryRowdata->enquiry_level == 0){
        //     $data_status['enquiry_level']   = 1;
        // }
        // $data_status['created_at']      = date('Y-m-d');
        // DB::table('enquiry_status_remark')->insert($data_status);

        // if($request->status_id == 2){
        //     $enquiryId = sprintf('%06d', $id);
        //     $currentYear = date('Y');
        //     $followup->survey_id  = 'SUR-'.$currentYear.'-'.$enquiryId;
        //     $followup->completed_date  = date('Y-m-d');
        //     $followup->enquiry_level   = 1;
        // }
        // $followup->save();

        return  redirect()->route('followup.index')->with('success', 'Enquiry Added successfully');
        
    }
    function repeatenquiry($enquiry_id){

        $data['followup'] = $followup =  Followup::where('id',$enquiry_id)->first();
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
        $data['enquiry_status'] = DB::table('enquiry_status_remark')
                                        ->where('enquiry_id', '=', $followup->id)
                                        ->where('enquiry_level', '=',0)
                                        ->where('survey_level', '=',0)
                                        ->orderBy('id', 'DESC')
                                        ->first() ?? (object) ['status' => null];

        //echo"<pre>";print_r($data);echo"</pre>";exit;
        return view('admin.repeatenquiry',$data);
    }

    function alldetail($enquiry_id){
        //echo $enquiry_id;exit;
        $data['followup'] = $followup = Followup::where('id' , '=' , $enquiry_id)->first();
        $data['survey_assign'] = DB::table('survey_assign')->where('enquiry_id' , '=' , $enquiry_id)->first();
        $data['costing_attribute'] = DB::table('costing_attribute')->where('enquiry_id',$enquiry_id)->get();
        $data['quotation_data'] = DB::table('quotation_attribute')->where('enquiry_id',$enquiry_id)->first();
        $data['supervisor_assign_data']     = SupervisorAssign::where('enquiry_id', $enquiry_id)->get();
        $data['manpower_assign_data']       = ManPowerAssign::where('enquiry_id', $enquiry_id)->get();
        $data['VehiclesAssignOperation']    = VehiclesAssignOperation::where('enquiry_id', $enquiry_id)->get();
        $data['quotation_packing_material'] = QuotationPackingMaterial::where('enquiry_id', $enquiry_id)
                                                ->selectRaw('material_id, SUM(allocate) as total_allocate, SUM(price_cost) as total_price')
                                                ->groupBy('material_id')
                                                ->get();
        $data['uploaded_documents'] = UploadDocuments::where('enquiry_id', $enquiry_id)->get();
        $data['invoice_data'] = Invoice::where('enquiry_id', $enquiry_id)->first();
        //echo "<pre>";print_r($data['quotation_packing_material']);echo "</pre>";exit;
        return view('admin.alldetail', $data);
    }
}
