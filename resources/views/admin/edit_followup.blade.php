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
                    <h3 class="page-title">Edit Enquiry</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('followup.index') }}">Enquiry</a></li>
                        <li class="breadcrumb-item active">Edit Enquiry</li>
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
                        <form id="category_form" action="{{ route('followup.update', $followup->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="form-group col-lg-6">
                                    <label for="name">Customer Type:</label>
                                    <select name="customer_type" id="customer_type" class="form-control form-select select" onchange="customerType(this.value);">
                                        <option value="">Select Customer Type</option>
                                        @foreach ($customer_type as $customer_type_data)
                                        <option value="{{ $customer_type_data->id }}"
                                            @if ($customer_type_data->id == $followup->customer_type) {{ 'selected' }} @endif>
                                    {{$customer_type_data->customer_type}}
                                        </option>
                                    @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-lg-6">
                                    <label for="name">Branch</label>
                                    <select name="branch" id="branch" class="form-control form-select select">
                                        <option value="">Select Branch</option>
                                        @foreach($branch_data as $data)
                                            <option value="{{ $data->id }}" {{ $data->id == $followup->branch ? 'selected' : '' }}>
                                                {{ $data->branch }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-lg-6">
                                    <label for="name">Enquiry Date</label>
                                    <input id="enquiry_date" name="enquiry_date" type="text" class="form-control"
                                        value="{{ $followup->enquiry_date }}" placeholder="Enter Enquiry Date" />
                                    <p class="form-error-text" id="inquiry_date_error" style="color: red;"></p>
                                </div>
                                <div class="form-group col-lg-6">
                                    <label for="name">Enquiry No</label>
                                    <input id="quote_no" name="quote_no" type="text" class="form-control"
                                        placeholder="Enter Packing Management Name" value="{{ $followup->quote_no }}"
                                        readonly/>
                                    <p class="form-error-text" id="quote_no_error" style="color: red;"></p>
                                </div>
                                <div class="form-group col-lg-6">
                                </div>
                                <div class="form-group">
                                    <input type="checkbox" id="client_box" name="client_box" onchange="clientvisibility()" value="{{ $followup->client_box }}"  @if($followup->client_box == 0) checked @endif>
                                        <label for="client_box"><b class="checkbox-color">Client Details:</b></label>
                                </div>
                                <div id="client_fields" class="hidden">
                                    <div class="row client-section-corporate">
                                        <div class="form-group col-lg-6">
                                            <label for="name">Name:</label>
                                            <select name="agent_id" id="agent_id" class="form-select select" onchange="getVendorDetails(this.value);">
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
                                            <select name="title_rank" id="title_rank" class="form-control form-select select client_fields_val_blank">
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
                                                value="{{ $followup->customer_phone2 }}" onclick="validateNumber();" />
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <label for="name">Contact Person :</label>
                                            <div id="agent_att_replace">
                                            <select name="agent_attr_id" id="agent_attr_id" class="form-control client_fields_val_blank" onchange="getContactPersonData(this.value)">
                                                    <option value="" selected>Select Contact Person</option>
                                                    @foreach ($agent_data as $agent)
                                                    <option value="{{ $agent->id }}" {{isset($followup->agent_attr_id) && $followup->agent_attr_id == $agent->id ? 'selected' : '' }}>
                                                        {{ $agent->name }} ( {{$agent->role}} )
                                                    </option>
                                                @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <label for="name">Mobile :</label>
                                            <input id="customer_phone1" name="customer_phone1" type="input" class="form-control client_fields_val_blank"
                                                value="{{ $followup->customer_phone1 }}" onclick="validateNumber();" />
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <label for="name">Contact Person Mobile:</label>
                                            <input id="contact_perosn_agent_mobile" name="contact_perosn_mobile" type="input"
                                                class="form-control" placeholder="Enter Contact Person Mobile"
                                                onkeypress="return validateNumber(event)"
                                                value="{{ $followup->contact_perosn_mobile ?? "" }}"/>
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <label for="name">Email :</label>
                                            <input id="customer_email" name="customer_email" type="input" class="form-control client_fields_val_blank"
                                                value="{{ $followup->customer_email }}" />
                                        </div>

                                        <div class="form-group col-lg-6">
                                            <label for="name">Contact Person Email:</label>
                                            <input id="contact_perosn_agent_email" name="contact_perosn_email" type="input" class="form-control"
                                                placeholder="Enter Contact Person Email"
                                                value="{{  $followup->contact_perosn_email ?? ""  }}" />
                                        </div>

                                        <div class="form-group col-lg-12">
                                            <label for="name">Address:</label>
                                            <textarea name="address" id="address" cols="5" rows="5" class="form-control client_fields_val_blank"
                                                placeholder="Enter Address">{{ $followup->address ?? "" }}</textarea>
                                        </div>
                                        {{--    <div class="form-group col-lg-6">
                                            <label for="name">Customer Name</label>
                                            <input id="customer_name" name="customer_name" type="input" class="form-control client_fields_val_blank"
                                                value="{{ $followup->customer_name }}" />
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <label for="name">Sales Person</label>
                                            <select name="salesman_id" id="salesman_id" class="form-control client_fields_val_blank">
                                                <option value="">Select Sales Person</option>
                                                @foreach ($salesman_data as $salesman)
                                                    <option value="{{ $salesman->id }}"
                                                        @if ($salesman->id == $followup->salesman_id) {{ 'selected' }} @endif>
                                                        {{ $salesman->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div> --}}
                                </div>
                                <div class="row">
                                    <div class="form-group col-lg-12">
                                        <label for="name">Associate: </label>
                                        @php
                                        if($followup->associate == 'Corporate'){
                                            $associate = $followup->associate;
                                        }else{
                                            $associate = "Corporate";
                                        }
                                        @endphp
                                        <input type="radio" name="associate" id="corporate" value="{{ $associate }}"  @if($followup->associate == 'Corporate') checked @endif onchange="customer_select(this.value);" class="client_fields_val_blank"> <label for="corporate">Corporate</label>
                                        @php
                                        if($followup->associate == 'Customer'){
                                            $associate = $followup->associate;
                                        }else{
                                            $associate = "Customer";
                                        }
                                        @endphp
                                        <input type="radio" name="associate" id="customer" value="{{ $associate }}"  @if($followup->associate == 'Customer') checked @endif onchange="customer_select(this.value);" class="client_fields_val_blank"> <label for="customer">Customer</label>
                                    </div>
                                </div>
                            </div>
                            <div class="radio_show hidden" id="customer_form_container">
                                <div class="form-group" >
                                    <input type="checkbox" id="customer_form" name="customer_form" onchange="individualvisibility()" value="{{ $followup->customer_form }}"  @if($followup->customer_form == 0) checked @endif>
                                        <label for="client"><b class="checkbox-color">Individual Details:</b></label>
                                    </div>
                                    <div id="individual_fields" class="hidden">
                                        <div class="row">
                                            <div class="form-group col-lg-6">
                                                <label for="name">Title/Rank:</label>
                                                <select name="customer_title_rank" id="customer_title_rank" class="form-control form-select cst_val_blank">
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
                                                <input type="text" name="f_name" id="f_name" class="form-control cst_val_blank" placeholder="Enter First Name" value="{{ $followup->f_name }}">
                                            </div>
                                            <div class="form-group col-lg-4">
                                                <label for="name">Middle Name:</label>
                                                <input type="text" name="m_name" id="m_name" class="form-control cst_val_blank" placeholder="Enter Middle Name" value="{{$followup->m_name}}">
                                            </div>
                                            <div class="form-group col-lg-4">
                                                <label for="name">Last Name:</label>
                                                <input type="text" name="l_name" id="l_name" class="form-control cst_val_blank" placeholder="Enter Last Name" value="{{$followup->l_name}}">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-lg-4">
                                                <label for="name">Mobile:</label>
                                                <input type="text" name="c_mobile" id="c_mobile" class="form-control cst_val_blank" placeholder="Enter Mobile Number" value="{{$followup->c_mobile}}">
                                            </div>
                                            <div class="form-group col-lg-4">
                                                <label for="name">Phone:</label>
                                                <input type="text" name="c_phone" id="c_phone" class="form-control cst_val_blank" placeholder="Enter Phone Number" value="{{$followup->c_phone}}">
                                            </div>
                                            <div class="form-group col-lg-4">
                                                <label for="name">Email:</label>
                                                <input type="text" name="c_email" id="c_email" class="form-control cst_val_blank" placeholder="Enter Email" value="{{$followup->c_email}}">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-lg-12">
                                                <label for="name">Address:</label>
                                                <input type="text" name="c_add" id="c_add" class="form-control cst_val_blank" placeholder="Enter Address" value="{{$followup->c_add}}">
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="country">Country</label>
                                                    <select class="form-control form-select cst_val_blank select" id="c_country" name="c_country">
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
                                                <input type="text" name="c_city" id="c_city" class="form-control cst_val_blank" placeholder="Enter City" value="{{$followup->c_city}}">
                                            </div>
                                        </div>
                                </div>
                                </div>
                                <div class="form-group" >
                                    <input type="checkbox" id="origin_desti_move" name="origin_desti_move" onchange="originmovevisibility()" value="{{ $followup->origin_desti_move }}"  @if($followup->origin_desti_move == 0) checked @endif>
                                        <label for="origin_desti_move"><b class="checkbox-color">Origin,Destination & Move Details:</b></label>
                                    </div>
                                    <div id="origin_desti_move_fields" class="hidden">
                                        <div class="row">
                                            <div class="form-group col-lg-4">
                                                <label for="name">Service Type</label>
                                                <select name="service_id" id="service_id" class="form-control form-select origin_desti_val_blank select">
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
                                                    <select name="service_required" id="service_required" class="form-control form-select origin_desti_val_blank select">
                                                        <option value=""> Select Service Required</option>
                                                        @foreach ($services_required as $services)
                                                        <option value="{{ $services->id }}"
                                                            @if ($services->id == $followup->service_required) {{ 'selected' }} @endif>
                                                            {{ $services->name }}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                    @php
                                                    /* if($followup->service_required == "Other"){
                                                        $service_other = $followup->service_required;
                                                        $service_req_val = $followup->service_req_val;
                                                        $styleDisplay = "display: block;";
                                                    }else{
                                                        $service_req_val = $followup->service_req_val;
                                                        $styleDisplay = "display: none;";
                                                    } */
                                                    @endphp
                                                   {{--  <input type="text" class="form-control origin_desti_val_blank mt-3" name="service_req_val"
                                                        id="service_req_val" style= "{{ $styleDisplay }}"
                                                        placeholder="Enter Products Other Value"
                                                        value="{{$service_req_val}}"> --}}
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                            <div class="form-group">
                                            <label for="Surveyor">Description Of Goods:</label>
                                            <select name="desc_of_goods" id="desc_of_goods" class="form-control form-select origin_desti_val_blank select">
                                                <option value="">Select Description Of Goods</option>
                                                @foreach ($goods_description as $goods_data)
                                                    <option value="{{ $goods_data->id }}"
                                                        @if ($goods_data->id == $followup->desc_of_goods) {{ 'selected' }} @endif>
                                                        {{ $goods_data->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @php
                                            /* if($followup->desc_of_goods == "Other" && $followup->input_goods != null){
                                            $service_any_other = $followup->input_goods;
                                            $styleDisplay1 = "display: block;";
                                            }else{
                                                $service_any_other = "Other";
                                                $styleDisplay1 = "display: none;";
                                            } */
                                            @endphp
                                            {{-- @if($services->name == "Other")
                                            <input type="text" class="form-control origin_desti_val_blank mt-3" name="input_goods" id="input_goods"
                                                style="{{ $styleDisplay1 }}" placeholder="Enter Goods Other Value"
                                                value="{{$service_any_other}}">
                                                @endif --}}
                                            </div>
                                            </div>

                                            <div class="col-md-4">
                                            <div class="form-group">
                                            <label for="Surveyor">Move Type</label>
                                            <select name="move_type" id="move_type" class="form-control form-select select" onchange="move_data(this.value);">
                                                <option value="">Select Move Type</option>
                                                <option value="Move Date" @if($followup->move_type == 'Move Date') {{'selected'}} @endif>Move Date</option>
                                                <option value="Move value" @if($followup->move_type == 'Move value') {{'selected'}} @endif>Move value</option>
                                                
                                            </select>
                                            <p class="form-error-text" id="move_type_error" style="color: red;"></p>
                                                </div>
                                            </div>
                                             <div class="form-group col-lg-4">
                                    <div class="form-group" id="move_dat_hide" style="display: none">

                                        <label for="name">Move Date</label>
                                        <input id="move_date" name="move_date" type="text" class="form-control"
                                            value="{{$followup->move_date}}" placeholder="Enter Move Date" />
                                        <p class="form-error-text" id="move_date_error" style="color: red;"></p>
                                    </div>
                                    <div class="form-group" id="move_val_hide" style="display: none">
                                        <label>Move Value</label>
                                        <input id="move_value" name="move_value" type="text" class="form-control"
                                            value="{{$followup->move_value}}" placeholder="Enter Move Value" />

                                        <p class="form-error-text" id="move_value_error" style="color: red;"></p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    &nbsp;
                                </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="survey_req">Survey Required ?</label>
                                                    <input type="checkbox" id="survey_req" name="survey_req" value="{{ $followup->survey_req }}"  @if($followup->survey_req == 0 && $followup->survey_req !== null) checked @endif>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                <label for="Surveyor">Survey Type:</label>
                                                <select name="survey_type" id="survey_type" class="form-control form-select origin_desti_val_blank select" >
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
                                                    $survey_date = date("Y-m-d",strtotime($followup->s_date));
                                                }else{
                                                    $survey_date = '';
                                                }
                                            @endphp
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label for="name">Survey Date:</label>
                                                    <input type="text" name="s_date" id="s_date" class="form-control origin_desti_val_blank" placeholder="Enter Survey Date" value="{{ $survey_date }}">
                                                </div>
                                            </div>

                                    <div class="row">
                                        <div class="col-lg-6"><b>Origin:/Pick up</b>
                                            <div class="form-group ">
                                                <label for="name">Address:</label>
                                                <input id="origin_add" name="origin_add" type="text" class="form-control origin_desti_val_blank"
                                                    placeholder="Enter Origin Address" value="{{$followup->origin_add}}"/>
                                            </div>
                                            <div class="form-group">
                                                <label for="name">Country:</label>
                                                <select name="origin_country" id="origin_country" class="form-select form-control origin_desti_val_blank select" />
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
                                                placeholder="Enter Origin State" value="{{$followup->origin_state}}" />
                                            </div>
                                            <div class="form-group">
                                                <label for="name">City:</label>
                                                <input id="origin_city" name="origin_city" type="text" class="form-control origin_desti_val_blank"
                                                placeholder="Enter Origin City" value="{{$followup->origin_city}}" />
                                            </div>
                                            <div class="form-group">
                                                <label for="name">Location:</label>
                                                <input id="origin_location" name="origin_location" type="text" class="form-control origin_desti_val_blank"
                                                placeholder="Enter Origin Location" value="{{$followup->origin_location}}" />
                                            </div>
                                            <div class="form-group">
                                                <label for="name">ZIP/POST Code:</label>
                                                <input id="origin_zip_post" name="origin_zip_post" type="text" class="form-control origin_desti_val_blank"
                                                placeholder="Enter Origin ZIP/POST Code"  value="{{$followup->origin_zip_post}}" />
                                            </div>
                                        </div>
                                        <div class="col-lg-6"><b>Destination:/Delivery</b>
                                            <div class="form-group">
                                                <label for="name">Address:</label>
                                                <input id="desti_add" name="desti_add" type="text" class="form-control origin_desti_val_blank"
                                                placeholder="Enter Destination Address" value="{{$followup->desti_add}}"/>
                                            </div>
                                            <div class="form-group">
                                                <label for="name">Country:</label>
                                                <select name="desti_country" id="desti_country" class="form-select form-control origin_desti_val_blank" />
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
                                                placeholder="Enter Destination State" value="{{$followup->desti_state}}" />
                                            </div>
                                            <div class="form-group">
                                                <label for="name">City:</label>
                                                <input id="desti_city" name="desti_city" type="text" class="form-control origin_desti_val_blank"
                                                placeholder="Enter Destination City" value="{{$followup->desti_city}}" />
                                            </div>
                                            <div class="form-group">
                                                <label for="name">Location:</label>
                                                <input id="desti_location" name="desti_location" type="text" class="form-control origin_desti_val_blank"
                                                placeholder="Enter Destination Location" value="{{$followup->desti_location}}"/>
                                            </div>
                                            <div class="form-group">
                                                <label for="name">ZIP/POST Code:</label>
                                                <input id="desti_zip_post" name="desti_zip_post" type="text" class="form-control origin_desti_val_blank"
                                                placeholder="Enter Destination ZIP/POST Code" value="{{$followup->desti_zip_post}}"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </div>
                                <div class="form-group" >
                                    <input type="checkbox" id="storage_details" name="storage_details" onchange="storagedetailvisibility()" value="{{$followup->storage_details}}" @if($followup->storage_details == 0) checked @endif>
                                        <label for="storage_details"><b class="checkbox-color">Storage Details:</b></label>
                                    </div>
                                    <div id="storage_details_fields" class="hidden">
                                    <div class="row">
                                        <div class="form-group col-lg-4">
                                            <label for="name">Storage Type:</label>
                                            <select name="storage_id" id="storage_id" class="form-control form-select storage_val_blank select">
                                            <option value="">Select Storage Type</option>
                                            @foreach($storage_type as $storage_type_data)
                                            <option value="{{$storage_type_data->id}}" @if($storage_type_data->id == $followup->storage_id){{'selected'}} @endif>
                                        {{$storage_type_data->storage_type}}
                                            </option>
                                            @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-lg-4">
                                            <label for="name">Frequency:</label>
                                            <select name="frequency" id="frequency" class="form-control form-select select">
                                                <option value="">Select Frequency</option>
                                                @foreach($frequency_data as $frequency)
                                                <option value="{{$frequency->id}}" @if($frequency->id == $followup->frequency){{'selected'}} @endif>
                                                     {{$frequency->name}}
                                                </option>
                                                @endforeach
                                            </select>
                                            {{-- <input id="frequency" name="frequency" type="text" class="form-control storage_val_blank"
                                            placeholder="Enter Frequency" value="{{$followup->frequency}}"/> --}}
                                        </div>
                                        <div class="form-group col-lg-4">
                                            <label for="name">Duration:</label>
                                            <select name="duration" id="duration" class="form-control form-select select">
                                                <option value="">Select Duration</option>
                                                @foreach($duration_data as $duration)
                                                <option value="{{$duration->id}}" @if($duration->id == $followup->duration){{'selected'}} @endif>
                                                     {{$duration->name}}
                                                </option>
                                                @endforeach
                                            </select>
                                            {{-- <input id="duration" name="duration" type="text" class="form-control storage_val_blank"
                                            placeholder="Enter Duration" value="{{$followup->duration}}"/> --}}
                                        </div>
                                        <div class="form-group col-lg-4">
                                            <label for="name">Billing Mode:</label>
                                            <select name="billing_mode" id="billing_mode" class="form-control form-select storage_val_blank select">
                                                <option value="Per unit" @if($followup->billing_mode == 'Per Unit'){{'selected'}} @endif>Per unit</option>
                                                <option value="Fixed Price" @if($followup->billing_mode == 'Fixed Price'){{'selected'}} @endif>Fixed Price</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-lg-4">
                                            <label for="name">Storage Mode:</label>
                                            <select name="storage_mode" id="storage_mode" class="form-control form-select storage_val_blank select">
                                            <option value="">Select Storage Mode</option>
                                            @foreach($storage_mode as $storage_mode_data)
                                            <option value="{{$storage_mode_data->id}}" @if($storage_mode_data->id == $followup->storage_mode){{'selected'}} @endif>
                                            {{$storage_mode_data->storage_mode}}
                                            </option>
                                            @endforeach
                                            </select>
                                        </div>
                                            <div class="form-group col-md-4">
                                                <label for="Surveyor">Product Types:</label>
                                                <select name="storage_product_type" id="storage_product_type" class="form-control form-select storage_val_blank select">
                                                    <option value=""> Select Product Types</option>
                                                    @foreach($product_type_data as $product_type)
                                                    <option value="{{ $product_type->id }}" @if($product_type->id == $followup->storage_product_type){{'selected'}} @endif>{{ $product_type->product_type }}</option>
                                                    @endforeach
                                                    {{-- @foreach ($services_required as $services)
                                                        <option value="{{ $services->name }}">
                                                            {{ $services->name }}
                                                        </option>
                                                    @endforeach --}}
                                                </select>
                                            </div>
                                    </div>
                                    </div>
                                    <div class="form-group" >
                                        <input type="checkbox" id="allowance_details" name="allowance_details" onchange="allowancevisibility()" value="{{$followup->allowance_details}}" @if($followup->allowance_details == 0) checked @endif>
                                            <label for="allowance_details"><b class="checkbox-color">Allowance:</b></label>
                                        </div>
                                        <div id="allowance_fields" class="hidden">
                                        <div class="row">
                                            <table id="allowance_table" class="table">
                                                <thead>
                                                  <tr>
                                                    <th colspan="3" style="text-align: center; background-color:blue;color:white;" >TransportVolume/WeightUnit</th>
                                                  </tr>
                                                </thead>
                                                <tbody>
                                                  <tr>
                                                    <td>Road</td>
                                                    <td><input type="text" id="road_input" name="road_input" class="form-control allowance_val_blank " value="{{$followup->road_input}}"></td>
                                                    <td>
                                                    <select name="road_cft_net" id="road_cft_net" class="form-control form-select allowance_val_blank select">
                                                        <option value="CBM Net" @if($followup->road_cft_net == 'CBM Net') selected @endif>CBM Net</option>
                                                        <option value="LBS Net" @if($followup->road_cft_net == 'LBS Net') selected @endif>LBS Net</option>
                                                        <option value="CFT Net" @if($followup->road_cft_net == 'CFT Net') selected @endif>CFT Net</option>
                                                        <option value="KG Net" @if($followup->road_cft_net == 'KG Net') selected @endif>KG Net</option>
                                                        <option value="Metric Ton" @if($followup->road_cft_net == 'Metric Ton') selected @endif>Metric Ton</option>
                                                    </select>
                                                    </td>
                                                  </tr>
                                                  <tr>
                                                    <td>Air</td>
                                                    <td><input type="text" id="air_input" name="air_input" class="form-control allowance_val_blank" value="{{$followup->air_input}}"></td>
                                                    <td>
                                                    <select name="air_lbs_net" id="air_lbs_net" class="form-control form-select allowance_val_blank select">
                                                        <option value="LBS Net" @if($followup->air_lbs_net == 'LBS Net') selected @endif>LBS Net</option>
                                                        <option value="CBM Net" @if($followup->air_lbs_net == 'CBM Net') selected @endif>CBM Net</option>
                                                        <option value="CFT Net" @if($followup->air_lbs_net == 'CFT Net') selected @endif>CFT Net</option>
                                                        <option value="KG Net" @if($followup->air_lbs_net == 'KG Net') selected @endif>KG Net</option>
                                                        <option value="Metric Ton" @if($followup->air_lbs_net == 'Metric Ton') selected @endif>Metric Ton</option>
                                                        </select>
                                                    </td>
                                                  </tr>
                                                  <tr>
                                                    <td>Sea</td>
                                                    <td><input type="text" id="sea_input" name="sea_input" class="form-control allowance_val_blank" value="{{$followup->sea_input}}"></td>
                                                    <td>
                                                    <select name="sea_cft_net" id="sea_cft_net" class="form-control form-select allowance_val_blank select">
                                                        <option value="CBM Net" @if($followup->sea_cft_net == 'CBM Net') selected @endif>CBM Net</option>
                                                        <option value="LBS Net" @if($followup->sea_cft_net == 'LBS Net') selected @endif>LBS Net</option>
                                                        <option value="CFT Net" @if($followup->sea_cft_net == 'CFT Net') selected @endif>CFT Net</option>
                                                        <option value="KG Net" @if($followup->sea_cft_net == 'KG Net') selected @endif>KG Net</option>
                                                        <option value="Metric Ton" @if($followup->sea_cft_net == 'Metric Ton') selected @endif>Metric Ton</option>
                                                        </select>
                                                    </td>
                                                  </tr>
                                                  <tr>
                                                    <td>Rail</td>
                                                    <td><input type="text" id="rail_input" name="rail_input" class="form-control allowance_val_blank" value="{{$followup->rail_input}}"></td>
                                                    <td>
                                                    <select name="rail_cft_net" id="rail_cft_net" class="form-control form-select allowance_val_blank select">
                                                        <option value="CBM Net" @if($followup->rail_cft_net == 'CBM Net') selected @endif>CBM Net</option>
                                                        <option value="LBS Net" @if($followup->rail_cft_net == 'LBS Net') selected @endif>LBS Net</option>
                                                        <option value="CFT Net" @if($followup->rail_cft_net == 'CFT Net') selected @endif>CFT Net</option>
                                                        <option value="KG Net" @if($followup->rail_cft_net == 'KG Net') selected @endif>KG Net</option>
                                                        <option value="Metric Ton" @if($followup->rail_cft_net == 'Metric Ton') selected @endif>Metric Ton</option>
                                                        </select>
                                                    </td>
                                                  </tr>
                                                </tbody>
                                              </table>
                                        </div>
                                        </div>
                                        <div class="form-group">
                                            <input type="checkbox" id="general_info_details" name="general_info_details" onchange="general_infovisibility()" value="{{$followup->general_info_details}}" @if($followup->general_info_details == 0) checked @endif>
                                                <label for="general_info_details"><b class="checkbox-color">General Information:</b></label>
                                            </div>
                                        <div id="general_info_fields" class="hidden">
                                        <div class="row">
                                            <div class="form-group col-lg-12">
                                            <label for="name">Payment By:</label>
                                            <input type="radio" name="payment_by" id="self_payment" value="Self" @if(isset($followup) && $followup->payment_by == "Self") checked @endif  class="gen_info_val_blank"> Self
                                            <input type="radio" name="payment_by" id="corporate_payment" value="Corporate" @if(isset($followup) && $followup->payment_by == "Corporate") checked @endif class="gen_info_val_blank"> Corporate
                                            </div>
                                            <div class="form-group col-lg-4">
                                                <label for="name">Source of Contact:</label>
                                                <select name="sourcelead_id" id="sourcelead_id" class="form-control form-select gen_info_val_blank select">
                                                    <option value=""> Select Source leads</option>
                                                    @foreach ($sourcelead_data as $sourcelead)
                                                        <option value="{{ $sourcelead->id }}"
                                                            @if ($sourcelead->id == $followup->sourcelead_id) {{ 'selected' }} @endif>
                                                            {{ $sourcelead->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <p class="form-error-text" id="sourcelead_id_error"
                                                    style="color: red; margin-top: 10px;"></p>
                                            </div>
                                            <div class="form-group col-lg-4">
                                                <label for="name">Enquiry Mode:</label>
                                                <select name="enquiry_mode" id="enquiry_mode" class="form-control form-select gen_info_val_blank select">
                                                    <option value="">Select Enquiry Mode</option>
                                                    @foreach($enquiry_mode as $enquiry_mode_data)
                                                    <option value="{{$enquiry_mode_data->id}}" @if($enquiry_mode_data->id == $followup->enquiry_mode){{'selected'}} @endif>
                                                    {{$enquiry_mode_data->enquiry_mode}}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group col-lg-4">
                                                <label for="name">Status:</label>
                                                <select name="status_id" id="status_id" class="form-control form-select gen_info_val_blank select">
                                                    <option value="">Select Status</option>
                                                    <option value="1" {{ $enquiry_status->status == '1' ? 'selected' : '' }}>Active</option>
                                                    <option value="2" {{ $enquiry_status->status == '2' ? 'selected' : '' }}>Completed</option>
                                                    <option value="3" {{ $enquiry_status->status == '3' ? 'selected' : '' }}>Followup</option>
                                                    <option value="4" {{ $enquiry_status->status == '4' ? 'selected' : '' }}>Lost</option>
                                                </select>
                                                <input type="text" style="display: none;" name="completed_date" placeholder="Enter Completed Date" class="form-control mt-2" id="completed_date" value="{{$followup->completed_date}}">
                                            </div>
                                            <div class="form-group col-lg-4">
                                                <label for="RMC">RMC:</label>
                                                <input type="text" name="rmc" id="rmc"
                                                 class="form-control gen_info_val_blank" placeholder="Enter RMC" value="{{$followup->rmc}}">
                                            </div>

                                            @php
                                                $user_data = Auth::user();
                                                $is_read_only = $user_data->role_id != 1;
                                            @endphp
                                            <div class="form-group col-lg-4">
                                                <label for="name">Assgin To:</label>
                                                <select name="assign_to" id="assign_to" class="form-control form-select gen_info_val_blank select" @if($is_read_only) disabled @endif>
                                                <option value="">Assign To</option>
                                                @foreach($salesperson_data as $salesperson)
                                                <option value="{{ $salesperson->id }}" @if($salesperson->id == $followup->assign_to){{'selected'}} @endif>{{ $salesperson->name }}</option>
                                                @endforeach
                                                </select>
                                                @if($is_read_only)
                                                    <input type="hidden" name="assign_to" value="{{ $followup->assign_to }}">
                                                @endif
                                            </div>
                                            <div class="col-md-12">
                                                <label for="sale_note">Sales Note:</label>
                                                <div class="form-group ">
                                                   <textarea id="sales_notes" name="sales_notes" class="form-control" cols="50" rows="6" class="gen_info_val_blank">{{$followup->sales_notes}}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <label for="sale_note">Surveyors Name:</label>
                                                <div class="form-group">
                                                <select name="surveyor" id="surveyor" class="form-control form-select select">
                                                    <option value="">Select Surveyor</option>
                                                    @foreach ($surveyor as $surveyor_data)
                                                    <option value="{{ $surveyor_data->id }}"@if ($surveyor_data->id == $followup->surveyor) {{ 'selected' }} @endif>
                                                    {{ $surveyor_data->name }}
                                                    </option>
                                                @endforeach
                                                </select>
                                                <p class="form-error-text" id="surveyor_error"
                                                style="color: red; margin-top: 10px;"></p>
                                                </div>
                                            </div>
                                        </div>
                                        </div>
                                @php
                                    $inquiryDate = '';
                                    if (!empty($followup->inquiry_date) && $followup->inquiry_date != '1970-01-01') {
                                        $inquiryDate = $followup->inquiry_date;
                                    } else {
                                        $inquiryDate = '';
                                    }
                                @endphp
                                {{-- <div class="form-group col-lg-3">
                                    <label for="name">Inquiry</label>
                                    <select name="inquiry_type" id="inquiry_type" class="form-control"
                                        onchange="inquiry_data(this.value);">
                                        <option value=""> Select Inquiry</option>
                                        <option value="Inquiry Date"
                                            @if ($followup->inquiry_type == 'Inquiry Date') {{ 'selected' }} @endif>
                                            Inquiry Date
                                        </option>
                                        <option value="Inquiry value"
                                            @if ($followup->inquiry_type == 'Inquiry value') {{ 'selected' }} @endif>
                                            Inquiry value
                                        </option>
                                    </select>
                                    <p class="form-error-text" id="inquiry_type_error"
                                        style="color: red; margin-top: 10px;"></p>
                                </div>
                                <div class="form-group col-lg-3">
                                    <div class="form-group" id="inquiry_dat_hide"
                                        @if ($followup->inquiry_type == 'Inquiry Date') {{ 'style=display:block' }} @else {{ 'style=display:none' }} @endif>
                                        <label for="name">Inquiry Date</label>
                                        <input id="inquiry_date" name="inquiry_date" type="text" class="form-control"
                                            value="{{ $inquiryDate }}" placeholder="Enter Inquiry Date" />
                                        <p class="form-error-text" id="inquiry_date_error" style="color: red;"></p>
                                    </div>
                                    <div class="form-group" id="inquiry_val_hide"
                                        @if ($followup->inquiry_type == 'Inquiry value') {{ 'style=display:block' }} @else {{ 'style=display:none' }} @endif>
                                        <label>Inquiry Value</label>
                                        <input id="inquiry_value" name="inquiry_value" type="text" class="form-control"
                                            value="{{ $followup->inquiry_value }}" placeholder="Enter Inquiry Value" />
                                        <p class="form-error-text" id="inquiry_value_error" style="color: red;"></p>
                                    </div>
                                </div>
                                @php
                                    $moveDate = '';
                                    if (!empty($followup->move_date) && $followup->move_date != '1970-01-01') {
                                        $moveDate = $followup->move_date;
                                    } else {
                                        $moveDate = '';
                                    }
                                @endphp
                                <div class="form-group col-lg-3">
                                    <label for="name">Move</label>
                                    <select name="move_type" id="move_type" class="form-control"
                                        onchange="move_data(this.value);">
                                        <option value=""> Select Move</option>
                                        <option value="Move Date"
                                            @if ($followup->move_type == 'Move Date') {{ 'selected' }} @endif>
                                            Move Date
                                        </option>
                                        <option value="Move value"
                                            @if ($followup->move_type == 'Move value') {{ 'selected' }} @endif>
                                            Move value
                                        </option>
                                    </select>
                                    <p class="form-error-text" id="move_type_error"
                                        style="color: red; margin-top: 10px;"></p>
                                </div>
                                <div class="form-group col-lg-3">
                                    <div class="form-group" id="move_dat_hide"
                                        @if ($followup->move_type == 'Move Date') {{ 'style=display:block' }} @else {{ 'style=display:none' }} @endif>
                                        <label for="name">Move Date</label>
                                        <input id="move_date" name="move_date" type="text" class="form-control"
                                            value="{{ $moveDate }}" placeholder="Enter Inquiry Date" />
                                        <p class="form-error-text" id="move_date_error" style="color: red;"></p>
                                    </div>
                                    <div class="form-group" id="move_val_hide"
                                        @if ($followup->move_type == 'Move value') {{ 'style=display:block' }} @else {{ 'style=display:none' }} @endif>
                                        <label>Move Value</label>
                                        <input id="move_value" name="move_value" type="text" class="form-control"
                                            value="{{ $followup->move_value }}" placeholder="Enter Move Value" />
                                        <p class="form-error-text" id="move_value_error" style="color: red;"></p>
                                    </div>
                                </div> --}}
                                {{-- <div class="form-group col-lg-3">
                                    <div class="form-group" id="inquiry_dat_hide" style="display: none">
                                        <label for="name">Inquiry Date</label>
                                        <input id="inquiry_date" name="inquiry_date" type="text" class="form-control"
                                            value="{{ $inquiryDate }}" placeholder="Enter Survey Date" />
                                        <p class="form-error-text" id="inquiry_date_error" style="color: red;"></p>
                                    </div>
                                    <div class="form-group" id="inquiry_val_hide" style="display: none">
                                        <label>Inquiry Value</label>
                                        <input id="inquiry_value" name="inquiry_value" type="text" class="form-control"
                                            value="{{ $followup->inquiry_value }}" placeholder="Enter Inquiry Value" />
                                        <p class="form-error-text" id="inquiry_value_error" style="color: red;"></p>
                                    </div>
                                </div> --}}
                                {{-- <div class="form-group col-lg-6">
                                    <label for="name">Inquiry Date</label>
                                    <input id="inquiry_date" name="inquiry_date" type="text" class="form-control"
                                        value="{{ date('m-d-Y', strtotime($followup->inquiry_date)) }}" />
                                    <p class="form-error-text" id="inquiry_date" style="color: red;"></p>
                                </div>
                                <div class="form-group col-lg-6">
                                    <label for="name">Move Date</label>
                                    <input id="move_date" name="move_date" type="text" class="form-control"
                                        value="{{ date('m-d-Y', strtotime($followup->move_date)) }}" />
                                    <p class="form-error-text" id="move_error" style="color: red;"></p>
                                </div> --}}
                                {{-- <div class="form-group col-lg-6">
                                    <label for="name">Volume</label>
                                    <input id="volume" name="volume" type="input" class="form-control"
                                        value="{{ $followup->volume }}" />
                                    <p class="form-error-text" id="volume_error" style="color: red;"></p>
                                </div> --}}
                                <div class="text-end mt-4">
                                    <a class="btn btn-primary" href="{{ route('followup.index') }}"> Cancel</a>
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

   /*  function customerType(params, typeOfAssociate) {

        if(params == '1' && typeOfAssociate == "Customer") { // 1 is Individual and 2 is Corporate

            $(".client-section-corporate").hide();
            $("#client_box").prop('checked', true);
            document.getElementById('customer').checked = true;
            customer_select("Customer");
            clientvisibility();
            document.getElementById('customer_form').checked = true;
            // Call clientvisibility to show the fields
        }else if(params == '2' && typeOfAssociate == "Corporate") {
            $(".client-section-corporate").show();
            $("#client_box").prop('checked', true);
            document.getElementById('corporate').checked = true;
            customer_select("Corporate");
            clientvisibility();
        } else {

            $(".client-section-corporate").show();
            $("#client_box").prop('checked', true);
            document.getElementById('corporate').checked = true;
            customer_select("Corporate");
            clientvisibility();
        }
    }
 */
    $(document).ready(function() {
        $('#agent_id').select2();
        $('#agent_attr_id').select2();
        $('#c_country').select2();

        $('#origin_country').select2();
        $('#desti_country').select2();
        customer_type = @json($followup->customer_type);
        typeOfAssociate = @json($followup->associate);
        customerType(customer_type, typeOfAssociate);
    });

    function getVendorDetails(agent_id){

        var url = '{{ route('contact-person.agent') }}';
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
                        document.getElementById('customer_phone2').value = response.phone || '';
                        document.getElementById('customer_phone1').value = response.mobile || '';
                        document.getElementById('customer_email').value = response.email || '';
                        document.getElementById('address').value = response.address || '';

                        document.getElementById('contact_perosn_agent_mobile').value = '';
                        document.getElementById('contact_perosn_agent_email').value  = '';
                    }
                    // document.getElementById('agent_att_replace').innerHTML = response;
                }
        });
    }

    function getContactPersonData(contactPersonId){

        var url = '{{ route('contact-person-detail') }}';
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
                        document.getElementById('contact_perosn_agent_mobile').value = response.mobile || '';
                        document.getElementById('contact_perosn_agent_email').value = response.email || '';
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
        $(document).ready(function() {
        var desc_val = $('#desc_of_goods').val();
        desc_goods(desc_val);
        var service_val = $('#service_required').val();
        service_req(service_val);
        var status_val = $('#status_id').val();
        status(status_val);
        });
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
        function storagedetailvisibility() {
            const checkbox = document.getElementById('storage_details');
            const container = document.getElementById('storage_details_fields');
            if (checkbox.checked) {
                container.classList.remove('hidden');
            } else {
                $('.storage_val_blank').val('');
                container.classList.add('hidden');
            }
        }
        function allowancevisibility() {
            const checkbox = document.getElementById('allowance_details');
            const container = document.getElementById('allowance_fields');
            if (checkbox.checked) {
                container.classList.remove('hidden');
            } else {
                $('.allowance_val_blank').val('');
                container.classList.add('hidden');
            }
        }
        function general_infovisibility() {
            const checkbox = document.getElementById('general_info_details');
            const container = document.getElementById('general_info_fields');
            if (checkbox.checked) {
                container.classList.remove('hidden');
            } else {
                $('.gen_info_val_blank').val('');
                $('.gen_info_val_blank').prop('checked', false);
                container.classList.add('hidden');
            }
        }
 window.onload = onload_check;
    function onload_check(){
        @if($followup->client_box == 0)
        const container = document.getElementById('client_fields');
            container.classList.remove('hidden');
        @endif
        @if($followup->customer_form == 0)
        const container1 = document.getElementById('individual_fields');
            container1.classList.remove('hidden');
        @endif
        @if($followup->origin_desti_move == 0)
        const container2 = document.getElementById('origin_desti_move_fields');
            container2.classList.remove('hidden');
        @endif
        @if($followup->storage_details == 0)
        const container3 = document.getElementById('storage_details_fields');
            container3.classList.remove('hidden');
        @endif
        @if($followup->allowance_details == 0)
        const container4 = document.getElementById('allowance_fields');
            container4.classList.remove('hidden');
        @endif
        @if($followup->general_info_details == 0)
        const container5 = document.getElementById('general_info_fields');
            container5.classList.remove('hidden');
        @endif
        @if ($followup->associate == "Customer")
        const customerRadio = document.getElementById('customer');
        showCustomerForm();
        @endif
    }
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
                jQuery('#customer_type_error').html("Please Select Survey Type");
                jQuery('#customer_type_error').show().delay(0).fadeIn('show');
                jQuery('#customer_type_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#customer_type').offset().top - 150
                }, 1000);
                return false;
            }
            /* var surveyor = jQuery("#surveyor").val();
            if (surveyor == '') {
                jQuery('#surveyor_error').html("Please Select Serveyor");
                jQuery('#surveyor_error').show().delay(0).fadeIn('show');
                jQuery('#surveyor_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#surveyor').offset().top - 150
                }, 1000);
                return false;
            } */
            // var service_id = jQuery("#service_id").val();
            // if (service_id == '') {
            //     jQuery('#service_id_error').html("Please Select Source Name");
            //     jQuery('#service_id_error').show().delay(0).fadeIn('show');
            //     jQuery('#service_id_error').show().delay(2000).fadeOut('show');
            //     $('html, body').animate({
            //         scrollTop: $('#service_id').offset().top - 150
            //     }, 1000);
            //     return false;
            // }
            /* var salesman_id = jQuery("#salesman_id").val();
            if (salesman_id == '') {
                jQuery('#salesman_id_error').html("Please Select Sales Person Name");
                jQuery('#salesman_id_error').show().delay(0).fadeIn('show');
                jQuery('#salesman_id_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#salesman_id').offset().top - 150
                }, 1000);
                return false;
            } */
            // var inquiry_type = jQuery("#inquiry_type").val();
            // if (inquiry_type == '') {
            //     jQuery('#inquiry_type_error').html("Please Select Inquiry Type");
            //     jQuery('#inquiry_type_error').show().delay(0).fadeIn('show');
            //     jQuery('#inquiry_type_error').show().delay(2000).fadeOut('show');
            //     $('html, body').animate({
            //         scrollTop: $('#inquiry_type').offset().top - 150
            //     }, 1000);
            //     return false;
            // }
            // if (inquiry_type == 'Inquiry Date') {
            //     var inquiry_date = jQuery("#inquiry_date").val();
            //     if (inquiry_date == '') {
            //         jQuery('#inquiry_date_error').html("Please Enter Inquiry Date");
            //         jQuery('#inquiry_date_error').show().delay(0).fadeIn('show');
            //         jQuery('#inquiry_date_error').show().delay(2000).fadeOut('show');
            //         $('html, body').animate({
            //             scrollTop: $('#inquiry_date').offset().top - 150
            //         }, 1000);
            //         return false;
            //     }
            // }
            // if (inquiry_type == 'Inquiry value') {
            //     var inquiry_value = jQuery("#inquiry_value").val();
            //     if (inquiry_value == '') {
            //         jQuery('#inquiry_value_error').html("Please Enter Moving Value");
            //         jQuery('#inquiry_value_error').show().delay(0).fadeIn('show');
            //         jQuery('#inquiry_value_error').show().delay(2000).fadeOut('show');
            //         $('html, body').animate({
            //             scrollTop: $('#inquiry_value').offset().top - 150
            //         }, 1000);
            //         return false;
            //     }
            // }
            // var move_type = jQuery("#move_type").val();
            // if (move_type == '') {
            //     jQuery('#move_type_error').html("Please Select Move Type");
            //     jQuery('#move_type_error').show().delay(0).fadeIn('show');
            //     jQuery('#move_type_error').show().delay(2000).fadeOut('show');
            //     $('html, body').animate({
            //         scrollTop: $('#move_type').offset().top - 150
            //     }, 1000);
            //     return false;
            // }
            // if (move_type == 'Move Date') {
            //     var move_date = jQuery("#move_date").val();
            //     if (move_date == '') {
            //         jQuery('#move_date_error').html("Please Enter Move Date");
            //         jQuery('#move_date_error').show().delay(0).fadeIn('show');
            //         jQuery('#move_date_error').show().delay(2000).fadeOut('show');
            //         $('html, body').animate({
            //             scrollTop: $('#move_date').offset().top - 150
            //         }, 1000);
            //         return false;
            //     }
            // }
            // if (move_type == 'Move value') {
            //     var move_value = jQuery("#move_value").val();
            //     if (move_value == '') {
            //         jQuery('#move_value_error').html("Please Enter Move Value");
            //         jQuery('#move_value_error').show().delay(0).fadeIn('show');
            //         jQuery('#move_value_error').show().delay(2000).fadeOut('show');
            //         $('html, body').animate({
            //             scrollTop: $('#move_value').offset().top - 150
            //         }, 1000);
            //         return false;
            //     }
            // }
            // var volume = jQuery("#volume").val();
            // if (volume == '') {
            //     jQuery('#volume_error').html("Please Enter Volume");
            //     jQuery('#volume_error').show().delay(0).fadeIn('show');
            //     jQuery('#volume_error').show().delay(2000).fadeOut('show');
            //     $('html, body').animate({
            //         scrollTop: $('#volume').offset().top - 150
            //     }, 1000);
            //     return false;
            // }
            // var customer_name = jQuery("#customer_name").val();
            // if (customer_name == '') {
            //     jQuery('#customer_name_error').html("Please Enter Customer Name");
            //     jQuery('#customer_name_error').show().delay(0).fadeIn('show');
            //     jQuery('#customer_name_error').show().delay(2000).fadeOut('show');
            //     $('html, body').animate({
            //         scrollTop: $('#customer_name').offset().top - 150
            //     }, 1000);
            //     return false;
            // }
            // var customer_email = jQuery("#customer_email").val();
            // if (customer_email == '') {
            //     jQuery('#customer_email_error').html("Please Enter Customer Email");
            //     jQuery('#customer_email_error').show().delay(0).fadeIn('show');
            //     jQuery('#customer_email_error').show().delay(2000).fadeOut('show');
            //     $('html, body').animate({
            //         scrollTop: $('#customer_email').offset().top - 150
            //     }, 1000);
            //     return false;
            // }
            // var em = jQuery('#customer_email').val();
            // var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
            // if (!filter.test(em)) {
            //     jQuery('#customer_email_error').html("Enter Valid Customer Email");
            //     jQuery('#customer_email_error').show().delay(0).fadeIn('show');
            //     jQuery('#customer_email_error').show().delay(2000).fadeOut('show');
            //     $('html, body').animate({
            //         scrollTop: $('#customer_email').offset().top - 150
            //     }, 1000);
            //     return false;
            // }
            // var customer_phone = jQuery("#customer_phone").val();
            // if (customer_phone == '') {
            //     jQuery('#customer_phone_error').html("Please Enter Customer Phone");
            //     jQuery('#customer_phone_error').show().delay(0).fadeIn('show');
            //     jQuery('#customer_phone_error').show().delay(2000).fadeOut('show');
            //     $('html, body').animate({
            //         scrollTop: $('#customer_phone').offset().top - 150
            //     }, 1000);
            //     return false;
            // }
            // if (customer_phone != '') {
            //     var filter = /^\d{7}$/;
            //     if (customer_phone.length < 7 || customer_phone.length > 15) {
            //         jQuery('#customer_phone_error').html("Please Enter Valid Phone Number");
            //         jQuery('#customer_phone_error').show().delay(0).fadeIn('show');
            //         jQuery('#customer_phone_error').show().delay(2000).fadeOut('show');
            //         $('html, body').animate({
            //             scrollTop: $('#customer_phone').offset().top - 150
            //         }, 1000);
            //         return false;
            //     }
            // }
            // var origin = jQuery("#origin").val();
            // if (origin == '') {
            //     jQuery('#origin_error').html("Please Enter Origin");
            //     jQuery('#origin_error').show().delay(0).fadeIn('show');
            //     jQuery('#origin_error').show().delay(2000).fadeOut('show');
            //     $('html, body').animate({
            //         scrollTop: $('#origin').offset().top - 150
            //     }, 1000);
            //     return false;
            // }
            // var destination = jQuery("#destination").val();
            // if (destination == '') {
            //     jQuery('#destination_error').html("Please Enter Destination");
            //     jQuery('#destination_error').show().delay(0).fadeIn('show');
            //     jQuery('#destination_error').show().delay(2000).fadeOut('show');
            //     $('html, body').animate({
            //         scrollTop: $('#destination').offset().top - 150
            //     }, 1000);
            //     return false;
            // }
            // var address = jQuery("#address").val();
            // if (address == '') {
            //     jQuery('#address_error').html("Please Enter Address");
            //     jQuery('#address_error').show().delay(0).fadeIn('show');
            //     jQuery('#address_error').show().delay(2000).fadeOut('show');
            //     $('html, body').animate({
            //         scrollTop: $('#address').offset().top - 150
            //     }, 1000);
            //     return false;
            // }
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
        });
        $(function() {
            $('#move_date').datepicker({
                format: 'yyyy-mm-dd', // Set the desired date format yyyy-mm-dd
                // autoclose: true,
                todayHighlight: true
            });
        });
        $(function() {
            $('#enquiry_date').datepicker({
                format: 'yyyy-mm-dd', // Set the desired date format yyyy-mm-dd
                // autoclose: true,
                todayHighlight: true
            });
        });
        $(function() {
            $('#s_date').datepicker({
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
    {{-- @php
    $company_data = DB::table('agents')->get()->toArray();
    $num_of_items = count($company_data);
    $num_count = 0;
@endphp
     <script>
  $( function() {
    var availableTags = [
    @foreach($company_data as $names)
      @php
      echo "'$names->company_name'";
      $num_count = $num_count + 1;
      if ($num_count < $num_of_items) {
            echo ",";
      }
      @endphp
    @endforeach
    ];
    $( "#company_name" ).autocomplete({
      minLength: 1,
      source: availableTags,
       select: function( event, ui ) {
       }
    });
  } );
  </script> --}}
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
    </script>
  <script>
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
