@extends('admin.includes.Template')
@section('content')
<style>
    .hidden {
     display: none;
 }
 #allowance_table,th,td{
     border: 1px solid black;
 }
 #allowance_table{
     width: 50%;
 }
 .checkbox-color{
    color: #0f548e !important;
}
input[type="checkbox"] {
    accent-color: #0f548e; /* Set the desired color */
}
 </style>
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Edit Job Order</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('job-order.index') }}">Job Order</a></li>
                        <li class="breadcrumb-item active">Edit Job Order</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Page Header -->
        <div id="validate" class="alert alert-danger alert-dismissible fade show" style="display: none;">
            <span id="login_error"></span>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form id="category_form" action="{{ route('job-order.update', $followup->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="form-group col-lg-4">
                                    <label for="name">Job Order ID</label>
                                    <input id="quote_no" name="quote_no" type="text" class="form-control"
                                        placeholder="Enter Packing Management Name" value="{{ $followup->job_order_id }}"
                                        readonly/>
                                    <p class="form-error-text" id="quote_no_error" style="color: red;"></p>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="name">Quotation ID:</label>
                                        <input id="quote_id" name="quote_id" type="text" class="form-control"
                                            value="{{ $followup->quote_id }}"  readonly/>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="name">Enquiry ID:</label>
                                        <input id="inquiry_id" name="inquiry_id" type="text" class="form-control"
                                            value="{{ $followup->quote_no }} "  readonly/>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="survey_id">Survey ID:</label>
                                        <input id="survey_id" name="survey_id" type="text" value="{{ isset($followup->survey_id) ? $followup->survey_id : '' }}" class="form-control"  readonly/>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="costing_id">Quotation Amount:</label>
                                        <input id="quotation_amount" name="quotation_amount" type="text" value="{{ isset($followup->grand_total) ? $followup->grand_total : "" }}" class="form-control"  readonly/>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="costing_id">Costing ID:</label>
                                        <input id="costing_id" name="costing_id" type="text" value="{{ isset($followup->costing_id) ? $followup->costing_id : '' }}" class="form-control"  readonly/>
                                    </div>
                                </div>
                                <div class="form-group col-lg-4">
                                    <label for="name">Customer Type:</label>
                                    <input type="hidden" name="customer_type" value="{{ $followup->customer_type }}">
                                    <select name="customer_type_dis" id="customer_type_dis" class="form-control form-select select" onchange="customerType(this.value);" disabled>
                                        <option value="">Select Customer Type</option>
                                        @foreach ($customer_type as $customer_type_data)
                                        <option value="{{ $customer_type_data->id }}"
                                            @if ($customer_type_data->id == $followup->customer_type) {{ 'selected' }} @endif>
                                    {{$customer_type_data->customer_type}}
                                        </option>
                                    @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-lg-4">
                                    <label for="name">Branch</label>
                                    <input type="hidden" name="branch" value="{{ $followup->branch }}">
                                    <select name="branch_dis" id="branch_dis" class="form-control form-select select" disabled>
                                        <option value="">Select Branch</option>
                                        @foreach($branch_data as $data)
                                            <option value="{{ $data->id }}" {{ $data->id == $followup->branch ? 'selected' : '' }}>
                                                {{ $data->branch }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-lg-6">
                                </div>

                                @if($followup->customer_type == 2)
                                <div class="form-group">
                                    <input type="checkbox" id="client_box" name="client_box" onchange="clientvisibility()" value="{{ $followup->client_box }}"  @if($followup->client_box == 0) checked disabled @endif>
                                        <label for="client_box"><b class="checkbox-color">Client Details:</b></label>
                                </div>
                                <div id="client_fields" class="hidden">
                                    <div class="row client-section-corporate">
                                        <div class="form-group col-lg-6">
                                            <label for="name">Name:</label>
                                            <select name="agent_id" id="agent_id" class="form-select select" disabled>
                                                <option value="">Select Name</option>
                                                @foreach($organization_name as $agent_name)
                                                <option value="{{ $agent_name->id }}" @if ($agent_name->id == $followup->agent_id) {{ 'selected' }} @endif>{{ $agent_name->company_name }}</option>
                                                @endforeach
                                            </select>

                                        {{--  <input id="company_name" name="company_name" type="input" class="form-control client_fields_val_blank"
                                                placeholder="Enter Company Name"
                                            value="{{ $followup->company_name }}"/> --}}
                                            <p class="form-error-text" id="company_name_error" style="color: red;"></p>
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <label for="name">Title/Rank :</label>
                                            <select name="title_rank" id="title_rank" class="form-control form-select select client_fields_val_blank" disabled>
                                                <option value="">Select Title/Rank</option>
                                                @foreach($title_rank as $title_rank_data)
                                                <option value="{{$title_rank_data->id}}" @if($title_rank_data->id == $followup->title_rank){{'selected'}} @endif>
                                                {{$title_rank_data->title_rank}}
                                                </option>
                                                @endforeach
                                            </select>
                                            <p class="form-error-text" id="title_rank_error"
                                                style="color: red; margin-top: 10px;"></p>
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <label for="name">Phone :</label>
                                            <input id="customer_phone2" name="customer_phone2" type="input" class="form-control client_fields_val_blank"
                                                value="{{ $followup->customer_phone2 }}" onclick="validateNumber();" readonly/>
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <label for="name">Contact Person :</label>
                                            <select name="agent_attr_id" id="test_agent_attr_id" class="form-control form-select select client_fields_val_blank" disabled>
                                                    <option value="" selected>Select Contact Person</option>
                                                    @foreach ($agent_data as $agent)
                                                    <option value="{{ $agent->id }}" {{isset($followup->agent_attr_id) && $followup->agent_attr_id == $agent->id ? 'selected' : '' }}>
                                                        {{ $agent->name }} ( {{$agent->role}} )
                                                    </option>
                                                @endforeach
                                                </select>
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <label for="name">Mobile :</label>
                                            <input id="customer_phone1" name="customer_phone1" type="input" class="form-control client_fields_val_blank"
                                                value="{{ $followup->customer_phone1 }}" onclick="validateNumber();" readonly/>
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <label for="name">Email :</label>
                                            <input id="customer_email" name="customer_email" type="input" class="form-control client_fields_val_blank"
                                                value="{{ $followup->customer_email }}" readonly/>
                                        </div>

                                        <div class="form-group col-lg-12">
                                            <label for="name">Address:</label>
                                            <textarea name="address" id="address" cols="5" rows="5" class="form-control client_fields_val_blank"
                                                placeholder="Enter Address" readonly>{{$followup->address}}</textarea>
                                        </div>
                                </div>

                            </div>
                            @endif
                            @php
                               /*  echo "<pre>";print_r($followup->customer_form);echo "<pre>";
                                echo "<pre>";print_r($followup->customer_type);echo "<pre>"; */
                            @endphp
                            @if($followup->customer_form == 0 || $followup->customer_type == 1)
                            <div class="radio_show" id="customer_form_container">
                                <div class="form-group" >
                                    <input type="checkbox" id="customer_form" name="customer_form" onchange="individualvisibility()" value="{{ $followup->customer_form }}"  @if($followup->customer_form == 0) checked disabled @endif>
                                        <label for="client"><b class="checkbox-color">Individual Details:</b></label>
                                    </div>
                                    <div id="individual_fields" class="">
                                        <div class="row">
                                            <div class="form-group col-lg-6">
                                                <label for="name">Title/Rank:</label>
                                                <select name="customer_title_rank" id="customer_title_rank" class="form-control form-select select cst_val_blank" disabled>
                                                    <option value="">Select Title/Rank</option>
                                                    @foreach($title_rank as $title_rank_data)
                                                    <option value="{{$title_rank_data->id}}" @if($title_rank_data->id == $followup->customer_title_rank){{'selected'}} @endif>
                                                    {{$title_rank_data->title_rank}}
                                                    </option>
                                                    @endforeach
                                                </select>
                                                <p class="form-error-text" id="title_rank_error"
                                                    style="color: red; margin-top: 10px;"></p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-lg-4">
                                                <label for="name">First Name:</label>
                                                <input type="text" name="f_name" id="f_name" class="form-control cst_val_blank" placeholder="Enter First Name" value="{{$followup->f_name}}" readonly>
                                            </div>
                                            <div class="form-group col-lg-4">
                                                <label for="name">Middle Name:</label>
                                                <input type="text" name="m_name" id="m_name" class="form-control cst_val_blank" placeholder="Enter Middle Name" value="{{$followup->m_name}}" readonly>
                                            </div>
                                            <div class="form-group col-lg-4">
                                                <label for="name">Last Name:</label>
                                                <input type="text" name="l_name" id="l_name" class="form-control cst_val_blank" placeholder="Enter Last Name" value="{{$followup->l_name}}" readonly>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-lg-4">
                                                <label for="name">Mobile:</label>
                                                <input type="text" name="c_mobile" id="c_mobile" class="form-control cst_val_blank" placeholder="Enter Mobile Number" value="{{$followup->c_mobile}}" readonly>
                                            </div>
                                            <div class="form-group col-lg-4">
                                                <label for="name">Phone:</label>
                                                <input type="text" name="c_phone" id="c_phone" class="form-control cst_val_blank" placeholder="Enter Phone Number" value="{{$followup->c_phone}}" readonly>
                                            </div>
                                            <div class="form-group col-lg-4">
                                                <label for="name">Email:</label>
                                                <input type="text" name="c_email" id="c_email" class="form-control cst_val_blank" placeholder="Enter Email" value="{{$followup->c_email}}" readonly>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-lg-12">
                                                <label for="name">Address:</label>
                                                <input type="text" name="c_add" id="c_add" class="form-control cst_val_blank" placeholder="Enter Address" value="{{$followup->c_add}}" readonly>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="country">Country</label>
                                                    <select class="form-control form-select cst_val_blank select" id="c_country" name="c_country" disabled>
                                                        <option value="">Select country</option>
                                                        @foreach ($country_data as $country)
                                                    <option value="{{ $country->id }}"
                                                            {{ $country->id == $followup->c_country ? 'selected' : '' }}>
                                                            {{ $country->country }}</option>
                                                    @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group col-lg-6">
                                                <label for="name">City:</label>
                                                <input type="text" name="c_city" id="c_city" class="form-control cst_val_blank" placeholder="Enter City" value="{{$followup->c_city}}" readonly>
                                            </div>
                                        </div>
                                </div>
                                </div>
                                @endif
                                <div class="form-group" >
                                    <input type="checkbox" id="origin_desti_move" name="origin_desti_move" onchange="originmovevisibility()" value="{{ $followup->origin_desti_move }}" @if($followup->origin_desti_move == 0) checked disabled @endif>
                                        <label for="origin_desti_move"><b class="checkbox-color">Origin,Destination & Move Details:</b></label>
                                    </div>
                                    <div id="origin_desti_move_fields" class="hidden">
                                        <div class="row">
                                            <div class="form-group col-lg-4">
                                                <label for="name">Service Type</label>
                                                <select name="service_id" id="service_id" class="form-control form-select origin_desti_val_blank select" disabled>
                                                    <option value=""> Select Services Type</option>
                                                    @foreach ($service_data as $service)
                                                        <option value="{{ $service->id }}"
                                                            @if ($service->id == $followup->service_id) {{ 'selected' }} @endif>
                                                            {{ $service->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="Surveyor">Service Required:</label>
                                                    <select name="service_required" id="service_required" class="form-control form-select origin_desti_val_blank select" disabled>
                                                        <option value=""> Select Service Required</option>
                                                        @foreach ($services_required as $services)
                                                        <option value="{{ $services->id }}"
                                                            @if ($services->id == $followup->service_required) {{ 'selected' }} @endif>
                                                            {{ $services->name }}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                            <div class="form-group">
                                            <label for="Surveyor">Description Of Goods:</label>
                                            <select name="desc_of_goods" id="desc_of_goods" class="form-control form-select origin_desti_val_blank select" disabled>
                                                <option value="">Select Description Of Goods</option>
                                                @foreach ($goods_description as $goods_data)
                                                    <option value="{{ $goods_data->id }}"
                                                        @if ($goods_data->id == $followup->desc_of_goods) {{ 'selected' }} @endif>
                                                        {{ $goods_data->name }}
                                                    </option>
                                                @endforeach
                                            </select>

                                            </div>
                                            </div>
                                           {{--  <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="survey_req">Job Order Required ?</label>
                                                    <input type="checkbox" id="survey_req" name="survey_req" value="{{ $followup->survey_req }}"  @if($followup->survey_req == 0 && $followup->survey_req !== null) checked @endif>
                                                </div>
                                            </div> --}}
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                <label for="Surveyor">Survey Type:</label>
                                                <select name="survey_type" id="survey_type" class="form-control form-select origin_desti_val_blank select" disabled>
                                                    <option value=""> Select Survey Type</option>
                                                    @foreach ($surveyor_type as $surveyor_type_data)
                                                    <option value="{{ $surveyor_type_data->id }}" @if($surveyor_type_data->id == $followup->survey_type) {{'selected'}} @endif>
                                                        {{ $surveyor_type_data->surveyor_type }}
                                                    </option>
                                                @endforeach
                                                </select>
                                                <p class="form-error-text" id="survey_type_error"
                                                style="color: red; margin-top: 10px;"></p>
                                                </div>
                                            </div>
                                            @php
                                                if($followup->s_date != '0000-00-00'){
                                                    $survey_date = date("d/m/Y",strtotime($followup->s_date));
                                                }else{
                                                    $survey_date = '';
                                                }
                                            @endphp
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label for="name">Survey Date:</label>
                                                    <input type="text" name="s_date" id="s_date" class="form-control origin_desti_val_blank" placeholder="Enter Job Order Date" value="{{ $survey_date }}" readonly>
                                                </div>
                                            </div>

                                    <div class="row">
                                        <div class="col-lg-6"><b>Origin:/Pick up</b>
                                            <div class="form-group ">
                                                <label for="name">Address:</label>
                                                <input id="origin_add" name="origin_add" type="text" class="form-control origin_desti_val_blank"
                                                    placeholder="Enter Origin Address" value="{{$followup->origin_add}}" readonly/>
                                            </div>
                                            <div class="form-group">
                                                <label for="name">Country:</label>
                                                <select name="origin_country" id="origin_country" class="form-select form-control origin_desti_val_blank select" disabled/>
                                                <option value="">Select Country</option>
                                                @foreach ($country_data as $country)
                                                <option value="{{ $country->id }}"
                                                    {{ $country->id == $followup->origin_country ? 'selected' : '' }}>
                                                    {{ $country->country }}</option>
                                            @endforeach
                                            </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="name">State:</label>
                                                <input id="origin_state" name="origin_state" type="text" class="form-control origin_desti_val_blank"
                                                placeholder="Enter Origin State" value="{{$followup->origin_state}}" readonly/>
                                            </div>
                                            <div class="form-group">
                                                <label for="name">City:</label>
                                                <input id="origin_city" name="origin_city" type="text" class="form-control origin_desti_val_blank"
                                                placeholder="Enter Origin City" value="{{$followup->origin_city}}" readonly/>
                                            </div>
                                            <div class="form-group">
                                                <label for="name">Location:</label>
                                                <input id="origin_location" name="origin_location" type="text" class="form-control origin_desti_val_blank"
                                                placeholder="Enter Origin Location" value="{{$followup->origin_location}}" readonly/>
                                            </div>
                                            <div class="form-group">
                                                <label for="name">ZIP/POST Code:</label>
                                                <input id="origin_zip_post" name="origin_zip_post" type="text" class="form-control origin_desti_val_blank"
                                                placeholder="Enter Origin ZIP/POST Code"  value="{{$followup->origin_zip_post}}" readonly/>
                                            </div>
                                            <div class="form-group">
                                                <label for="name">POL :</label>
                                                <input id="shipping_pol" name="shipping_pol" type="text"
                                                    class="form-control" placeholder="Enter POL"
                                                    value="{{ $quotation_data->shipping_pol ?? "" }}"/>
                                            </div>
                                            <div class="form-group">
                                                <label for="name">Vessel Schedule :</label>
                                                <input id="shipping_vessel_schedule" name="shipping_vessel_schedule" type="text"
                                                    class="form-control" placeholder="Enter Vessel Schedule"
                                                    value="{{ $quotation_data->shipping_vessel_schedule ?? "" }}"/>
                                            </div>
                                            <div class="form-group">
                                                <label for="name">Scope Of Work :</label>
                                                <input id="shipping_scope_work" name="shipping_scope_work" type="text"
                                                    class="form-control" placeholder="Enter Scope Of Work"
                                                    value="{{ $quotation_data->shipping_scope_work ?? "" }}"/>
                                            </div>
                                            <div class="form-group">
                                                <label for="name">Place Of Acceptance :</label>
                                                <input id="shipping_place_of_accept" name="shipping_place_of_accept" type="text"
                                                    class="form-control" placeholder="Enter Place Of Acceptance"
                                                    value="{{ $quotation_data->shipping_place_of_accept ?? "" }}"/>
                                            </div>
                                            <div class="form-group">
                                                <label for="name">On Board Date :</label>
                                                <input id="shipping_board_date" name="shipping_board_date" type="text"
                                                    class="form-control" placeholder="Enter Date Of Acceptance"
                                                    value="{{ $quotation_data->shipping_board_date ?? "" }}" autocomplete="off"/>
                                            </div>
                                            <div class="form-group">
                                                <label for="name">Place Of Delivery :</label>
                                                <input id="shipping_place_of_delivery" name="shipping_place_of_delivery" type="text"
                                                    class="form-control" placeholder="Enter Place Of Delivery"
                                                    value="{{ $quotation_data->shipping_place_of_delivery ?? "" }}"/>
                                            </div>
                                            <div class="form-group">
                                                <label for="name">Place Of Issue :</label>
                                                <input id="place_of_issue"
                                                       name="place_of_issue"
                                                       type="text"
                                                       class="form-control"
                                                       placeholder="Enter Place Of Delivery"
                                                       value="{{ $quotation_data->place_of_issue ?? "" }}"
                                                />
                                            </div>
                                            <div class="form-group">
                                                <label for="name">Alternate No 1 :</label>
                                                <input id="origin_alternate_1"
                                                       name="origin_alternate_1"
                                                       type="text"
                                                       class="form-control"
                                                       placeholder="Enter Place Of Delivery"
                                                       value="{{ $quotation_data->origin_alternate_1 ?? "" }}"
                                                       onkeypress="return validateNumber(event)"
                                                />
                                            </div>
                                            <div class="form-group">
                                                <label for="name">Alternate No 2 :</label>
                                                <input id="origin_alternate_2"
                                                       name="origin_alternate_2"
                                                       type="text"
                                                       class="form-control"
                                                       placeholder="Enter Place Of Delivery"
                                                       value="{{ $quotation_data->origin_alternate_2 ?? "" }}"
                                                       onkeypress="return validateNumber(event)"
                                                />
                                            </div>
                                        </div>
                                        <div class="col-lg-6"><b>Destination:/Delivery</b>
                                            <div class="form-group">
                                                <label for="name">Address:</label>
                                                <input id="desti_add" name="desti_add" type="text" class="form-control origin_desti_val_blank"
                                                placeholder="Enter Destination Address" value="{{ $followup->desti_add }}" readonly/>
                                            </div>
                                            <div class="form-group">
                                                <label for="name">Country:</label>
                                                <select name="desti_country"
                                                        id="desti_country"
                                                        class="form-select select form-control origin_desti_val_blank" disabled/>
                                                        <option value="">Select Country</option>
                                                        @foreach ($country_data as $country)
                                                        <option value="{{ $country->id }}"
                                                            {{ $country->id == $followup->desti_country ? 'selected' : '' }}>
                                                            {{ $country->country }}</option>
                                                        @endforeach
                                            </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="name">State:</label>
                                                <input id="desti_state" name="desti_state" type="text" class="form-control origin_desti_val_blank"
                                                placeholder="Enter Destination State" value="{{ $followup->desti_state }}" readonly/>
                                            </div>
                                            <div class="form-group">
                                                <label for="name">City:</label>
                                                <input id="desti_city" name="desti_city" type="text" class="form-control origin_desti_val_blank"
                                                placeholder="Enter Destination City" value="{{ $followup->desti_city }}" readonly/>
                                            </div>
                                            <div class="form-group">
                                                <label for="name">Location:</label>
                                                <input id="desti_location" name="desti_location" type="text" class="form-control origin_desti_val_blank"
                                                placeholder="Enter Destination Location" value="{{$followup->desti_location}}" readonly/>
                                            </div>
                                            <div class="form-group">
                                                <label for="name">ZIP/POST Code:</label>
                                                <input id="desti_zip_post" name="desti_zip_post" type="text" class="form-control origin_desti_val_blank"
                                                placeholder="Enter Destination ZIP/POST Code" value="{{$followup->desti_zip_post}}" readonly/>
                                            </div>
                                            <div class="form-group">
                                                <label for="name">POD :</label>
                                                <input id="shipping_pod" name="shipping_pod" type="text"
                                                    class="form-control" placeholder="Enter POD"
                                                    value="{{ $quotation_data->shipping_pod ?? "" }}"/>
                                            </div>
                                            <div class="form-group">
                                                <label for="name">Route :</label>
                                                <input id="shipping_route" name="shipping_route" type="text"
                                                    class="form-control" placeholder="Enter Route"
                                                    value="{{ $quotation_data->shipping_route ?? "" }}"/>
                                            </div>
                                            <div class="form-group">
                                                <label for="name">Freight Term :</label>
                                                <input id="shipping_freight_term" name="shipping_freight_term" type="text"
                                                    class="form-control" placeholder="Enter Freight Term"
                                                    value="{{ $quotation_data->shipping_freight_term ?? "" }}"/>
                                            </div>
                                            <div class="form-group">
                                                <label for="name">Date Of Acceptance :</label>
                                                <input id="shipping_date_of_accept" name="shipping_date_of_accept" type="text"
                                                    class="form-control" placeholder="Enter Date Of Acceptance"
                                                    value="{{ $quotation_data->shipping_date_of_accept ?? "" }}" autocomplete="off"/>
                                            </div>
                                            <div class="form-group">
                                                <label for="name">B/L Status :</label>
                                                <input id="bl_status" name="bl_status" type="text"
                                                    class="form-control" placeholder="Enter B/L Status"
                                                    value="{{ $quotation_data->bl_status ?? "" }}"/>
                                            </div>
                                            <div class="form-group">
                                                <label for="name">No Of Original B/L :</label>
                                                <input id="no_of_original_bl" name="no_of_original_bl" type="text"
                                                    class="form-control" placeholder="Enter No Of Original B/L"
                                                    value="{{ $quotation_data->no_of_original_bl ?? "" }}"/>
                                            </div>
                                            <div class="form-group">
                                                <label for="name">Alternate No 1 :</label>
                                                <input id="desti_alternate_1" name="desti_alternate_1" type="text"
                                                    class="form-control" placeholder="Enter Alternate No 1"
                                                    value="{{ $quotation_data->desti_alternate_1 ?? "" }}" onkeypress="return validateNumber(event)" />
                                            </div>
                                            <div class="form-group">
                                                <label for="name">Alternate No 2 :</label>
                                                <input id="desti_alternate_2" name="desti_alternate_2" type="text"
                                                    class="form-control" placeholder="Enter Alternate No 2"
                                                    value="{{ $quotation_data->desti_alternate_2 ?? "" }}" onkeypress="return validateNumber(event)"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </div>
                                <div class="form-group">
                                    <input type="checkbox" id="planned_details" name="planned_details" onchange="plannedDetailvisibility()" value="{{$quotation_data->planned_details ?? 1 }}" @if($quotation_data->planned_details == 1) checked @endif>
                                        <label for="planned_details"><b class="checkbox-color">Planned:</b></label>
                                    </div>
                                    <div id="planned_details_fields" class="hidden">
                                    <div class="row">
                                        <div class="form-group col-lg-4">
                                            <label for="name">Pack Date From:</label>
                                            <input id="pack_date_from" name="packing_move_date" type="text"
                                                    class="form-control" placeholder="Select Pack Date From"
                                                    value="{{ $quotation_data->packing_move_date ?? "" }}" autocomplete="off"/>
                                        </div>
                                        <div class="form-group col-lg-4">
                                            <label for="name">Pack Date To:</label>
                                            <input id="pack_date_to" name="pack_date_to" type="text"
                                                    class="form-control" placeholder="Select Pack Date To"
                                                    value="{{ $quotation_data->pack_date_to ?? "" }}"  autocomplete="off"/>
                                        </div>
                                        <div class="form-group col-lg-4">
                                            <label for="name">Load Date:</label>
                                            <input id="load_date" name="load_date" type="text"
                                                    class="form-control" placeholder="Select Load Date"
                                                    value="{{ $quotation_data->load_date ?? "" }}"  autocomplete="off"/>

                                            <input id="load_time" name="load_time" type="time"
                                                    class="form-control" placeholder="Select Load Time"
                                                    value="{{ $quotation_data->load_time ?? "" }}"  autocomplete="off"/>
                                        </div>
                                        <div class="form-group col-lg-4">
                                            <label for="name">Dispatch Date:</label>
                                            <input id="dispatch_date" name="dispatch_date" type="text"
                                                    class="form-control" placeholder="Select Dispatch Date"
                                                    value="{{ $quotation_data->dispatch_date ?? "" }}"  autocomplete="off"/>
                                        </div>
                                        <div class="form-group col-lg-4">
                                            <label for="name">Arrival Date:</label>
                                            <input id="arrival_date" name="arrival_date" type="text"
                                                    class="form-control" placeholder="Select Arrival Date"
                                                    value="{{ $quotation_data->arrival_date ?? "" }}"  autocomplete="off"/>

                                            <input id="arrival_time" name="arrival_time" type="time"
                                                    class="form-control" placeholder="Select Arrival Time"
                                                    value="{{ $quotation_data->arrival_time ?? "" }}"  autocomplete="off"/>
                                        </div>
                                        <div class="form-group col-lg-4">
                                            <label for="name">Delivery Date:</label>
                                            <input id="delivery_date" name="delivery_date" type="text"
                                                    class="form-control" placeholder="Select Delivery Date"
                                                    value="{{ $quotation_data->delivery_date ?? "" }}"  autocomplete="off"/>
                                        </div>
                                    </div>
                                    </div>
                                    <div class="form-group">
                                        <input type="checkbox" id="transport_details" name="transport_details" onchange="transportDetailvisibility()" value="{{$quotation_data->transport_details ?? 1 }}" @if($quotation_data->transport_details == 1) checked @endif>
                                            <label for="transport_details"><b class="checkbox-color">Transport:</b></label>
                                        </div>
                                        <div id="transport_details_fields" class="hidden">
                                        <div class="row">
                                            <div class="form-group col-lg-4">
                                                <label for="name">Model:</label>
                                                <select name="service_id"
                                                            id="transport_model"
                                                            class="form-select select form-control transport_val_blank" disabled/>
                                                    <option value="">Select Model</option>
                                                    @foreach ($service_data as $service)
                                                    <option value="{{ $service->id }}"
                                                        {{ $service->id == $followup->service_id ? 'selected' : '' }}>
                                                        {{ $service->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group col-lg-4">
                                                <label for="name">Shipment Type:</label>
                                                <select name="shipment_type"
                                                            id="shipment_type"
                                                            class="form-select select form-control transport_val_blank" disabled/>
                                                    <option value="">Select Shipment Type</option>
                                                    @foreach ($shipment_type as $shipmentType)
                                                    <option value="{{ $shipmentType->id }}"
                                                        {{ $shipmentType->id == $followup->shipment_type ? 'selected' : '' }}>
                                                        {{ $shipmentType->name }}</option>
                                                    @endforeach
                                                </select>
                                                <input type="checkbox" name="isMultipleContainer" id="isMultipleContainer" @if($quotation_data->isMultipleContainer == 1) checked @endif> <label for="isMultipleContainer">IsMultiContainer</label>
                                            </div>
                                            <div class="form-group col-lg-4">
                                                <label for="name">Allowance:</label>
                                                    <select id="job_order_allowance" name="job_order_allowance" class="form-control form-select select">
                                                        <option value="" @if(($quotation_data->job_order_allowance ?? '') == '') selected @endif>Select Option</option>
                                                        <option value="CBM Net" @if(($quotation_data->job_order_allowance ?? '') == 'CBM Net') selected @endif>CBM Net</option>
                                                        <option value="LBS Net" @if(($quotation_data->job_order_allowance ?? '') == 'LBS Net') selected @endif>LBS Net</option>
                                                        <option value="CFT Net" @if(($quotation_data->job_order_allowance ?? '') == 'CFT Net') selected @endif>CFT Net</option>
                                                        <option value="KG Net" @if(($quotation_data->job_order_allowance ?? '') == 'KG Net') selected @endif>KG Net</option>
                                                        <option value="Metric Ton" @if(($quotation_data->job_order_allowance ?? '') == 'Metric Ton') selected @endif>Metric Ton</option>
                                                    </select>
                                            </div>
                                            <div class="form-group col-lg-4">
                                                <label for="transit_time">Transit Time (Days):</label>
                                                <input id="transit_time" name="transit_time" type="text"
                                                        class="form-control" placeholder="Enter Transit Time (Days)"
                                                        value="{{ $quotation_data->transit_time ?? "" }}"/>
                                            </div>
                                            <div class="form-group col-lg-4">
                                                <label for="vessel_no">Vessel No:</label>
                                                <input id="vessel_no" name="shipping_vessel_no" type="text"
                                                        class="form-control" placeholder="Enter Vessel No"
                                                        value="{{ $quotation_data->shipping_vessel_no ?? "" }}"/>
                                            </div>
                                            <div class="form-group col-lg-4">
                                                <label for="vessel_name">Vessel Name:</label>
                                                <input id="vessel_name" name="shipping_vessel_name" type="text"
                                                        class="form-control" placeholder="Enter Vessel Name"
                                                        value="{{ $quotation_data->shipping_vessel_name ?? "" }}"/>
                                            </div>
                                            <div class="form-group col-lg-4">
                                                <label for="shipping_mbl">MBL:</label>
                                                <input id="transport_mbl" name="shipping_mbl" type="text"
                                                        class="form-control" placeholder="Enter MBL"
                                                        value="{{ $quotation_data->shipping_mbl ?? "" }}"/>
                                            </div>
                                            <div class="form-group col-lg-4">
                                                <label for="container_no">Container No:</label>
                                                <input id="container_no"
                                                       name="container_no"
                                                       type="text"
                                                       class="form-control"
                                                       placeholder="Enter Container No"
                                                       value="{{ $quotation_data->container_no ?? "" }}"
                                                />
                                            </div>
                                            <div class="form-group col-lg-4">
                                                <label for="transport_hbl">HBL:</label>
                                                <input id="transport_hbl"
                                                       name="shipping_hbl"
                                                       type="text"
                                                       class="form-control"
                                                       placeholder="Enter HBL"
                                                       value="{{ $quotation_data->shipping_hbl ?? "" }}"
                                                />
                                            </div>
                                            <div class="form-group col-lg-4">
                                                <label for="track_id">Track ID:</label>
                                                <input id="track_id"
                                                       name="track_id"
                                                       type="text"
                                                       class="form-control"
                                                       placeholder="Enter Track ID"
                                                       value="{{ $quotation_data->track_id ?? "" }}"
                                                />
                                                <input type="checkbox" name="insurance" id="insurance" value="1" @if($quotation_data->insurance == 1) checked @endif><label for="insurance">Insurance</label>
                                            </div>
                                          </div>
                                    </div>
                                    <div class="form-group">
                                        <input type="checkbox" id="goods_details" name="planned_details" onchange="goodstDetailvisibility()" value="{{$quotation_data->goods_details ?? 0 }}" @if($quotation_data->goods_details == 1) checked @endif>
                                            <label for="goods_details"><b class="checkbox-color">Goods Details:</b></label>
                                        </div>
                                        <div id="goods_details_fields" class="hidden">
                                        <div class="row">
                                            <div class="form-group col-lg-6">
                                                <label for="name">Survey Volume:</label>
                                                <input type="text" id="survey_volume" name="survey_volume" class="form-control goods_val_blank" placeholder="Enter Survey Volume" value="{{ "159.00 CFT Net / 4.50 CBM Net" }}" readonly>
                                            </div>
                                            <div class="form-group col-lg-6">
                                                <label for="name">Survey Weight:</label>
                                                <input type="text" id="survey_weight" name="survey_weight" class="form-control goods_val_blank" placeholder="Enter Survey Weight" value="{{ "468.81 CFT Net / 1031.38 CBM Net" }}" readonly>
                                            </div>
                                            <div class="form-group col-lg-6">
                                                <label for="name">Quoted Volume:</label>
                                                <input type="text" id="survey_volume" name="survey_volume" class="form-control goods_val_blank" placeholder="Enter Survey Volume" value="{{ "159.00 CFT Net / 4.50 CBM Net" }}" readonly>
                                            </div>
                                            <div class="form-group col-lg-6">
                                                <label for="name">Quoted Weight:</label>
                                                <input type="text" id="survey_weight" name="survey_weight" class="form-control goods_val_blank" placeholder="Enter Survey Weight" value="{{ "468.81 CFT Net / 1031.38 CBM Net" }}" readonly>
                                            </div>
                                          </div>
                                    </div>
                                    <div class="form-group">
                                        <input type="checkbox" id="freight_details" name="freight_details" onchange="freightDetailvisibility()" value="{{$quotation_data->freight_details ?? 1 }}" @if($quotation_data->freight_details == 1) checked @endif>
                                            <label for="freight_details"><b class="checkbox-color">Freight Forwarder / Carrier Line:</b></label>
                                        </div>
                                        <div id="freight_details_fields" class="hidden">
                                        <div class="row">
                                            <div class="form-group col-lg-6">
                                                <label for="name">Name:</label>

                                                <select name="freight_agent_id"
                                                        id="freight_agent_id"
                                                        class="form-select select"
                                                        onchange="getVendorDetails(this.value);">

                                                    <option value="">Select Name</option>
                                                    @foreach($organization_name as $agent_name)
                                                    <option value="{{ $agent_name->id }}" @if ($agent_name->id == $quotation_data->freight_agent_id) selected @endif>{{ $agent_name->company_name }}</option>
                                                    @endforeach
                                                </select>
                                                {{-- <div id="agent_att_replace">
                                                </div> --}}


                                                {{-- <input type="text" id="freight_name" name="freight_name" class="form-control freight_val_blank" placeholder="Enter Name" value=""> --}}
                                            </div>
                                            <div class="form-group col-lg-6">
                                                <label for="name">Mobile:</label>
                                                <input type="text" id="freight_mobile" name="freight_mobile" class="form-control freight_val_blank" placeholder="Enter Mobile" value="{{ $quotation_data->freight_mobile ?? "" }}">
                                            </div>
                                            <div class="form-group col-lg-6">
                                                <label for="name">Email:</label>
                                                <input type="text" id="freight_email" name="freight_email" class="form-control freight_val_blank" placeholder="Enter Email" value="{{ $quotation_data->freight_email ?? "" }}">
                                            </div>
                                            <div class="form-group col-lg-6">
                                                <label for="name">Rate:</label>
                                                <input type="text" id="freight_rate" name="freight_rate" class="form-control freight_val_blank" placeholder="Enter Rate" value="{{ $quotation_data->freight_rate ?? "" }}">
                                            </div>
                                            <div class="form-group col-lg-12">
                                                <label for="name">Address:</label>
                                                <textarea type="text" id="freight_address" name="freight_address" class="form-control freight_val_blank" placeholder="Enter Address">{{ $quotation_data->freight_address ?? "" }}</textarea>
                                            </div>
                                          </div>
                                    </div>
                                    <div class="form-group">
                                        <input type="checkbox" id="desti_agent_details" name="desti_agent_details" onchange="destinationAgentDetailvisibility()" value="{{$quotation_data->desti_agent_details ?? 1 }}" @if($quotation_data->desti_agent_details == 1) checked @endif>
                                            <label for="desti_agent_details"><b class="checkbox-color">Destination Agent:</b></label>
                                        </div>
                                        <div id="desti_agent_details_fields" class="hidden">
                                        <div class="row">
                                            <div class="form-group col-lg-4">
                                                <label for="name">Agent Name:</label>

                                                <select name="desti_agent_id" id="desti_agent_id" class="form-select select" onchange="getVendorDetailsForDestiAgent(this.value);">
                                                    <option value="">Select Name</option>
                                                    @foreach($organization_name as $agent_name)
                                                    <option value="{{ $agent_name->id }}" @if($quotation_data->desti_agent_id == $agent_name->id) selected @endif>{{ $agent_name->company_name }}</option>
                                                    @endforeach
                                                </select>
                                                {{-- <input type="text" id="desti_agent_name" name="desti_agent_name" class="form-control desti_agent_val_blank" placeholder="Enter Name" value=""> --}}
                                            </div>
                                            <div class="form-group col-lg-4">
                                                <label for="name">Agent Email:</label>
                                                <input type="text" id="desti_agent_email" name="desti_agent_email" class="form-control desti_agent_val_blank" placeholder="Enter Email" value="{{ $quotation_data->desti_agent_email ?? "" }}">
                                            </div>
                                            <div class="form-group col-lg-4">
                                                <label for="name">Agent Mobile:</label>
                                                <input type="text" id="desti_agent_mobile" name="desti_agent_mobile" class="form-control desti_agent_val_blank" placeholder="Enter Mobile" value="{{ $quotation_data->desti_agent_mobile ?? "" }}">
                                            </div>

                                            <div class="form-group col-lg-4">
                                                <label for="name">Contact:</label>
                                                <div id="agent_att_replace">
                                                    <select name="desti_agent_attr_id" id="agent_attr_id" class="form-control select">
                                                        <option value="" selected>Select Contact Person</option>
                                                        @foreach ($agent_data as $agent)
                                                            <option value="{{ $agent->id }}" {{isset($quotation_data->desti_agent_contact) && $quotation_data->desti_agent_contact == $agent->id ? 'selected' : '' }}>
                                                                {{ $agent->name }}  @if($agent->role !="" && !empty($agent->role))( {{$agent->role}} )@endif
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                {{-- <input type="text" id="desti_agent_contact" name="desti_agent_contact" class="form-control desti_agent_val_blank" placeholder="Enter Contact" value=""> --}}
                                            </div>

                                            <div class="form-group col-lg-4">
                                                <label for="name">Email:</label>
                                                <input type="text" id="contact_desti_agent_email" name="contact_desti_agent_email" class="form-control desti_agent_val_blank" placeholder="Enter Email" value="{{ $quotation_data->contact_desti_agent_email ?? "" }}">
                                            </div>
                                            <div class="form-group col-lg-4">
                                                <label for="name">Mobile:</label>
                                                <input type="text" id="contact_desti_agent_mobile" name="contact_desti_agent_mobile" class="form-control desti_agent_val_blank" placeholder="Enter Mobile" value="{{ $quotation_data->contact_desti_agent_mobile ?? "" }}">
                                            </div>

                                            {{-- <div class="form-group col-lg-6">
                                                <label for="name">Address:</label>
                                                <select>
                                                    <option value=""></option>
                                                    <option value=""></option>
                                                    <option value=""></option>
                                                    <option value=""></option>
                                                    <option value=""></option>
                                                </select>
                                            </div> --}}
                                            <div class="form-group col-lg-12">
                                                <label for="name">Address:</label>
                                                <textarea type="text" id="desti_agent_address" name="desti_agent_address" class="form-control desti_agent_val_blank" placeholder="Enter Address">{{ $quotation_data->desti_agent_address ?? "" }}</textarea>
                                            </div>
                                          </div>
                                    </div>
                                    <div class="form-group">
                                        <input type="checkbox" id="po_details" name="po_details" value="1" checked/>
                                            <label for="po_details"><b class="checkbox-color">Purchase Order:</b></label>
                                        </div>
                                        <div id="po_details_fields">
                                        <div class="row">

                                            <div class="form-group col-lg-12">
                                                <label for="name">Purchase Order:</label>
                                                {{-- <input type="text" id="purchase_order_no" name="purchase_order_no" class="form-control" placeholder="Enter Purchase Order" value="{{ $quotation_data->purchase_order_no ?? "PO-".date('Y')."-".sprintf('%06d', $followup->id) }}" readonly> --}}

                                                <input type="text" id="purchase_order_no" name="purchase_order_no" class="form-control" placeholder="Enter Purchase Order" value="" >
                                            </div>
                                          </div>
                                    </div>
                                    <div class="form-group">
                                        <input type="checkbox" id="recommendation_details" name="recommendation_details" onchange="recommendaionDetailvisibility()" value="{{ $quotation_data->recommendation_details ?? 1 }}" @if($quotation_data->recommendation_details == 1) checked @endif>
                                            <label for="recommendation_details"><b class="checkbox-color">Recommendations & Guidelines:</b></label>
                                        </div>
                                        <div id="recommendation_details_fields" class="hidden">
                                        <div class="row">

                                            <div class="form-group col-lg-12">
                                                <label for="name">Customer Remarks:</label>
                                                <textarea type="text" id="customer_remarks" name="customer_remarks" class="form-control recommendation_val_blank" placeholder="Enter Customer Remarks">{{ $quotation_data->customer_remarks ?? "" }}</textarea>
                                            </div>
                                            <div class="form-group col-lg-12">
                                                <label for="name">Surveyor Feedback:</label>
                                                <textarea type="text" id="surveyor_feedback" name="surveyor_feedback" class="form-control recommendation_val_blank" placeholder="Enter Surveyor Feedback">{{ $quotation_data->surveyor_feedback ?? "" }}</textarea>
                                            </div>
                                          </div>
                                    </div>

                                        <div class="form-group">
                                            <input type="checkbox" id="general_info_details" name="jo_general_info_details" onchange="general_infovisibility()" value="{{$followup->jo_general_info_details ?? 1}}" @if($followup->jo_general_info_details == 1) checked @endif>
                                                <label for="general_info_details"><b class="checkbox-color">General Information:</b></label>
                                        </div>
                                        <div id="general_info_fields" class="hidden">
                                        <div class="row">
                                            <div class="form-group col-lg-12">
                                                <label for="jo_gi_option">Option:</label>
                                                <input type="checkbox" name="jo_gi_option" id="jo_gi_option" value="Show Costing"   class="gen_info_val_blank" checked> <label for="jo_gi_option">Show Costing</label>
                                            </div>
                                            <div class="form-group col-lg-12">
                                                <label for="payment_by">Payment By:</label>
                                                <input type="radio" name="payment_by" id="self_payment" value="Self" @if(isset($followup) && $followup->payment_by == "Self") checked @endif  class="gen_info_val_blank"> Self
                                                <input type="radio" name="payment_by" id="corporate_payment" value="Corporate" @if(isset($followup) && $followup->payment_by == "Corporate") checked @endif class="gen_info_val_blank"> Corporate
                                            </div>
                                            <div class="form-group col-lg-4">
                                                <label for="refrence_no">Reference No:</label>
                                                <input type="text" name="refrence_no" id="refrence_no" value="{{ $followup->refrence_no ?? "" }}" class="form-control gen_info_val_blank">
                                            </div>
                                            <div class="form-group col-lg-4">
                                                <label for="execution_branch">Execution Branch:</label>
                                                <select name="execution_branch" id="execution_branch" class="form-control form-select gen_info_val_blank select">
                                                    <option value="">Select Execution Branch</option>
                                                </select>
                                                <p class="form-error-text" id="sourcelead_id_error"
                                                    style="color: red; margin-top: 10px;"></p>
                                            </div>
                                            <div class="form-group col-lg-4">
                                                    <label for="status_id">Status:</label>
                                                    <select name="status_id" id="status_id" class="form-control form-select gen_info_val_blank select">
                                                        <option value="">Select Status</option>
                                                        <option value="1" {{ $enquiry_status->status == '1' ? 'selected' : '' }}>Active</option>
                                                        <option value="2" {{ $enquiry_status->status == '2' ? 'selected' : '' }}>Completed</option>
                                                        <option value="3" {{ $enquiry_status->status == '3' ? 'selected' : '' }}>Followup</option>
                                                        <option value="4" {{ $enquiry_status->status == '4' ? 'selected' : '' }}>Lost</option>
                                                    </select>
                                            </div>
                                            <div class="form-group col-lg-6">
                                                <label for="account_manager_id">Account Manager:</label>
                                                <select name="account_manager_id" id="account_manager_id" class="form-control form-select gen_info_val_blank select">
                                                    <option value=""> Select Account Manager</option>
                                                    @foreach ($account_managers as $ac_manager)
                                                        <option value="{{ $ac_manager->id }}"
                                                            @if ($ac_manager->id == $followup->account_manager_id) {{ 'selected' }} @endif>
                                                            {{ $ac_manager->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <p class="form-error-text" id="account_manager_id_error"
                                                    style="color: red; margin-top: 10px;"></p>
                                            </div>
                                            <div class="form-group col-lg-6">
                                                <label for="order_type">Order Type:</label>
                                                <select name="order_type" id="order_type" class="form-control form-select gen_info_val_blank select">
                                                    <option value="">Select Order Type</option>
                                                    <option value="Billed Job" @if("Billed Job" == $followup->order_type){{'selected'}} @endif>{{ "Billed Job" }}</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-lg-6">
                                                <label for="service_delivery_time">Service Delivery Time:</label>
                                                <input type="time"
                                                       name="service_delivery_time"
                                                       id="service_delivery_time"
                                                       class="form-control gen_info_val_blank"
                                                       placeholder="Enter Service Delivery Time"
                                                       value="{{ $followup->service_delivery_time ?? "" }}"
                                                />
                                            </div>
                                            <div class="form-group col-lg-6">
                                                <label for="service_delivery_date">Service Delivery Date:</label>
                                                <input type="text"
                                                       name="service_delivery_date"
                                                       id="service_delivery_date"
                                                       class="form-control gen_info_val_blank"
                                                       placeholder="Enter Service Delivery Time"
                                                       value="{{ $followup->service_delivery_date ?? "" }}"
                                                />
                                            </div>
                                            <div class="form-group col-lg-6">
                                                <label for="service_invoicing_time">Service Invoicing Time:</label>
                                                <input type="time"
                                                       name="service_invoicing_time"
                                                       id="service_invoicing_time"
                                                       class="form-control gen_info_val_blank"
                                                       placeholder="Enter Service Invoicing Time"
                                                       value="{{ $followup->service_invoicing_time ?? "" }}"
                                                />
                                            </div>
                                            <div class="form-group col-lg-6">
                                                <label for="service_invoicing_date">Service Invoicing Date:</label>
                                                <input type="text"
                                                       name="service_invoicing_date"
                                                       id="service_invoicing_date"
                                                       class="form-control gen_info_val_blank"
                                                       placeholder="Enter Service Invoicing Date"
                                                       value="{{ $followup->service_invoicing_time ?? "" }}"
                                                />
                                            </div>
                                            <div class="form-group col-lg-6">
                                                <label for="credit_limit_in_aed">Credit Limit in AED:</label>
                                                <input type="text"
                                                       name="credit_limit_in_aed"
                                                       id="credit_limit_in_aed"
                                                       class="form-control gen_info_val_blank"
                                                       placeholder="Enter Credit Limit in AED"
                                                       value="{{ $followup->credit_limit_in_aed ?? "" }}"
                                                />
                                            </div>
                                            <div class="form-group col-lg-6">
                                                <label for="credit_period_in_days">Credit Period in Days:</label>
                                                {{-- <input type="text"
                                                       name="credit_period_in_days"
                                                       id="credit_period_in_days"
                                                       class="form-control gen_info_val_blank"
                                                       placeholder="Enter Credit Period in Days"
                                                       value="{{ 30 }}"
                                                       readonly
                                                /> --}}

                                                <input type="text"
                                                name="credit_period_in_days"
                                                id="credit_period_in_days"
                                                class="form-control gen_info_val_blank"
                                                placeholder="Enter Credit Period in Days"
                                                value=""
                                                
                                         />
                                            </div>
                                            <div class="col-md-6">
                                                <label for="sale_note">Coordinator Name:</label>
                                                <div class="form-group">
                                                <select name="coordinator_id" id="coordinator_id" class="form-control form-select select">
                                                    <option value="">Select Coordinator Name</option>
                                                    @foreach($coordinators_data as $data)
                                                        <option value="{{ $data->id }}"
                                                        @if($data->id == $followup->coordinator_id) selected @endif
                                                        >{{ $data->name }}</option>
                                                    @endforeach
                                                </select>
                                                <p class="form-error-text" id="coordinator_name_error"
                                                style="color: red; margin-top: 10px;"></p>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="assign_to">Assgin To:</label>
                                                <select name="assign_to" id="assign_to" class="form-control form-select gen_info_val_blank select">
                                                <option value="">Assign To</option>
                                                @foreach($salesperson_data as $salesperson)
                                                <option value="{{ $salesperson->id }}" @if($salesperson->id == $followup->assign_to){{'selected'}} @endif>{{ $salesperson->name }}</option>
                                                @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-12">
                                                <label for="description">Description:</label>
                                                <textarea name="job_order_description" class="form-control" id="job_order_description">{{ $followup->job_order_description ?? "" }}</textarea>
                                            </div>
                                            <div class="form-group col-lg-12 mt-2">
                                                <label for="order_type">Execution Status:</label>
                                                <select name="execution_status" id="execution_status" class="form-control form-select gen_info_val_blank select">
                                                    <option value="">Select Execution Status</option>
                                                </select>
                                            </div>
                                            <div class="col-md-12 mt-2">
                                                <label for="description">Additional Details:</label>
                                                <textarea name="additional_details" class="form-control" id="additional_details">{{ $followup->additional_details ?? "" }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                <div class="text-end mt-4">
                                    <a class="btn btn-primary" href="{{ route('job-order.index') }}"> Cancel</a>
                                    <button class="btn btn-primary mb-1" type="button" disabled id="spinner_button"
                                        style="display: none;">
                                        <span class="spinner-border spinner-border-sm" role="status"
                                            aria-hidden="true"></span>
                                        Loading...
                                    </button>
                                    <button type="button" class="btn btn-primary"
                                        onclick="javascript:category_validation()" id="submit_button">Submit</button>
                                    <!-- <input type="submit" name="submit" value="Submit" class="btn btn-primary"> -->
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
@section('footer_js')
<script>

    function customerType(params) {

        if(params == '1') {
            $(".client-section-corporate").hide();
            $("#client_box").prop('checked', true);
            document.getElementById('customer').checked = true;
            customer_select("Customer");
            clientvisibility();
            document.getElementById('customer_form').checked = true;
            // Call clientvisibility to show the fields
        } else {
            $(".client-section-corporate").show();
            $("#client_box").prop('checked', true);
            document.getElementById('corporate').checked = true;
            customer_select("Corporate");
            clientvisibility();
        }
    }

    $(document).ready(function() {
        $('#agent_id').select2();
        $('#freight_agent_id').select2();
        $('#desti_agent_id').select2();
        $('#agent_attr_id').select2();
        $('#assign_to').select2();
        // customer_type = '{{ $followup->customer_type }}';
        // customerType(customer_type);

        clientvisibility();
        originmovevisibility();
        // individualvisibility();
        
        plannedDetailvisibility();
        transportDetailvisibility();
        goodstDetailvisibility();
        freightDetailvisibility();
        destinationAgentDetailvisibility();
        recommendaionDetailvisibility();
        general_infovisibility();
    });

    function getVendorDetails(agent_id){

        // var url = '{{ route('contact-person.agent') }}';
        var url = '{{ route('contact-person.job_order') }}';
        $.ajax({
                url: url,
                type: 'post',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "id": agent_id
                },
                success: function(response) {

                    if (response.error) {
                        alert(response.error);
                    } else {
                        // Populate the HTML for the contact person dropdown
                        // document.getElementById('agent_att_replace').innerHTML = response.html;

                        // Populate other fields with the agent's data
                        // document.getElementById('customer_phone2').value = response.phone || '';
                        document.getElementById('freight_mobile').value = response.mobile || '';
                        document.getElementById('freight_email').value = response.email || '';
                        document.getElementById('freight_address').value = response.address || '';
                    }
                    // document.getElementById('agent_att_replace').innerHTML = response;
                }
        });
    }
    function getVendorDetailsForDestiAgent(agent_id){

        var url = '{{ route('contact-person.job_order') }}';
        $.ajax({
                url: url,
                type: 'post',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "id": agent_id
                },
                success: function(response) {

                    if (response.error) {
                        alert(response.error);
                    } else {
                        // Populate the HTML for the contact person dropdown
                        document.getElementById('agent_att_replace').innerHTML = response.html;

                        // Populate other fields with the agent's data
                        // document.getElementById('customer_phone2').value = response.phone || '';
                        document.getElementById('desti_agent_mobile').value = response.mobile || '';
                        document.getElementById('desti_agent_email').value = response.email || '';
                        document.getElementById('desti_agent_address').value = response.address || '';
                    }
                    // document.getElementById('agent_att_replace').innerHTML = response;
                }
        });
    }

    function getContactPersonData(contactPersonId){

        var url = '{{ route('get-contact-person.detail') }}';
        $.ajax({
                url: url,
                type: 'post',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "agentAttributeId": contactPersonId
                },
                success: function(response) {

                    if (response.error) {
                        alert(response.error);
                    } else {
                        // Populate other fields with the agent's data
                        // document.getElementById('customer_phone2').value = response.phone || '';
                        document.getElementById('contact_desti_agent_mobile').value = response.mobile || '';
                        document.getElementById('contact_desti_agent_email').value = response.email || '';
                    }
                    // document.getElementById('agent_att_replace').innerHTML = response;
                }
        });
    }



    function clientvisibility() {
     const checkbox = document.getElementById('client_box');
     const container = document.getElementById('client_fields');
     if (checkbox.checked ) {
         container.classList.remove('hidden');
     } else {
        $('.client_fields_val_blank').val('');
        $('.client_fields_val_blank').prop('checked', false);
         container.classList.add('hidden');
     }
 }
    function individualvisibility() {
            const checkbox = document.getElementById('customer_form');
            const container = document.getElementById('individual_fields');
            if (checkbox.checked) {
                container.classList.remove('hidden');
            } else {
                $('.cst_val_blank').val('');
                container.classList.add('hidden');
            }
        }

        function originmovevisibility() {
            const checkbox = document.getElementById('origin_desti_move');
            const container = document.getElementById('origin_desti_move_fields');
            if (checkbox.checked) {
                container.classList.remove('hidden');
            } else {
                $('.origin_desti_val_blank').val('');
                container.classList.add('hidden');
            }
        }
        function customer_select(value) {
            // alert(value);exit;
            const checkbox = document.getElementById('customer_form');
            var formWrapper = document.getElementById('customer_form_wrapper');
            if (value === "Customer") {
                checkbox.checked = true;
                $('.radio_show').removeClass('hidden');
                showCustomerForm();
                individualvisibility(); // Show individual fields
            } else if (value === "Corporate" || value === "None") {
                checkbox.checked = false;
                $('.radio_show').addClass('hidden');
                individualvisibility(); // Hide individual fields
            }
        }
        
        /* $(document).ready(function() {
        var desc_val = $('#desc_of_goods').val();
        desc_goods(desc_val);
        var service_val = $('#service_required').val();
        service_req(service_val);
        var status_val = $('#status_id').val();
        status(status_val);
        }); */
        /* function desc_goods(element) {
        if (element.toLowerCase() === "other") {
            $("#input_goods").show();
        }
        if (element.toLowerCase() != "other") {
            $("#input_goods").hide();
        }
        }
        function service_req(element) {
        // alert(element);
        if (element.toLowerCase() === "other") {
            $("#service_req_val").show();
        }
        if (element.toLowerCase() != "other") {
            $("#service_req_val").hide();
        }
        } */
        function status(element) {
        if (element === "Completed") {
            $("#completed_date").show();
        }else if (element != "Completed") {
            $("#completed_date").hide();
        }
        }
        function plannedDetailvisibility() {

            const checkbox = document.getElementById('planned_details');
            const container = document.getElementById('planned_details_fields');
            if (checkbox.checked) {
                container.classList.remove('hidden');
            } else {
                // $('.planned_val_blank').val('');
                container.classList.add('hidden');
            }
        }
        function transportDetailvisibility() {
            const checkbox = document.getElementById('transport_details');
            const container = document.getElementById('transport_details_fields');
            if (checkbox.checked) {
                container.classList.remove('hidden');
            } else {
                // $('.transport_val_blank').val('');
                container.classList.add('hidden');
            }
        }
        function goodstDetailvisibility() {
            const checkbox = document.getElementById('goods_details');
            const container = document.getElementById('goods_details_fields');
            if (checkbox.checked) {
                container.classList.remove('hidden');
            } else {
                // $('.goods_val_blank').val('');
                container.classList.add('hidden');
            }
        }
        function freightDetailvisibility() {
            const checkbox = document.getElementById('freight_details');
            const container = document.getElementById('freight_details_fields');
            if (checkbox.checked) {
                container.classList.remove('hidden');
            } else {
                // $('.freight_val_blank').val('');
                container.classList.add('hidden');
            }
        }
        function destinationAgentDetailvisibility() {
            const checkbox = document.getElementById('desti_agent_details');
            const container = document.getElementById('desti_agent_details_fields');
            if (checkbox.checked) {
                container.classList.remove('hidden');
            } else {
                // $('.desti_agent_val_blank').val('');
                container.classList.add('hidden');
            }
        }
        function recommendaionDetailvisibility() {
            const checkbox = document.getElementById('recommendation_details');
            const container = document.getElementById('recommendation_details_fields');
            if (checkbox.checked) {
                container.classList.remove('hidden');
            } else {
                // $('.recommendation_val_blank').val('');
                container.classList.add('hidden');
            }
        }

        function general_infovisibility() {

            const checkbox = document.getElementById('general_info_details');
            const container = document.getElementById('general_info_fields');
            if (checkbox.checked) {
                container.classList.remove('hidden');
            } else {
                // $('.gen_info_val_blank').val('');
                $('.gen_info_val_blank').prop('checked', false);
                container.classList.add('hidden');
            }
        }

        //  window.onload = onload_check;
        function showCustomerForm() {
            const formContainer = document.getElementById('customer_form_container');
            if (formContainer) {
                formContainer.classList.remove('hidden');
            }
            const individualFields = document.getElementById('individual_fields');
            if (individualFields) {
                individualFields.classList.remove('hidden');
            }
        }
 </script>
    <script>
        function category_validation() {
            var customer_type = jQuery("#customer_type").val();
            if (customer_type == '') {
                jQuery('#customer_type_error').html("Please Select Job Order Type");
                jQuery('#customer_type_error').show().delay(0).fadeIn('show');
                jQuery('#customer_type_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#customer_type').offset().top - 150
                }, 1000);
                return false;
            }

            $('#spinner_button').show();
            $('#submit_button').hide();
            $('#category_form').submit();
        }
    </script>
    <script type="text/javascript">
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
    </script>
    <script type="text/javascript">
        $(function() {
            $('#inquiry_date').datepicker({
                format: 'yyyy-mm-dd', // Set the desired date format yyyy-mm-dd
                // autoclose: true,
                todayHighlight: true
            });

            $('#move_date').datepicker({
                format: 'yyyy-mm-dd', // Set the desired date format yyyy-mm-dd
                // autoclose: true,
                todayHighlight: true
            });

            $('#enquiry_date').datepicker({
                format: 'yyyy-mm-dd', // Set the desired date format yyyy-mm-dd
                // autoclose: true,
                todayHighlight: true
            });

            $('#s_date').datepicker({
                format: 'yyyy-mm-dd', // Set the desired date format yyyy-mm-dd
                // autoclose: true,
                todayHighlight: true
            });
            $('#shipping_date_of_accept').datepicker({
                format: 'yyyy-mm-dd', // Set the desired date format yyyy-mm-dd
                // autoclose: true,
                todayHighlight: true
            });
            $('#shipping_board_date').datepicker({
                format: 'yyyy-mm-dd', // Set the desired date format yyyy-mm-dd
                // autoclose: true,
                todayHighlight: true
            });
            $('#pack_date_to').datepicker({
                format: 'yyyy-mm-dd', // Set the desired date format yyyy-mm-dd
                // autoclose: true,
                todayHighlight: true
            });
            $('#load_date').datepicker({
                format: 'yyyy-mm-dd', // Set the desired date format yyyy-mm-dd
                // autoclose: true,
                todayHighlight: true
            });
            $('#dispatch_date').datepicker({
                format: 'yyyy-mm-dd', // Set the desired date format yyyy-mm-dd
                // autoclose: true,
                todayHighlight: true
            });
            $('#arrival_date').datepicker({
                format: 'yyyy-mm-dd', // Set the desired date format yyyy-mm-dd
                // autoclose: true,
                todayHighlight: true
            });
            $('#delivery_date').datepicker({
                format: 'yyyy-mm-dd', // Set the desired date format yyyy-mm-dd
                // autoclose: true,
                todayHighlight: true
            });
            $('#pack_date_from').datepicker({
                format: 'yyyy-mm-dd', // Set the desired date format yyyy-mm-dd
                // autoclose: true,
                todayHighlight: true
            });
            $('#service_delivery_date').datepicker({
                format: 'yyyy-mm-dd', // Set the desired date format yyyy-mm-dd
                // autoclose: true,
                todayHighlight: true
            });
            $('#service_invoicing_date').datepicker({
                format: 'yyyy-mm-dd', // Set the desired date format yyyy-mm-dd
                // autoclose: true,
                todayHighlight: true
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            var inq_val = $('#inquiry_type').val();
            inquiry_data(inq_val);
            var mov_val = $('#move_type').val();
            move_data(mov_val);
        });
        function inquiry_data(element) {
            // alert(element);
            if (element == "Inquiry Date") {
                $("#inquiry_dat_hide").show();
                $("#inquiry_val_hide").hide();
            } else if (element == "Inquiry value") {
                $("#inquiry_val_hide").show();
                $("#inquiry_dat_hide").hide();
            } else {
                $("#inquiry_val_hide").hide();
                $("#inquiry_dat_hide").hide();
            }
        }
        function move_data(element) {
            // alert(element);
            if (element == "Move Date") {
                $("#move_dat_hide").show();
                $("#move_val_hide").hide();
            } else if (element == "Move value") {
                $("#move_val_hide").show();
                $("#move_dat_hide").hide();
            } else {
                $("#move_val_hide").hide();
                $("#move_dat_hide").hide();
            }
        }
    </script>
  <?php
// Get company data from the database
$company_data = DB::table('agents')->get(['company_name'])->toArray();
// Serialize the data to JSON format
$company_names = array_map(function($item) {
    return $item->company_name;
}, $company_data);
$json_company_names = json_encode($company_names);
?>
<script>
    $(function() {
        // Parse the JSON data in JavaScript
        var availableTags = <?php echo $json_company_names; ?>;
        // jQuery autocomplete setup
        $("#company_name").autocomplete({
            minLength: 1,
            source: availableTags,
            select: function(event, ui) {
                // Your select event handler here
            }
        });
    });


        $("#agent_attr_id").change(function() {
            let selectedValue = $(this).val();
            // alert(selectedValue);
            console.log("Selected Value:", selectedValue);
        });


    function agent_att_data_replace(id) {
        var url = '{{ url('agent_att_data_replace') }}';
        $.ajax({
            url: url,
            type: 'post',
            data: {
                "_token": "{{ csrf_token() }}",
                "id": id
            },
            success: function(response) {
                var data = JSON.parse(response); // Parse the JSON response
                $('#customer_name').val(data.name);
                $('#customer_email').val(data.email); // Set email field value
                $('#customer_phone1').val(data.phone); // Set phone field value
                $('#customer_phone2').val(data.phone1); // Set phone field value
            }
        });
    }
</script>

@stop
