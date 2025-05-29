@extends('admin.includes.Template')
@section('content')
    @php
        $userId = Auth::id();
    //
        $get_user_data = Helper::get_user_data($userId);
        $get_permission_data = Helper::get_permission_data($get_user_data->role_id);

        $add_perm = [];
        $edit_perm = [];
        $delete_perm = [];
        if ($get_permission_data->add_perm != '') {
            $add_perm = $get_permission_data->add_perm;
            $add_perm = explode(',', $add_perm);
        }
        if ($get_permission_data->editperm != '') {
            $edit_perm = $get_permission_data->editperm;
            $edit_perm = explode(',', $edit_perm);
        }
        if ($get_permission_data->delete_perm != '') {
            $delete_perm = $get_permission_data->delete_perm;
            $delete_perm = explode(',', $delete_perm);
        }
    @endphp
<style>
    div.container { max-width: 1200px }
    .folloup-modal { max-width: 670px !important; }

  .popup-content {
      word-wrap: break-word;
      white-space: normal; /* Ensures long text wraps to the next line */
  }

  #admin_accept_quote{
    padding:5px;
  }

</style>
@php

@endphp

    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Sales Report</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active">Sales Report</li>
                    </ul>
                </div>
                @if (in_array('51', $add_perm) || in_array('51', $delete_perm))
                <div class="col-auto">
                    {{-- <a class="btn btn-primary me-1" href="javascript:void('0');" onclick="excel_download();">Excel
                        Download</a> --}}
                    @if($get_user_data->role_id != '7')
                   
                    <a class="btn btn-primary filter-btn" href="javascript:void(0);" id="filter_search">
                        <i class="fas fa-filter"></i> Filter
                    </a>
                    
                    @endif
                </div>
            @endif
            </div>
        </div>
        <!-- /Page Header -->
        @if ($message = Session::get('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <strong>Success!</strong> {{ $message }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if ($message = Session::get('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                <strong>Error!</strong> {{ $message }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        
        <!-- Search Filter -->
        
        <div id="validate" class="alert alert-success alert-dismissible fade show" style="display: none;">
            <span id="success-message-list"></span>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>

        @php
            if (!empty($salespersonsFilter) || !empty($servicesFilter))   {
                $displayCard = 'display:block';
            } else {
                $displayCard = 'display:none';
            }
        @endphp

        <div id="filter_inputs" class="card filter-card" style="@php echo $displayCard; @endphp">
            <div class="card-body pb-0">
                <form action="{{ route('salesreport.filter') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-sm-6 col-md-10">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Sales Persons</label>
                                        <select name="salespersonsFilter" class="form-control">
                                            <option value="">-- Select Sales Persons --</option>
                                            
                                            @foreach($salesperson_data as $salesperson)
                                            <option value="{{ $salesperson->id }}" {{ $salespersonsFilter == $salesperson->id ? 'selected' : '' }}>{{ $salesperson->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Services</label>
                                        <select name="servicesFilter" class="form-control">
                                            <option value="">-- Select Services --</option>
                                            
                                            @foreach($services as $servicesdata)
                                            <option value="{{ $servicesdata->id }}" {{ $servicesFilter == $servicesdata->id ? 'selected' : '' }}>{{ $servicesdata->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3 col-md-2" style="margin-top: 23px;">
                            <input class="btn btn-primary" value="Search" type="submit">
                            <a href="{{ route('salesreport.lists') }}" class="btn btn-primary">Reset</a>
                        </div>
                    </div>
            </div>
            </form>
        </div>
        
        <!-- /Search Filter -->
        <div class="row">
            <div class="col-sm-12">
                <div class="card card-table">
                    <div class="card-body container">
                        <form id="form" action="" enctype="multipart/form-data">
                            <INPUT TYPE="hidden" NAME="hidPgRefRan" VALUE="<?php echo rand(); ?>">
                            @csrf
                            <div class="table-responsive">
                                <table class="table table-center table-hover datatable" id="header_lock">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Select</th>
                                            <th>Quote No</th>
                                            <th>Service</th>
                                            <th>Salesperson Name</th>
                                            <th>Client Detail</th>
                                            {{-- <th>Contact Person</th>
                                            <th>Client Mobile</th>
                                            <th>Client Email</th> --}}
                                            <th>Quotation</th>											
                                            <th>Margin</th>											
                                            <th>Vat (5%)</th>
                                            <th>Total Amount</th>
                                            <th>Total Expense + Material</th>
                                            {{-- <th>Total Material</th> --}}
                                            <th>Total Profit (AED)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($salesreport as $salesreport_data)

                                        @php
                                            $quotation_attribute = DB::table('quotation_attribute')
                                                ->where('enquiry_id', $salesreport_data->id)
                                                ->first();

                                                $expense = DB::table('expense_inquiry')
                                                            ->where('inquiry_id', $salesreport_data->id)
                                                            ->sum('expense_value');
                                            $material = DB::table('quotation_packing_materials')
                                                        ->where('enquiry_id', $salesreport_data->id)
                                                        ->sum('price_cost');
                                        @endphp
                                            <tr>
                                                <td><input name="selected[]" id="selected[]" value="{{ $salesreport_data->id }}"
                                                type="checkbox" class="minimal-red"
                                                style="height: 20px;width: 20px;border-radius: 0px;color: red;">
                                                </td>
                                                <td>{{ $salesreport_data->quote_no }}</td>
                                                <td>{!! Helper::service($salesreport_data->service_id) !!}</td>
                                                <td>
                                                    @if ($salesreport_data->assign_to != '')
                                                    {!! Helper::salesmanname($salesreport_data->assign_to) !!}
                                                    @else
                                                        {{ '-' }}
                                                    @endif
                                                        
                                                </td>
                                                @php
                                                    $clientName = "";
                                                    if($salesreport_data->agent_id != '' && $salesreport_data->customer_type != '1'  && $salesreport_data->customer_type == '2'){
                                                        $clientName = Helper::getOrganizationName($salesreport_data->agent_id);
                                                    }else{
                                                        $clientName = $salesreport_data->f_name;
                                                    }
                                                @endphp

                                                @php
                                                $clientMobile = "";
                                                if($salesreport_data->customer_phone1 != '' && $salesreport_data->customer_type != '1' && $salesreport_data->customer_type == '2'){

                                                    if($salesreport_data->customer_phone1 != ''){
                                                        $clientMobile = $salesreport_data->customer_phone1;
                                                    }else {
                                                        $clientMobile = $salesreport_data->customer_phone2;
                                                    }

                                                }else{

                                                    if($salesreport_data->c_mobile != ''){
                                                        $clientMobile = $salesreport_data->c_mobile;
                                                    }else{
                                                        $clientMobile = $salesreport_data->c_phone;
                                                    }
                                                }
                                                @endphp
                                                <td>
                                                        {{ $clientName }} <br>{{$clientMobile}}
                                                </td>
                                                {{-- <td>
                                                    @if ($salesreport_data->agent_attr_id != '')
                                                             {{ Helper::getOrganizationContactName($salesreport_data->agent_attr_id) }}
                                                    @else
                                                        {{ '-' }}
                                                    @endif
                                                </td> --}}
                                               
                                                {{-- <td>
                                                    {{ $clientMobile }}
                                                </td>
                                                @php
                                                    $clientEmail = "";
                                                    if($salesreport_data->customer_email != '' && $salesreport_data->customer_type != '1' && $salesreport_data->customer_type == '2'){
                                                        $clientEmail = $salesreport_data->customer_email;
                                                    }else{
                                                        $clientEmail = $salesreport_data->c_email;
                                                    }
                                                @endphp
                                                <td>
                                                    {{ $clientEmail }}
                                                </td> --}}
                                                <td>{{$salesreport_data->prov_sum}}</td>
                                                <td>{{$salesreport_data->margin_amount}}</td>
                                                
                                                <td>

                                                    @php
                                                        if(isset($quotation_attribute)){
                                                            if (isset($quotation_attribute->vat_charge) && $quotation_attribute->vat_charge == 1){
                                                                $vatAmount = $salesreport_data->prov_sum + $salesreport_data->margin_amount;
                                                                $vat = ($vatAmount * 5) / 100;
                                                            }else{
                                                                $vat = 0;
                                                            }
                                                        }else{
                                                            $vat = 0;
                                                        }
                                                        
                                                    @endphp
                                                    {{ $vat }}
                                                </td>
                                                <td>{{$salesreport_data->grand_total}}</td>
                                                <td>
                                                    @php
                                                        $EXPMAT = $expense + $material;
                                                    @endphp
                                                    {{ number_format($EXPMAT, 2) }}
                                                </td>
                                                {{-- <td>{{$expense}}</td> --}}
                                                {{-- <td>{{$material}}</td> --}}
                                                @php
                                                    $totalProfit = $salesreport_data->grand_total - $expense - $material;
                                                @endphp
                                                <td>{{ number_format($totalProfit, 2) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <span style="float: left;"> </span>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            @if(!empty($salesperson_data))
           
        
                <div class="col-md-12" style="margin-top: 24px;margin-bottom: 50px;">
                    <strong class="customer-text" style="font-size: 18px;color:#272b41;">
                         Details
                    </strong>
                    <div class="table-responsive">
                        <table class="invoice-table table table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center">Sales Person</th>
                                    <th class="text-center">Total Amount</th>
                                    <th class="text-center">Total Expense + Material</th>
                                    <th class="text-center">Total Profit</th>
                                </tr>
                            </thead>
                            <tbody>

                                @php
                                    $subTotalAmount = 0;
                                    $subTotalExpense = 0;
                                    $subTotalMaterial = 0;
                                    $subTotalProfit = 0;
                                @endphp
                                @foreach($salesperson_data as $salesperson)

                                {{-- Only show the selected salesperson if the filter is applied --}}
                                    @if(!empty($salespersonsFilter) && $salespersonsFilter != $salesperson->id)
                                     @continue
                                    @endif
                                    @php
                                        $totalAmount = 0;
                                        $totalExpense = 0;
                                        $totalMaterial = 0;
                                        $totalProfit = 0;
                                        $EXPMAT = 0;
                                        $hasSales = false;
                            
                                        foreach($salesreport as $salesreport_data) {
                                            if($salesreport_data->assign_to == $salesperson->id) {
                                                $hasSales = true;
                            
                                                $quotation_attribute = DB::table('quotation_attribute')
                                                    ->where('enquiry_id', $salesreport_data->id)
                                                    ->first();
                            
                                                $expense = DB::table('expense_inquiry')
                                                    ->where('inquiry_id', $salesreport_data->id)
                                                    ->sum('expense_value');
                            
                                                $material = DB::table('quotation_packing_materials')
                                                    ->where('enquiry_id', $salesreport_data->id)
                                                    ->sum('price_cost');
                            
                                                $totalAmount += $salesreport_data->grand_total;
                                                $totalExpense += $expense;
                                                $totalMaterial += $material;
                                            }
                                        }
                            
                                        $EXPMAT = $totalExpense + $totalMaterial;
                                        $totalProfit = $totalAmount - $EXPMAT;
                                    @endphp
                                <tr>
                                    <td class="text-center">{{ $salesperson->name }}</td>
                                    <td class="text-center">{{ $hasSales ? $totalAmount : 0 }}</td>
                                    <td class="text-center">{{ $hasSales ? $EXPMAT : 0 }}</td>
                                    <td class="text-center">{{ $hasSales ? $totalProfit : 0 }}</td>
                                </tr>
                                @php
                                    $subTotalAmount += $totalAmount;
                                    $subTotalExpense += $totalExpense;
                                    $subTotalMaterial += $totalMaterial;
                                    $subTotalProfit += $totalProfit;

                                @endphp
                                @endforeach

                                <tr>
                                    <td class="text-center">Total</td>
                                    <td class="text-center">{{ $subTotalAmount }}</td>
                                    <td class="text-center">{{ $subTotalExpense + $subTotalMaterial }}</td>
                                    <td class="text-center">{{ $subTotalProfit }}</td>
                                </tr>
                                @endif

                                
                            </tbody>
                        </table>
                    </div>
                </div>
           
        
        </div>
    </div>


@stop
@section('footer_js')
    
@stop
