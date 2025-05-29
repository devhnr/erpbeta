<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\admin\Followup;
use App\Models\admin\Service;
use Illuminate\Support\Facades\DB;

class Salesreportcontroller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $salespersonsFilter = $request->salespersonsFilter;
        $servicesFilter = $request->servicesFilter;

        $query = Followup::where('accept_reject',0);

        if (!empty($salespersonsFilter)) {
            $query = $query->where('assign_to', $salespersonsFilter);
        }
        if (!empty($servicesFilter)) {
            $query = $query->where('service_id', $servicesFilter);
        }

        $data['salesreport']= $query->where('enquiry_level','=',1)
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
        $data['salesperson_data'] = DB::table('users')->Where('role_id','=', 7)->where('surveyor','=',NULL)->get();

        $data['salespersonsFilter'] =$salespersonsFilter;
        $data['servicesFilter'] =$servicesFilter;

        $data['services'] = Service::orderBy('id','DESC')->get();

        return view('admin.list_salesreport', $data);
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
}
