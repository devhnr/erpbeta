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
use App\Models\admin\Expense;
use Mpdf\Mpdf;

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
        $data['expense'] = Expense::orderBy('id','DESC')->get();
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
            }else{
                $data['vat_charge']  = 0;
            }

            if($request->provisional_sum != "" && $request->selling_amount != "" && $request->grand_total_new != ""){

                $followup_data = Followup::where('id',$id)->first();

                $updateFollowup['prov_sum'] = $request->provisional_sum;
                $updateFollowup['selling_amount'] = $request->selling_amount;
                $updateFollowup['grand_total'] = $request->grand_total_new;
                $updateFollowup['grand_total_with_vat'] = $request->newgrandtotal;

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

    public function invoice_generate(Request $request,$enquiry_id){

        $data['invoice_data'] = Invoice::all();
        $data['followup'] = Followup::findOrFail($enquiry_id);
        $data['enquiry_id'] = $enquiry_id;
        return view('admin.invoice-bill-selection',$data);
    }

    private function getInvoiceViewData($enquiry_id) {

        $data['invoice_data'] = $invoice_data = Invoice::where('enquiry_id', $enquiry_id)->first();
        $data['followup'] = $followup = Followup::findOrFail($enquiry_id);
        
        $agents_data = DB::table('agents')->where('id', $followup->agent_id)->where('is_approved', 1)->first();
        $agents_attribute = DB::table('agents_attribute')->where('id', $followup->agent_attr_id)->first();
        
        $data['quotation_data'] = DB::table('quotation_attribute')->where('enquiry_id', $enquiry_id)->first();
        $data['costing_attribute'] = DB::table('costing_attribute')->where('enquiry_id', $enquiry_id)->where('is_checked',1)->get();
        
        $total_amount = DB::table('costing_attribute')->where('enquiry_id', $enquiry_id)->where('is_checked',1)->sum('total') ?? 0;
        $data['totalQtyUnchecked'] = DB::table('costing_attribute')->where('enquiry_id', $enquiry_id)->sum('qty') ?? 0;
        
        $marginPercent = $followup->margin_percent ?? 0;
        $vat_charge_amount = 0;
        $totalAmount = 0;
        
        if($total_amount != 0  && $total_amount > 0){

            $totalAmount = $total_amount + ($total_amount * $marginPercent / 100);
            
            if ($invoice_data->vat_charge == 1) {
                $totalAmount += ($totalAmount * 5 / 100);
                $vat_charge_amount = ($total_amount + ($total_amount * $marginPercent / 100)) * 5 / 100;
            }
        }

        if($followup->grand_total !== 0 && $totalAmount == 0 || $vat_charge_amount == 0){
            $totalAmount = $followup->grand_total;
            $vat_charge_amount = $followup->selling_amount * 5 / 100;
        }
        
        $data['total_amount_word'] = $this->convertNumberToWords(round($totalAmount)) . " Only";
        $data['vat_amount_word'] = $this->convertNumberToWords(round($vat_charge_amount)) . " Only";
        $data['vat_charge_amount'] = $vat_charge_amount;
        
        $data['clientName'] = $agents_data->company_name ?? $followup->f_name;
        $data['contactPerson'] = $agents_attribute->name ?? '';
        
        $data['country_name'] = $data['city'] = $data['state'] = $data['destination_country'] = "";
        
        if ($followup->customer_type == 1) {

            $data['country_name'] = DB::table('countries')->where('id', $followup->c_country)->value('country') ?? "";
            $data['city'] = $followup->c_city ?? "";
            $data['destination_country'] = $data['country_name'];

        } elseif ($followup->customer_type == 2) {

            $data['country_name'] = DB::table('countries')->where('id', $agents_data->country)->value('country') ?? "";
            $data['city'] = $agents_data->city ?? "";
            $data['state'] = $agents_data->state ?? "";
        }

         $data['invoice_date'] = date('d/m/Y', strtotime($invoice_data->invoice_date));
        //$data['invoice_date'] = $invoice_data->invoice_date;
        
        return $data;
    }
    
    public function invoice_format_type(Request $request) {

        try {
            $data = $this->getInvoiceViewData($request->enquiry_id);

            if($request->formatType == 1){
                $invoiceFormatType = view('admin.invoice-bill', $data)->render();
            }

            if($request->formatType == 2){
                $invoiceFormatType = view('admin.invoice-bill-2', $data)->render();
            }
            
            return response()->json(['status' => 'success', 'data' => $invoiceFormatType]);

        } catch (\Exception $e) {

            return response()->json(['status' => 'fail', 'error' => $e->getMessage()]);
        }
    }
    
    public function invoice_bill_download(Request $request) {

        try {
            $data = $this->getInvoiceViewData($request->query('enquiry_id'));

            //echo"<pre>";print_r($data);echo "</pre>";exit;
            if($request->formatType == 1){

                //echo"in";exit;
                $invoiceFormatType = view('admin.invoice-bill', $data)->render();
                
                $pdfFileName = "Proma-Invoice.pdf";
            }

            if($request->formatType == 2){
                $invoiceFormatType = view('admin.invoice-bill-2', $data)->render();
                $pdfFileName = "TAX-Invoice.pdf";
            }
            
            $mpdf = new Mpdf();
            $mpdf->SetMargins(10, 10, 10);
            $mpdf->SetAutoPageBreak(true, 30);
            $footerImage = public_path('admin/assets/img/erp-sign.png');

           /*  $footerHtml = '<div style="margin-left:470px;font-size: 12px; font-weight: bold;">
                            For: QUICKSERVE RELOCATIONS LLC
                        </div>
                        <div style="text-align: right;">
                            <img src="' . $footerImage . '" width="150px" />
                        </div>
                        <div style="margin-left:580px;font-size: 10px;">
                            Authorised Signatory
                        </div>'; */
            
           /*  $mpdf->SetHTMLFooter($footerHtml); */
            $mpdf->WriteHTML($invoiceFormatType);

            
            
            return response()->streamDownload(function () use ($mpdf) {
                echo $mpdf->Output('', 'S');
            }, $pdfFileName, ['Content-Type' => 'application/pdf']);

        } catch (\Exception $e) {
            return back()->with('error', 'Something went wrong. Please try again later.');
        }
    }
    

    public function convertNumberToWords($number)
    {
        $hyphen = '-';
        $separator = ', ';
        $negative = 'Negative ';
        $dictionary = [
            0 => 'Zero',
            1 => 'One',
            2 => 'Two',
            3 => 'Three',
            4 => 'Four',
            5 => 'Five',
            6 => 'Six',
            7 => 'Seven',
            8 => 'Eight',
            9 => 'Nine',
            10 => 'Ten',
            11 => 'Eleven',
            12 => 'Twelve',
            13 => 'Thirteen',
            14 => 'Fourteen',
            15 => 'Fifteen',
            16 => 'Sixteen',
            17 => 'Seventeen',
            18 => 'Eighteen',
            19 => 'Nineteen',
            20 => 'Twenty',
            30 => 'Thirty',
            40 => 'Forty',
            50 => 'Fifty',
            60 => 'Sixty',
            70 => 'Seventy',
            80 => 'Eighty',
            90 => 'Ninety',
            100 => 'Hundred',
            1000 => 'Thousand',
            1000000 => 'Million',
            1000000000 => 'Billion'
        ];

        if (!is_numeric($number)) {
            return false;
        }

        if ($number < 0) {
            return $negative . $this->convertNumberToWords(abs($number));
        }

        $string = $fraction = null;

        // Split integer and decimal parts
        if (strpos((string) $number, '.') !== false) {
            list($number, $fraction) = explode('.', (string) $number);
            $fraction = (int) round($fraction * 100 / pow(10, strlen($fraction))); // Convert to fils
        }

        // Convert integer part (Dirhams)
        switch (true) {
            case $number < 21:
                $string = $dictionary[$number];
                break;
            case $number < 100:
                $tens = ((int) ($number / 10)) * 10;
                $units = $number % 10;
                $string = $dictionary[$tens];
                if ($units) {
                    $string .= ' ' . $dictionary[$units];
                }
                break;
            case $number < 1000:
                $hundreds = (int) ($number / 100);
                $remainder = $number % 100;
                $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
                if ($remainder) {
                    $string .= ' ' . $this->convertNumberToWords($remainder);
                }
                break;
            default:
                $baseUnit = pow(1000, floor(log($number, 1000)));
                $numBaseUnits = (int) ($number / $baseUnit);
                $remainder = $number % $baseUnit;
                $string = $this->convertNumberToWords($numBaseUnits) . ' ' . $dictionary[$baseUnit];
                if ($remainder) {
                    $string .= ' ' . $this->convertNumberToWords($remainder);
                }
                break;
        }

        // Handle fractional part (Fils)
        if ($fraction !== null && $fraction > 0) {
            $fractionWords = $this->convertNumberToWords($fraction);
            $string .= $fractionWords;
        }

        return $string;
    }

    public function invoice_status_update(Request $request){

        try{
            $status = $request->status_id ?? 0;
            $enquiry_id = $request->enquiry_id;

            $enquiryId = sprintf('%06d', $enquiry_id);
            $currentYear = date('Y');
            // $orderNumber  = 'IN-'.$currentYear.'-'.$enquiryId;

            if($status == 2){
                $followup = Followup::find($enquiry_id);
                $followup->billing_level = 1;
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

            if($status === 2){
                $data_status['closing_level']  = 1;
            }else{
                $data_status['closing_level']  = 0;
            }
            DB::table('enquiry_status_remark')->insert($data_status);

            if($status == 2){
                return response()->json(['status'=> 2,'success' => 'Status changed successfully']);
            }else{
                return response()->json(['status'=> 0,'success' => 'Status changed successfully']);
            }

        }
        catch(\Exception $e){
            return response()->json(['status'=> 'FAIL','error' => $e->getMessage()]);
        }
    }

    function expense_replace(Request $request){
        //echo "<pre>";print_r($request->all());echo "</pre>";exit;

        $id = $request->id;

        $expense = Expense::orderBy('id','DESC')->get();

        $html="";
        $ex= 1;
        foreach($expense as $expense_data){

            $data = DB::table('expense_inquiry')
                    ->where('inquiry_id',$id)
                    ->where('expense_id',$expense_data->id)
                    ->orderBy('id','desc')
                    ->first();

            if($data != ''){

                if($data->expense_value != ''){
                    $value = $data->expense_value;
                }else{
                    $value = "";
                }
            }else{
                $value = "";
            }

            $html.='<tr>

                            <input type="hidden" name="expense_name[]" id="expense_name_'.$expense_data->id.'" value="'.$expense_data->name.'">
                            <input type="hidden" name="expense_id[]" value="'.$expense_data->id.'">
                        <td>'.$ex.'</td>
                        <td>'.$expense_data->name.'</td>
                        <td><input type="number" 
                                        class="form-control" 
                                        id="expense_value_'.$expense_data->id.'" 
                                        name="expense_value[]" 
                                        value="'.e($value).'"
                                 /></td>
                        
                    </tr>';

            //$html.='<tr><td colspan="3"><p class="form-error-text" id="expense_value_error_'.$expense_data->id.'_'.$id.'"   style="color: red; margin-top: 10px;"></p></td></tr>';

            $ex++;
        }

        echo $html;

    }

    function expense_inquiry_form(Request $request){
        //echo"<pre>";print_r($request->all());echo "</pre>";exit;

        $inquiry_id = $request->expense_inquiry_id_follow;
        $expense_name = $request->expense_name;
        $expense_value = $request->expense_value;
        $expense_id = $request->expense_id;

        DB::table('expense_inquiry')->where('inquiry_id',$inquiry_id)->delete();
        if (isset($expense_value) > 0 && $expense_value != '') {

            for ($i = 0; $i < count($expense_value); $i++) {

                if($expense_value[$i] != ''){

                    $content['inquiry_id'] = $inquiry_id;
                    $content['expense_id'] = $expense_id[$i];
                    $content['expense_value'] = $expense_value[$i];
                    $content['expense_name'] = $expense_name[$i];
                    $this->insert_attribute($content);
                }
            }
        }

        return redirect()->route('billing-invoice.index')->with('success','Expense Inquiry Added Successfully.');
    }

    function insert_attribute($content){

        $data['inquiry_id'] = $content['inquiry_id'];
        $data['expense_id'] = $content['expense_id'];
        $data['expense_value'] = $content['expense_value'];
        $data['expense_name'] = $content['expense_name'];
        
        DB::table('expense_inquiry')->insert($data);

    }

}
