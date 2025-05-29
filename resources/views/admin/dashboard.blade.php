   @extends('admin.includes.Template')

   @section('content')



       <div class="content container-fluid">

           <div class="success">

               @if ($message = Session::get('login_success'))
                   <div class="alert alert-success alert-dismissible fade show" style="text-align: center;">

                       {{ $message }}

                       <button type="button" class="btn-close" data-bs-dismiss="alert"></button>

                   </div>
               @endif

           </div>

           <!-- Page Header -->

           <div class="page-header">

               <div class="row align-items-center">

                   <div class="col">
                    @php
                        $currentMonth = date("F");
                    @endphp

                       <h2 class="page-title">Current Month Report - {{$currentMonth}}</h2>

                   </div>

               </div>

           </div>

           @php

            use Illuminate\Support\Facades\DB;
            use Carbon\Carbon;

            $currentMonth = Carbon::now()->month;

            $user_data = Auth::user();

            if($user_data->role_id != 1){

                $total_inquiry_count = DB::table('followups')->where('salesman_id', $user_data->id)->whereMonth('added_date', $currentMonth)->count();
                $accept_inquiry_count = DB::table('followups')->where('salesman_id', $user_data->id)->where('accept_reject',1)->whereMonth('added_date', $currentMonth)->count();
                $totalAmountSum = DB::table('followups')
                                 ->where('salesman_id', $user_data->id)
                                ->where('accept_reject', '1')
                                ->whereMonth('added_date', $currentMonth)
                                ->sum('total_amount');

                $followups_count = DB::table('followups')
                        ->leftJoin('follow_up_date', 'followups.id', '=', 'follow_up_date.inquiry_id')
                        ->where('salesman_id', $user_data->id)
                        ->where('accept_reject','=',1)
                        // ->whereMonth('added_date', $currentMonth)
                        ->whereMonth('follow_up_date.follow_up_date', $currentMonth)
                        ->select('followups.id as follow_id','=','follow_up_date.inquiry_id')
                        ->count();


            }else
            {

                $total_inquiry_count = DB::table('followups')->whereMonth('added_date', $currentMonth)->count();
                $accept_inquiry_count = DB::table('followups')->where('accept_reject',1)->whereMonth('added_date', $currentMonth)->count();

                $totalAmountSum = DB::table('followups')
                                ->where('accept_reject', '1')
                                ->whereMonth('added_date', $currentMonth)
                                ->sum('total_amount');

                // $follow_up_date = DB::table('followups')->whereMonth('added_date', $currentMonth);

                $followups_count = DB::table('followups')
                        ->leftJoin('follow_up_date', 'followups.id', '=', 'follow_up_date.inquiry_id')
                        ->where('accept_reject','=',1)
                        // ->whereMonth('added_date', $currentMonth)
                        ->whereMonth('follow_up_date.follow_up_date', $currentMonth)
                        ->select('followups.id as follow_id','=','follow_up_date.inquiry_id')
                        ->count();

                // echo"<pre>";print_r($query);echo"</pre>";exit;
            }
            

            //echo"<pre>";print_r($followups_count);echo"</pre>";

           @endphp

           <div class="row">
                        <div class="col-xl-3 col-sm-6 col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="dash-widget-header">
                                        <span class="dash-widget-icon bg-1">
                                            <i class="fas fa-dollar-sign"></i>
                                        </span>
                                        <div class="dash-count">
                                            <div class="dash-title">Total Inquiry</div>
                                            <div class="dash-counts">
                                                <p>{{$total_inquiry_count}}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="progress progress-sm mt-3">
                                        <div class="progress-bar bg-5" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <!-- <p class="text-muted mt-3 mb-0"><span class="text-danger me-1"><i class="fas fa-arrow-down me-1"></i>1.15%</span> since last week</p> -->
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-sm-6 col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="dash-widget-header">
                                        <span class="dash-widget-icon bg-2">
                                            <i class="fas fa-users"></i>
                                        </span>
                                        <div class="dash-count">
                                            <div class="dash-title">Accept Inquiry</div>
                                            <div class="dash-counts">
                                                <p>{{$accept_inquiry_count}}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="progress progress-sm mt-3">
                                        <div class="progress-bar bg-6" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <!-- <p class="text-muted mt-3 mb-0"><span class="text-success me-1"><i class="fas fa-arrow-up me-1"></i>2.37%</span> since last week</p> -->
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-sm-6 col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="dash-widget-header">
                                        <span class="dash-widget-icon bg-3">
                                            <i class="fas fa-file-alt"></i>
                                        </span>
                                        <div class="dash-count">
                                            <div class="dash-title">Total Sales</div>
                                            <div class="dash-counts">
                                                <p>{{$totalAmountSum}}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="progress progress-sm mt-3">
                                        <div class="progress-bar bg-7" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <!-- <p class="text-muted mt-3 mb-0"><span class="text-success me-1"><i class="fas fa-arrow-up me-1"></i>3.77%</span> since last week</p> -->
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-sm-6 col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="dash-widget-header">
                                        <span class="dash-widget-icon bg-4">
                                            <i class="far fa-file"></i>
                                        </span> 
                                        <div class="dash-count">
                                            <div class="dash-title">Followups</div>
                                            <div class="dash-counts">
                                                <p>{{$followups_count}}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="progress progress-sm mt-3">
                                        <div class="progress-bar bg-8" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <!-- <p class="text-muted mt-3 mb-0"><span class="text-danger me-1"><i class="fas fa-arrow-down me-1"></i>8.68%</span> since last week</p> -->
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xl-12 d-flex">
                            <div class="card flex-fill">
                                <div class="card-header">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h5 class="card-title">Sales Analytics</h5>

                                        {{-- <div class="dropdown">
                                            <button class="btn btn-white btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                                Monthly
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <li>
                                                    <a href="javascript:void(0);" class="dropdown-item">Weekly</a>
                                                </li>
                                                <li>
                                                    <a href="javascript:void(0);" class="dropdown-item">Monthly</a>
                                                </li>
                                                <li>
                                                    <a href="javascript:void(0);" class="dropdown-item">Yearly</a>
                                                </li>                                               
                                            </ul>
                                        </div> --}}
                                    </div>
                                </div>
                                <div class="card-body">
                                   <!--  <div class="d-flex align-items-center justify-content-between flex-wrap flex-md-nowrap">
                                        <div class="w-md-100 d-flex align-items-center mb-3">
                                            <div>
                                                <span>Total Sales</span>
                                                <p class="h3 text-primary me-5">$1000</p>
                                            </div>
                                            <div>
                                                <span>Receipts</span>
                                                <p class="h3 text-success me-5">$1000</p>
                                            </div>
                                            <div>
                                                <span>Expenses</span>
                                                <p class="h3 text-danger me-5">$300</p>
                                            </div>
                                            <div>
                                                <span>Earnings</span>
                                                <p class="h3 text-dark me-5">$700</p>
                                            </div>
                                        </div>
                                    </div> -->
                                    
                                    <div id="sales_chart_new"></div>
                                </div>
                            </div>
                        </div>
                        
                    </div>

           @php

               $user_data = Auth::user();

               $inquiry_data = DB::table('followups')
                   ->where('salesman_id', $user_data->id)
                   ->get();

               //echo'<pre>';print_r( $inquiry_data);echo'</pre>';

           @endphp

           @if ($user_data->role_id != 1)

               @php
                   $enddate_count = 0;
               @endphp

               @if (count($inquiry_data) > 0 && isset($inquiry_data))


                   <div class="row">
                       <div class="col-lg-12">
                           <div class="card">
                               <div class="card-header">
                                   <h4 class="card-title">Today's Follow Up</h4>
                               </div>
                               <div class="card-body">
                                   <div class="table-responsive">
                                       <table class="table mb-0">
                                           <thead>
                                               <tr>
                                                   <th>Inquiry Id</th>
                                                   <th>Customer Name</th>
                                                   <th>Customer Phone</th>
                                                   <th>Follow Up Date</th>
                                                   <th>Next Follow Up Date</th>
                                                   <th>Remark </th>

                                               </tr>
                                           </thead>
                                           <tbody>


                                               @php
                                                   $date_new = date('Y-m-d');
                                                   $data_found = false; // Initialize the variable
                                               @endphp

                                               @foreach ($inquiry_data as $inquiry_data_new)
                                                   @php
                                                       $follow_up_date_data = DB::table('follow_up_date')
                                                           ->where('inquiry_id', $inquiry_data_new->id)
                                                           ->orderBy('id', 'DESC')
                                                           ->get();
                                                   @endphp

                                                   @if ($follow_up_date_data->isNotEmpty())
                                                       @foreach ($follow_up_date_data as $follow_up_date_data_new)
                                                           @if ($date_new == $follow_up_date_data_new->follow_up_date)
                                                               <tr>
                                                                   <td>{{ $follow_up_date_data_new->inquiry_id }}</td>
                                                                   <td>{{ $inquiry_data_new->customer_name }}</td>
                                                                   <td>

                                                                    @if ($inquiry_data_new->customer_phone1 != '')
                                                                             {{ $inquiry_data_new->customer_phone1 }}
                                                                    @else
                                                                        {{ '-' }}
                                                                    @endif
                                                                       
                                                                    </td>
                                                                   <td>{{ $follow_up_date_data_new->follow_up_date }}</td>
                                                                   <td>{{ $follow_up_date_data_new->next_follow_up_date }}
                                                                   </td>
                                                                   <td>{{ $follow_up_date_data_new->remarks }}</td>
                                                               </tr>
                                                               @php
                                                                   $data_found = true; // Set the variable to true when data is found
                                                               @endphp
                                                           @endif
                                                       @endforeach
                                                   @endif
                                               @endforeach

                                               @if (!$data_found)
                                                   <tr>
                                                       <td colspan="6" style="text-align: center">
                                                           {{ 'No data available in table !' }}</td>
                                                   </tr>
                                               @endif


                                           </tbody>
                                       </table>
                                   </div>
                               </div>
                           </div>
                       </div>

                   </div>
               @else
               @endif

           @endif




       </div>



   @stop

@section('footer_js')
@php



$currentYear = Carbon::now()->year;

    $total_januaryCount = DB::table('followups')
    ->whereYear('added_date', $currentYear)
    ->whereMonth('added_date', 1);

    if($user_data->role_id != 1){
        $total_januaryCount = $total_januaryCount->where('salesman_id', $user_data->id);
    }
    $total_januaryCount = $total_januaryCount->count();

    $accept_januaryCount = DB::table('followups')
    ->where('accept_reject', 1)
    ->whereYear('added_date', $currentYear)
    ->whereMonth('added_date', 1); 

    if($user_data->role_id != 1){
        $accept_januaryCount = $accept_januaryCount->where('salesman_id', $user_data->id);
    }
    $accept_januaryCount = $accept_januaryCount->count();

    //Feb Count;

    $total_febCount = DB::table('followups')
    ->whereYear('added_date', $currentYear)
    ->whereMonth('added_date', 2);

    if($user_data->role_id != 1){
        $total_febCount = $total_febCount->where('salesman_id', $user_data->id);
    }
    $total_febCount = $total_febCount->count();

    $accept_febCount = DB::table('followups')
    ->where('accept_reject', 1)
    ->whereYear('added_date', $currentYear)
    ->whereMonth('added_date', 2); 

    if($user_data->role_id != 1){
        $accept_febCount = $accept_febCount->where('salesman_id', $user_data->id);
    }
    $accept_febCount = $accept_febCount->count();

    //March Count

    $total_marchCount = DB::table('followups')
    ->whereYear('added_date', $currentYear)
    ->whereMonth('added_date', 3);

    if($user_data->role_id != 1){
        $total_marchCount = $total_marchCount->where('salesman_id', $user_data->id);
    }
    $total_marchCount = $total_marchCount->count();

    $accept_marchCount = DB::table('followups')
    ->where('accept_reject', 1)
    ->whereYear('added_date', $currentYear)
    ->whereMonth('added_date', 3);

    if($user_data->role_id != 1){
        $accept_marchCount = $accept_marchCount->where('salesman_id', $user_data->id);
    }
    $accept_marchCount = $accept_marchCount->count();

    //April Count

    $total_aprilCount = DB::table('followups')
    ->whereYear('added_date', $currentYear)
    ->whereMonth('added_date', 4);

    if($user_data->role_id != 1){
        $total_aprilCount = $total_aprilCount->where('salesman_id', $user_data->id);
    }
    $total_aprilCount = $total_aprilCount->count();

    $accept_aprilCount = DB::table('followups')
    ->where('accept_reject', 1)
    ->whereYear('added_date', $currentYear)
    ->whereMonth('added_date', 4); 

    if($user_data->role_id != 1){
        $accept_aprilCount = $accept_aprilCount->where('salesman_id', $user_data->id);
    }
    $accept_aprilCount = $accept_aprilCount->count();

    //May Count

    $total_mayCount = DB::table('followups')
    ->whereYear('added_date', $currentYear)
    ->whereMonth('added_date', 5);

    if($user_data->role_id != 1){
        $total_mayCount = $total_mayCount->where('salesman_id', $user_data->id);
    }
    $total_mayCount = $total_mayCount->count();

    $accept_mayCount = DB::table('followups')
    ->where('accept_reject', 1)
    ->whereYear('added_date', $currentYear)
    ->whereMonth('added_date', 5);

    if($user_data->role_id != 1){
        $accept_mayCount = $accept_mayCount->where('salesman_id', $user_data->id);
    }
    $accept_mayCount = $accept_mayCount->count();

     //June Count

     $total_juneCount = DB::table('followups')
    ->whereYear('added_date', $currentYear)
    ->whereMonth('added_date', 6); 

    if($user_data->role_id != 1){
        $total_juneCount = $total_juneCount->where('salesman_id', $user_data->id);
    }
    $total_juneCount = $total_juneCount->count();

    $accept_juneCount = DB::table('followups')
    ->where('accept_reject', 1)
    ->whereYear('added_date', $currentYear)
    ->whereMonth('added_date', 6); 

    if($user_data->role_id != 1){
        $accept_juneCount = $accept_juneCount->where('salesman_id', $user_data->id);
    }
    $accept_juneCount = $accept_juneCount->count();

     //July Count

     $total_julyCount = DB::table('followups')
    ->whereYear('added_date', $currentYear)
    ->whereMonth('added_date', 7);

    if($user_data->role_id != 1){
        $total_julyCount = $total_julyCount->where('salesman_id', $user_data->id);
    }
    $total_julyCount = $total_julyCount->count();

    $accept_julyCount = DB::table('followups')
    ->where('accept_reject', 1)
    ->whereYear('added_date', $currentYear)
    ->whereMonth('added_date', 7); 

    if($user_data->role_id != 1){
        $accept_julyCount = $accept_julyCount->where('salesman_id', $user_data->id);
    }
    $accept_julyCount = $accept_julyCount->count();

     //Aug Count

     $total_augCount = DB::table('followups')
    ->whereYear('added_date', $currentYear)
    ->whereMonth('added_date', 8); 

    if($user_data->role_id != 1){
        $total_augCount = $total_augCount->where('salesman_id', $user_data->id);
    }
    $total_augCount = $total_augCount->count();

    $accept_augCount = DB::table('followups')
    ->where('accept_reject', 1)
    ->whereYear('added_date', $currentYear)
    ->whereMonth('added_date', 8);

    if($user_data->role_id != 1){
        $accept_augCount = $accept_augCount->where('salesman_id', $user_data->id);
    }
    $accept_augCount = $accept_augCount->count();

     //Sep Count

     $total_sepCount = DB::table('followups')
    ->whereYear('added_date', $currentYear)
    ->whereMonth('added_date', 9); 

    if($user_data->role_id != 1){
        $total_sepCount = $total_sepCount->where('salesman_id', $user_data->id);
    }
    $total_sepCount = $total_sepCount->count();

    $accept_sepCount = DB::table('followups')
    ->where('accept_reject', 1)
    ->whereYear('added_date', $currentYear)
    ->whereMonth('added_date', 9); 

    if($user_data->role_id != 1){
        $accept_sepCount = $accept_sepCount->where('salesman_id', $user_data->id);
    }
    $accept_sepCount = $accept_sepCount->count();

     //Oct Count

     $total_octCount = DB::table('followups')
    ->whereYear('added_date', $currentYear)
    ->whereMonth('added_date', 10); 

    if($user_data->role_id != 1){
        $total_octCount = $total_octCount->where('salesman_id', $user_data->id);
    }
    $total_octCount = $total_octCount->count();

    $accept_octCount = DB::table('followups')
    ->where('accept_reject', 1)
    ->whereYear('added_date', $currentYear)
    ->whereMonth('added_date', 10); 

    if($user_data->role_id != 1){
        $accept_octCount = $accept_octCount->where('salesman_id', $user_data->id);
    }
    $accept_octCount = $accept_octCount->count();

     //Nov Count

     $total_novCount = DB::table('followups')
    ->whereYear('added_date', $currentYear)
    ->whereMonth('added_date', 11); 

    if($user_data->role_id != 1){
        $total_novCount = $total_novCount->where('salesman_id', $user_data->id);
    }
    $total_novCount = $total_novCount->count();

    $accept_novCount = DB::table('followups')
    ->where('accept_reject', 1)
    ->whereYear('added_date', $currentYear)
    ->whereMonth('added_date', 11); 

    if($user_data->role_id != 1){
        $accept_novCount = $accept_novCount->where('salesman_id', $user_data->id);
    }
    $accept_novCount = $accept_novCount->count();

     //Dec Count

     $total_decCount = DB::table('followups')
    ->whereYear('added_date', $currentYear)
    ->whereMonth('added_date', 12); 

    if($user_data->role_id != 1){
        $total_decCount = $total_decCount->where('salesman_id', $user_data->id);
    }
    $total_decCount = $total_decCount->count();

    $accept_decCount = DB::table('followups')
    ->where('accept_reject', 1)
    ->whereYear('added_date', $currentYear)
    ->whereMonth('added_date', 12); 

    if($user_data->role_id != 1){
        $accept_decCount = $accept_decCount->where('salesman_id', $user_data->id);
    }
    $accept_decCount = $accept_decCount->count();



@endphp

<script>
    // Column chart
	var columnCtx = document.getElementById("sales_chart_new"),
	columnConfig = {
		colors: ['#ffb800', '#42cdff'],
		series: [
            {
			name: "Total Inquiry",
			type: "column",
			data: [{{$total_januaryCount}}, {{$total_febCount}}, {{$total_marchCount}}, {{$total_aprilCount}}, {{$total_mayCount}}, {{$total_juneCount}}, {{$total_julyCount}}, {{$total_augCount}}, {{$total_sepCount}}, {{$total_octCount}}, {{$total_novCount}}, {{$total_decCount}}]
			},
			{
			name: "Accept Inquiry",
			type: "column",
			data: [{{$accept_januaryCount}}, {{$accept_febCount}}, {{$accept_marchCount}}, {{$accept_aprilCount}}, {{$accept_mayCount}}, {{$accept_juneCount}}, {{$accept_julyCount}}, {{$accept_augCount}}, {{$accept_sepCount}}, {{$accept_octCount}}, {{$accept_novCount}}, {{$accept_decCount}}]
			}
			
		],
		chart: {
			type: 'bar',
			fontFamily: 'Poppins, sans-serif',
			height: 350,
			toolbar: {
				show: false
			}
		},
		plotOptions: {
			bar: {
				horizontal: false,
				columnWidth: '60%',
				endingShape: 'rounded'
			},
		},
		dataLabels: {
			enabled: false
		},
		stroke: {
			show: true,
			width: 2,
			colors: ['transparent']
		},
		xaxis: {
			categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct','Nov','Dec'],
		},
		yaxis: {
			title: {
				text: ''
			}
		},
		fill: {
			opacity: 1
		},
		tooltip: {
			y: {
				formatter: function (val) {
					return  + val + ""
				}
			}
		}
	};
	var columnChart = new ApexCharts(columnCtx, columnConfig);
	columnChart.render();
</script>

@stop