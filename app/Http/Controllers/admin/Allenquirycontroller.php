<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Models\admin\Followup;

class Allenquirycontroller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $user = Auth::user();
        // echo"<pre>";print_r($user->toArray());echo"</pre>";exit;
        $startdate = $request->s_date;
        $fil_enq_id = $request->fil_enq_id;
        $enddate = $request->e_date;
        $salesmanname = $request->salesmanname;
        $servicename = $request->servicename;
        $clientNameFilter = $request->clientNameFilter;
        $clientMobileFilter = $request->clientMobileFilter;
        $clientEmailFilter = $request->clientEmailFilter;
        $statusFilter = $request->statusFilter;
        $salespersonsFilter = $request->salespersonsFilter;
        $user_data = Auth::user();
        // $query = DB::table('followups');

        $query = DB::table('followups')
                    ->leftJoin('agents', function ($join) {
                        $join->on('agents.id', '=', 'followups.agent_id')
                            ->where('followups.customer_type', 2);
                    })
                    ->select('followups.*', 'agents.company_name');

        if (!empty($clientNameFilter)) {
            $query->where(function($q) use ($clientNameFilter) {
                $q->where(function($sub) use ($clientNameFilter) {
                    $sub->where('followups.customer_type', 2)
                        ->where('agents.company_name', 'like', '%' . $clientNameFilter . '%');
                })
                ->orWhere(function($sub) use ($clientNameFilter) {
                    $sub->where('followups.customer_type', '!=', 2)
                        ->where('followups.f_name', 'like', '%' . $clientNameFilter . '%');
                });
            });
        }

        if (!empty($clientMobileFilter)) {
            $query->where(function($q) use ($clientMobileFilter) {
                $q->where(function($sub) use ($clientMobileFilter) {
                    $sub->where('followups.customer_type', 2)
                        ->where(function($mobile) use ($clientMobileFilter) {
                            $mobile->where('followups.customer_phone1', 'like', '%' . $clientMobileFilter . '%')
                                   ->orWhere('followups.customer_phone2', 'like', '%' . $clientMobileFilter . '%');
                        });
                })->orWhere(function($sub) use ($clientMobileFilter) {
                    $sub->where('followups.customer_type', '!=', 2)
                        ->where(function($mobile) use ($clientMobileFilter) {
                            $mobile->where('followups.c_mobile', 'like', '%' . $clientMobileFilter . '%')
                                   ->orWhere('followups.c_phone', 'like', '%' . $clientMobileFilter . '%');
                        });
                });
            });
        }

        if (!empty($clientEmailFilter)) {
            $query->where(function($q) use ($clientEmailFilter) {
                $q->where(function($sub) use ($clientEmailFilter) {
                    $sub->where('followups.customer_type', 2)
                        ->where('followups.customer_email', 'like', '%' . $clientEmailFilter . '%');
                })->orWhere(function($sub) use ($clientEmailFilter) {
                    $sub->where('followups.customer_type', '!=', 2)
                        ->where('followups.c_email', 'like', '%' . $clientEmailFilter . '%');
                });
            });
        }

       
        if (!empty($statusFilter)) {
            $query->where(function($q) use ($statusFilter) {
                if ($statusFilter === 'Enquiry') {
                    $q->where('followups.enquiry_level', 0);
                } elseif ($statusFilter === 'Survey') {
                    $q->where('followups.survey_level', 0)->where('followups.enquiry_level', '!=', 0);
                } elseif ($statusFilter === 'Costing') {
                    $q->where('followups.costing_level', 0)->where('followups.survey_level', '!=', 0);
                } elseif ($statusFilter === 'Quotation') {
                    $q->where('followups.quote_level', 0)->where('followups.costing_level', '!=', 0);
                } elseif ($statusFilter === 'Accepted Quotation') {
                    $q->where('followups.accept_quote_level', 0)->where('followups.quote_level', '!=', 0);
                } elseif ($statusFilter === 'Job Order') {
                    $q->where('followups.job_order_level', 0)->where('followups.accept_quote_level', '!=', 0);
                } elseif ($statusFilter === 'Operation') {
                    $q->where('followups.operation_level', 0)->where('followups.job_order_level', '!=', 0);
                } elseif ($statusFilter === 'Shipment') {
                    $q->where('followups.shipment_level', 0)->where('followups.operation_level', '!=', 0);
                } elseif ($statusFilter === 'Invoice') {
                    $q->where('followups.billing_level', 0)->where('followups.shipment_level', '!=', 0);
                } elseif ($statusFilter === 'Closed') {
                    $q->where('followups.closing_level', 0)->where('followups.billing_level', '!=', 0);
                } elseif ($statusFilter === 'Accepted') {
                    $q->where('followups.enquiry_level', '!=', 0)
                    ->where('followups.survey_level', '!=', 0)
                    ->where('followups.costing_level', '!=', 0)
                    ->where('followups.quote_level', '!=', 0)
                    ->where('followups.accept_quote_level', '!=', 0)
                    ->where('followups.job_order_level', '!=', 0)
                    ->where('followups.operation_level', '!=', 0)
                    ->where('followups.shipment_level', '!=', 0)
                    ->where('followups.billing_level', '!=', 0)
                    ->where('followups.closing_level', '!=', 0);
                }
            });
        }

        if (!empty($salespersonsFilter)) {
            $query = $query->where('followups.assign_to', $salespersonsFilter);
        }

        if($user_data->role_id != 1 && $user_data->role_id != 7){
            $query = $query->where('followups.salesman_id', $user_data->id);
        }
        if($user_data->role_id != 1){
            $query = $query->where('assign_to', $user_data->id);
        }
        // if($user_data->role_id == 7){
        //     $query = $query->where('followups.surveyor', $user_data->id);
        // }

        if (!empty($fil_enq_id)) {
            $query = $query->where('followups.quote_no', 'like', '%' . $fil_enq_id . '%');
        }
        // echo"<pre>";print_r($user_data->id);echo"</pre>";exit;
        if ($startdate !='')
        {
            $query = $query->where('followups.added_date', '>=', date('Y-m-d', strtotime($startdate)));
            //$query=$query->where('created_at', $startdate);
        }
        if ($enddate !='')
        {
            $query = $query->where('followups.added_date', '<=', date('Y-m-d', strtotime($enddate)));
            //$query=$query->where('created_at', $startdate);
        }
        $data['startdate'] =$startdate;
        $data['enddate'] =$enddate;
        $data['fil_enq_id'] =$fil_enq_id;
        $data['clientNameFilter'] =$clientNameFilter;
        $data['clientMobileFilter'] =$clientMobileFilter;
        $data['clientEmailFilter'] =$clientEmailFilter;
        $data['statusFilter'] =$statusFilter;
        $data['salespersonsFilter'] =$salespersonsFilter;
        
        if ($salesmanname !='')
        {
            $query=$query->where('followups.salesman_id', $salesmanname);
        }
        if ($servicename !='')
        {
            $query=$query->where('followups.service_id', $servicename);
        }
        $data['filter_salep_id'] =$salesmanname;
        $data['filter_service_id'] =$servicename;
        // $data['salesman_data'] = DB::table('users')->Where('role_id',7)->get();
        $data['salesman_data'] = DB::table('users')->Where('id','!=', 1)->get();
        $data['service_data'] = DB::table('services')->get();
        $data['followup_status'] = DB::table('followup_status')->get();
        $data['followup_data']= $query->orderBy('id', 'DESC')->paginate(10);
        $data['salesperson_data'] = DB::table('users')->Where('role_id','=', 7)->where('surveyor','=',NULL)->get();
        // echo $query->toSql();
        //  echo'<pre>';print_r( $data['followup_data']);echo'</pre>';exit;
        return view('admin.list_allenquiry',$data);
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
    public function count(Request $request)
    {

        $salespersonsFilter = $request->salespersonsFilter;
        
        $data['error'] = '';
$user_data = Auth::user();
        $followupsQuery = Followup::query();

        // Step 2: Apply salesperson filter if selected
        if (!empty($salespersonsFilter)) {
            $followupsQuery->where('assign_to', $salespersonsFilter);
        }

        if($user_data->role_id != 1){
            $followupsQuery = $followupsQuery->where('assign_to', $user_data->id);
        }

        // Step 3: Get filtered followups
        $followups = $followupsQuery->get();

        $statusCounts = [
            'Enquiry' => 0,
            'Survey' => 0,
            'Costing' => 0,
            'Quotation' => 0,
            'Accepted Quotation' => 0,
            'Job Order' => 0,
            'Operation' => 0,
            'Shipment' => 0,
            'Invoice' => 0,
            'Closing' => 0,
            //'Accepted' => 0,
        ];
    
        foreach ($followups as $followup) {
            if ($followup->enquiry_level == 0) {
                $statusCounts['Enquiry']++;
            } elseif ($followup->survey_level == 0) {
                $statusCounts['Survey']++;
            } elseif ($followup->costing_level == 0) {
                $statusCounts['Costing']++;
            } elseif ($followup->quote_level == 0) {
                $statusCounts['Quotation']++;
            } elseif ($followup->accept_quote_level == 0) {
                $statusCounts['Accepted Quotation']++;
            } elseif ($followup->job_order_level == 0) {
                $statusCounts['Job Order']++;
            } elseif ($followup->operation_level == 0) {
                $statusCounts['Operation']++;
            } elseif ($followup->shipment_level == 0) {
                $statusCounts['Shipment']++;
            } elseif ($followup->billing_level == 0) {
                $statusCounts['Invoice']++;
            } elseif ($followup->closing_level == 0) {
                $statusCounts['Closing']++;
            } else {
                //$statusCounts['Accepted']++;
            }
        }

        $statusRoutes = [
            'Enquiry' => route('followup.index'),
            'Survey' => route('survey.index'),
            'Costing' => route('costing.index'),
            'Quotation' => route('quote.index'),
            'Accepted Quotation' => route('accepted-quotation.index'),
            'Job Order' => route('job-order.index'),
            'Operation' => route('operation.index'),
            'Shipment' => route('shipment.index'),
            'Invoice' => route('billing-invoice.index'),
            'Closing' => route('closing.index'),
            //'Accepted' => route('accepted.index'),
        ];

        $data['salespersonsFilter'] =$salespersonsFilter;
        
        $data['statusCounts'] = $statusCounts;
        $data['statusRoutes'] = $statusRoutes;
        $data['salesperson_data'] = DB::table('users')->Where('role_id','=', 7)->where('surveyor','=',NULL)->get();
        return view('admin.list_allenquiry-count',$data);
    }
}
