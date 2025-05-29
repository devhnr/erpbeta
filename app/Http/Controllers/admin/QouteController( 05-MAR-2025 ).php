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
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use Image;
// use PDF;
// use Mpdf\Mpdf;
use Mail;
use App\Models\admin\Code;
// use Mccarlosen\LaravelMpdf\Facades\LaravelMpdf;
use Mpdf\Mpdf;
class QouteController extends Controller
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
        $data['filter_salep_id']   =  $salesmanname;
        $data['filter_service_id'] = $servicename;
        // $data['salesman_data']  = DB::table('users')->Where('role_id',7)->get();
        $data['salesman_data']     = DB::table('users')->Where('id','!=', 1)->get();
        $data['service_data']      = DB::table('services')->get();
        $data['followup_status']   = DB::table('followup_status')->get();
        $data['followup_data']     = $query->where('enquiry_level','=',1)
                                            ->where('survey_level','=',1)
                                            ->where('costing_level','=',1)
                                            ->where('quote_level','=',0)
                                            ->orderBy('id','DESC')
                                            ->get();
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
    public function quotation_store($enquiry_id){
        $data['followup_data'] = $followup_data = Followup::findOrfail($enquiry_id);
        $data['services_data'] = $services_data = Service::where('id',$followup_data->service_id)->orderBy('id','DESC')->first();
        $data['branch_data'] = DB::table('branch')->get();
        $data['title_rank'] = DB::table('title_rank')->get();
        $data['organization_name'] = DB::table('agents')->where('is_approved',1)->get();
        $origin_add = $followup_data->origin_add;
        $origin_city = $followup_data->origin_city;
        if($followup_data->origin_country !=""){
            $origin_country = Helper::countryname($followup_data->origin_country);
        }else{
            $origin_country = "";
        }
        $data['originFullAddress'] = $origin_add . ', ' . $origin_city . ', ' . $origin_country;
        $desti_add = $followup_data->desti_add;
        $desti_city = $followup_data->desti_city;
        if($followup_data->desti_country != ""){
            $desti_country = Helper::countryname($followup_data->desti_country);
        }else{
            $desti_country = "";
        }
        $data['destinationFullAddress'] = $desti_add . ', ' . $desti_city . ', ' . $desti_country;
        $data['origin_and_desti']       = $origin_country .', ' . $origin_city . ' To ' . $desti_country .', ' . $desti_city;
        $data['agent_data']             = DB::table('agents_attribute')->where('agent_id',$followup_data->agent_id)->get();
        $data['service_data']           = Service::orderBy('id','DESC')->get();
        $data['shipment_type']          =  DB::table('shipment_type')->get();
        $data['salesperson_data']       = DB::table('users')->Where('role_id','=', 7)->get();
        $data['costing_attribute']      = DB::table('costing_attribute')->where('enquiry_id',$enquiry_id)->get();
        $data['quotation_data']         = DB::table('quotation_attribute')->where('enquiry_id',$enquiry_id)->first();
        $data['enquiry_status']         = DB::table('enquiry_status_remark')
                                                ->where('enquiry_id', '=', $enquiry_id)
                                                ->where('enquiry_level', '=',1)
                                                ->where('survey_level', '=',1)
                                                ->where('costing_level', '=',1)
                                                ->where('quote_level', '=',0)
                                                ->where('status', '!=',2)
                                                ->orderBy('id', 'DESC')
                                                ->first() ?? (object) ['status' => null];
        $data['footer_content']         = $this->footerContent($enquiry_id);
        $data['body_mail_content']      = $this->bodyMailContent($enquiry_id);
        return view('admin.add_quotation', $data);
    }
    public function footerContent($enquiry_id){
        $htmlContent = "";
        $followup_data = Followup::findOrfail($enquiry_id);
        $data['services_data'] = $services_data = Service::where('id',$followup_data->service_id)->orderBy('id','DESC')->first();
        $htmlContent = '<div class="incl" style="font-size: 20px;">
                            <span><b>Price Includes:</b></span>
                        </div>
                        <div class="incl2" style="font-size: 16px;">
                            ' . (isset($services_data->price_include) && !empty($services_data->price_include) ? html_entity_decode($services_data->price_include) : '') . '
                        </div>';
                        if (isset($services_data->price_exclude) && !empty($services_data->price_exclude)) {
                            $htmlContent .= '<br/>
                            <div class="col-sm-12" style="margin: 10px 0;">
                                <div class="incl" style="font-size: 20px;">
                                    <p><b>Price Excludes:</b></p>
                                </div>
                                <div class="incl2" style="font-size: 16px; ">
                                    ' . html_entity_decode($services_data->price_exclude) . '
                                </div>
                            </div>';
                        }
                        if (isset($services_data->insurances) && !empty($services_data->insurances)) {
                            $htmlContent .= '<br/>
                            <div class="col-sm-12" style="margin: 10px 0;">
                                <div class="incl" style="font-size: 20px;">
                                    <p><b>Insurance:</b></p>
                                </div>
                                <div class="incl2" style="font-size: 16px; ">
                                    ' . html_entity_decode($services_data->insurances) . '
                                </div>
                            </div>';
                        }
                        if (isset($services_data->price_note) && !empty($services_data->price_note)) {
                            $htmlContent .= '<br/>
                            <div class="col-sm-12" style="margin: 10px 0;">
                                <div class="incl" style="font-size: 20px;">
                                    <p><b>Note:</b></p>
                                </div>
                                <div class="incl2" style="font-size: 16px; ">
                                    ' . html_entity_decode($services_data->price_note) . '
                                </div>
                            </div>';
                        }
                        if (isset($services_data->payment_terms) && !empty($services_data->payment_terms)) {
                            $htmlContent .= '<br/>
                            <div class="col-sm-12" style="margin: 10px 0;">
                                <div class="incl" style="font-size: 20px;">
                                    <p><b>Payment Terms:</b></p>
                                </div>
                                <div class="incl2" style="font-size: 16px; ">
                                    ' . html_entity_decode($services_data->payment_terms) . '
                                </div>
                            </div>';
                        }
                        if (isset($services_data->payment_options) && !empty($services_data->payment_options)) {
                            $htmlContent .= '<br/>
                            <div class="col-sm-12" style="margin: 10px 0;">
                                <div class="incl" style="font-size: 20px;">
                                    <p><b>Payment Options:</b></p>
                                </div>
                                <div class="incl2" style="font-size: 16px; ">
                                    ' . html_entity_decode(preg_replace('/\{[^}]*\}/', $services_data->validity, $services_data->payment_options)) . '
                                </div>
                            </div>';
                        }
                        /*  $htmlContent .= '<div class="col-sm-12" style="margin: 10px 0;">
                                            <div style="font-size: 20px; text-align: center;">
                                                <p><b>The validity of the quotation is ' . $services_data->validity . ' Days.</b></p>
                                            </div>
                                        </div>'; */
        return $htmlContent;
    }

    public function bodyMailContent($enquiry_id){
        $htmlContent = "";
        $followup_data = Followup::findOrfail($enquiry_id);
        $agents_data = DB::table('agents')->where('id',$followup_data->agent_id)->where('is_approved',1)->first();
        $bodyMailContent = "";
        $customerName = "";
        if($followup_data->agent_id !== null && $followup_data->agent_id !== ""){
            $customerName = $agents_data->company_name;
        }else{
            $customerName = $followup_data->f_name;
        }
        $bodyMailContent = ' <p>Dear '.$customerName.',</p>
                        <p>I would like to thank you for the opportunity to bid on the upcoming relocation.</p>
                        <p>Please find attached our rate for the requested services.</p>
                        <p>If you need any other information regarding our services, please feel free to contact us.</p>
                        <p>Rest assured you will receive top-quality service &amp; prompt attention.</p>
                        <p>I hope that you will find our rates competitive &amp; favour us with your valued order.</p>
                        <p>Looking forward to your confirmation.</p>';
        return $bodyMailContent;
    }
    function getCurrentRouteName(){
        $moduleName = "";
        if(Route::currentRouteName() === "survey.index"){
            return "Survey";
        }else if(Route::currentRouteName() === "costing.index"){
            return "Costing";
        }else if(Route::currentRouteName() === "quote.index"){
            return "Quotation";
        }
    }
    public function upload(Request $request): JsonResponse
    {
        if ($request->hasFile('upload')) {
            $originName = $request->file('upload')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('upload')->getClientOriginalExtension();
            $fileName = $fileName . '_' . time() . '.' . $extension;
            $request->file('upload')->move(public_path('media'), $fileName);
            $url = asset('public/media/' . $fileName);
            return response()->json(['fileName' => $fileName, 'uploaded'=> 1, 'url' => $url]);
        }
    }
    public function qoutation_store(Request $request){

        if($request->action == "add-qoutation"){

            // echo "<pre>";print_r($request->all());echo "</pre>";exit;
            $enquiry_id                         = $request->enquiry_hidden_id;
            $dataUpdate['service_id']           = $request->service_id;
            $dataUpdate['shipment_type']        = $request->shipment_type;
            $dataUpdate['assign_to']            = $request->assign_to;
            $dataUpdate['grand_total']          = $request->grand_total;
            // $dataUpdate['status_id']         = $request->status_id;
            $dataUpdate['mail_to_customer']           = $request->mail_to_customer;
            DB::table('followups')->where('id',$enquiry_id)->update($dataUpdate);
            $data['enquiry_id']                 = $enquiry_id;
            $data['quotation_date']             = date("Y-m-d",strtotime($request->quotation_date));
            $data['payment_by']                 = $request->payment_by;
            $data['quote_customer_address']     = $request->quote_customer_address;
            if(isset($request->include_insurance) && !empty($request->include_insurance) && $request->include_insurance !=""){
                $data['include_insurance']      = $request->include_insurance;
            }else{
                $data['include_insurance']      = NULL;
            }
            if(isset($request->vat_charge) && !empty($request->vat_charge) && $request->vat_charge !=""){
                $data['vat_charge']             = $request->vat_charge;
            }else{
                $data['vat_charge']             = NULL;
            }
            $data['shipping_detail_box']        = $request->shipping_detail_box;
            $data['packing_move_date']          = $request->packing_move_date;
            $data['pack_date_to']               = $request->pack_date_to;
            $data['load_date']                  = $request->load_date;
            $data['est_delivery_dt']            = $request->est_delivery_dt;
            $data['shipping_eta']               = $request->shipping_eta;
            $data['shipping_etd']               = $request->shipping_etd;
            $data['shipping_pol']               = $request->shipping_pol;
            $data['shipping_pod']               = $request->shipping_pod;
            $data['shipping_mbl']               = $request->shipping_mbl;
            $data['shipping_hbl']               = $request->shipping_hbl;
            $data['shipping_vessel_name']       = $request->shipping_vessel_name;
            $data['shipping_vessel_no']         = $request->shipping_vessel_no;
            $data['shipping_vessel_schedule']   = $request->shipping_vessel_schedule;
            $data['shipping_route']             = $request->shipping_route;
            $data['shipping_scope_work']        = $request->shipping_scope_work;
            $data['shipping_freight_term']      = $request->shipping_freight_term;
            $data['shipping_place_of_accept']   = $request->shipping_place_of_accept;
            $data['shipping_date_of_accept']    = $request->shipping_date_of_accept;
            $data['shipping_place_of_delivery'] = $request->shipping_place_of_delivery;
            $data['shipping_board_date']        = $request->shipping_board_date;
            $data['shipping_place_of_receipt']  = $request->shipping_place_of_receipt;
            $data['shipping_date_of_delivery']  = $request->shipping_date_of_delivery;
            $data['shipping_collection_from']   = $request->shipping_collection_from;
            $data['shipping_destination_city']  = $request->shipping_destination_city;
            $data['shipping_detention_free_time'] = $request->shipping_detention_free_time;
            $data['shipping_delivery_to']       = $request->shipping_delivery_to;
            $data['terms_condition_box']        = $request->terms_condition_box;
            $data['cover_letter_desc']          = $request->cover_letter_desc;       // ckEditor
            $data['term_condition_desc']        = $request->term_condition_desc;     // ckEditor
            $data['footer_desc']                = $request->footer_desc;             // ckEditor
            $data['body_mail']                  = $request->body_mail;             // ckEditor
            $data['general_info_box']           = $request->general_info_box;             // ckEditor
            /*  $data['artical_list']            = $request->artical_list;
            $data['show_option']                = $request->show_option;*/
            $data['sales_note']                 = $request->sales_note;
            $userId = Auth::id();
            $data_status['user_id']            = $userId;
            $data_status['enquiry_id']         = $enquiry_id;
            $data_status['status']             = $request->status_id ?? 0;
            $data_status['created_at']         = date('Y-m-d');
            $data_status['enquiry_level']      = 1;
            $data_status['survey_level']       = 1;
            $data_status['costing_level']       = 1;
            DB::table('enquiry_status_remark')->insert($data_status);
            $isEnquiryExits = DB::table("quotation_attribute")->where('enquiry_id',$enquiry_id)->first();

            if ($request->descriptionu != '' && count($request->descriptionu) > 0  && count($request->updateid1xxx) > 0 ) {
                $countOfDesc = count($request->descriptionu);
                for ($i = 0; $i < $countOfDesc; $i++) {
                    if($request->descriptionu[$i] != ''){

                        $contentUpdate['enquiry_id']              = $enquiry_id;
                        $contentUpdate['updateid1xxx']            = $request->updateid1xxx[$i] ? : 0;
                        $contentUpdate['descriptionu']            = $request->descriptionu[$i] ? : NULL;
                        $this->update_attribute($contentUpdate);
                    }
                }
            }
            if($isEnquiryExits !="" && !empty($isEnquiryExits)){
                DB::table('quotation_attribute')->where('enquiry_id',$enquiry_id)->update($data);
                return redirect()->route('quote.index')->with('success','Quotation has been updated successfully');
            }else{
                DB::table('quotation_attribute')->insert($data);
                return redirect()->route('quote.index')->with('success','Quotation has been Added successfully');
            }
            // echo "<pre>";print_r($isEnquiryExits);echo "</pre>";exit;
        }
    }

    public function update_attribute($content)
    {
        $data = [
            'enquiry_id'          => $content['enquiry_id'] ?? null,
            'description'         => $content['descriptionu'] ?? null
        ];

        // Perform the update operation using the provided ID
        if (!empty($content['updateid1xxx'])) {
            DB::table('costing_attribute')->where('id', $content['updateid1xxx'])->update($data);
        } else {
            throw new \Exception('Missing or invalid ID for update operation');
        }
    }
    public function customer_mail($enquiry_id){
        $data['enquiry_id'] = $enquiry_id;
        $data['followup_data'] = $followup_data = Followup::findOrfail($enquiry_id);
        $data['cc_email_data'] = DB::table('cc_emails')->get();
        return view("admin.customer-mail-format",$data);
    }
    public function mail_format_type(Request $request){
        $formatType = $request->formatType;
        $enquiry_id = $request->enquiry_id;
        $followup_data = Followup::findOrfail($enquiry_id);
        $mailSubject = $followup_data->description . ' ( '.$followup_data->quote_id.' )' ?? "";
        $mailFormatType1 = "";
        $mailFormatType2 = "";
        $mailFormatType3 = "";
        $acceptQuoteStyle = "display: none;";
        if($formatType == 1){
            $mailFormatType1 .= $this->quoteEmailFormat1($enquiry_id,$acceptQuoteStyle);
            return response()->json(['status' => 'success', 'data' => $mailFormatType1, 'subject' => $mailSubject]);
        }
        if($formatType == 2){
            $mailFormatType2 .= $this->quoteEmailFormat2($enquiry_id,$acceptQuoteStyle);
            return response()->json(['status' => 'success', 'data' => $mailFormatType2, 'subject' => $mailSubject]);
        }
        if($formatType == 3){
            $mailFormatType3 .= $this->quoteEmailFormat3($enquiry_id,$acceptQuoteStyle);
            return response()->json(['status' => 'success', 'data' => $mailFormatType3, 'subject' => $mailSubject]);
        }
    }
    public function quoteEmailFormat1($enquiry_id, $acceptQuoteStyle){

        $clientName = "";
        $data['contactPerson'] = "";
        $data['followup_data'] = $followup_data = Followup::findOrfail($enquiry_id);
        $agents_data = DB::table('agents')->where('id',$followup_data->agent_id)->where('is_approved',1)->first();
        // echo "<pre>";print_r($agents_data);echo "</pre>";exit;
        $agents_attribute = DB::table('agents_attribute')->where('id',$followup_data->agent_attr_id)->first();
        $data['quotation_data'] = $quotation_data = DB::table('quotation_attribute')->where('enquiry_id',$enquiry_id)->first();
        $data['costing_attribute'] = DB::table('costing_attribute')->where('enquiry_id',$enquiry_id)->get();
        if($agents_data !="" && !empty($agents_data)){
            $data['clientName'] = $agents_data->company_name;
        }else if($followup_data->f_name !="" && !empty($followup_data->f_name)){
            $data['clientName'] = $followup_data->f_name;
        }
        if($agents_attribute !="" && !empty($agents_attribute)){
            $data['contactPerson'] = $agents_attribute->name;
        }
        $data['surveyor'] = DB::table('users')
                                    ->where('id', $followup_data->surveyor)
                                    ->where('role_id', '=', 7)
                                    ->where('surveyor', '1')
                                    ->value('name');

        $description = DB::table('goods_description')->where('id', $followup_data->desc_of_goods)->first();
        $data['description_goods'] = $description->name ?? "";

        $servicesRequired = DB::table('services_required')->where('id', $followup_data->service_required)->first();
        $data['services_required'] = $servicesRequired->name ?? "";

        $service_data = Service::orderBy('id','DESC')->where('id', $followup_data->service_id)->first();
        $data['service_data'] = $service_data->name ?? "";

        $origin_add = $followup_data->origin_add;
        $origin_city = $followup_data->origin_city;
        if($followup_data->origin_country !=""){
            $origin_country = Helper::countryname($followup_data->origin_country);
        }else{
            $origin_country = "";
        }
        $data['originFullAddress'] = $origin_add . ', ' . $origin_city . ', ' . $origin_country;
        $desti_add = $followup_data->desti_add;
        $desti_city = $followup_data->desti_city;
        if($followup_data->desti_country !=""){
            $desti_country = Helper::countryname($followup_data->desti_country);
        }else{
            $desti_country = "";
        }
        $data['destinationFullAddress'] = $desti_add . ', ' . $desti_city . ', ' . $desti_country;
        $data['acceptQuoteStyle'] = $acceptQuoteStyle;
        // echo "<pre>";print_r($followup_data);echo "</pre>";exit;
        return view('admin.get_quote_pdf',$data)->render();
    }

    public function quoteEmailFormat2($enquiry_id, $acceptQuoteStyle){
        $clientName = "";
        $clientPhoneNo = "";
        $clientEmail = "";
        $data['contactPerson'] = "";
        $data['followup_data'] = $followup_data = Followup::findOrfail($enquiry_id);
        $agents_data = DB::table('agents')->where('id',$followup_data->agent_id)->where('is_approved',1)->first();
        $agents_attribute = DB::table('agents_attribute')->where('id',$followup_data->agent_attr_id)->first();
        $data['quotation_data'] = $quotation_data = DB::table('quotation_attribute')->where('enquiry_id',$enquiry_id)->first();
        // echo "<pre>";print_r($quotation_data);echo "</pre>";exit;
        $data['costing_attribute'] = DB::table('costing_attribute')->where('enquiry_id',$enquiry_id)->get();
        if($agents_data !="" && !empty($agents_data)){
            $data['clientName'] = $agents_data->company_name;
        }else if($followup_data->f_name !="" && !empty($followup_data->f_name)){
            $data['clientName'] = $followup_data->f_name;
        }
        if (
            (isset($followup_data->customer_phone2) && !empty($followup_data->customer_phone2)) ||
            (isset($followup_data->customer_phone1) && !empty($followup_data->customer_phone1))
        ) {
            $data['clientPhoneNo'] = !empty($followup_data->customer_phone1) ? $followup_data->customer_phone1 :                            $followup_data->customer_phone2;
        }else{
            $data['clientPhoneNo'] = "";
        }

        if (
            (isset($followup_data->c_mobile) && !empty($followup_data->c_mobile)) ||
            (isset($followup_data->c_phone) && !empty($followup_data->c_phone))
        ) {
            $data['customerPhoneNo'] = !empty($followup_data->c_mobile) ? $followup_data->c_mobile : $followup_data->c_phone;
        }else{
            $data['customerPhoneNo'] = "";
        }

        if (
            (isset($followup_data->customer_email) && !empty($followup_data->customer_email)) ||
            (isset($followup_data->c_email) && !empty($followup_data->c_email))
        ) {
            $data['clientEmail'] = !empty($followup_data->customer_email) ? $followup_data->customer_email : $followup_data->c_email;
        } else {
            $data['clientEmail'] = "";
        }

        $data['customerEmail'] = (isset($followup_data->c_email) && !empty($followup_data->c_email)) ? $followup_data->c_email : "";

        if($agents_attribute !="" && !empty($agents_attribute)){
            $data['contactPerson'] = $agents_attribute->name;
        }
        $grand_total = $followup_data->grand_total ?? "";
        if($grand_total !="" && !empty($grand_total)){
            $data['grand_total'] = $this->convertNumberToWords($grand_total) . " Only";
        }else{
            $data['grand_total'] = "";
        }
        $data['surveyor'] = DB::table('users')
                            ->where('id', $followup_data->surveyor)
                            ->where('role_id', '=', 7)
                            ->where('surveyor', '1')
                            ->value('name');
        $description = DB::table('goods_description')->where('id', $followup_data->desc_of_goods)->first();
        $data['description_goods'] = $description->name ?? "";
        $servicesRequired = DB::table('services_required')->where('id', $followup_data->service_required)->first();
        $data['services_required'] = $servicesRequired->name ?? "";
        $service_data = Service::orderBy('id','DESC')->where('id', $followup_data->service_id)->first();
        $data['service_data'] = $service_data->name ?? "";
        $origin_add = $followup_data->origin_add;
        $origin_city = $followup_data->origin_city;
        if($followup_data->origin_country !=""){
            $origin_country = Helper::countryname($followup_data->origin_country);
        }else{
            $origin_country = "";
        }
        $data['originFullAddress'] = $origin_add . ', ' . $origin_city . ', ' . $origin_country;
        $desti_add = $followup_data->desti_add;
        $desti_city = $followup_data->desti_city;
        if($followup_data->desti_country !=""){
            $desti_country = Helper::countryname($followup_data->desti_country);
        }else{
            $desti_country = "";
        }
        $data['destinationFullAddress'] = $desti_add . ', ' . $desti_city . ', ' . $desti_country;
        $data['acceptQuoteStyle'] = $acceptQuoteStyle;
        return view('admin.get-quote-format-2',$data)->render();
    }
    public function quoteEmailFormat3($enquiry_id, $acceptQuoteStyle){
        $clientName = "";
        $clientPhoneNo = "";
        $clientEmail = "";
        $data['clientPhoneNo']   = "";
        $data['customerPhoneNo'] = "";
        $data['clientEmail']     = "";
        $data['customerEmail']   = "";
        $data['contactPerson']   = "";
        $data['followup_data']   = $followup_data = Followup::findOrfail($enquiry_id);
        $agents_data = DB::table('agents')->where('id',$followup_data->agent_id)->where('is_approved',1)->first();
        $data['quotation_data'] = $quotation_data = DB::table('quotation_attribute')->where('enquiry_id',$enquiry_id)->first();
        $agents_attribute = DB::table('agents_attribute')->where('id',$followup_data->agent_attr_id)->first();
        // echo "<pre>";print_r($quotation_data);echo "</pre>";exit;
        $data['costing_attribute'] = DB::table('costing_attribute')->where('enquiry_id',$enquiry_id)->get();
        if (!empty($agents_data) && !empty($agents_data->company_name)) {
            $data['clientName'] = $agents_data->company_name;
        } else {
            $data['clientName'] = $followup_data->f_name;
        }
        // Check for client phone number
        if (isset($followup_data->customer_phone1) && !empty($followup_data->customer_phone1)) {
            $data['clientPhoneNo'] = $followup_data->customer_phone1;
        } elseif (isset($followup_data->customer_phone2) && !empty($followup_data->customer_phone2)) {
            $data['clientPhoneNo'] = $followup_data->customer_phone2;
        }

        // Check for customer phone number
        if (isset($followup_data->c_mobile) && !empty($followup_data->c_mobile)) {
            $data['customerPhoneNo'] = $followup_data->c_mobile;
        } elseif (isset($followup_data->c_phone) && !empty($followup_data->c_phone)) {
            $data['customerPhoneNo'] = $followup_data->c_phone;
        }
        if (isset($followup_data->customer_email) && !empty($followup_data->customer_email)) {
            $data['clientEmail'] = $followup_data->customer_email;
        }

        if (isset($followup_data->c_email) && !empty($followup_data->c_email)) {
            $data['customerEmail'] = $followup_data->c_email;
        }

        if($agents_attribute !="" && !empty($agents_attribute)){
            $data['contactPerson'] = $agents_attribute->name;
        }
        $grand_total = $followup_data->grand_total ?? "";
        if($grand_total !="" && !empty($grand_total)){
            $data['grand_total'] = $this->convertNumberToWords($grand_total) . " Only";
        }else{
            $data['grand_total'] = "";
        }
        $data['surveyor'] = DB::table('users')
                            ->where('id', $followup_data->surveyor)
                            ->where('role_id', '=', 7)
                            ->where('surveyor', '1')
                            ->value('name');
        $description = DB::table('goods_description')->where('id', $followup_data->desc_of_goods)->first();
        $data['description_goods'] = $description->name ?? "";
        $servicesRequired = DB::table('services_required')->where('id', $followup_data->service_required)->first();
        $data['services_required'] = $servicesRequired->name ?? "";
        $service_data = Service::orderBy('id','DESC')->where('id', $followup_data->service_id)->first();
        $data['service_data'] = $service_data->name ?? "";
        $origin_add = $followup_data->origin_add;
        $origin_city = $followup_data->origin_city;
        if($followup_data->origin_country !=""){
            $origin_country = Helper::countryname($followup_data->origin_country);
        }else{
            $origin_country = "";
        }
        $data['originFullAddress'] = $origin_add . ', ' . $origin_city . ', ' . $origin_country;
        $desti_add = $followup_data->desti_add;
        $desti_city = $followup_data->desti_city;
        if($followup_data->desti_country !=""){
            $desti_country = Helper::countryname($followup_data->desti_country);
        }else{
            $desti_country = "";
        }
        $data['destinationFullAddress'] = $desti_add . ', ' . $desti_city . ', ' . $desti_country;
        $data['acceptQuoteStyle'] = $acceptQuoteStyle;
        return view('admin.get-quote-format-3',$data)->render();
    }
    public function send_quotation_mail(Request $request){

        try{

            $formatType  = $request->formatType;
            $enquiry_id  = $request->enquiry_id;
            $mailSubject = $request->mailSubject;
            $cc_emails   = $request->cc_emails ?? [];
            $to_mail     = (array) $request->to_mail ?? [];
            $selectedFormatType = "";
            $followup_data = Followup::findOrfail($enquiry_id);
            $agents_data = DB::table('agents')->where('id',$followup_data->agent_id)->where('is_approved',1)->first();
            $quotation_data  = DB::table('quotation_attribute')->where('enquiry_id',$enquiry_id)->first();
            $mailFormatType = "";
            $html = "";
            $htmlAdmin = "";
            $customerName = "";
            if($followup_data->agent_id !== null && $followup_data->agent_id !== ""){
                $customerName = $agents_data->company_name;
            }else{
                $customerName = $followup_data->f_name;
            }
            // echo "<pre>";print_r($followup_data);echo "</pre>";exit;
            $clientEmail = "";
            $customerEmail = "";
            if($followup_data->customer_email !== null && $followup_data->customer_email !== "" && !empty($followup_data->customer_email)){
                $clientEmail = $followup_data->customer_email;
            }

            if($followup_data->c_email !== null && $followup_data->c_email !== "" && !empty($followup_data->c_email)){
                $customerEmail = $followup_data->c_email;
            }
            /* $mailFormatType2 = "";
            $mailFormatType3 = ""; */
            $acceptQuoteStyle = "display: none;";
            if($formatType == 1){
                $selectedFormatType = 1;
                $mailFormatType .= $this->quoteEmailFormat1($enquiry_id, $acceptQuoteStyle);
            }elseif($formatType == 2){
                $selectedFormatType = 2;
                $mailFormatType .= $this->quoteEmailFormat2($enquiry_id, $acceptQuoteStyle);
            }elseif($formatType == 3){
                $selectedFormatType = 3;
                $mailFormatType .= $this->quoteEmailFormat3($enquiry_id, $acceptQuoteStyle);
            }
            // Ensure $to_mail is an array
            $to_mail = is_array($to_mail) ? $to_mail : [];

            if (!empty($customerEmail)) {
                array_push($to_mail, $customerEmail);
            }

            if (!empty($clientEmail)) {
                array_push($to_mail, $clientEmail);
            }
            $admin = 'ventesh.hnrtechnologies@gmail.com';
            // $admin = 'accounts@quickserverelo.com';
            // $html .= $this->quoteEmailFormat1($enquiry_id);
                $html .= '<!DOCTYPE html>
                            <html lang="en">
                            <head>
                                <meta charset="UTF-8">
                                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                                <title>ERP-Quotation</title>
                            </head>
                            <body>';

                            if($quotation_data->body_mail != "" && !empty($quotation_data->body_mail)){

                                $html .= $quotation_data->body_mail;

                            }else{

                                $html .= '<p>Dear '.$customerName.',</p>
                                <p>I would like to thank you for the opportunity to bid on the upcoming relocation.</p>
                                <p>Please find attached our rate for the requested services.</p>
                                <p>If you need any other information regarding our services, please feel free to contact us.</p>
                                <p>Rest assured you will receive top-quality service &amp; prompt attention.</p>
                                <p>I hope that you will find our rates competitive &amp; favour us with your valued order.</p>
                                <p>Looking forward to your confirmation.</p>';
                            }



                                $html .= '<a href="' . route('accept.quotation', ['enquiry_id' => $enquiry_id, 'format_type' => $selectedFormatType]) . '" style="text-decoration: none;">
                                    <button type="button"
                                            style="background-color: #0056b3;
                                                color: #fff;
                                                padding: 10px 20px;
                                                border: none;
                                                border-radius: 5px;
                                                cursor: pointer;
                                                font-size: 16px;">
                                        Accept Quotation
                                    </button>
                                </a>
                            </body>
                            </html>';


        $htmlAdmin .= '<!DOCTYPE html>
                            <html lang="en">
                            <head>
                                <meta charset="UTF-8">
                                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                                <title>ERP-Quotation</title>
                            </head>
                            <body>';

                            if($quotation_data->body_mail != "" && !empty($quotation_data->body_mail)){

                                $htmlAdmin .= $quotation_data->body_mail;

                            }else{

                                $htmlAdmin .= '<p>Dear '.$customerName.',</p>
                                <p>I would like to thank you for the opportunity to bid on the upcoming relocation.</p>
                                <p>Please find attached our rate for the requested services.</p>
                                <p>If you need any other information regarding our services, please feel free to contact us.</p>
                                <p>Rest assured you will receive top-quality service &amp; prompt attention.</p>
                                <p>I hope that you will find our rates competitive &amp; favour us with your valued order.</p>
                                <p>Looking forward to your confirmation.</p>';
                            }
                            $htmlAdmin .= '</body>
                            </html>';
                // $pdf = PDF::loadHTML($mailFormatType);
                $mpdf = new Mpdf();
                // Set document margins and enable automatic page breaks
                $mpdf->SetMargins(10, 10, 10);
                $mpdf->SetAutoPageBreak(true, 30); // Leave 30mm margin at the bottom for the image

                // Signature Image Path
                $footerImage = public_path('admin/assets/img/erp-sign.png'); // Ensure the path is accessible

                // Apply footer globally (for all pages)
                $mpdf->SetHTMLFooter('
                    <div style="position: fixed; right: 20px; bottom: 20px;">
                        <img src="'.$footerImage.'" width="150px" />
                    </div>
                ');

                // Add HTML Content
                $mpdf->WriteHTML($mailFormatType);
                // Generate PDF content
                $pdfContent = $mpdf->Output('', 'S'); // 'S' returns the PDF as a string

                // Email Configuration (If applicable)
                $subject = $mailSubject;
                $ccRecipients = implode(",", $cc_emails);

                foreach ($to_mail as $to) {
                    if (isset($to) && filter_var($to, FILTER_VALIDATE_EMAIL)) {
                        Mail::send([], [], function ($message) use ($html, $to, $subject, $pdfContent, $ccRecipients) {
                            $message->to($to);
                            $message->subject($subject);
                            $message->attachData($pdfContent, "ERP-Quotation.pdf", [
                                'mime' => 'application/pdf',
                            ]);
                            $message->html($html);
                        });
                    }
                }
                if (isset($admin) && filter_var($admin, FILTER_VALIDATE_EMAIL)) {
                    $admin = [$admin];
                    Mail::send([], [], function ($message) use ($htmlAdmin,$pdfContent, $admin, $cc_emails, $subject) {
                        $message->to($admin);
                        $message->subject($subject);
                        $message->attachData($pdfContent, "ERP-Quotation.pdf", [
                            'mime' => 'application/pdf',
                        ]);
                        // Add CC recipients
                        if (!empty($cc_emails)) {
                            foreach ($cc_emails as $ccRecipient) {
                                if (filter_var($ccRecipient, FILTER_VALIDATE_EMAIL)) {
                                    $message->cc($ccRecipient);
                                }
                            }
                        }
                        $message->html($htmlAdmin);
                    });
                }
                return response()->json(['status' => 'SUCCESS','message' => 'Mail has been sent successfully'], 200);
        }catch(\Exception $e){
            return response()->json(['status' => 'ERROR','message' => 'Something went wrong. Please try again later'], 500);
        }
    }
    public function request_accepted($enquiry_id,$format_type){
        $followup_data = Followup::findOrfail($enquiry_id);
        $followup_data->accepted_quotation = 1;
        $followup_data->quote_level = 1;
        $followup_data->save();

        /* $userId = Auth::id();
        $data_status['user_id']            = $userId;
        $data_status['enquiry_id']         = $enquiry_id;
        $data_status['status']             = $request->status_id ?? 0;
        $data_status['created_at']         = date('Y-m-d');
        $data_status['enquiry_level']      = 1;
        $data_status['survey_level']       = 1;
        $data_status['quote_level']        = 1;
        DB::table('enquiry_status_remark')->insert($data_status); */

        $clientName = "";
        $clientEmail = "";
        $clientPhoneNo = "";

        $customerName = "";
        $customerEmail = "";
        $customerPhoneNo = "";

        $contactPersonName = "";
        $contactPersonEmail = "";
        $contactPersonPhoneNo = "";


        $bodyMessage = "";
        $agents_data = DB::table('agents')->where('id',$followup_data->agent_id)->where('is_approved',1)->first();
        $contactPerson_data = DB::table('agents_attribute')->where('id',$followup_data->agent_attr_id)->first();

        /* Start Client Detail */
        if(isset($followup_data)){
            if($followup_data->agent_id !== null && $followup_data->agent_id !== "" && $followup_data->company_name !== ""){
                $clientName = $agents_data->company_name;
            }

            if(isset($followup_data->customer_email) && !empty($followup_data->customer_email)){
                $clientEmail = $followup_data->customer_email;
            }

            if((isset($followup_data->customer_phone1) && !empty($followup_data->customer_phone1)) || (isset($followup_data->customer_phone2) && !empty($followup_data->customer_phone2))){
                $clientPhoneNo = $followup_data->customer_phone1 ?? $followup_data->customer_phone2;
            }
        }
        /* END Client Detail */

        /* Start Contact Person */

        if(isset($contactPerson_data)){

            if($contactPerson_data->name !== null && $contactPerson_data->name !== ""){
                $contactPersonName = $contactPerson_data->name;
            }

            if(isset($contactPerson_data->email) && !empty($contactPerson_data->email)){
                $contactPersonEmail = $contactPerson_data->email;
            }

            if(isset($contactPerson_data->telephone) && !empty($contactPerson_data->telephone)){
                $contactPersonPhoneNo = $contactPerson_data->telephone;
            }
        }

        /* END Contact Person */

        /* Start Customer Detail */
        if(isset($followup_data)){
            if($followup_data->f_name !== null && $followup_data->f_name !== ""){
                $customerName = $followup_data->f_name;
            }

            if(isset($followup_data->c_email) && !empty($followup_data->c_email)){
                $customerEmail = $followup_data->c_email;
            }

            if((isset($followup_data->c_mobile) && !empty($followup_data->c_mobile)) || (isset($followup_data->c_phone) && !empty($followup_data->c_phone))){
                $customerPhoneNo = $followup_data->c_mobile ?? $followup_data->c_phone;
            }
        }
        /* END Customer Detail */
        $bodyMessage .= '<!DOCTYPE html>
                            <html lang="en">
                            <head>
                                <meta charset="UTF-8">
                                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                                <title>ERP-Quotation</title>
                            </head>
                            <body>
                                <p>Dear '.$customerName.',</p>
                                <p>Many thanks for your confirmation.</p>
                                <p>Our crews will be there at the requested date and the time of crews arrival will be between 0830 - 0900 hours to handle your move.</p>
                                <p>The moment they arrive - crews will be doing a residence check before the move starts and hence we requested to please keep your high value and important things/documents safe with you.</p>
                                <p>This job will be completed in 1 day.</p>
                                <p>Please let me know from which area you need to start your move upon the crews arrival.</p>
                                <p>If any property which belongs to the landlord is not moving please inform the crew leader so that the \'"Do not move sticker"\' will be labelled by the crew leader.</p>
                                <p>In case of any assistance required please feel free to contact</p>
                                <p>In case of any amendments in the date please do let us know 48 hours in advance.</p><br/>
                                <p>Happy Moving !!</p>
                            </body>
                            </html>';


        $acceptedMailToAdmin = '
                            <!doctype html>
                            <html>
                                <head>
                                    <meta charset="utf-8">
                                    <title>Email Template</title>
                                    <style>
                                        .logo {
                                            text-align: center;
                                            width: 100%;
                                        }
                                        .wrapper {
                                            width: 100%;
                                            max-width: 500px;
                                            margin: auto;
                                            font-size: 14px;
                                            line-height: 24px;
                                            font-family: Helvetica Neue, Helvetica, Arial, sans-serif;
                                            color: #555;
                                        }
                                        .wrapper div {
                                            height: auto;
                                            float: left;
                                            margin-bottom: 15px;
                                            width: 100%;
                                        }
                                        .text-center {
                                            text-align: center;
                                        }
                                        .email-wrapper {
                                            padding: 5px;
                                            border: 1px solid #ccc;
                                            width: 100%;
                                        }
                                        .big {
                                            text-align: center;
                                            font-size: 26px;
                                            color: #e31e24;
                                            font-weight: bold;
                                            margin-bottom: 0 !important;
                                            text-transform: uppercase;
                                            line-height: 34px;
                                        }
                                        .welcome {
                                            font-size: 17px;
                                            font-weight: bold;
                                        }
                                        .footer {
                                            text-align: center;
                                            color: #999;
                                            font-size: 13px;
                                        }
                                    </style>
                                </head>
                                <body>
                                    <div class="wrapper">
                                        <div class="email-wrapper">
                                            <table style="border-collapse: collapse;" width="100%" border="0" cellspacing="0" cellpadding="10">
                                                <tr>
                                                    <td>
                                                        <table width="100%" border="0" cellspacing="0" cellpadding="5">
                                                            <tr>
                                                                <td style="font-size: 18px;">Hello Team,</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="line-height: 20px;">
                                                                    Quotation has been Accepted By Customer <br><br> Please find the Below details
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <table style="border-top: 3px solid #333;" bgcolor="#f7f7f7" width="100%" border="0" cellspacing="0" cellpadding="5">
                                                            <tr>
                                                                <td width="50%">
                                                                    <table width="100%" border="0" cellspacing="0" cellpadding="5">';

                                                if(isset($clientName) && !empty($clientName) && $clientName !=""){

                                                    $acceptedMailToAdmin .= '<tr>
                                                                            <td width="150px">Client Name:</td>
                                                                            <td>' . $clientName . '</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td width="150px">Client Email:</td>
                                                                            <td>' . $clientEmail . '</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td width="150px">Client Phone No:</td>
                                                                            <td>' . $clientPhoneNo . '</td>
                                                                        </tr>';

                                                }

                                                if(isset($contactPersonName) && !empty($contactPersonEmail) && $contactPersonPhoneNo !=""){
                                                $acceptedMailToAdmin .= '<tr>
                                                                                <td width="150px">Contact Person Name:</td>
                                                                                <td>' . $contactPersonName . '</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td width="150px">Contact Person Email:</td>
                                                                                <td>' . $contactPersonEmail . '</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td width="150px">Contact Person Phone No:</td>
                                                                                <td>' . $contactPersonPhoneNo . '</td>
                                                                            </tr>';
                                                }

                                                if(isset($customerName) && !empty($customerEmail) && $customerPhoneNo !=""){
                                                    $acceptedMailToAdmin .= '<tr>
                                                                            <td width="150px">Customer Name:</td>
                                                                            <td>' . $customerName . '</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td width="150px">Customer Email:</td>
                                                                            <td>' . $customerEmail . '</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td width="150px">Customer Phone No:</td>
                                                                            <td>' . $customerPhoneNo . '</td>
                                                                        </tr>';
                                                }

                                                $acceptedMailToAdmin .= '<tr>
                                                                            <td width="100px">Enquiry ID:</td>
                                                                            <td>' . $followup_data->quote_no . '</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td width="100px">Quotation ID:</td>
                                                                            <td>' . $followup_data->quote_id . '</td>
                                                                        </tr>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </body>
                            </html>';

        // echo "<pre>";print_r($acceptedMailToAdmin);echo "</pre>";exit;
        $to_mail = $followup_data->customer_email ?? $followup_data->c_email ?? "";
        $admin   = "ventesh.hnrtechnologies@gmail.com";
        // $admin = 'accounts@quickserverelo.com';
        $subject = "Thank You for Accepting the Quotation - ERP";
        $subjectAdmin = "Quotation Accepted (".$followup_data->quote_id.") - ERP";

        $ccRecipients = ['accounts@quickserverelo.com', 'cs@quickserverelo.com','sales@quickserverelo.com','moving@quickserverelo.com','info@quickserverelo.com','accounts@quickserverelo.com','zafar@quickserverelo.com'];

        /*  $ccRecipients = ['adarsh.hnrtechnologies@gmail.com', 'devang.hnrtechnologies@gmail.com','abhishek.hnrtechnologies@gmail.com','venteshdevendra@gmail.com']; */

        if (isset($clientEmail) && filter_var($clientEmail, FILTER_VALIDATE_EMAIL)) {
            Mail::send([], [], function ($message) use ($bodyMessage,$clientEmail, $subject, $ccRecipients) {
                $message->to($clientEmail);
                $message->subject($subject);
                $message->html($bodyMessage);
                // Add CC recipients
                foreach ($ccRecipients as $ccRecipient) {
                    $message->cc($ccRecipient);
                }
            });
        }
        if (isset($customerEmail) && filter_var($customerEmail, FILTER_VALIDATE_EMAIL)) {
            Mail::send([], [], function ($message) use ($bodyMessage,$customerEmail, $subject, $ccRecipients) {
                $message->to($customerEmail);
                $message->subject($subject);
                $message->html($bodyMessage);
                // Add CC recipients
                foreach ($ccRecipients as $ccRecipient) {
                    $message->cc($ccRecipient);
                }
            });
        }
        if (isset($admin) && filter_var($admin, FILTER_VALIDATE_EMAIL)) {
            $toAdmin = [$admin];
            Mail::send([], [], function ($message) use ($acceptedMailToAdmin,$toAdmin, $subjectAdmin, $ccRecipients) {
                $message->to($toAdmin);
                $message->subject($subjectAdmin);
                $message->html($acceptedMailToAdmin);
                // Add CC recipients
                foreach ($ccRecipients as $ccRecipient) {
                    $message->cc($ccRecipient);
                }
            });
        }
        return redirect()->route('accept.quotation', ['enquiry_id' => $followup_data->id, 'format_type' => $format_type])->with('success','Quotation Accepted Successfully');
    }
    public function accept_quotation($enquiryId, $formatType){
        $acceptQuoteStyle = "display: block;";
        if($formatType == 1){
            $selectedFormatType = 1;
            return $this->quoteEmailFormat1($enquiryId, $acceptQuoteStyle);
        }elseif($formatType == 2){
            $selectedFormatType = 2;
            return $this->quoteEmailFormat2($enquiryId, $acceptQuoteStyle);
        }elseif($formatType == 3){
            $selectedFormatType = 3;
            return $this->quoteEmailFormat3($enquiryId, $acceptQuoteStyle);
        }
    }
    public function revise_request($enquiry_id){
        // echo "<pre>";print_r(Route::currentRouteName());echo "</pre>";exit;
        $data['inquiry_id'] = $enquiry_id;
        $data['branch_data'] = DB::table('branch')->get();
        $data['service_data']= Service::orderBy('id','DESC')->get();
        $data['shipment_type']=  DB::table('shipment_type')->get();
        $data['services_required'] = DB::table('services_required')->get();
        $data['goods_description'] = DB::table('goods_description')->get();
        $data['followup_data'] = $followup_data = DB::table('followups')->where('id',$enquiry_id)->first();
        $data['survey_data'] = DB::table('survey_assign')->where('enquiry_id', $enquiry_id)->first();
        $data['costing_attribute'] = DB::table('costing_attribute')->where('enquiry_id',$enquiry_id)->get();
        $data['similar_rate_data'] = DB::table('followups')
                                            ->where('id','!=',$enquiry_id)
                                            ->where('enquiry_level', '=', 1)
                                            ->where('survey_level', '=', 1)
                                            ->where('costing_level', '=', 0)
                                            ->where('desti_country', '=', $followup_data->desti_country)
                                            ->where('desti_city', '=', $followup_data->desti_city)
                                            ->get();
        $data['enquiry_status'] = DB::table('enquiry_status_remark')
                                            ->where('enquiry_id', '=', $enquiry_id)
                                            ->where('enquiry_level', '=',1)
                                            ->where('survey_level', '=',1)
                                            ->where('costing_level', '=',0)
                                            ->where('status', '!=',2)
                                            ->orderBy('id', 'DESC')
                                            ->first() ?? (object) ['status' => null];
        $data['code_data'] = Code::pluck('name');
        $data["action"] = "revise-quotation";
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
    public function quote_costing_remove(Request $request){
        $enquiryId = $request->enquiry_id;
        $id = $request->id;
        $result = DB::table('costing_attribute')->where('enquiry_id', '=',$enquiryId)->where('id', '=',$id)->delete();
        return redirect()->route('revise.request',$enquiryId)->with('success','Costing Attribute has been deleted successfully');
    }

    public function accept_quotation_byadmin(Request $request){
        $enquiry_id = $request->enquiry_id;
        $status = $request->status_id;

        $followup_data = Followup::findOrfail($enquiry_id);
        $followup_data->accepted_quotation = 1;
        $followup_data->quote_level = 1;
        $followup_data->save();

        $userId = Auth::id();
        $data_status['user_id']            = $userId;
        $data_status['enquiry_id']         = $enquiry_id;
        $data_status['status']             = $status ?? 0;
        $data_status['created_at']         = date('Y-m-d');
        $data_status['enquiry_level']      = 1;
        $data_status['survey_level']       = 1;
        $data_status['quote_level']        = 1;
        DB::table('enquiry_status_remark')->insert($data_status);

        $clientName = "";
        $clientEmail = "";
        $clientPhoneNo = "";

        $customerName = "";
        $customerEmail = "";
        $customerPhoneNo = "";

        $contactPersonName = "";
        $contactPersonEmail = "";
        $contactPersonPhoneNo = "";


        $bodyMessage = "";
        $agents_data = DB::table('agents')->where('id',$followup_data->agent_id)->where('is_approved',1)->first();
        $contactPerson_data = DB::table('agents_attribute')->where('id',$followup_data->agent_attr_id)->first();

        /* Start Client Detail */
        if(isset($followup_data)){
            if($followup_data->agent_id !== null && $followup_data->agent_id !== "" && $followup_data->company_name !== ""){
                $clientName = $agents_data->company_name;
            }

            if(isset($followup_data->customer_email) && !empty($followup_data->customer_email)){
                $clientEmail = $followup_data->customer_email;
            }

            if((isset($followup_data->customer_phone1) && !empty($followup_data->customer_phone1)) || (isset($followup_data->customer_phone2) && !empty($followup_data->customer_phone2))){
                $clientPhoneNo = $followup_data->customer_phone1 ?? $followup_data->customer_phone2;
            }
        }
        /* END Client Detail */

        /* Start Contact Person */

        if(isset($contactPerson_data)){

            if($contactPerson_data->name !== null && $contactPerson_data->name !== ""){
                $contactPersonName = $contactPerson_data->name;
            }

            if(isset($contactPerson_data->email) && !empty($contactPerson_data->email)){
                $contactPersonEmail = $contactPerson_data->email;
            }

            if(isset($contactPerson_data->telephone) && !empty($contactPerson_data->telephone)){
                $contactPersonPhoneNo = $contactPerson_data->telephone;
            }
        }
        /* END Contact Person */

        /* Start Customer Detail */
        if(isset($followup_data)){
            if($followup_data->f_name !== null && $followup_data->f_name !== ""){
                $customerName = $followup_data->f_name;
            }

            if(isset($followup_data->c_email) && !empty($followup_data->c_email)){
                $customerEmail = $followup_data->c_email;
            }

            if((isset($followup_data->c_mobile) && !empty($followup_data->c_mobile)) || (isset($followup_data->c_phone) && !empty($followup_data->c_phone))){
                $customerPhoneNo = $followup_data->c_mobile ?? $followup_data->c_phone;
            }
        }
        $bodyMessage .= '<!DOCTYPE html>
                            <html lang="en">
                            <head>
                                <meta charset="UTF-8">
                                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                                <title>ERP-Quotation</title>
                            </head>
                            <body>
                                <p>Dear '.$customerName.',</p>
                                <p>Many thanks for your confirmation.</p>
                                <p>Our crews will be there at the requested date and the time of crews arrival will be between 0830 - 0900 hours to handle your move.</p>
                                <p>The moment they arrive - crews will be doing a residence check before the move starts and hence we requested to please keep your high value and important things/documents safe with you.</p>
                                <p>This job will be completed in 1 day.</p>
                                <p>Please let me know from which area you need to start your move upon the crews arrival.</p>
                                <p>If any property which belongs to the landlord is not moving please inform the crew leader so that the \'"Do not move sticker"\' will be labelled by the crew leader.</p>
                                <p>In case of any assistance required please feel free to contact</p>
                                <p>In case of any amendments in the date please do let us know 48 hours in advance.</p><br/>
                                <p>Happy Moving !!</p>
                            </body>
                            </html>';

        // Start
        $acceptedMailToAdmin = '
                            <!doctype html>
                            <html>
                                <head>
                                    <meta charset="utf-8">
                                    <title>Email Template</title>
                                    <style>
                                        .logo {
                                            text-align: center;
                                            width: 100%;
                                        }
                                        .wrapper {
                                            width: 100%;
                                            max-width: 500px;
                                            margin: auto;
                                            font-size: 14px;
                                            line-height: 24px;
                                            font-family: Helvetica Neue, Helvetica, Arial, sans-serif;
                                            color: #555;
                                        }
                                        .wrapper div {
                                            height: auto;
                                            float: left;
                                            margin-bottom: 15px;
                                            width: 100%;
                                        }
                                        .text-center {
                                            text-align: center;
                                        }
                                        .email-wrapper {
                                            padding: 5px;
                                            border: 1px solid #ccc;
                                            width: 100%;
                                        }
                                        .big {
                                            text-align: center;
                                            font-size: 26px;
                                            color: #e31e24;
                                            font-weight: bold;
                                            margin-bottom: 0 !important;
                                            text-transform: uppercase;
                                            line-height: 34px;
                                        }
                                        .welcome {
                                            font-size: 17px;
                                            font-weight: bold;
                                        }
                                        .footer {
                                            text-align: center;
                                            color: #999;
                                            font-size: 13px;
                                        }
                                    </style>
                                </head>
                                <body>
                                    <div class="wrapper">
                                        <div class="email-wrapper">
                                            <table style="border-collapse: collapse;" width="100%" border="0" cellspacing="0" cellpadding="10">
                                                <tr>
                                                    <td>
                                                        <table width="100%" border="0" cellspacing="0" cellpadding="5">
                                                            <tr>
                                                                <td style="font-size: 18px;">Hello Team,</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="line-height: 20px;">
                                                                    Quotation has been Accepted By Customer <br><br> Please find the Below details
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <table style="border-top: 3px solid #333;" bgcolor="#f7f7f7" width="100%" border="0" cellspacing="0" cellpadding="5">
                                                            <tr>
                                                                <td width="50%">
                                                                    <table width="100%" border="0" cellspacing="0" cellpadding="5">';

                                                if(isset($clientName) && !empty($clientName) && $clientName !=""){

                                                    $acceptedMailToAdmin .= '<tr>
                                                                            <td width="150px">Client Name:</td>
                                                                            <td>' . $clientName . '</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td width="150px">Client Email:</td>
                                                                            <td>' . $clientEmail . '</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td width="150px">Client Phone No:</td>
                                                                            <td>' . $clientPhoneNo . '</td>
                                                                        </tr>';

                                                }

                                                if(isset($contactPersonName) && !empty($contactPersonEmail) && $contactPersonPhoneNo !=""){
                                                $acceptedMailToAdmin .= '<tr>
                                                                                <td width="150px">Contact Person Name:</td>
                                                                                <td>' . $contactPersonName . '</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td width="150px">Contact Person Email:</td>
                                                                                <td>' . $contactPersonEmail . '</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td width="150px">Contact Person Phone No:</td>
                                                                                <td>' . $contactPersonPhoneNo . '</td>
                                                                            </tr>';
                                                }

                                                if(isset($customerName) && !empty($customerEmail) && $customerPhoneNo !=""){
                                                    $acceptedMailToAdmin .= '<tr>
                                                                            <td width="150px">Client Name:</td>
                                                                            <td>' . $customerName . '</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td width="150px">Client Email:</td>
                                                                            <td>' . $customerEmail . '</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td width="150px">Client Phone No:</td>
                                                                            <td>' . $customerPhoneNo . '</td>
                                                                        </tr>';
                                                }

                                                $acceptedMailToAdmin .= '<tr>
                                                                            <td width="100px">Enquiry ID:</td>
                                                                            <td>' . $followup_data->quote_no . '</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td width="100px">Quotation ID:</td>
                                                                            <td>' . $followup_data->quote_id . '</td>
                                                                        </tr>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </body>
                            </html>';

        $to_mail = $followup_data->customer_email ?? "";
        $toAdmin   = "ventesh.hnrtechnologies@gmail.com";
        // $toAdmin = 'accounts@quickserverelo.com';
        $subject = "Thank You for Accepting the Quotation - ERP";
        $subjectAdmin = "Quotation Accepted (".$followup_data->quote_id.") - ERP";

        if (isset($admin) && filter_var($admin, FILTER_VALIDATE_EMAIL)) {
            Mail::send([], [], function ($message) use ($acceptedMailToAdmin,$toAdmin, $subjectAdmin) {
                $message->to($toAdmin);
                $message->subject($subjectAdmin);
                $message->html($acceptedMailToAdmin);
            });
        }

        if (isset($customerEmail) && filter_var($customerEmail, FILTER_VALIDATE_EMAIL)) {
            Mail::send([], [], function ($message) use ($acceptedMailToAdmin,$customerEmail, $subject) {
                $message->to($customerEmail);
                $message->subject($subject);
                $message->html($bodyMessage);
            });
        }
        // END

        if (isset($to_mail) && filter_var($to_mail, FILTER_VALIDATE_EMAIL)) {
            $toCustomer = [$to_mail];
            Mail::send([], [], function ($message) use ($bodyMessage,$toCustomer, $subject) {
                $message->to($toCustomer);
                $message->subject($subject);
                $message->html($bodyMessage);
            });
        }

        return response()->json(['status' => 'SUCCESS','message' => 'Quotation Accepted Successfully'], 200);
        // return redirect()->route('accept.quotation', ['enquiry_id' => $followup_data->id, 'format_type' => $format_type])->with('success','Quotation Accepted Successfully');
    }
    
    public function quotation_download(Request $request)
    {
        try {

            $mailFormatType = "";
            $formatType  = $request->query('formatType'); // Use query() for GET parameters
            $enquiry_id  = $request->query('enquiry_id');

            $followup_data = Followup::findOrFail($enquiry_id);
            $agents_data = DB::table('agents')->where('id', $followup_data->agent_id)->where('is_approved', 1)->first();
            $quotation_data  = DB::table('quotation_attribute')->where('enquiry_id', $enquiry_id)->first();
            $acceptQuoteStyle = "display: none;";
            if($formatType == 1){
                $selectedFormatType = 1;
                $mailFormatType .= $this->quoteEmailFormat1($enquiry_id, $acceptQuoteStyle);
            }elseif($formatType == 2){
                $selectedFormatType = 2;
                $mailFormatType .= $this->quoteEmailFormat2($enquiry_id, $acceptQuoteStyle);
            }elseif($formatType == 3){
                $selectedFormatType = 3;
                $mailFormatType .= $this->quoteEmailFormat3($enquiry_id, $acceptQuoteStyle);
            }

            $mpdf = new Mpdf();
            $mpdf->SetMargins(10, 10, 10);
            $mpdf->SetAutoPageBreak(true, 30);

            // Signature Image Path
            $footerImage = public_path('admin/assets/img/erp-sign.png');

            $mpdf->SetHTMLFooter('
                <div style="text-align: right;">
                    <img src="' . $footerImage . '" width="150px" />
                </div>
            ');

            // Add HTML content to PDF
            $mpdf->WriteHTML($mailFormatType);

            // Generate and return the PDF for download
            $fileName = "Quotation-ERP.pdf";
            return response()->streamDownload(function () use ($mpdf) {
                echo $mpdf->Output('', 'S');
            }, $fileName, [
                'Content-Type' => 'application/pdf',
            ]);

        } catch (\Exception $e) {
            return back()->with('error', 'Something went wrong. Please try again later.');
        }
    }


    public function convertNumberToWords($number)
    {
        $hyphen      = '-';
        $conjunction = ' and ';
        $separator   = ', ';
        $negative    = 'Negative ';
        $dictionary  = [
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
        // Split the number into the integer and fractional parts
        if (strpos((string) $number, '.') !== false) {
            list($number, $fraction) = explode('.', (string) $number);
        }
        switch (true) {
            case $number < 21:
                $string = $dictionary[$number];
                break;
            case $number < 100:
                $tens   = ((int) ($number / 10)) * 10;
                $units  = $number % 10;
                $string = $dictionary[$tens];
                if ($units) {
                    $string .= $hyphen . $dictionary[$units];
                }
                break;
            case $number < 1000:
                $hundreds  = (int) ($number / 100);
                $remainder = $number % 100;
                $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
                if ($remainder) {
                    $string .= $conjunction . $this->convertNumberToWords($remainder);
                }
                break;
            default:
                $baseUnit = pow(1000, floor(log($number, 1000)));
                $numBaseUnits = (int) ($number / $baseUnit);
                $remainder = $number % $baseUnit;
                $string = $this->convertNumberToWords($numBaseUnits) . ' ' . $dictionary[$baseUnit];
                if ($remainder) {
                    $string .= $remainder < 100 ? $conjunction : $separator;
                    $string .= $this->convertNumberToWords($remainder);
                }
                break;
        }
        // Handle the fractional part and add "and" before it
        if ($fraction !== null && is_numeric($fraction)) {
            $fractionWords = $this->convertNumberToWords((int)$fraction);
            $string .= $conjunction . $fractionWords;
        }
        return $string;
    }

    

}
