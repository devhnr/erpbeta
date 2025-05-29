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

class ShipmentController extends Controller
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
                                      ->where('shipment_level', '=',0)
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
                                            ->where('shipment_level', '=',0)
                                            ->where('status', '!=',2)
                                            ->orderBy('id', 'DESC')
                                            ->first() ?? (object) ['status' => null]; */

        $data['currentRoute'] = Route::currentRouteName();
        return view('admin.list_shipment', $data);
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
        }
    }


    public function shipment_status_update(Request $request){

        try{
            // echo "<pre>";print_r($request->all());exit;
            $status = $request->status_id ?? 0;
            $enquiry_id = $request->enquiry_id;

            $enquiryId = sprintf('%06d', $enquiry_id);
            $currentYear = date('Y');
            $orderNumber  = 'IN-'.$currentYear.'-'.$enquiryId;

            if($status == 2){
                $followup = Followup::find($enquiry_id);
                $followup->order_number = $orderNumber;
                $followup->shipment_level = 1;
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

            if($status === 2){
                $data_status['billing_level']  = 1;
            }else{
                $data_status['billing_level']  = 0;
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
