<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
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
use Mpdf\Mpdf;

class OperationController extends Controller
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
                                      ->where('operation_level', '=',0)
                                      ->orderBy('id','DESC')
                                      ->get();

        $data['moduleName'] = $this->getCurrentRouteName();
        /* $data['enquiry_status'] = DB::table('enquiry_status_remark')
                                            ->where('enquiry_level', '=',1)
                                            ->where('survey_level', '=',1)
                                            ->where('costing_level', '=',1)
                                            ->where('quote_level', '=',1)
                                            ->where('accept_quote_level', '=',1)
                                            ->where('job_order_level', '=',1)
                                            ->where('operation_level', '=',0)
                                            ->where('status', '!=',2)
                                            ->orderBy('id', 'DESC')
                                            ->first() ?? (object) ['status' => null]; */

        $data['routeMapping'] = [
            'survey.index' => 'survey.detail',
            'costing.index' => 'costing.detail',
            'quote.index' => 'quote.detail',
            'accepted-quotation.index' => 'quote.detail',
            'operation.index' => 'operation.detail',
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
        $data['quotation_data']             = $quotation_data = DB::table('quotation_attribute')->where('enquiry_id',$id)->first();
        $data['shipment_type']              = DB::table('shipment_type')->get();
        $data['enquiry_status']             = DB::table('enquiry_status_remark')
                                                    ->where('enquiry_id', '=',$id)
                                                    ->where('enquiry_level', '=',1)
                                                    ->where('survey_level',  '=',1)
                                                    ->where('costing_level', '=',1)
                                                    ->where('quote_level',   '=',1)
                                                    ->where('accept_quote_level', '=',1)
                                                    ->where('job_order_level', '=',0)
                                                    ->where('status', '!=',2)
                                                    ->orderBy('id', 'DESC')
                                                    ->first() ?? (object) ['status' => null];

        $data['account_managers']           = DB::table('users')->Where('role_id','=', 12)->get(); // Get Account Manager
        $data['coordinators_data']          = DB::table('users')->Where('role_id','=', 13)->get(); // Get Coordinator
        $data['supervisor_data']            = DB::table('users')->where('role_id','=',14)->where('supervisor','1')->get();
        $data['assigned_date']              = $assigned_date = SupervisorAssign::where('enquiry_id', $id)->value('assigned_date');
        $data['supervisor_assign_data']     = SupervisorAssign::where('enquiry_id', $id)->get();
        $data['date_wise_supervisor_data']  = SupervisorAssign::where('enquiry_id', '!=', $id)
                                                        ->whereDate('assigned_date', $assigned_date)
                                                        ->get();

        $data['manPower_data']              = DB::table('users')->where('role_id','=',15)->where('men_power','1')->get();
        $data['manpower_assigned_date']     = $manpower_assigned_date = ManPowerAssign::where('enquiry_id', $id)->value('assigned_date');
        $data['manpower_assign_data']       = ManPowerAssign::where('enquiry_id', $id)->get();
        $data['date_wise_manpower_data']    = ManPowerAssign::where('enquiry_id', '!=', $id)
                                                        ->whereDate('assigned_date', $manpower_assigned_date)
                                                        ->get();
        return view('admin.edit-operation',compact('followup'),$data);
    }

    public function edit_man_power($id)
    {
        $followup = Followup::findOrFail($id);
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
        $data['quotation_data']             = $quotation_data = DB::table('quotation_attribute')->where('enquiry_id',$id)->first();
        $data['shipment_type']              = DB::table('shipment_type')->get();
        $data['enquiry_status']             = DB::table('enquiry_status_remark')
                                                    ->where('enquiry_id', '=',$id)
                                                    ->where('enquiry_level', '=',1)
                                                    ->where('survey_level',  '=',1)
                                                    ->where('costing_level', '=',1)
                                                    ->where('quote_level',   '=',1)
                                                    ->where('accept_quote_level', '=',1)
                                                    ->where('job_order_level', '=',0)
                                                    ->where('status', '!=',2)
                                                    ->orderBy('id', 'DESC')
                                                    ->first() ?? (object) ['status' => null];

        $data['account_managers']           = DB::table('users')->Where('role_id','=', 12)->get(); // Get Account Manager
        $data['coordinators_data']          = DB::table('users')->Where('role_id','=', 13)->get(); // Get Coordinator
        $data['supervisor_data']            = DB::table('users')->where('role_id','=',14)->where('supervisor','1')->get();
        $data['assigned_date']              = $assigned_date = SupervisorAssign::where('enquiry_id', $id)->value('assigned_date');
        $data['supervisor_assign_data']     = SupervisorAssign::where('enquiry_id', $id)->get();
        $data['date_wise_supervisor_data']  = SupervisorAssign::where('enquiry_id', '!=', $id)
                                                                ->whereDate('assigned_date', $assigned_date)
                                                                ->get();
        $data['manPower_data']              = DB::table('users')->where('role_id','=',15)->where('men_power','1')->get();
        $data['manpower_assigned_date']     = $manpower_assigned_date = ManPowerAssign::where('enquiry_id', $id)->value('assigned_date');
        $data['manpower_assign_data']       = ManPowerAssign::where('enquiry_id', $id)->get();
        $data['date_wise_manpower_data']    = ManPowerAssign::where('enquiry_id', '!=', $id)
                                                        ->whereDate('assigned_date', $manpower_assigned_date)
                                                        ->get();
        return view('admin.edit-operation-man-power',compact('followup'),$data);
    }
    public function edit_vehicles($id)
    {
        $followup = Followup::findOrFail($id);
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
        $data['quotation_data']             = $quotation_data = DB::table('quotation_attribute')->where('enquiry_id',$id)->first();
        $data['shipment_type']              = DB::table('shipment_type')->get();
        $data['enquiry_status']             = DB::table('enquiry_status_remark')
                                                    ->where('enquiry_id', '=',$id)
                                                    ->where('enquiry_level', '=',1)
                                                    ->where('survey_level',  '=',1)
                                                    ->where('costing_level', '=',1)
                                                    ->where('quote_level',   '=',1)
                                                    ->where('accept_quote_level', '=',1)
                                                    ->where('job_order_level', '=',0)
                                                    ->where('status', '!=',2)
                                                    ->orderBy('id', 'DESC')
                                                    ->first() ?? (object) ['status' => null];

        $data['account_managers']           = DB::table('users')->Where('role_id','=', 12)->get(); // Get Account Manager
        $data['coordinators_data']          = DB::table('users')->Where('role_id','=', 13)->get(); // Get Coordinator
        $data['supervisor_data']            = DB::table('users')->where('role_id','=',14)->where('supervisor','1')->get();
        $data['assigned_date']              = $assigned_date = SupervisorAssign::where('enquiry_id', $id)->value('assigned_date');
        $data['supervisor_assign_data']     = SupervisorAssign::where('enquiry_id', $id)->get();
        $data['date_wise_supervisor_data']  = SupervisorAssign::where('enquiry_id', '!=', $id)
                                                        ->whereDate('assigned_date', $assigned_date)
                                                        ->get();
        $data['manPower_data']              = DB::table('users')->where('role_id','=',15)->where('men_power','1')->get();
        $data['manpower_assigned_date']     = $manpower_assigned_date = ManPowerAssign::where('enquiry_id', $id)->value('assigned_date');
        $data['manpower_assign_data']       = ManPowerAssign::where('enquiry_id', $id)->get();
        $data['date_wise_manpower_data']    = ManPowerAssign::where('enquiry_id', '!=', $id)
                                                        ->whereDate('assigned_date', $manpower_assigned_date)
                                                        ->get();
        
        $data['vehicles_data']              = Vehicale::with('attributes')->with('vehiclesAssign')->get();
        $data['pack_date']                  = $pack_date = VehiclesAssignOperation::where('enquiry_id', $id)->value('pack_date');
        $data['date_wise_vehicle_data']     = VehiclesAssignOperation::where('enquiry_id', '!=', $id)
                                                        ->whereDate('pack_date', $pack_date)
                                                        ->get();

        $data['VehiclesAssignOperation']    = VehiclesAssignOperation::where('enquiry_id', $id)->get();
        return view('admin.edit-operation-vehicles',compact('followup'),$data);
    }

    public function edit_packing_material($id)
    {
        $followup = Followup::findOrFail($id);
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
        $data['quotation_data']             = $quotation_data = DB::table('quotation_attribute')->where('enquiry_id',$id)->first();
        $data['shipment_type']              = DB::table('shipment_type')->get();
        $data['enquiry_status']             = DB::table('enquiry_status_remark')
                                                    ->where('enquiry_level', '=',1)
                                                    ->where('survey_level', '=',1)
                                                    ->where('costing_level', '=',1)
                                                    ->where('quote_level', '=',1)
                                                    ->where('accept_quote_level', '=',1)
                                                    ->where('job_order_level', '=',1)
                                                    ->where('operation_level', '=',0)
                                                    ->where('status', '!=',2)
                                                    ->orderBy('id', 'DESC')
                                                    ->first() ?? (object) ['status' => null];

        $data['material_data'] = Materials::with('attributes')->get();
        $data['quotation_packing_material'] = QuotationPackingMaterial::where('enquiry_id', $id)->get();
        return view('admin.edit-operation-packing-material',compact('followup'),$data);
    }

    public function updateDriver(Request $request)
    {
        $request->validate([
            'enquiry_id' => 'required|integer',
            'vehicle_id' => 'required|integer',
            'driver_id' => 'required|integer'
        ]);

        // Find the record to update
        $existingRecord = VehiclesAssignOperation::where([
            'enquiry_id' => $request->enquiry_id,
            'vehicle_id' => $request->vehicle_id
        ])->first();

        if ($existingRecord) {
            // Update driver_id
            $existingRecord->update(['driver_id' => $request->driver_id]);
            return response()->json(['status' => 'success', 'message' => 'Driver updated successfully!']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Record not found.']);
        }
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
        // Extract data from the request
        $data['packing_move_date']       = $request->input('packing_move_date');
        $data['pack_date_to']            = $request->input('pack_date_to');
        $data['load_date']               = $request->input('load_date');
        $data['load_time']               = $request->input('load_time');
        $data['dispatch_date']           = $request->input('dispatch_date');
        $data['arrival_date']            = $request->input('arrival_date');
        $data['arrival_time']            = $request->input('arrival_time');
        $data['delivery_date']           = $request->input('delivery_date');

        DB::table('quotation_attribute')->where('enquiry_id',$id)->update($data);

        $operationPackDate       = $request->input('assigned_date');
        $supervisorTimeZoneNames = $request->input('supervisor_time_zone_name', []);

        // Loop through each supervisor_time_zone_name
        foreach ($supervisorTimeZoneNames as $supervisorId) {
            // Dynamically construct the key for surveyor_time_zone_$id
            $surveyorTimeZoneKey = 'surveyor_time_zone_' . $supervisorId;

            // Get the time zones for the current supervisor ID
            $timeZones = $request->input($surveyorTimeZoneKey, []);

            // Convert time zones array to a comma-separated string
            $timeZonesString = implode(',', $timeZones);

            // Check if enquiry_id already exists in the supervisor_assign table
            $checkSupervisorIdExists = SupervisorAssign::where('enquiry_id',$id)->where('supervisors_id',$supervisorId)->first();

            if ($checkSupervisorIdExists) {

                // If enquiry_id exists, update the existing record
                $checkSupervisorIdExists->update([
                    'assigned_date' => $operationPackDate,
                    'time_zones' => $timeZonesString,
                ]);
            } else {
                
                // If enquiry_id does not exist, insert a new record
                SupervisorAssign::create([
                    'enquiry_id' => $id,
                    'assigned_date' => $operationPackDate,
                    'supervisors_id' => $supervisorId,
                    'time_zones' => $timeZonesString,
                ]);
            }
        } 

        return redirect()->route('man-power.edit', $id)->with('success','Supervisor data has been Added successfully');
    }

    public function updateinquiry(Request $request, $id)
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
         elseif($segment == "job-order"){
            return  redirect()->route('job-order.index')->with('success', 'Quotation has been added successfully');

         }
         elseif($segment == "operation"){
            return  redirect()->route('operation.index')->with('success', 'Quotation has been added successfully');

         }
    }



    public function update_man_power(Request $request, $id)
    {
        $data['packing_move_date']       = $request->input('packing_move_date');
        $data['pack_date_to']            = $request->input('pack_date_to');
        $data['load_date']               = $request->input('load_date');
        $data['load_time']               = $request->input('load_time');
        $data['dispatch_date']           = $request->input('dispatch_date');
        $data['arrival_date']            = $request->input('arrival_date');
        $data['arrival_time']            = $request->input('arrival_time');
        $data['delivery_date']           = $request->input('delivery_date');

        DB::table('quotation_attribute')->where('enquiry_id',$id)->update($data);

        $operationPackDate       = $request->input('assigned_date');
        $manPowerTimeZoneNames = $request->input('man_power_time_zone_name', []);

        // Loop through each supervisor_time_zone_name
        foreach ($manPowerTimeZoneNames as $manPowerId) {
            // Dynamically construct the key for Man_power_time_zone_$id
            $manPowerTimeZoneKey = 'man_power_time_zone_' . $manPowerId;

            // Get the time zones for the current supervisor ID
            $timeZones = $request->input($manPowerTimeZoneKey, []);

            // Convert time zones array to a comma-separated string
            $timeZonesString = implode(',', $timeZones);

            // Check if enquiry_id already exists in the supervisor_assign table
            $checkManPowerIdExists = ManPowerAssign::where('enquiry_id',$id)->where('men_power_id',$manPowerId)->first();

            if ($checkManPowerIdExists) {

                // If enquiry_id exists, update the existing record
                $checkManPowerIdExists->update([
                    'assigned_date' => $operationPackDate,
                    'time_zones' => $timeZonesString,
                ]);
            } else {
                
                // If enquiry_id does not exist, insert a new record
                ManPowerAssign::create([
                    'enquiry_id' => $id,
                    'assigned_date' => $operationPackDate,
                    'men_power_id' => $manPowerId,
                    'time_zones' => $timeZonesString,
                ]);
            }
        } 

        return redirect()->route('operation-vehicles.edit',$id)->with('success','Man Power data has been updated successfully');
    }

    public function update_vehicle(Request $request, $id)
    {
        if(!empty($request->unchecked_vehicles)){

            $explodeUncheckedVehicles = explode(',', $request->unchecked_vehicles);
            foreach ($explodeUncheckedVehicles as $uncheckedVehicle) {
                VehiclesAssignOperation::where('vehicle_id', $uncheckedVehicle)->delete();
            }
        }

        if(!empty($request->vehicle_id)){
            $countOfVehicleid = count($request->vehicle_id);
            for ($i = 0; $i < $countOfVehicleid; $i++) {
                if (!empty($request->vehicle_id[$i])) {

                    $TimeZoneKey = 'time_zone_' . $request->vehicle_id[$i];

                    // Get the time zones for the current supervisor ID
                    $timeZones = $request->input($TimeZoneKey, []);
                    // Convert time zones array to a comma-separated string
                    $timeZonesString = is_array($timeZones) ? implode(", ", $timeZones) : $timeZones;

                    $data = [
                        'enquiry_id'        => $id,
                        'vehicle_id'        => $request->vehicle_id[$i],
                        'driver_id'         => $request->driver_name[$i] ?? 0,
                        'driver_mobile_no'  => $request->driver_mobile_no[$i] ?? "",
                        'no_of_trip'        => $request->no_of_trip[$i] ?? "",
                        'amount'            => $request->amount[$i] ?? "",
                        'pack_date'         => $request->pack_date ?? "",
                        'time_zone_id'      => $timeZonesString
                    ];

                    // Check if record exists
                    $existingRecord  = VehiclesAssignOperation::where([
                        'enquiry_id' => $id,
                        'vehicle_id' => $request->vehicle_id[$i],
                        'driver_id'  => $request->driver_name[$i]
                    ])->first();

                    if ($existingRecord) {
                        // Update existing record
                        if(!empty($data['driver_mobile_no']) || !empty($data['no_of_trip']) || !empty($data['amount'])){
                            
                           /*  if(!empty($data['driver_mobile_no'])){
                                $updateData['driver_mobile_no'] = $data['driver_mobile_no'];
                            } */
                            if(!empty($data['pack_date'])){
                                $updateData['pack_date'] = $data['pack_date'];
                            }

                            $updateData = [
                                'driver_mobile_no'       => $data['driver_mobile_no'],
                                'no_of_trip'       => $data['no_of_trip'],
                                'amount'           => $data['amount'],
                                'time_zone_id'     => $timeZonesString
                            ];
                            $existingRecord->update($updateData);
                        }
                    } else {
                        // Insert new record
                        VehiclesAssignOperation::create($data);
                    }
                }
            }
        }
        return redirect()->route('operation-packing.edit',$id)->with('success', 'Vehicle data has been updated successfully');
    }

    /* public function update_vehicle(Request $request, $id){

        if (count($_POST['vehicle_id']) > 0 && $_POST['vehicle_id'] != '') {

            $countOfVehicleid = count($_POST['vehicle_id']);
            for ($i = 0; $i < $countOfVehicleid; $i++) {
                if($request->vehicle_id[$i] != '')
                {
                    $content['enquiry_id'] = $id;
                    $content['vehicle_id'] = $request->vehicle_id[$i];
                    $content['driver_id'] = $request->driver_name[$i];
                    $content['driver_mobile_no'] = $_POST['driver_mobile_no'][$i];
                    $this->insert_vehicle_attribute($content);
                }
            }
        }

        return redirect()->route('operation.index')->with('success','Vehicle data has been updated successfully');
    } */

    function insert_vehicle_attribute($content)
    {
        $data['enquiry_id'] = $content['enquiry_id'];
        $data['vehicle_id'] = $content['vehicle_id'];
        $data['driver_id'] = $content['driver_id'];
        $data['driver_mobile_no'] = $content['driver_mobile_no'] ?? "";
        VehiclesAssignOperation::create($data);
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
    /**
     * Return the current route name.
     *
     * @return string

    */
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
        }
    }

    public function checkDate(Request $request)
    {
        // $exists = Supervisor::whereDate('assigned_date', $request->date)->exists();
        $assignedDate = $request->input('date');
        // Fetch all supervisors and their assigned time zones for the given date
        $existingAssignments = SupervisorAssign::whereDate('assigned_date', $assignedDate)->get();
        return response()->json($existingAssignments);
    }
    public function checkManPowerDate(Request $request)
    {
        // $exists = Supervisor::whereDate('assigned_date', $request->date)->exists();
        $assignedDate = $request->input('date');
        // Fetch all supervisors and their assigned time zones for the given date
        $existingAssignments = ManPowerAssign::whereDate('assigned_date', $assignedDate)->get();
        return response()->json($existingAssignments);
    }

    public function getDriverInfo(Request $request)
    {
        $driver = VehicalAttribute::where('id', $request->driver_id)->first();
        if ($driver) {
            return response()->json([
                'success' => true,
                'mobile' => $driver->driver_mobile_no  // Ensure this column exists in your database
            ]);
        }

        return response()->json(['success' => false, 'message' => 'Driver not found']);
    }

    public function checkVehicleDate(Request $request)
    {
        // $exists = Supervisor::whereDate('assigned_date', $request->date)->exists();
        $assignedDate = $request->input('date');
        // Fetch all supervisors and their assigned time zones for the given date
        $existingAssignments = VehiclesAssignOperation::whereDate('pack_date', $assignedDate)->get()->toArray();
        return response()->json($existingAssignments);
    }

    public function warehouse_allocate(Request $request){

        $material_id = $request->input('material_id');
        $enquiry_id = $request->input('enquiry_id');

        $godown_id = $request->input('godown_id_new');
        $allocate = $request->input('allocate');

        // Check if all values in the allocate array are 0
        if (count(array_filter($allocate, function($value) {
            return trim($value) !== ''; // Check if the value is not an empty string
        })) === 0) {
            // Redirect if all allocate values are 0
            return redirect()->route('operation-packing.edit',$enquiry_id)
                             ->with('error', 'Please enter a valid allocate value in at least one row.');
        }

        foreach($godown_id as $key => $value){

            if($allocate[$key] !="" && !empty($allocate[$key])){

                $materialAttribute = MaterialAttribute::where('material_id',$material_id)->where('godown_id',$value)->first();

                $materialStock = $materialAttribute->stock;
                $materialUnitCost = $materialAttribute->price;

                if($allocate[$key] >= $materialStock){
                    return redirect()->route('operation-packing.edit',$enquiry_id)
                    ->with('error', 'The allocate value cannot be greater than the quantity.');
                }
                $priceCost  = $materialUnitCost * $allocate[$key];

                $totalStock = $materialStock - $allocate[$key];

                MaterialAttribute::where('material_id',$material_id)
                                  ->where('godown_id',$value)
                                  ->update(['stock' => $totalStock]);
                                  
                $data = [
                    'enquiry_id' => $enquiry_id,
                    'material_id' => $material_id,
                    'godown_id' => $value,
                    'allocate' => $allocate[$key],
                    'price_cost' => $priceCost
                ];
                
                $checkMaterialExists = QuotationPackingMaterial::where('enquiry_id', $enquiry_id)
                                                                ->where('material_id', $material_id)
                                                                ->where('godown_id', $value)
                                                                ->first();
    
                if ($checkMaterialExists && !empty($checkMaterialExists)) {
                    // If enquiry_id exists, update the existing record
                    $checkMaterialExists->update($data);
                } else {
                    // If enquiry_id does not exist, insert a new record
                    QuotationPackingMaterial::create($data);
                }
            }
        }

        return redirect()->route('operation-packing.edit',$enquiry_id)->with('success', 'Packing Material data has been updated successfully');
    }
    public function warehouse_return(Request $request){

       
        $material_id = $request->input('material_id');
        $enquiry_id = $request->input('enquiry_id');

        $godown_id = $request->input('godown_id');
        $return_allocate = $request->input('return_allocate',[]);

        foreach($godown_id as $key => $value){

            if($return_allocate[$key] !="" && !empty($return_allocate[$key])){

                $materialAttribute = MaterialAttribute::where('material_id',$material_id)->where('godown_id',$value)->first();

                $materialStock = $materialAttribute->stock;
                $materialUnitCost = $materialAttribute->price;

                if($return_allocate[$key] >= $materialStock){
                    return redirect()->route('operation-packing.edit',$enquiry_id)
                    ->with('error', 'The return quantity cannot be <br/>greater than the allocated quantity.');
                }

                $priceCost  = $materialUnitCost * $return_allocate[$key];

                $additionStock = $materialStock + $return_allocate[$key];
                

                $checkMaterialExists = QuotationPackingMaterial::where('enquiry_id', $enquiry_id)
                                                                ->where('material_id', $material_id)
                                                                ->where('godown_id', $value)
                                                                ->first();

                $operationPackMaterial = $checkMaterialExists->allocate;
                
                $subtractionOfStock = $operationPackMaterial - $return_allocate[$key];
                $sumOfStockAndCost = $materialUnitCost * $subtractionOfStock;

                MaterialAttribute::where('material_id',$material_id)
                                  ->where('godown_id',$value)
                                  ->update(['stock' => $additionStock]);
                                  
                $data = [
                    'enquiry_id' => $enquiry_id,
                    'material_id' => $material_id,
                    'godown_id' => $value,
                    'allocate' => $subtractionOfStock,
                    'price_cost' => $sumOfStockAndCost
                ];

                $dataInsertReturn = [
                    'enquiry_id' => $enquiry_id,
                    'material_id' => $material_id,
                    'godown_id' => $value,
                    'allocate' => $subtractionOfStock,
                    'total_cost' => $materialUnitCost * $return_allocate[$key]
                ];

                OperationPackingMaterialReturn::create($dataInsertReturn);
                
                if ($checkMaterialExists && !empty($checkMaterialExists)) {
                    // If enquiry_id exists, update the existing record

                    $checkMaterialExists->update($data);
                } 
            }
        }
        return redirect()->route('operation-packing.edit',$enquiry_id)->with('success', 'Packing Material data has been updated successfully');
    }

    public function edit_label($id)
    {
        $followup = Followup::findOrFail($id);
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
        $data['quotation_data']             = $quotation_data = DB::table('quotation_attribute')->where('enquiry_id',$id)->first();
        $data['shipment_type']              = DB::table('shipment_type')->get();
        $data['enquiry_status']             = DB::table('enquiry_status_remark')
                                                    ->where('enquiry_level', '=',1)
                                                    ->where('survey_level', '=',1)
                                                    ->where('costing_level', '=',1)
                                                    ->where('quote_level', '=',1)
                                                    ->where('accept_quote_level', '=',1)
                                                    ->where('job_order_level', '=',1)
                                                    ->where('operation_level', '=',0)
                                                    ->where('status', '!=',2)
                                                    ->orderBy('id', 'DESC')
                                                    ->first() ?? (object) ['status' => null];

        $data['material_data'] = Materials::with('attributes')->get();
        $data['quotation_packing_material'] = QuotationPackingMaterial::where('enquiry_id', $id)->get();
        return view('admin.edit-operation-label',compact('followup'),$data);
    }


    public function show_label(Request $request){
           
            // echo "<pre>";print_r($request->all());echo "</pre>";exit;
            $data['labelName']          = $request->input('labelName');
            $data['labelDescription']   = $request->input('labelDescription');
            $data['labelFooter']        = $request->input('labelFooter');
            $data['labelNumber']        = $request->input('labelNumber');
            $data['noOfLabels']         = $request->input('noOfLabels');
            $data['fromNo']             = $request->input('fromNo');
            $data['shipmentDate']       = $request->input('shipmentDate');
            $data['originCity']         = $request->input('originCity');
            $data['destiCity']          = $request->input('destiCity');

            $data['productType'] = "";
            $data['goodsType'] = "";

            $productTypeID              = $request->input('productType');
            $goodsTypeID                = $request->input('goodsType');

            if($productTypeID != ""){
                $data['productType']    = DB::table('product_type')->where('id',$productTypeID)->value('product_type');
            }
            if($goodsTypeID != ""){
                $data['goodsType']      = DB::table('goods_description')->where('id',$goodsTypeID)->value('name');
            }  

            // Store data in session
            session(['label_data' => $data]);
            
            try {
                $labelHtml = view('admin.operation-label', $data)->render();
                return response()->json(['status' => 'success', 'data' => $labelHtml]);
            } catch (\Exception $e) {
                return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
            }
    }

    public function update_label(Request $request, $id)
    {
        try{

            $request->validate([
                'label_number'       => 'required',
                'no_of_labels'       => 'required',
                'label_name'         => 'required',
                'from_no'            => 'required'
            ]);

            $data['label_number']       = $request->input('label_number');
            $data['no_of_labels']       = $request->input('no_of_labels');
            $data['label_name']         = $request->input('label_name');
            $data['label_description']  = $request->input('label_description');
            $data['label_footer']       = $request->input('label_footer');
            $data['from_no']            = $request->input('from_no');
            $data['show_label']         = $request->input('show_label');
            $data['shipment_date']      = date("Y-m-d", strtotime($request->input('shipment_date')));
            Followup::where('id',$id)->update($data);
            return redirect()->route('operation-lable.edit',$id)->with('success', 'Label has been updated successfully');

        }catch(\Exception $e){

            return redirect()->route('operation-lable.edit',$id)->with('error', $e->getMessage());
        }
        
    }



    public function preview_label($enquiry_id)
    {
        $followup = Followup::findOrFail($enquiry_id);
        $data = session('label_data');
        // echo "<pre>";print_r($data);echo "</pre>";exit;
        return view('admin.operation-preview-label',compact('followup'),$data);
    }

    public function edit_documents($enquiry_id){
        $followup = Followup::findOrFail($enquiry_id);
        $data['branch_data'] = DB::table('branch')->get();
        $data['uploaded_documents'] = UploadDocuments::where('enquiry_id', $enquiry_id)->paginate(8);
        // echo "<pre>";print_r($data['uploaded_documents']);echo "</pre>";exit;
        return view('admin.operation-upload-documents',compact('followup'),$data);
    }

    public function upload_documents(Request $request, $enquiry_id)
    {
        // Validate inputs
        /* $request->validate([
            'upload_file.*' => 'required|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
            'title.*'       => 'required|string|max:255',
        ]); */

        // Get input values
        $documents = $request->file('upload_file');
        $titles    = $request->input('title');

        // Check if both title and document exist
        if (!empty($documents) && !empty($titles)) {
            foreach ($titles as $key => $title) {
                // Ensure document exists for the corresponding title
                if (isset($documents[$key])) {
                    $document = $documents[$key];

                    // Generate unique filename
                    $documentName = time() . '.' . $document->getClientOriginalName();
                    $document->move(public_path('upload/operation-docs'), $documentName);

                    // Insert data into database
                    UploadDocuments::create([
                        'enquiry_id' => $enquiry_id,
                        'title'      => $title,
                        'document'   => $documentName,
                    ]);
                }
            }
            return redirect()->route('operation-documents.edit', $enquiry_id)->with('success', 'Document uploaded successfully');
        }else{
            return redirect()->route('operation-documents.edit', $enquiry_id)->with('error', 'The document has not been uploaded.');
        }
    }

    public function download_document($id)
    {
        // Find document by ID
        $document = UploadDocuments::findOrFail($id);

        // Get the file path
        $filePath = public_path('upload/operation-docs/' . $document->document);

        // Check if file exists
        if (file_exists($filePath)) {
            return response()->download($filePath, $document->document);
        } else {
            return redirect()->route('operation-documents.edit', $id)->with('error', 'File not found.');
        }
    }

    public function delete_documents(Request $request,$documentId)
    {
        // Find the document by ID
        $document = UploadDocuments::findOrFail($documentId);
        // Get the file path
        $filePath = public_path('upload/operation-docs/' . $document->document);
        // Check if file exists
        if (file_exists($filePath)) {
            // Delete the file
            unlink($filePath);
            // Delete the document from the database
            $document->delete();
            return redirect()->route('operation-documents.edit', $document->enquiry_id)->with('success', 'Document deleted successfully');
        } else {
            return redirect()->route('operation-documents.edit', $document->enquiry_id)->with('success', 'File not found');
        }

    }

    public function client_care_report_download($enquiry_id)
    {
        $followup = Followup::findOrFail($enquiry_id);
        $quotation_data = DB::table('quotation_attribute')->where('enquiry_id', $enquiry_id)->first();
        $agentName = DB::table('agents')->where('id', $followup->agent_id)->value('company_name');
        $clientName = "";
        if($followup->f_name != ""){
            $clientName = $followup->f_name;
        }else{
            $clientName = $agentName;
        }

        // Render the Blade view into an HTML string
        $html = view('admin.client-care-report', compact('followup', 'quotation_data','clientName'));

        return $html;
        // $html = view('admin.client-care-report', compact('followup', 'quotation_data'))->render();

        // $pdf = PDF::loadHTML($html);
        // Save the PDF file
        

        // echo $html;exit;
        // return $pdf->download('Client-Care-Report.pdf');

        // $mpdf = new Mpdf();

        // $mpdf = new Mpdf([
        //     'mode' => 'utf-8',
        //     'format' => 'A4',
        //     'orientation' => 'Portrait',
        //     'margin_left' => 10,
        //     'margin_right' => 10,
        //     'margin_top' => 10,
        //     'margin_bottom' => 10,
        //     'default_font' => 'Arial'
        // ]);
        // $mpdf->SetMargins(10, 10, 10);
        // $mpdf->SetAutoPageBreak(true, 30);
        // $mpdf->WriteHTML($html);

        // // Output PDF as download
        // return response($mpdf->Output('client-care-report.pdf', 'D'))
        //     ->header('Content-Type', 'application/pdf');
    }

    public function get_report($enquiryId){

        $followup = Followup::findOrFail($enquiryId);
        return view('admin.get-reports',compact('followup'));
    }

    public function job_cost_report($enquiry_id){
        
        $followup = Followup::findOrFail($enquiry_id);
        $quotation_data = DB::table('quotation_attribute')->where('enquiry_id', $enquiry_id)->first();
        $agentName = DB::table('agents')->where('id', $followup->agent_id)->value('company_name');
        $clientName = "";
        if($followup->f_name != ""){
            $clientName = $followup->f_name;
        }else{
            $clientName = $agentName;
        }
        return view('admin.job-cost-report', compact('followup', 'quotation_data','clientName'));
    }

    public function operation_status_change(Request $request){
        $enquiry_id = $request->enquiry_id;
        $operation_status = $request->status_id ?? 0;

        $operationData = [
            'operation_status' => $operation_status
        ];

        if($operation_status == 2){
            $followup = Followup::find($enquiry_id);
            $followup->operation_level = 1;
            $followup->save();
        }

        $userId = Auth::id();
        $data_status['user_id']                 = $userId;
        $data_status['enquiry_id']              = $enquiry_id;
        $data_status['status']                  = $operation_status;
        $data_status['created_at']              = date('Y-m-d');
        $data_status['enquiry_level']           = 1;
        $data_status['survey_level']            = 1;
        $data_status['costing_level']           = 1;
        $data_status['quote_level']             = 1;
        $data_status['accept_quote_level']      = 1;
        $data_status['job_order_level']         = 1;

        if($operation_status === 2){
            $data_status['operation_level']  = 1;
        }else{
            $data_status['operation_level']  = 0;
        }
        DB::table('enquiry_status_remark')->insert($data_status);

        if($operation_status == 2){
            return response()->json(['status'=> 2,'success' => 'Status changed successfully']);
        }else{
            return response()->json(['status'=> 0,'success' => 'Status changed successfully']);
        }
    }

}
