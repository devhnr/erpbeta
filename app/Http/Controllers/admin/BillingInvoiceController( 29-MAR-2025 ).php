<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Image;
use PDF;
use Mail;
use App\Models\admin\Followup;
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

class BillingInvoiceController extends Controller
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
        if($user_data->role_id == 7){
            $query = $query->where('surveyor', $user_data->id);
        }
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
                                      ->where('billing_level', '=',0)
                                      ->orderBy('id','DESC')
                                      ->get();

        $data['moduleName'] = $this->getCurrentRouteName();
        
        // echo $data['moduleName'];exit;
        /* $data['enquiry_status'] = DB::table('enquiry_status_remark')
                                            ->where('enquiry_level', '=',1)
                                            ->where('survey_level', '=',1)
                                            ->where('costing_level', '=',1)
                                            ->where('quote_level', '=',1)
                                            ->where('accept_quote_level', '=',1)
                                            ->where('job_order_level', '=',1)
                                            ->where('operation_level', '=',1)
                                            ->where('shipment_level', '=',1)
                                            ->where('billing_level', '=',0)
                                            ->where('status', '!=',2)
                                            ->orderBy('id', 'DESC')
                                            ->first() ?? (object) ['status' => null]; */
        $data['currentRoute'] = Route::currentRouteName();
        return view('admin.list_billing-invoice', $data);
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
        }
    }

    public function invoice_bill(Request $request,$enquiry_id){

        $followup                           = Followup::findOrFail($enquiry_id);
        $data['sourcelead_data']            = Source_lead::orderBy('id','DESC')->get();
        $data['service_data']               = Service::orderBy('id','DESC')->get();
        $data['salesman_data']              = DB::table('users')->Where('id','!=', 1)->get();
        $data['country_data']               = DB::table('countries')->get();
        $data['branch_data']                = DB::table('branch')->get();
        $data['services_required']          = DB::table('services_required')->get();
        $data['goods_description']          = DB::table('goods_description')->get();
        $data['surveyor']                   = DB::table('users')->where('role_id','=',7)->where('surveyor','1')->get();
        $data['surveyor_type']              = DB::table('surveyor_type')->get();
        $data['customer_type']              = DB::table('customer_type')->get();
        $data['title_rank']                 = DB::table('title_rank')->get();
        $data['storage_type']               = DB::table('storage_type')->get();
        $data['storage_mode']               = DB::table('storage_mode')->get();
        $data['enquiry_mode']               = DB::table('enquiry_mode')->get();
        $data['duration_data']              = Duration::all();
        $data['frequency_data']             = Frequency::all();
        $data['organization_name']          = DB::table('agents')->where('agent_type',1)->where('is_approved',1)->get(); // fetch only agent data and active status
        $data['agent_data']                 = DB::table('agents_attribute')->where('agent_id',$followup->agent_id)->get();
        $data['product_type_data']          = DB::table('product_type')->get();
        $data['salesperson_data']           = DB::table('users')->Where('role_id','=', 7)->get(); // Get Sales Person
        $data['quotation_data']             = $quotation_data = DB::table('quotation_attribute')->where('enquiry_id',$enquiry_id)->first();
        $data['shipment_type']              = DB::table('shipment_type')->get();
        $data['material_data']              = Materials::with('attributes')->get();
        $data['quotation_packing_material'] = QuotationPackingMaterial::where('enquiry_id', $enquiry_id)->get();

        $agentName = DB::table('agents')->where('is_approved',1)->where('id', $followup->agent_id)->first();
        $clientName = "";
        if($followup->f_name != ""){
            $data['clientName'] = $followup->f_name;
        }else{
            $data['clientName'] = $agentName->company_name;
        }
        $data['country_name'] = "";
        $data['city'] = "";
        $data['state'] = "";

        if(!empty($agentName->country)){
            $data['country_name'] = DB::table('countries')->where('id',$agentName->country)->value('country');
        }
        
        if(!empty($agentName->city)){
            $data['city'] = $agentName->city;
        }
        if(!empty($agentName->state)){
            $data['state'] = $agentName->state;
        }        

        /* Individual Customer Data */
        $data['individual_customer_name']    = $followup->f_name    ?? "";
        $data['individual_customer_email']   = $followup->c_email   ?? "";
        $data['individual_customer_mobile']  = $followup->c_mobile  ?? "";
        $data['individual_customer_phone']   = $followup->c_phone   ?? "";
        $data['individual_customer_address'] = $followup->c_add     ?? "";                                                                                                                                                             
        $data['individual_customer_country'] = $followup->c_country ?? "";
        $data['individual_customer_city']    = $followup->c_city    ?? "";

        $data['account_detail_data'] = CompanyAccountDetails::findorFail(1);
        $data['invoice_data'] = Invoice::where('enquiry_id',$followup->id)->first();
        $data['costing_attribute'] = DB::table('costing_attribute')->where('enquiry_id',$followup->id)->get();

        // echo "<pre>";print_r($data['account_detail_data']);echo "</pre>";exit;

        return view('admin.add-invoice-bill',compact('followup'),$data);
    }

    public function invoice_bill_update(Request $request,$id){

        try{
            // echo "<pre>";print_r($request->all());echo "</pre>";exit;
            $invoiceObj                     = Invoice::where('enquiry_id',$id)->first();
            // Ensure invoice date is properly formatted
            $invoiceDate                    = \DateTime::createFromFormat('d-m-Y', $request->invoice_date);
            $formattedDate                  = $invoiceDate ? $invoiceDate->format('Y-m-d') : null;


            $serviceDate                    = \DateTime::createFromFormat('d-m-Y', $request->service_date);
            $serviceFormatDate              = $serviceDate ? $serviceDate->format('Y-m-d') : null;

            $data['enquiry_id']             = $request->id;
            $data['invoice_date']           = $formattedDate;
            $data['payment_by']             = $request->payment_by;
            $data['trn_no']                 = $request->trn_no;
            $data['place_of_service']       = $request->place_of_service;

            $data['service_date']           = $serviceFormatDate;
            $data['service_code']           = $request->service_code;
            $data['ref_no']                 = $request->ref_no;
            $data['service_description']    = $request->service_description;
            $data['ship_address']           = $request->ship_address;

            if(isset($request->include_insurance) && $request->include_insurance !== ""){
                $data['is_insurance']  = 1;
            }
           
            if(isset($request->vat_charge) && $request->vat_charge !== ""){
                $data['vat_charge']  = 1;
            }

            if($request->provisional_sum != "" && $request->selling_amount != "" && $request->grand_total_new != ""){

                $followup_data = Followup::where('id',$id)->first();

                $updateFollowup['prov_sum'] = $request->provisional_sum;
                $updateFollowup['selling_amount'] = $request->selling_amount;
                $updateFollowup['grand_total'] = $request->grand_total_new;

                // if(isset($request->vat_charge) && $request->vat_charge !== "" && $invoiceObj->vat_charge == 0){

                //     // echo "VAT Charge is not included in the invoice";exit;
                    
                //     $updateFollowup['total_sum'] = $request->grand_total_new + ($request->grand_total_new * $followup_data->margin_percent / 100) * 5 / 100;

                // }else{
                    
                //     // echo "VAT Charge is included in the invoice";exit;
                //     $updateFollowup['total_sum'] = $request->grand_total_new;
                // }
                
                Followup::where('id',$id)->update($updateFollowup);
            }

            if($invoiceObj !="" && !empty($invoiceObj)){
                
                $invoiceObj->update($data);
            }else{
                Invoice::create($data);
            }

            foreach($request->updateid1xxx as $key => $value){

                if(!empty($request->selectOne[$key]) && $request->selectOne[$key] !== ""){

                    $constingAttribute = DB::table('costing_attribute')
                                            ->where('id',$value)
                                            ->where('enquiry_id',$id)
                                            ->update(['is_checked' => 1]);
                }else{

                    $constingAttribute = DB::table('costing_attribute')
                                                ->where('id',$value)
                                                ->where('enquiry_id',$id)
                                                ->update(['is_checked' => 0]);
                }
            }

            return redirect()->route('billing-invoice.index')->with('success','Invoice Bill has been updated');

        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
        
    }
}
