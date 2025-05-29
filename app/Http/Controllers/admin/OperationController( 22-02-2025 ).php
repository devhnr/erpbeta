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
use PDF;
use Mail;
use App\Models\admin\Code;
use App\Models\admin\Supervisor as SupervisorAssign;
use App\Models\admin\MenPower as ManPowerAssign;

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
                                      ->where('job_order_level', '=',1)
                                      ->where('operation_level', '=',0)
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
                                            ->where('job_order_level', '=',1)
                                            ->where('operation_level', '=',0)
                                            ->where('status', '!=',2)
                                            ->orderBy('id', 'DESC')
                                            ->first() ?? (object) ['status' => null];

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
        // echo "<pre>";print_r($followup->agent_id);echo"</pre>";exit;
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

        // echo "<pre>";print_r($data['date_wise_supervisor_data']);echo"</pre>";exit;
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

        // echo "<pre>";print_r($request->all());echo "</pre>";exit;
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

        // echo "<pre>";print_r($supervisorTimeZoneNames);echo"</pre>";exit;
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
        } //exit;

        return redirect()->route('operation.index')->with('success','Man Power data has been updated successfully');
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
}
