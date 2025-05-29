@extends('admin.includes.Template')
@section('content')
    <style type="text/css">
        .hidden{
            display: none;
        }
        ul li {
            list-style: inherit;
        .checkbox-color{
            color: #0f548e !important;
        }
        input[type="checkbox"] {
            accent-color: #0f548e; /* Set the desired color */
        }
        }
        .table > tbody > tr > td {
            padding: 2px;
        }
        .table-responsive .form-control {
        padding: 2px;
        }
        .card-body{
            padding: 10px 5px;
        }
        .bg-color{
            background-color: #ccc;
            pointer-events: none; /* Disable any interaction */
            cursor: not-allowed; /* Change cursor to indicate no interaction */
        }
        .dollar-sign-btn{
            margin-left: 90%;
            cursor: pointer;
        }
        .dollar-sign:hover{
            background: #3484C3;
            color: #fff;
        }
        .similar-rate-model{
            max-width: 85% !important;
        }
        .similar-rate-model table thead th{
            background: #3484C3;
            color: #fff;
        }
        .similar-rate-model .table > tbody > tr > td {
            padding: 10px;
        }
        .similar-rate-model .modal-body h5{
            color: #3484C3;
        }
        #similar_rate_model .close {
            background-color: #3484C3 !important;
            border-color: #3484C3;
            border-radius: 50%;
            color: #fff;
            font-size: 13px;
            height: 25px;
            line-height: 20px;
            margin: 0;
            opacity: 1;
            padding: 0;
            position: absolute;
            right: 10px;
            top: 10px;
            width: 25px;
            z-index: 99;
        }
        .activities-tab-content{
            display: none;
        }
        .loader {
            display: block;
            margin: 0 auto;
            width: 80px;
            height: 80px;
            background: url('{{ asset('public/admin/assets/img/loader.gif') }}') repeat center center;
            background-size: contain;
        }
        .loader {
            display: none;
        }
        .activities-tab-content .table-hover tbody tr.no-hover:hover {
            background-color: #000;
        }
        .checkbox-color {
            color: #0f548e !important;
        }
        table thead th {
            background-color: #3484C3;
            color: #fff;
        }
        #terms_condition_fields .nav-tabs{
            width: 67%;
        }
        #terms_condition_fields .nav-tabs.nav-tabs-solid > li > a {
            color: #333 !important;
            padding: 10px 23px !important;
        }
        #terms_condition_fields .nav-tabs.nav-tabs-solid > li > a.active, .nav-tabs.nav-tabs-solid > li > a.active:hover, .nav-tabs.nav-tabs-solid > li > a.active:focus {
            background-color: #3484C3 !important;
            border-color: #3484C3 !important;
            color: #fff !important;
            padding: 10px 23px !important;
        }
    </style>
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Quotation</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('quote.index') }}">Quotation</a></li>
                        <li class="breadcrumb-item active">Add Quotation</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Page Header -->
        @if ($message = Session::get('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <strong>Success!</strong> {{ $message }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        <div id="validate" class="alert alert-danger alert-dismissible fade show" style="display: none;">
            <span id="login_error"></span>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <!-- <h4 class="card-title">Basic Info</h4> -->
                        <form id="survey_form" action="{{ route('qoutation.store') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="action" value="add-qoutation">
                            <input id="enquiry_hidden_id" name="enquiry_hidden_id" type="hidden" class="form-control"
                        value="{{ $followup_data->id }}"/>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="name">Quotation ID:</label>
                                        <input id="quote_id" name="quote_id" type="text" class="form-control"
                                            value="{{ $followup_data->quote_id }}"  readonly/>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="name">Enquiry ID:</label>
                                        <input id="inquiry_id" name="inquiry_id" type="text" class="form-control"
                                            value="{{ $followup_data->quote_no }} "  readonly/>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="survey_id">Survey ID:</label>
                                        <input id="survey_id" name="survey_id" type="text" value="{{ isset($followup_data->survey_id) ? $followup_data->survey_id : '' }}" class="form-control"  readonly/>
                                    </div>
                                </div>
                                <div class="form-group col-lg-4">
                                    <label for="name">Date</label>
                                    <input id="quotation_date" name="quotation_date" type="text" class="form-control"
                                        value="{{ $quotation_data->quotation_date ?? date("Y-m-d") }}"
                                        placeholder="Enter Date" />
                                </div>
                                <div class="form-group col-lg-4">
                                    <label for="name">Branch</label>
                                    <select name="branch" id="branch" class="form-control form-select select" disabled>
                                        <option value="">Select Branch</option>
                                        @foreach($branch_data as $data)
                                            <option value="{{ $data->id }}" {{ $data->id == $followup_data->branch ? 'selected' : '' }}>
                                                {{ $data->branch }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="client_box"><b class="checkbox-color">Client Details:</b></label>
                                </div>
                                <div id="client_fields">
                                    <div class="row client-section-corporate">
                                        @if($followup_data->customer_type == '2')
                                        <div class="form-group col-lg-4">
                                            <label for="name">Name:</label>
                                            <select name="agent_id" id="agent_id" class="form-select select" onchange="getVendorDetails(this.value);" disabled>
                                                <option value="">Select Name</option>
                                                @foreach($organization_name as $agent_name)
                                                <option value="{{ $agent_name->id }}" @if ($agent_name->id == $followup_data->agent_id) {{ 'selected' }} @endif>{{ $agent_name->company_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-lg-4">
                                            <label for="name">Email :</label>
                                            <input id="customer_email" name="customer_email" type="input" class="form-control client_fields_val_blank"
                                                value="{{ $followup_data->customer_email }}" readonly/>
                                        </div>
                                        <div class="form-group col-lg-4">
                                            <label for="name">Mobile :</label>
                                            <input id="customer_phone1" name="customer_phone1" type="input" class="form-control client_fields_val_blank"
                                                value="{{ $followup_data->customer_phone1 }}" onclick="validateNumber();" readonly/>
                                        </div>
                                        <div class="form-group col-lg-4">
                                            <label for="name">Phone :</label>
                                            <input id="customer_phone2" name="customer_phone2" type="input" class="form-control client_fields_val_blank"
                                                value="{{ $followup_data->customer_phone2 }}" onclick="validateNumber();" readonly />
                                        </div>
                                    @else
                                        <div class="form-group col-lg-4">
                                            <label for="name">Name:</label>
                                            <input type="text" name="f_name" id="f_name" class="form-control cst_val_blank" placeholder="Enter First Name" value="{{$followup_data->f_name}}" readonly>
                                        </div>
                                        <div class="form-group col-lg-4">
                                            <label for="name">Email:</label>
                                            <input type="text" name="c_email" id="c_email" class="form-control cst_val_blank" placeholder="Enter Email" value="{{$followup_data->c_email}}" readonly>
                                        </div>
                                        <div class="form-group col-lg-4">
                                            <label for="name">Mobile:</label>
                                            <input type="text" name="c_mobile" id="c_mobile" class="form-control cst_val_blank" placeholder="Enter Mobile Number" value="{{$followup_data->c_mobile}}" readonly>
                                        </div>
                                        <div class="form-group col-lg-4">
                                            <label for="name">Phone:</label>
                                            <input type="text" name="c_phone" id="c_phone" class="form-control cst_val_blank" placeholder="Enter Phone Number" value="{{ $followup_data->c_phone }}" readonly>
                                        </div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="client_box"><b class="checkbox-color">Address Detail:</b></label>
                                </div>
                                <div class="row">
                                    <div class="form-group col-lg-6">
                                        <label for="name">Payment By</label>
                                        <div class="mt-2">
                                            <input type="radio" name="payment_by" id="payment_by_self" value="Self" @if(isset($quotation_data) && $quotation_data->payment_by == "Self") checked @endif> <label for="payment_by_self" checked> Self</label>&nbsp;&nbsp;&nbsp;
                                            <input type="radio" name="payment_by" id="payment_by_corporate" value="Corporate" @if(isset($quotation_data) && $quotation_data->payment_by == "Corporate") checked @endif> <label for="payment_by_corporate"> Corporate</label>
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label for="name">Address:</label>
                                       <select name="quote_customer_address" id="quote_customer_address" class="form-control form-select select">
                                        <option value="">Select</option>
                                        <option value="{{ $originFullAddress }}" @if(isset($quotation_data) && $quotation_data->quote_customer_address == $originFullAddress) selected @endif>{{ $originFullAddress }}</option>
                                        <option value="{{ $destinationFullAddress }}" @if(isset($quotation_data) && $quotation_data->quote_customer_address == $destinationFullAddress) selected @endif>{{ $destinationFullAddress }}</option>
                                       </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="checkbox" id="costing_detail_box" name="costing_detail_box" onchange="clientvisibility()" value="0" @if($followup_data->costing_id != '') checked @endif>
                                        <label for="costing_detail_box"><b class="checkbox-color">Costing Details:</b></label>
                                </div>
                                <div id="costing_detail_fields" class="hidden">
                                    <div class="row">
                                        <div class="form-group col-lg-4">
                                            <label for="name">Costing ID:</label>
                                            <input id="costing_format_id" name="costing_format_id" type="text"
                                                class="form-control" placeholder="Enter Costing ID"
                                                value="{{ $followup_data->costing_id }}" readonly/>
                                        </div>
                                        <div class="form-group col-lg-4">
                                            <label for="origin_desti_address">Origin & Destination:</label>
                                            <select name="origin_desti_address" id="origin_desti_address" class="form-control form-select select" disabled>
                                                <option value="{{ $origin_and_desti }}">{{ $origin_and_desti }}</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-lg-4">
                                            <label for="service_id">Service Type</label>
                                            <select name="service_id" id="service_id" class="form-control select">
                                                <option value=""> Select Shipment Mode</option>
                                                @foreach ($service_data as $service)
                                                    <option value="{{ $service->id }}"
                                                        @if ($service->id == $followup_data->service_id) {{ 'selected' }} @endif>
                                                        {{ $service->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-lg-4">
                                            <label for="shipment_type">Shipment Type</label>
                                            <select id="shipment_type" name="shipment_type" class="form-control select">
                                                <option value="">Select Shipment Type</option>
                                                @foreach($shipment_type as $shipment)
                                                    <option value="{{$shipment->id}}" @if($followup_data->shipment_type == $shipment->id) selected @endif>{{$shipment->name}}</option>
                                                @endforeach
                                                </select>
                                        </div>
                                        <div class="form-group col-lg-12">
                                            <label for="costing_detail_box"><b class="checkbox-color">Costing Details:</b></label>
                                            <div class="table-responsive mt-4">
                                                <table class="table table-center table-hover">
                                                    <thead style="background-color:#3484C3">
                                                        <tr>
                                                            <th>Description</th>
                                                            <th>Selling Cost</th>
                                                            <th>Qty</th>
                                                            <th>Selling Sum</th>
                                                            <th>Total</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if($costing_attribute !="" && count($costing_attribute) > 0 && !empty($costing_attribute))
                                                            @foreach ($costing_attribute as $i => $costing)
                                                            <input type="hidden" name="updateid1xxx[]"
                                                                                 id="updateid1xxx{{ $i + 1 }}"
                                                                                 value="{{ $costing->id }}">
                                                                <tr>
                                                                    <td style="width:25%;">
                                                                        {{-- 1 --}}
                                                                        <input type="text" class="form-control" id="description" name="descriptionu[]" value="{{ $costing->description }}">
                                                                    </td>
                                                                    <td style="width:7%;">
                                                                        <input type="number" class="form-control" id="selling" name="sellingu[]" value="{{ $costing->prov ?? "" }}" readonly>
                                                                    </td>
                                                                    <td style="width:5%;">
                                                                        <input type="number" class="form-control qty" id="qty" name="qtyu[]" value="{{ $costing->qty ?? "" }}" readonly>
                                                                    </td>
                                                                    <td style="width:7%;">
                                                                        <input type="number" class="form-control" id="selling_sum" name="selling_sumu[]" value="{{ $costing->selling_sum ?? "" }}" readonly>
                                                                    </td>
                                                                    <td style="width:10%;">
                                                                        <input type="number" class="form-control" id="total" name="totalu[]" value="{{ $costing->total ?? "" }}" readonly>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-form-label col-md-4">Provisional Sum : </label>
                                                <div class="col-md-5">
                                                    <input type="number" class="form-control" name="prov_sum" id="prov_sum" value="{{ isset($followup_data->prov_sum) ? $followup_data->prov_sum : "" }}" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-form-label col-md-4">Selling Sum : </label>
                                                <div class="col-md-5">
                                                    <input type="text" class="form-control" name="selling_amount"  id="selling_amount" value="{{ isset($followup_data->selling_amount) ? $followup_data->selling_amount : "" }}" onkeypress="return validateNumber(event)">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <input type="checkbox" name="include_insurance" id="include_insurance" value="1"
                                                    @if(isset($quotation_data) && $quotation_data->include_insurance == "1") checked @endif>
                                                <label for="include_insurance">Include Insurance?</label>
                                            </div>
                                            <div class="form-group">
                                                <input type="checkbox" name="vat_charge" id="vat_charge" value="1"
                                                    @if(isset($quotation_data) && $quotation_data->vat_charge == "1") checked @endif>
                                                <label for="vat_charge">VAT ( 5% )</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-form-label col-md-4"><b>Grand Total :</b></label>
                                                <div class="col-md-5">
                                                    <input type="text" class="form-control" name="grand_total"  id="grand_total" value="{{ isset($followup_data->grand_total) ? $followup_data->grand_total : "" }}" onkeypress="return validateNumber(event)">
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" name="newgrandtotal" id="newgrandtotal" value="{{ isset($followup_data->grand_total) ? $followup_data->grand_total : "" }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="checkbox" id="shipping_detail_box" name="shipping_detail_box" onchange="shippingVisibility()" value="0"
                                        @if(isset($quotation_data) && $quotation_data->shipping_detail_box == "0") checked @endif>
                                    <label for="shipping_detail_box"><b class="checkbox-color">Shipping & Agent Outsourcing Details:</b></label>
                                </div>
                                <div id="shipping_detail_fields" class="hidden">
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label for="name">Packing/Move Date :</label>
                                                <input id="packing_move_date" name="packing_move_date" type="text"
                                                    class="form-control" placeholder="Select Packing/Move Date"
                                                    value="{{ $quotation_data->packing_move_date ?? "" }}" autocomplete="off"/>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label for="name">Pack Date To :</label>
                                                <input id="pack_date_to" name="pack_date_to" type="text"
                                                    class="form-control" placeholder="Select Pack Date To"
                                                    value="{{ $quotation_data->pack_date_to ?? "" }}" autocomplete="off"/>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label for="name">Load Date :</label>
                                                <input id="load_date" name="load_date" type="text"
                                                    class="form-control" placeholder="Select Load Date"
                                                    value="{{ $quotation_data->load_date ?? "" }}" autocomplete="off"/>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label for="name">Est. Delivery Date :</label>
                                                <input id="est_delivery_dt" name="est_delivery_dt" type="text"
                                                    class="form-control" placeholder="Select Est. Delivery Date"
                                                    value="{{ $quotation_data->est_delivery_dt ?? "" }}" autocomplete="off"/>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label for="name">ETA :</label>
                                                <input id="shipping_eta" name="shipping_eta" type="text"
                                                    class="form-control" placeholder="Enter ETA"
                                                    value="{{ $quotation_data->shipping_eta ?? "" }}"/>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label for="name">ETD :</label>
                                                <input id="shipping_etd" name="shipping_etd" type="text"
                                                    class="form-control" placeholder="Enter ETD"
                                                    value="{{ $quotation_data->shipping_etd ?? "" }}"/>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label for="name">POL :</label>
                                                <input id="shipping_pol" name="shipping_pol" type="text"
                                                    class="form-control" placeholder="Enter POL"
                                                    value="{{ $quotation_data->shipping_pol ?? "" }}"/>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label for="name">POD :</label>
                                                <input id="shipping_pod" name="shipping_pod" type="text"
                                                    class="form-control" placeholder="Enter POD"
                                                    value="{{ $quotation_data->shipping_pod ?? "" }}"/>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label for="name">MBL :</label>
                                                <input id="shipping_mbl" name="shipping_mbl" type="text"
                                                    class="form-control" placeholder="Enter MBL"
                                                    value="{{ $quotation_data->shipping_mbl ?? "" }}"/>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label for="name">HBL :</label>
                                                <input id="shipping_hbl" name="shipping_hbl" type="text"
                                                    class="form-control" placeholder="Enter HBL"
                                                    value="{{ $quotation_data->shipping_hbl ?? "" }}"/>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label for="name">Vessel Name :</label>
                                                <input id="shipping_vessel_name" name="shipping_vessel_name" type="text"
                                                    class="form-control" placeholder="Enter Vessel Name"
                                                    value="{{ $quotation_data->shipping_vessel_name ?? "" }}"/>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label for="name">Vessel No :</label>
                                                <input id="shipping_vessel_no" name="shipping_vessel_no" type="text"
                                                    class="form-control" placeholder="Enter Vessel No"
                                                    value="{{ $quotation_data->shipping_vessel_no ?? "" }}"/>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label for="name">Vessel Schedule :</label>
                                                <input id="shipping_vessel_schedule" name="shipping_vessel_schedule" type="text"
                                                    class="form-control" placeholder="Enter Vessel Schedule"
                                                    value="{{ $quotation_data->shipping_vessel_schedule ?? "" }}"/>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label for="name">Route :</label>
                                                <input id="shipping_route" name="shipping_route" type="text"
                                                    class="form-control" placeholder="Enter Route"
                                                    value="{{ $quotation_data->shipping_route ?? "" }}"/>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label for="name">Scope Of Work :</label>
                                                <input id="shipping_scope_work" name="shipping_scope_work" type="text"
                                                    class="form-control" placeholder="Enter Scope Of Work"
                                                    value="{{ $quotation_data->shipping_scope_work ?? "" }}"/>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label for="name">Freight Term :</label>
                                                <input id="shipping_freight_term" name="shipping_freight_term" type="text"
                                                    class="form-control" placeholder="Enter Freight Term"
                                                    value="{{ $quotation_data->shipping_freight_term ?? "" }}"/>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label for="name">Place Of Acceptance :</label>
                                                <input id="shipping_place_of_accept" name="shipping_place_of_accept" type="text"
                                                    class="form-control" placeholder="Enter Place Of Acceptance"
                                                    value="{{ $quotation_data->shipping_place_of_accept ?? "" }}"/>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label for="name">Date Of Acceptance :</label>
                                                <input id="shipping_date_of_accept" name="shipping_date_of_accept" type="text"
                                                    class="form-control" placeholder="Enter Date Of Acceptance"
                                                    value="{{ $quotation_data->shipping_date_of_accept ?? "" }}"/>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label for="name">Place Of Delivery :</label>
                                                <input id="shipping_place_of_delivery" name="shipping_place_of_delivery" type="text"
                                                    class="form-control" placeholder="Enter Place Of Delivery"
                                                    value="{{ $quotation_data->shipping_place_of_delivery ?? "" }}"/>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label for="name">On Board Date :</label>
                                                <input id="shipping_board_date" name="shipping_board_date" type="text"
                                                    class="form-control" placeholder="Enter Date Of Acceptance"
                                                    value="{{ $quotation_data->shipping_board_date ?? "" }}" autocomplete="off"/>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label for="name">Place Of Receipt :</label>
                                                <input id="shipping_place_of_receipt" name="shipping_place_of_receipt" type="text"
                                                    class="form-control" placeholder="Enter Place Of Receipt"
                                                    value="{{ $quotation_data->shipping_place_of_receipt ?? "" }}"/>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label for="name">Date Of Delivery:</label>
                                                <input id="shipping_date_of_delivery" name="shipping_date_of_delivery" type="text"
                                                    class="form-control" placeholder="Select Date Of Delivery"
                                                    value="{{ $quotation_data->shipping_date_of_delivery ?? "" }}"/>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label for="name">Collection From :</label>
                                                <input id="shipping_collection_from" name="shipping_collection_from" type="text"
                                                    class="form-control" placeholder="Enter Collection From"
                                                    value="{{ $quotation_data->shipping_collection_from ?? "" }}"/>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label for="name">Destination City:</label>
                                                <input id="shipping_destination_city" name="shipping_destination_city" type="text"
                                                    class="form-control" placeholder="Enter Destination City"
                                                    value="{{ $quotation_data->shipping_destination_city ?? "" }}"/>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label for="name">Detention Free Time <br/> (Days) :</label>
                                                <input id="shipping_detention_free_time" name="shipping_detention_free_time" type="text"
                                                    class="form-control" placeholder="Enter Detention Free Time"
                                                    value="{{ $quotation_data->shipping_detention_free_time ?? "" }}"/>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label for="name">Delivery To:</label>
                                                <input id="shipping_delivery_to" name="shipping_delivery_to" type="text"
                                                    class="form-control" placeholder="Enter Delivery To"
                                                    value="{{ $quotation_data->shipping_delivery_to ?? "" }}"/>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label for="name">Frequency /Transit Time (in days):</label>
                                                <input id="shipping_delivery_to" name="shipping_delivery_to" type="text"
                                                    class="form-control" placeholder="Enter Frequency /Transit Time (in days)"
                                                    value="{{ $quotation_data->shipping_delivery_to ?? "" }}"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="checkbox" id="terms_condition_box" name="terms_condition_box" onchange="termConditionVisibility()" value="0" @if(isset($quotation_data) && $quotation_data->terms_condition_box == "0") checked @endif>
                                    <label for="terms_condition_box"><b class="checkbox-color">Terms & Conditions:</b></label>
                            </div>
                            <div id="terms_condition_fields" class="hidden">
                                <div class="col-md-12">
                                    <div>
                                        <ul class="nav nav-tabs nav-tabs-solid nav-tabs-rounded nav-justified">
                                            <li class="nav-item"><a class="nav-link active" href="#solid-rounded-justified-tab1" data-bs-toggle="tab">Cover Letter</a></li>
                                            <li class="nav-item"><a class="nav-link" href="#solid-rounded-justified-tab2" data-bs-toggle="tab">Term & Conditions</a></li>
                                            <li class="nav-item"><a class="nav-link" href="#solid-rounded-justified-tab3" data-bs-toggle="tab">Footer</a></li>
                                            <li class="nav-item"><a class="nav-link" href="#solid-rounded-justified-tab4" data-bs-toggle="tab">Body Mail</a></li>
                                        </ul>
                                        <div class="tab-content">
                                            <div class="tab-pane show active" id="solid-rounded-justified-tab1">
                                                <div class="form-group col-lg-12">
                                                    <textarea type="text" id="cover_letter_desc" name="cover_letter_desc" class="form-control" placeholder="Enter Cover Letter">{{ $quotation_data->cover_letter_desc ?? $services_data->cover_letter ?? "" }}</textarea>
                                                </div>
                                            </div>
                                            <div class="tab-pane" id="solid-rounded-justified-tab2">
                                                <div class="form-group col-lg-12">
                                                    <textarea type="text" id="term_condition_desc" name="term_condition_desc" class="form-control" placeholder="Enter Term & Condition">{{ $quotation_data->term_condition_desc ?? $services_data->term_and_condittion ?? "" }}</textarea>
                                                </div>
                                            </div>
                                            @php
                                                $footerContent = $quotation_data->footer_desc ?? "";
                                                if($footerContent != "" && !empty($footerContent) && $footerContent != null){
                                                    $footer_desc = $quotation_data->footer_desc;
                                                }else{
                                                    $footer_desc = $footer_content;
                                                }
                                                $bodyContent = $quotation_data->body_mail ?? "";
                                                if($bodyContent != "" && !empty($bodyContent) && $bodyContent != null){
                                                    $bodyContentDesc = $quotation_data->body_mail;
                                                }else{
                                                    $bodyContentDesc = $body_mail_content;
                                                }
                                            @endphp
                                            <div class="tab-pane" id="solid-rounded-justified-tab3">
                                                <div class="form-group col-lg-12">
                                                    <textarea type="text" id="footer_desc" name="footer_desc" class="form-control" placeholder="Enter Footer">{{ $footer_desc }}</textarea>
                                                </div>
                                            </div>
                                            <div class="tab-pane" id="solid-rounded-justified-tab4">
                                                <div class="form-group col-lg-12">
                                                    <textarea type="text" id="body_mail" name="body_mail" class="form-control" placeholder="Enter Body Mail">{{ $bodyContentDesc }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="checkbox" id="general_info_box" name="general_info_box" onchange="generalInfoVisibility()" value="0" @if(isset($quotation_data) && $quotation_data->general_info_box == "0") checked @endif>
                                    <label for="general_info_box"><b class="checkbox-color">General Information:</b></label>
                            </div>
                            <div id="general_info_fields" class="hidden">
                                <div class="form-group row">
                                    <label class="col-form-label col-md-2">Base Currency</label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" value="AED" readonly>
                                    </div>
                                </div>
                               {{--  <div class="form-group row">
                                    <label class="col-form-label col-md-2">Show Option</label>
                                    <div class="col-md-6">
                                        <select name="show_option" id="show_option" class="form-control form-select select">
                                            <option value="" selected>3 Selected</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-md-2">Artical List</label>
                                    <div class="col-md-6">
                                        <input type="radio" id="artical_list_none" name="artical_list" value="AED" @if(isset($quotation_data) && $quotation_data->artical_list == "AED") checked @endif> <label for="artical_list_none"> None</label>
                                        <input type="radio" id="artical_list_vol_1" name="artical_list" value="Without Volume" @if(isset($quotation_data) && $quotation_data->artical_list == "Without Volume") checked @endif> <label for="artical_list_vol_1"> Without Volume</label>
                                        <input type="radio" id="artical_list_vol_2" name="artical_list" value="With Volume" @if(isset($quotation_data) && $quotation_data->artical_list == "With Volume") checked @endif> <label for="artical_list_vol_2"> With Volume</label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-md-2">More Option</label>
                                    <div class="col-md-6">
                                        <select name="show_option" id="show_option" class="form-control form-select select">
                                            <option value="" >Select</option>
                                            <option value="Basic" @if(isset($quotation_data) && $quotation_data->show_option == "Basic") selected @endif>Basic</option>
                                            <option value="Advance" @if(isset($quotation_data) && $quotation_data->show_option == "Advance") selected @endif>Advance</option>
                                        </select>
                                    </div>
                                </div> --}}
                                <div class="form-group row">
                                    <label class="col-form-label col-md-2">Mail To Customer</label>
                                    <div class="col-md-6">
                                        <input type="radio" id="mail_yes" name="mail_to_customer" value="1" @if(isset($followup_data) && $followup_data->mail_to_customer == "1") checked @endif> <label for="mail_yes"> Yes</label>
                                        <input type="radio" id="mail_no" name="mail_to_customer" value="0" @if(isset($followup_data) && $followup_data->mail_to_customer == "0" || $followup_data->mail_to_customer == NULL) checked @endif> <label for="mail_no"> No</label>
                                    </div>
                                </div>
                                {{-- <div class="form-group row">
                                    <label class="col-form-label col-md-2">Status</label>
                                    <div class="col-md-6">
                                        <select name="status_id" id="status_id" class="form-control form-select gen_info_val_blank select">
                                            <option value="">Select Status</option>
                                            <option value="1" {{ $enquiry_status->status == '1' ? 'selected' : '' }}>Active</option>
                                            <option value="2" {{ $enquiry_status->status == '2' ? 'selected' : '' }}>Completed</option>
                                            <option value="3" {{ $enquiry_status->status == '3' ? 'selected' : '' }}>Followup</option>
                                            <option value="4" {{ $enquiry_status->status == '4' ? 'selected' : '' }}>Lost</option>
                                        </select>
                                    </div>
                                </div> --}}
                                <div class="form-group row">
                                    <label class="col-form-label col-md-2">Assign To</label>
                                    <div class="col-md-6">
                                        <select name="assign_to" id="assign_to" class="form-control form-select gen_info_val_blank select">
                                            <option value="">Select Assign To</option>
                                            @foreach($salesperson_data as $salesperson)
                                            <option value="{{ $salesperson->id }}" @if($salesperson->id == $followup_data->assign_to){{'selected'}} @endif>{{ $salesperson->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-md-2">Sales Note</label>
                                    <div class="col-md-6">
                                        <textarea name="sales_note" id="sales_note" class="form-control">@if(isset($quotation_data) && $quotation_data->sales_note != "") {{ $quotation_data->sales_note }} @endif</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="text-end mt-4">
                                    <a class="btn btn-primary" href="{{ route('quote.index') }}"> Cancel</a>
                                    <button class="btn btn-primary mb-1" type="button" disabled id="spinner_button"
                                        style="display: none;">
                                        <span class="spinner-border spinner-border-sm" role="status"
                                            aria-hidden="true"></span>
                                        Loading...
                                    </button>
                                    <button type="button" class="btn btn-primary"
                                        onclick="javascript:quote_validation()" id="submit_button">Submit</button>
                                    <!-- <input type="submit" name="submit" value="Submit" class="btn btn-primary"> -->
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
@section('footer_js')
    {{-- <script src="https://cdn.ckeditor.com/ckeditor5/35.4.0/classic/ckeditor.js"></script> --}}
    {{-- CKEditor CDN --}}
    <script>
        function quote_validation() {
            $('#spinner_button').show();
            $('#submit_button').hide();
            $('#survey_form').submit();
        }
        function setTodayDate() {
            const today = new Date();
            const formattedDate = today.toISOString().split('T')[0];
            document.getElementById('quote_date').value = formattedDate;
        }
        $(document).ready(function() {
            // Add a click event listener to elements with the 'price' class
            $('.dollar-sign').on('click', function() {
                $('#similar_rate_model').modal('show');
            });
            shippingVisibility();
            termConditionVisibility();
            generalInfoVisibility();
        });
        // window.onload = setTodayDate;
    </script>
     <script>
        function quoteinformationvisibilty() {
                const checkbox = document.getElementById('quote_info_box');
                const container = document.getElementById('quote_info_fields');
                if (checkbox.checked ) {
                    container.classList.remove('hidden');
                } else {
                    container.classList.add('hidden');
                }
            }
        </script>
    <script type="text/javascript">
        $(function() {
            $('#quotation_date').datepicker({
                format: 'yyyy-mm-dd', // Set the desired date format yyyy-mm-dd
                // autoclose: true,
                defaultDate: new Date(), // Default to the current date
                todayHighlight: true
            });
        });
        $(function() {
            $('#survey_date').datepicker({
                format: 'yyyy-mm-dd', // Set the desired date format yyyy-mm-dd
                // autoclose: true,
                todayHighlight: true
            });
        });
        $(function() {
            $('#quotetion_date').datepicker({
                format: 'yyyy-mm-dd', // Set the desired date format yyyy-mm-dd
                // autoclose: true,
                todayHighlight: true
            });
        });
        $(function() {
            $('#packing_move_date').datepicker({
                format: 'yyyy-mm-dd', // Set the desired date format yyyy-mm-dd
                // autoclose: true,
                todayHighlight: true
            });
        });
        $(function() {
            $('#pack_date_to').datepicker({
                format: 'yyyy-mm-dd', // Set the desired date format yyyy-mm-dd
                // autoclose: true,
                todayHighlight: true
            });
        });
        $(function() {
            $('#load_date').datepicker({
                format: 'yyyy-mm-dd', // Set the desired date format yyyy-mm-dd
                // autoclose: true,
                todayHighlight: true
            });
        });
        $(function() {
            $('#est_delivery_dt').datepicker({
                format: 'yyyy-mm-dd', // Set the desired date format yyyy-mm-dd
                // autoclose: true,
                todayHighlight: true
            });
        });
        $(function() {
            $('#shipping_date_of_accept').datepicker({
                format: 'yyyy-mm-dd', // Set the desired date format yyyy-mm-dd
                // autoclose: true,
                todayHighlight: true
            });
        });
        $(function() {
            $('#shipping_board_date').datepicker({
                format: 'yyyy-mm-dd', // Set the desired date format yyyy-mm-dd
                // autoclose: true,
                todayHighlight: true
            });
        });
        $(function() {
            $('#shipping_date_of_delivery').datepicker({
                format: 'yyyy-mm-dd', // Set the desired date format yyyy-mm-dd
                // autoclose: true,
                todayHighlight: true
            });
        });
    </script>
    <script>
    function validateNumber(event) {
        var key = window.event ? event.keyCode : event.which;
        if (event.keyCode === 8 || event.keyCode === 46) {
            return true;
        } else if (key < 48 || key > 57) {
            return false;
        } else {
            return true;
        }
    }
    window.onload = function() {
        // Set the checkbox to be checked by default
        const checkbox = document.getElementById('quote_info_box');
        checkbox.checked = true;  // Make sure it's checked
        // Call the function to update the visibility based on the checked state
        quoteinformationvisibilty();
        setTodayDate();
    };
    function clientvisibility() {
        const checkbox = document.getElementById('costing_detail_box');
        const container = document.getElementById('costing_detail_fields');
        if (checkbox.checked ) {
            container.classList.remove('hidden');
        } else {
            container.classList.add('hidden');
        }
    }
    function shippingVisibility() {
        const checkbox = document.getElementById('shipping_detail_box');
        const container = document.getElementById('shipping_detail_fields');
        if (checkbox.checked ) {
            container.classList.remove('hidden');
        } else {
            container.classList.add('hidden');
        }
    }
    function termConditionVisibility() {
        const checkbox = document.getElementById('terms_condition_box');
        const container = document.getElementById('terms_condition_fields');
        if (checkbox.checked ) {
            container.classList.remove('hidden');
        } else {
            container.classList.add('hidden');
        }
    }
    function generalInfoVisibility() {
        const checkbox = document.getElementById('general_info_box');
        const container = document.getElementById('general_info_fields');
        if (checkbox.checked ) {
            container.classList.remove('hidden');
        } else {
            container.classList.add('hidden');
        }
    }
    $(document).ready(function () {
        let costingId = $('#costing_format_id').val();
        // alert(costingId);
        if (costingId && costingId !== '') {
            $("#costing_detail_box").prop('checked', true);
            clientvisibility();
        }
    });
    $(document).ready(function () {
            // Attach the change event to the checkbox
        $('#vat_charge').on('change', function () {
            // Get the current grand total
            const grandTotal = parseFloat($('#grand_total').val());
            // Validate the grand total
            if (!isNaN(grandTotal) && grandTotal > 0) {
                let originalTotal = grandTotal; // Default value without VAT
                if ($(this).is(':checked')) {
                    // Add VAT when checked
                    let vatCharge = grandTotal * 5 / 100;
                    let total = grandTotal + vatCharge;
                    $('#grand_total').val(total.toFixed(2));
                    $('#newgrandtotal').val(total.toFixed(2));
                } else {
                    // Subtract VAT when unchecked
                    let vatCharge = grandTotal * 5 / 105; // Reverse VAT calculation
                    let total = grandTotal - vatCharge;
                    $('#grand_total').val(total.toFixed(2));
                    $('#newgrandtotal').val(total.toFixed(2));
                    // $('#grand_total').val(@json($followup_data->grand_total));
                }
            }
        });
        /* const grandTotal = parseFloat($('#grand_total').val());
        // alert("grandTotal = " + grandTotal);
            // Validate the grand total
            if (!isNaN(grandTotal) && grandTotal > 0) {
                let originalTotal = grandTotal; // Default value without VAT
                if ($('#vat_charge').is(':checked')) {
                    // Add VAT when checked
                    let vatCharge = (grandTotal * 5)  / 100;
                    let total = grandTotal + vatCharge;
                    $('#grand_total').val(total.toFixed(2));
                } else {
                    // Subtract VAT when unchecked
                    let vatCharge = grandTotal * 5 / 105; // Reverse VAT calculation
                    let total = grandTotal - vatCharge;
                    $('#grand_total').val(grandTotal.toFixed(2));
                    // $('#grand_total').val(@json($followup_data->grand_total));
                }
            } */
    });
    </script>
    <script src="{{ asset('public/admin/assets/ckeditor/build/ckeditor.js') }}"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/34.2.0/classic/ckeditor.js"></script>
    {{-- <script src="https://cdn.ckeditor.com/ckeditor5/35.4.0/classic/ckeditor.js"></script> --}}
    <script>
    ClassicEditor
            .create( document.querySelector( '#cover_letter_desc' ),{
                ckfinder: {
                    uploadUrl: "{{route('ckeditor.upload').'?_token='.csrf_token()}}",
                }
            })
            .catch( error => {
            } );
    ClassicEditor
            .create( document.querySelector( '#term_condition_desc' ),{
                ckfinder: {
                    uploadUrl: "{{route('ckeditor.upload').'?_token='.csrf_token()}}",
                }
            })
            .catch( error => {
            } );
    ClassicEditor
            .create( document.querySelector( '#footer_desc' ),{
                ckfinder: {
                    uploadUrl: "{{route('ckeditor.upload').'?_token='.csrf_token()}}",
                }
            })
            .catch( error => {
            } );
    ClassicEditor
            .create( document.querySelector( '#body_mail' ),{
                ckfinder: {
                    uploadUrl: "{{route('ckeditor.upload').'?_token='.csrf_token()}}",
                }
            })
            .catch( error => {
            } );
    </script>
@stop
