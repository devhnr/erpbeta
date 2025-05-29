<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\admin\Followup;
use App\Models\admin\Source_lead;
use App\Models\admin\Service;
use App\Models\admin\Duration;
use App\Models\admin\Frequency;
use Illuminate\Support\Facades\DB;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Auth;
use App\Models\admin\Code;

class JobOrderController extends Controller
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
        if($user_data->role_id == 7){
            $query = $query->where('surveyor', $user_data->id);
        }
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
                                      ->where('costing_level', '=',1)
                                      ->where('quote_level', '=',1)
                                      ->where('accept_quote_level', '=',1)
                                      ->orderBy('id','DESC')
                                      ->get();

        $data['moduleName'] = $this->getCurrentRouteName();
        // echo"<pre>";print_r($data['moduleName']);echo"</pre>";exit;
        $data['enquiry_status'] = DB::table('enquiry_status_remark')
                                            ->where('enquiry_level', '=',1)
                                            ->where('survey_level', '=',1)
                                            ->where('costing_level', '=',1)
                                            ->where('quote_level', '=',1)
                                            ->where('accept_quote_level', '=',1)
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
        $followup = Followup::findOrFail($id);
        // echo "<pre>";print_r($followup->agent_id);echo"</pre>";exit;
        $data['sourcelead_data']        = Source_lead::orderBy('id','DESC')->get();
        $data['service_data']           = Service::orderBy('id','DESC')->get();
        $data['salesman_data']          = DB::table('users')->Where('id','!=', 1)->get();
        $data['country_data']           = DB::table('countries')->get();
        $data['branch_data']            = DB::table('branch')->get();
        $data['services_required']      = DB::table('services_required')->get();
        $data['goods_description']      = DB::table('goods_description')->get();
        $data['surveyor']               = DB::table('users')->where('role_id','=',7)->where('surveyor','1')->get();
        $data['surveyor_type']          = DB::table('surveyor_type')->get();
        $data['customer_type']          = DB::table('customer_type')->get();
        $data['title_rank']             = DB::table('title_rank')->get();
        $data['storage_type']           = DB::table('storage_type')->get();
        $data['storage_mode']           = DB::table('storage_mode')->get();
        $data['enquiry_mode']           = DB::table('enquiry_mode')->get();
        $data['duration_data']          = Duration::all();
        $data['frequency_data']         = Frequency::all();
        $data['organization_name']      = DB::table('agents')->where('agent_type',1)->where('is_approved',1)->get(); // fetch only agent data and active status
        $data['agent_data']             = DB::table('agents_attribute')->where('agent_id',$followup->agent_id)->get();
        $data['product_type_data']      = DB::table('product_type')->get();
        $data['salesperson_data']       = DB::table('users')->Where('role_id','=', 7)->get(); // Get Sales Person
        $data['quotation_data']         = $quotation_data = DB::table('quotation_attribute')->where('enquiry_id',$id)->first();
        $data['shipment_type']          =  DB::table('shipment_type')->get();
        $data['enquiry_status'] = DB::table('enquiry_status_remark')
                                            ->where('enquiry_id', '=',$id)
                                            ->where('enquiry_level', '=',1)
                                            ->where('survey_level',  '=',1)
                                            ->where('costing_level', '=',1)
                                            ->where('quote_level',   '=',1)
                                            ->where('accept_quote_level', '=',1)
                                            ->where('status', '!=',2)
                                            ->orderBy('id', 'DESC')
                                            ->first() ?? (object) ['status' => null];

        $data['account_managers'] = DB::table('users')->Where('role_id','=', 12)->get(); // Get Account Manager
        $data['coordinators_data'] = DB::table('users')->Where('role_id','=', 13)->get(); // Get Coordinator


        // echo "<pre>";print_r($data['quotation_data']);echo"</pre>";exit;
        return view('admin.update-job-order-details',compact('followup'),$data);
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
        $data = [
            'shipping_pol' => $request->shipping_pol ?? null,
            'shipping_vessel_schedule' => $request->shipping_vessel_schedule ?? null,
            'shipping_scope_work' => $request->shipping_scope_work ?? null,
            'shipping_place_of_accept' => $request->shipping_place_of_accept ?? null,
            'shipping_board_date' => $request->shipping_board_date ?? null,
            'shipping_place_of_delivery' => $request->shipping_place_of_delivery ?? null,
            'place_of_issue' => $request->place_of_issue ?? null,
            'origin_alternate_1' => $request->origin_alternate_1 ?? null,
            'origin_alternate_2' => $request->origin_alternate_2 ?? null,
            'shipping_pod' => $request->shipping_pod ?? null,
            'shipping_route' => $request->shipping_route ?? null,
            'shipping_freight_term' => $request->shipping_freight_term ?? null,
            'shipping_date_of_accept' => $request->shipping_date_of_accept ?? null,
            'bl_status' => $request->bl_status ?? null,
            'no_of_original_bl' => $request->no_of_original_bl ?? null,
            'desti_alternate_1' => $request->desti_alternate_1 ?? null,
            'desti_alternate_2' => $request->desti_alternate_2 ?? null,
            'packing_move_date' => $request->packing_move_date ?? null,
            'pack_date_to' => $request->pack_date_to ?? null,
            'load_date' => $request->load_date ?? null,
            'load_time' => $request->load_time ?? null,
            'dispatch_date' => $request->dispatch_date ?? null,
            'arrival_date' => $request->arrival_date ?? null,
            'arrival_time' => $request->arrival_time ?? null,
            'delivery_date' => $request->delivery_date ?? null,
            'job_order_allowance' => $request->job_order_allowance ?? null,
            'transit_time' => $request->transit_time ?? null,
            'shipping_vessel_no' => $request->shipping_vessel_no ?? null,
            'shipping_vessel_name' => $request->shipping_vessel_name ?? null,
            'shipping_mbl' => $request->shipping_mbl ?? null,
            'container_no' => $request->container_no ?? null,
            'shipping_hbl' => $request->shipping_hbl ?? null,
            'track_id' => $request->track_id ?? null,
            'freight_agent_id' => $request->freight_agent_id ?? null,
            'freight_mobile' => $request->freight_mobile ?? null,
            'freight_email' => $request->freight_email ?? null,
            'freight_rate' => $request->freight_rate ?? null,
            'freight_address' => $request->freight_address ?? null,
            'desti_agent_id' => $request->desti_agent_id ?? null,
            'desti_agent_email' => $request->desti_agent_email ?? null,
            'desti_agent_mobile' => $request->desti_agent_mobile ?? null,
            'desti_agent_attr_id' => $request->desti_agent_attr_id ?? null,
            'contact_desti_agent_email' => $request->contact_desti_agent_email ?? null,
            'contact_desti_agent_mobile' => $request->contact_desti_agent_mobile ?? null,
            'desti_agent_address' => $request->desti_agent_address ?? null,
            'customer_remarks' => $request->customer_remarks ?? null,
            'surveyor_feedback' => $request->surveyor_feedback ?? null,

            // Boolean checkbox fields (set to 1 if checked, 0 if unchecked)
            'planned_details' => $request->has('planned_details') ? 1 : 0,
            'transport_details' => $request->has('transport_details') ? 1 : 0,
            'isMultipleContainer' => $request->has('isMultipleContainer') ? 1 : 0,
            'insurance' => $request->has('insurance') ? 1 : 0,
            'goods_details' => $request->has('goods_details') ? 1 : 0,
            'freight_details' => $request->has('freight_details') ? 1 : 0,
            'desti_agent_details' => $request->has('desti_agent_details') ? 1 : 0,
            'recommendation_details' => $request->has('recommendation_details') ? 1 : 0,
        ];

        $following_fields = [
            'jo_gi_option' => $request->jo_gi_option ?? null,
            'refrence_no' => $request->refrence_no ?? null,
            'execution_branch' => $request->execution_branch ?? null,
            'account_manager_id' => $request->account_manager_id ?? null,
            'order_type' => $request->order_type ?? null,
            'service_delivery_time' => $request->service_delivery_time ?? null,
            'service_delivery_date' => $request->service_delivery_date ?? null,
            'service_invoicing_time' => $request->service_invoicing_time ?? null,
            'service_invoicing_date' => $request->service_invoicing_date ?? null,
            'credit_limit_in_aed' => $request->credit_limit_in_aed ?? null,
            'credit_period_in_days' => $request->credit_period_in_days ?? null,
            'coordinator_id' => $request->coordinator_id ?? null,
            'job_order_description' => $request->job_order_description ?? null,
            'execution_status' => $request->execution_status ?? null,
            'additional_details' => $request->additional_details ?? null,


            // Boolean checkbox fields (set to 1 if checked, 0 if unchecked)
            'jo_general_info_details' => $request->has('jo_general_info_details') ? 1 : 0,
        ];


        DB::table("followups")->where('id', $id)->update($following_fields);
        DB::table("quotation_attribute")->where('enquiry_id', $id)->update($data);
        return redirect()->route('job-order.index')->with('success', 'Job Order Details Updated Successfully');
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

    function agent_att_job_order() {
        $id = $_POST['id'];
        $agent_data = DB::table('agents')->where('id',$id)->first();
        if ($agent_data) {

            $country = "";
            $state = "";
            $city = "";
            $z_code = "";

            $phone = $agent_data->phone;
            $mobile = $agent_data->company_telephone;
            $email = $agent_data->company_email;
            $address = $agent_data->address;
            // Check and assign country
            if ($agent_data->country != "" && !empty($agent_data->country)) {
                $country = $agent_data->country;
            }

            // Check and assign state
            if ($agent_data->state != "" && !empty($agent_data->state)) {
                $state = $agent_data->state;
            }

            // Check and assign city
            if ($agent_data->city != "" && !empty($agent_data->city)) {
                $city = $agent_data->city;
            }

            // Check and assign ZIP code
            if ($agent_data->z_code != "" && !empty($agent_data->z_code)) {
                $z_code = $agent_data->z_code;
            }

            // Construct full address
            $fullAddress = $address;
            if (!empty($city)) {
                $fullAddress .= ', ' . $city;
            }
            if (!empty($state)) {
                $fullAddress .= ', ' . $state;
            }
            if (!empty($country)) {
                $fullAddress .= ', ' . Helper::countryname($country);
            }
            if (!empty($z_code)) {
                $fullAddress .= ' - ' . $z_code;
            }
            $data = DB::table('agents_attribute')->where('agent_id', $id)
                    ->orderBy('id', 'desc')->get();
            $html = "<select class='form-control form-select select' id='agent_attr_id' name='agent_attr_id' onchange='getContactPersonData(this.value)'>";
            $html .= "<option value=''>Select Contact Person</option>";
            if ($data != '' && count($data) > 0) {
                for ($i = 0; $i < count($data); $i++) {
                    $html .= "<option value='" . $data[$i]->id . "'> " . $data[$i]->name . " ( " . $data[$i]->role . " ) </option>";
                }
            }
            $html .= "</select>";

            return response()->json([
                'html' => $html,
                'phone' => $phone,
                'mobile' => $mobile,
                'email' => $email,
                'address' => $fullAddress
            ]);
        } else {
            return response()->json([
                'error' => 'Organization not found',
            ]);
        }
    }

    function get_contact_person_details(Request $request) {

        $agentAttributeId = $request->agentAttributeId;
        $agent_data = DB::table('agents_attribute')->where('id',$agentAttributeId)->first();
        if ($agent_data) {

            return response()->json([
                'email' => $agent_data->email,
                'mobile' => $agent_data->telephone
            ]);

        } else {
            return response()->json([
                'error' => 'Organization not found',
            ]);
        }
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
        }
    }
}
