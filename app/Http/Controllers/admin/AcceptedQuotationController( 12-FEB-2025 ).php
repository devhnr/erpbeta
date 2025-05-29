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
                                        ->where('costing_level','=',1)
                                        ->where('quote_level','=',1)
                                        ->where('accept_quote_level','=',0)
                                        ->where('accepted_quotation','=',1)
                                        ->orderBy('id','DESC')
                                        ->get();
        $data['moduleName'] = $this->getCurrentRouteName();
        $data['enquiry_status'] = DB::table('enquiry_status_remark')
                                    ->where('enquiry_level', '=',1)
                                    ->where('survey_level', '=',1)
                                    ->where('costing_level', '=',1)
                                    ->where('quote_level', '=',1)
                                    ->where('accept_quote_level', '=',0)
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
