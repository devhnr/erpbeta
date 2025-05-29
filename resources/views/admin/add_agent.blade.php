@extends('admin.includes.Template')
@section('content')
<style>
    .hidden {
        display: none;
    }
   .arrow {
    border: solid black;
    border-width: 0 3px 3px 0;
    display: inline-block;
    padding: 3px;
    }
    .down {
    transform: rotate(45deg);
    -webkit-transform: rotate(45deg);
    }
</style>
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Organization</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Add Organization</li>
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
                        <!-- <h4 class="card-title">Basic Info</h4> -->
                        <form id="category_form" action="{{ route('agent.store') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="country">Organization Type</label>
                                        <select class="form-control form-select select" id="agent_type" name="agent_type" onchange="checkOrganizeType(this.value);">
                                            <option value="">Select Organization Type</option>
                                            @foreach ($agent_data as $agent)
                                                <option value="{{ $agent->id }}">{{ $agent->agent_type }}</option>
                                            @endforeach
                                        </select>
                                        <p class="form-error-text" id="agent_error" style="color: red; margin-top: 10px;">
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name" id="organization-name-lable">Name</label>
                                        <input id="company_name" name="company_name" type="text" class="form-control"
                                            placeholder="Enter Name" value="" />
                                        <p class="form-error-text" id="company_name_error" style="color: red;"></p>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="name">Website Name</label>
                                        <input id="url" name="url" type="text" class="form-control"
                                            placeholder="Enter Website Name" value="" />
                                        <p class="form-error-text" id="url_error" style="color: red;"></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group industry-type-div">
                                        <label for="industry_type">Industry Type</label>
                                        <select class="form-control form-select select" id="industry_type" name="industry_type">
                                            <option value="">Select Industry Type</option>
                                            @if ($industry_type_data && !empty($industry_type_data))
                                            @foreach($industry_type_data as $data)
                                                <option value="{{ $data->id }}">{{ $data->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        <p class="form-error-text" id="industry_type_error" style="color: red; margin-top: 10px;">
                                        </p>
                                    </div>

                                    <div class="form-group company-role-div" style="display: none;">
                                        <label for="industry_type">Company Role</label>
                                        <select class="form-control form-select select" id="company_role" name="company_role">
                                            <option value="">Select Company Role</option>
                                            @if ($industry_type_data && !empty($industry_type_data))
                                            @foreach($industry_type_data as $data)
                                                <option value="{{ $data->id }}">{{ $data->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        <p class="form-error-text" id="company_role_error" style="color: red; margin-top: 10px;">
                                        </p>
                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="branch">Branch</label>
                                        <select name="branch" id="branch" class="form-control form-select select">
                                            <option value="">Select Branch</option>
                                            @foreach($branch_data as $data)
                                            <option value="{{$data->id}}">{{$data->branch}}</option>
                                            @endforeach
                                        </select>
                                        <p class="form-error-text" id="branch_error" style="color: red; margin-top: 10px;">
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Phone</label>
                                        <input id="phone" name="phone" type="text"
                                            class="form-control" placeholder="Enter  Phone">
                                        <p class="form-error-text" id="phone_error" style="color: red;"></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Others</label>
                                        <input id="others" name="others" type="text"
                                            class="form-control" placeholder="Enter  Others">
                                        <p class="form-error-text" id="other_error" style="color: red;"></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Email</label>
                                        <input id="company_email" name="company_email" type="text" class="form-control"
                                            placeholder="Enter Email" value="" />
                                        <p class="form-error-text" id="email_error" style="color: red;"></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Mobile</label>
                                        <input id="company_telephone" name="company_telephone" type="text"
                                            class="form-control" placeholder="Enter  Mobile"
                                            onkeypress="return validateNumber(event)" value="" />
                                        <p class="form-error-text" id="telephone_error" style="color: red;"></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="branch">No of Employees</label>
                                        <select class="form-control form-select select" id="no_of_emp" name="no_of_emp">
                                            <option value="">Select No of Employees</option>
                                            <option value="1-10">1-10</option>
                                            <option value="11-20">11-20</option>
                                            <option value="21-30">21-30</option>
                                            <option value="31-40">31-40</option>
                                            <option value="41-50">41-50</option>
                                            <option value="50 Above">50 Above</option>
                                        </select>
                                        <p class="form-error-text" id="no_of_emp_error" style="color: red; margin-top: 10px;">
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Parent Company</label>
                                        <input id="parent_company" name="parent_company" type="text" class="form-control"
                                        placeholder="Enter Parent Company" value="" />
                                        <p class="form-error-text" id="parent_company_error" style="color: red;"></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="branch">Annual Revenue</label>
                                        <select class="form-control form-select select" id="annual_revenue" name="annual_revenue">
                                            <option value="">Select Annual Revenue</option>
                                            <option value="1-10 Million">1 - 10 Million</option>
                                            <option value="11-20 Million">11-20 Million</option>
                                            <option value="21-30 Million">21-30 Million</option>
                                            <option value="31-40 Million">31-40 Million</option>
                                            <option value="41-50 Million">41-50 Million</option>
                                            <option value="50 Above Million">50 Above Million</option>
                                        </select>
                                        <p class="form-error-text" id="annual_revenue_error" style="color: red; margin-top: 10px;">
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-6 approve-agent-div">
                                    <div class="form-group">
                                        <label for="approved_agent">Approved Agents</label>
                                        <select name="approved_agent_id" id="approved_agent_id" class="form-control form-select select">
                                            <option value="">Select Approved Agents</option>
                                            @foreach($approved_agent_data as $data)
                                            <option value="{{$data->id}}">{{$data->name}}</option>
                                            @endforeach
                                        </select>
                                        <p class="form-error-text" id="approved_agent_error" style="color: red; margin-top: 10px;">
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="name">Years In Business</label>
                                        <input id="years_in_business" name="years_in_business" type="textarea"
                                            class="form-control" placeholder="Enter Years In Business" value="" />
                                        <p class="form-error-text" id="years_in_business_error" style="color: red;"></p>
                                    </div>
                                </div>
                                <div class="form-group">
                                <input type="checkbox" id="toggleFields" name="toggleFields" onchange="Addressvisibility()" value="0">
                                    <label for="toggleFields"><b>Address Details:</b></label>
                                </div>
                                <p class="form-error-text" id="address_for_arabic_error" style="color: red; margin-top: 10px;display:none;">
                                </p>
                                <div id="address_fields" class="hidden">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="name">Address</label>
                                            <input id="address" name="address" type="text" class="form-control"
                                                placeholder="Enter Address" value="" />
                                            <span class="form-error-text" id="address_for_arabic_error1" style="color: red; margin-top: 10px;">
                                                </span>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="name">Address for Arabic</label>
                                            <input id="address_for_arabic" name="address_for_arabic" type="text" class="form-control"
                                                placeholder="Enter Address for Arabic" value="" />
                                        </div>
                                    </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="country">Country</label>
                                        <select class="form-control form-select select" id="country" name="country">
                                            <option value="">Select country</option>
                                            @foreach ($country_data as $country)
                                                <option value="{{ $country->id }}">{{ $country->country }}</option>
                                            @endforeach
                                        </select>
                                        <p class="form-error-text" id="country_error" style="color: red;"></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="state">State</label>
                                        <input id="state" name="state" type="text" class="form-control"
                                            placeholder="Enter State" value="" />
                                        <p class="form-error-text" id="state_error" style="color: red;"></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">City</label>
                                        <input id="city" name="city" type="text" class="form-control"
                                            placeholder="Enter City" value="" />
                                        <p class="form-error-text" id="city_error" style="color: red;"></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">ZIP/POST Code</label>
                                        <input id="z_code" name="z_code" type="text" class="form-control"
                                            placeholder="Enter ZIP/POST Code" value="" />
                                        <p class="form-error-text" id="z_code_error" style="color: red;"></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                    <input type="checkbox" id="primary_add" name="primary_add" value="0">
                                    <label for="primary_add">Primary Address:</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">State Code</label>
                                        <input id="state_code" name="state_code" type="text" class="form-control"
                                            placeholder="Enter State Code" value="" />
                                        <p class="form-error-text" id="state_code_error" style="color: red;"></p>
                                    </div>
                                </div>
                        </div>

                    </div>
                    <div class="form-group">
                        <input type="checkbox" id="details" name="details" onchange="detailsvisibility()" value="0">
                            <label for="details"><b>Details:</b></label>
                        </div>
                        <p class="form-error-text" id="detai-section-error" style="color: red;display:none;"></p>
                        <div id="details_fields" class="hidden">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="name">Address</label>
                                    <input id="add_details" name="add_details" type="text" placeholder="Enter Address" class="form-control" readonly>
                                    <p class="form-error-text" id="add-details-error" style="color: red;display:none;"></p>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="country">Subsidiary</label>
                                    <select class="form-control form-select select" id="subsidiary" name="subsidiary">
                                        <option value="">Select Subsidiary</option>
                                    </select>
                                    <p class="form-error-text" id="subsidiary-error" style="color: red;display:none;"></p>
                                </div>
                            </div>
                            <div class="col-md-12 trn-no-div">
                                <div class="form-group">
                                    <label for="trn_no">TRN NO.</label>
                                    <input id="trn_no" name="trn_no" type="text" class="form-control"placeholder="Enter TRN NO">
                                    <p class="form-error-text" id="trn-no-error" style="color: red;display:none;"></p>
                                </div>
                            </div>
                            <div class="col-md-12 company-vat-no-div" style="display: none;">
                                <div class="form-group">
                                    <label for="name">Company VAT Number</label>
                                    <input id="company_vat_num" name="company_vat_num" type="text"
                                        class="form-control" placeholder="Enter Company VAT Number" value="" />
                                    <p class="form-error-text" id="company_vat_num_error" style="color: red;"></p>
                                </div>
                            </div>
                        </div>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" id="contracts" name="contracts" onchange="contractsvisibility()" value="0">
                            <label for="contracts"><b>Contracts:</b></label>
                        </div>
                                    <div id="contracts_fields" class="hidden">
                                    <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="name">Name</label>
                                            <input id="name_contracts" name="name_contracts" placeholder="Enter Name" type="text" class="form-control">
                                        </div>
                                    </div>
                            </div>
                            </div>
                                {{-- Name add more start --}}
                            <div class="form-group">
                                <input type="checkbox" id="contact_fields" name="contact_fields" onchange="contactvisibility()" value="0">
                                <label for="contact_fields"><b>Contact:</b></label>
                            </div>
                                <div id="add_more_fields" class="hidden">
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="form-group"> <label for="poc">P.O.C</label>
                                            <input type="text" id="name" name="name[]" class="form-control"
                                                placeholder="Enter P.O.C">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group"> <label for="poc">Email</label>
                                            <input type="text" id="email" name="email[]" class="form-control"
                                                placeholder="Enter Email">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group"> <label for="poc">Telephone</label>
                                            <input type="text" id="telephone" name="telephone[]" class="form-control"
                                                placeholder="Enter Telephone" onkeypress="return validateNumber(event)">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group"> <label for="poc">P.O.C Position/Title</label>
                                            <input type="text" id="role" name="role[]" class="form-control"
                                                placeholder="Enter P.O.C Position/Title">
                                        </div>
                                    </div>
                                </div>
                                <div class="input_fields_wrap12"></div>
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <button
                                            style="border: medium none;margin-right: 50px;line-height: 25px;margin-top: -62px;"
                                            class="submit btn bg-purple pull-right" type="button"
                                            id="add_field_button12">Add</button>
                                    </div>
                                </div>
                            </div>
                        <div class="form-group">
                            <input type="checkbox" id="bank_details" name="bank_details" onchange="bank_detailsvisibility()" value="0">
                            <label for="bank_details"><b>Bank Account Details:</b></label>
                        </div>
                            <div id="bank_details_fields" class="hidden">
                            <div class="row">
                                <div class="col-md-6">
                                <div class="form-group"> <label for="poc">Account Title:</label>
                                    <input type="text" id="ac_title" name="ac_title" class="form-control"
                                        placeholder="Enter Account Title">
                                </div>
                                </div>
                                <div class="col-md-6">
                                <div class="form-group"> <label for="poc">IBAN:</label>
                                    <input type="text" id="iban" name="iban" class="form-control"
                                        placeholder="Enter IBAN">
                                </div>
                                </div>
                                <div class="col-md-6">
                                <div class="form-group"> <label for="poc">Account Number:</label>
                                    <input type="text" id="ac_num" name="ac_num" class="form-control"
                                        placeholder="Enter Account Number">
                                </div>
                                </div>
                                <div class="col-md-6">
                                <div class="form-group"> <label for="poc">BIC:</label>
                                    <input type="text" id="bic" name="bic" class="form-control"
                                        placeholder="Enter BIC">
                                </div>
                                </div>
                                <div class="col-md-6">
                                <div class="form-group"> <label for="poc">SWIFT:</label>
                                    <input type="text" id="swift" name="swift" class="form-control"
                                        placeholder="Enter SWIFT">
                                </div>
                                </div>
                                <div class="col-md-6">
                                <div class="form-group"> <label for="poc">Bank:</label>
                                    <input type="text" id="bank" name="bank" class="form-control"
                                        placeholder="Enter Bank">
                                </div>
                                </div>
                                <div class="col-md-6">
                                <div class="form-group"> <label for="poc">Branch Code:</label>
                                    <input type="text" id="branch_code" name="branch_code" class="form-control"
                                        placeholder="Enter Branch Code">
                                </div>
                                </div>
                                <div class="col-md-6">
                                <div class="form-group"> <label for="poc">Branch Name:</label>
                                    <input type="text" id="branch_name" name="branch_name" class="form-control"
                                        placeholder="Enter Branch Name">
                                </div>
                                </div>
                            </div>
                            </div>
                        <div class="form-group">
                            <input type="checkbox" id="acc_type" name="acc_type" onchange="acc_typevisibility()" value="0">
                            <label for="acc_type"><b>Account Types:</b></label>
                        </div>
                            <div id="acc_type_fields" class="hidden">
                            <div class="row">
                                <div class="col-md-12">
                                <div class="form-group"> <label for="poc">Name</label>
                                    <input type="text" id="acc_type_name" name="acc_type_name" class="form-control"
                                        placeholder="Enter Name">
                                </div>
                                </div>
                            </div>
                            </div>
                        <div class="form-group">
                            <input type="checkbox" id="tax_exception" name="tax_exception" onchange="tax_exceptionvisibility()" value="0">
                            <label for="tax_exception"><b>Tax Exception:</b></label>
                        </div>
                            <div id="tax_exception_fields" class="hidden">
                            <div class="row">
                                <div class="col-md-12">
                                <div class="form-group"> <label for="poc">Name</label>
                                    <input type="text" id="tax_exception_name" name="tax_exception_name" class="form-control"
                                        placeholder="Enter Name">
                                </div>
                                </div>
                            </div>
                            </div>
                        <div class="form-group">
                            <input type="checkbox" id="general_info" name="general_info" onchange="genearal_info_visibility()" value="0">
                            <label for="general_info"><b>General Information:</b></label>
                            <p class="form-error-text" id="general_info-section" style="color: red;"></p>
                        </div>
                        <div id="general_information" class="hidden">
                        <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="RMC_agent">Is RMC Agent</label>
                                        <input type="checkbox" id="RMC_agent" name="RMC_agent" value="0">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="reference">Reference</label>
                                        <select class="form-control form-select select" id="reference" name="reference">
                                            <option value="">Select Reference</option>
                                            @if ($reference_data && !empty($reference_data))
                                            @foreach($reference_data as $data)
                                                <option value="{{ $data->id }}">{{ $data->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        {{-- <input type="text" id="reference" name="reference" class="form-control" placeholder="Enter Reference"> --}}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Status</label>
                                        <select id="active_inactive" name="active_inactive" class="form-control form-select select">
                                            <option value="">Select Active/Inactive</option>
                                            <option value="active">Active</option>
                                            <option value="inactive">Inactive</option>
                                        </select>
                                        <p class="form-error-text" id="active_inactive_error" style="color: red;"></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="grade">Grade</label>
                                        <input type="text" id="grade" name="grade" class="form-control" placeholder="Enter Grade">
                                    </div>
                                </div>

                                @php
                                    $user_data = Auth::user();
                                    $is_read_only = $user_data->role_id != 1;
                                    $SaleID = $is_read_only ? $user_data->id : '';
                                @endphp

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="grade">Assigned To</label>
                                      <select class="form-control multiple select" id="sales_person" name="sales_person" @if($is_read_only) disabled @endif>
                                        <option value="">Select Salesperson</option>
                                        @foreach ($salesman_data as $salesman)
                                                <option value="{{ $salesman->id }}" @if($salesman->id == $SaleID) selected @endif>{{ $salesman->name }}</option>
                                            @endforeach
                                      </select>
                                      <p class="form-error-text" id="sales_person_error" style="color: red;"></p>

                                       @if($is_read_only)
        <input type="hidden" name="sales_person" value="{{ $SaleID }}">
    @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="grade">Created By</label>
                                        <input type="text" id="create_by" name="create_by" class="form-control" placeholder="Enter Created By">
                                        <p class="form-error-text" id="create_by_error" style="color: red;"></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="grade">Last Modified By</label>
                                        <input type="text" id="modified_by" name="modified_by" class="form-control" placeholder="Enter Last Modified By">
                                        <p class="form-error-text" id="modified_by_error" style="color: red;"></p>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label for="description">Description</label>
                                    <div class="form-group">
                                       <textarea id="desc" name="desc" cols="70" rows="10" class="form-control"></textarea>
                                       <p class="form-error-text" id="desc_error" style="color: red;"></p>
                                    </div>
                                </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="checkbox" id="credit_term" name="credit_term" onchange="credit_termvisibility()" value="0">
                                <label for="credit_term"><b>Credit Terms:</b></label>
                            </div>
                            <div id="cerdit_terms" class="hidden">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <textarea name="credit_desc" id="credit_desc" cols="60" rows="10" class="form-control"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">Credit Limit in <span class="credit-currency-type">AED</span></label>
                                            <input id="limit_aed" name="limit_aed" type="text" class="form-control"
                                                placeholder="Enter Credit limit in AED" value="" />
                                            <label for="name">Credit Period in Days</label>
                                            <input id="period_days" name="period_days" type="text" class="form-control"
                                                placeholder="Enter Credit Period in Days" value="" />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <input type="checkbox" id="trade_license" name="trade_license" onchange="trade_license_function()" value="0">
                                <label for="trade_license"><b>Trade license:</b></label>
                            </div>
                            <div id="trade_license_field" class="hidden">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="trade_license_file">Upload File</label>
                                            <input type="file" name="trade_license_file" id="trade_license_file" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="expiry_date">Expiry Date</label>
                                            <input type="date" name="trade_license_expiry_date" id="trade_license_expiry_date" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="checkbox" id="vat_certificate" name="vat_certificate" onchange="vat_certificate_function()" value="0">
                                <label for="vat_certificate"><b>VAT certificate:</b></label>
                            </div>
                            <div id="vat_certificate_field" class="hidden">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="vat_certificate_file">Upload File</label>
                                            <input type="file" name="vat_certificate_file" id="vat_certificate_file" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="checkbox" id="eid" name="eid" onchange="eid_function()" value="0">
                                <label for="eid" id="eid-label"><b>EID:</b></label>
                            </div>
                            <div id="eid_field" class="hidden">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="eid_file">Upload File</label>
                                            <input type="file" name="eid_file" id="eid_file"  class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="expiry_date">Expiry Date</label>
                                            <input type="date" name="eid_expiry_date" id="eid_expiry_date" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group passport-visa-div">
                                <input type="checkbox" id="passport_visa_copies" name="passport_visa_copies" onchange="passport_visa_copies_function()" value="0">
                                <label for="passport_visa_copies"><b>Passport & Visa copies:</b></label>
                            </div>
                            <div id="passport_visa_copies_field" class="hidden passport-visa-div">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="passport_visa_copies_file">Upload File</label>
                                            <input type="file" name="passport_visa_copies_file" id="passport_visa_copies_file"  class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </div>
                            <div class="text-end mt-4">
                                <a class="btn btn-primary" href="{{ route('agent.index') }}"> Cancel</a>
                                <button class="btn btn-primary mb-1" type="button" disabled id="spinner_button"
                                    style="display: none;">
                                    <span class="spinner-border spinner-border-sm" role="status"
                                        aria-hidden="true"></span>
                                    Loading...
                                </button>
                                <button type="button" class="btn btn-primary" onclick="javascript:agent_validation()"
                                    id="submit_button">Submit</button>
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
    <!-- /Main Wrapper -->
    <!-- <script>
        $(function() {
            $("#name").keyup(function() {
                var Text = $(this).val();
                Text = Text.toLowerCase();
                Text = Text.replace(/[^a-zA-Z0-9]+/g, '-');
                $("#page_url").val(Text);
            });
        });
    </script> -->
    <script>
       function checkOrganizeType(element) {
            // 1 => Agent, 3 => Corporate
            let placeHolderLabel, labelName, industryName,industryLabel,creditCurrencyTypePlaceHolder;

            if (element == 1) {
                placeHolderLabel = "Enter Agent Name";
                labelName = "Agent Name";
                industryName = "Company Role";
                industryLabel = "Select Company Role";
                creditCurrencyTypePlaceHolder = "Enter Credit limit in USD";
                $(".company-role-div").show();
                $(".industry-type-div").hide();

                $(".company-vat-no-div").show();
                $(".trn-no-div").hide();

                $(".approve-agent-div").show();
                $(".passport-visa-div").hide();
                $("#eid-label").html('<b>National ID : </b>');
                $(".credit-currency-type").html('USD');

            } else {
                placeHolderLabel = "Enter Company Name";
                labelName = "Company Name";
                industryName = "Industry Type";
                industryLabel = "Select Industry Type";
                creditCurrencyTypePlaceHolder = "Enter Credit limit in AED";
                $(".industry-type-div").show();
                $(".company-role-div").hide();

                $(".trn-no-div").show();
                $(".company-vat-no-div").hide();

                $(".approve-agent-div").hide();
                $(".passport-visa-div").show();
                $("#eid-label").html('<b>EID : </b/>');
                $(".credit-currency-type").html('AED');
            }

            // Update input placeholder
            const $inputElement = $('#company_name');
            if ($inputElement.length) {
                $inputElement.attr('placeholder', placeHolderLabel);
            }
            const $crediLimitInput = $('#limit_aed');
            if ($crediLimitInput.length) {
                $crediLimitInput.attr('placeholder', creditCurrencyTypePlaceHolder);
            }

            // Update organization name label
            const $nameLabel = $('#organization-name-lable');
            if ($nameLabel.length) {
                $nameLabel.html(labelName);
            }

            // Hide or show .poc-section based on element value
           /*  if (element == 3) {
                $(".poc-section").hide();
            } else {
                $(".poc-section").show();
            } */
        }

        function agent_validation() {
            let agentType,companyRole;
            var agent_type = jQuery("#agent_type").val();
            if (agent_type == '') {
                jQuery('#agent_error').html("Please Select Organization Type");
                jQuery('#agent_error').show().delay(0).fadeIn('show');
                jQuery('#agent_error').show().delay(3000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#agent_type').offset().top - 150
                }, 1000);
                return false;
            }

            if(agent_type == 1){
                agentType = "Agent Name";
                companyRole = "Company Role";
            }else{
                agentType = "Company Name";
                companyRole = "Industry Type";
            }
            var name = jQuery("#company_name").val();
           // alert(name)
            if (name == '') {
                jQuery('#company_name_error').html("Please Enter " + agentType);
                jQuery('#company_name_error').show().delay(0).fadeIn('show');
                jQuery('#company_name_error').show().delay(3000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#name').offset().top - 150
                }, 1000);
                return false;
            }
            if(agent_type == 1){

                var company_role = jQuery("#company_role").val();
                if (company_role == '') {
                    jQuery('#company_role_error').html("Please Select " + companyRole);
                    jQuery('#company_role_error').show().delay(0).fadeIn('show');
                    jQuery('#company_role_error').show().delay(3000).fadeOut('show');
                    $('html, body').animate({
                        scrollTop: $('#industry_type').offset().top - 150
                    }, 1000);
                    return false;
                }
            }else{

                var industry_type = jQuery("#industry_type").val();
                if (industry_type == '') {
                    jQuery('#industry_type_error').html("Please Select " + companyRole);
                    jQuery('#industry_type_error').show().delay(0).fadeIn('show');
                    jQuery('#industry_type_error').show().delay(3000).fadeOut('show');
                    $('html, body').animate({
                        scrollTop: $('#industry_type').offset().top - 150
                    }, 1000);
                    return false;
                }

            }
            // var branch = jQuery("#branch").val();
            // if (branch == '') {
            //     jQuery('#branch_error').html("Please Select Branch");
            //     jQuery('#branch_error').show().delay(0).fadeIn('show');
            //     jQuery('#branch_error').show().delay(3000).fadeOut('show');
            //     $('html, body').animate({
            //         scrollTop: $('#branch').offset().top - 150
            //     }, 1000);
            //     return false;
            // }
            var email = jQuery("#company_email").val();

            if (email == '') {
                jQuery('#email_error').html("Please Enter E-mail");
                jQuery('#email_error').show().delay(0).fadeIn('show');
                jQuery('#email_error').show().delay(3000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#company_email').offset().top - 150
                }, 1000);
                return false;
            }

            var emailPattern = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
            if (!emailPattern.test(email)) {

                jQuery('#email_error').html("Please enter a valid email address.");
                jQuery('#email_error').show().delay(0).fadeIn('show');
                jQuery('#email_error').show().delay(3000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#company_email').offset().top - 150
                }, 1000);
                return false;
            }

            $.ajax({
               type: "POST",
               url: "{{ url('check-email-exits') }}",
               data: {
                   "_token": "{{ csrf_token() }}",
                   "email": email,
               },
               success: function(responses) {

                   /* if (responses.message == 'EXITS') {

                        jQuery('#email_error').html("The email address already exists!");
                        jQuery('#email_error').show().delay(0).fadeIn('show');
                        jQuery('#email_error').show().delay(3000).fadeOut('show');
                        $('html, body').animate({
                            scrollTop: $('#company_email').offset().top - 150
                        }, 1000);
                        return false;
                   }else{ */

                        var mobile = jQuery("#company_telephone").val();
                        if (mobile == '') {

                            jQuery('#telephone_error').html("Please Enter Mobile Number");
                            jQuery('#telephone_error').show().delay(0).fadeIn('show');
                            jQuery('#telephone_error').show().delay(2000).fadeOut('show');
                            $('html, body').animate({
                                scrollTop: $('#company_telephone').offset().top - 150
                            }, 1000);
                            return false;
                        }

                        if (mobile != '') {
                            // var filter = /^\d{7}$/;
                            if (mobile.length < 7 || mobile.length > 15) {
                                jQuery('#telephone_error').html("Please Enter Valid Mobile Number");
                                jQuery('#telephone_error').show().delay(0).fadeIn('show');
                                jQuery('#telephone_error').show().delay(2000).fadeOut('show');
                                $('html, body').animate({
                                    scrollTop: $('#company_telephone').offset().top - 150
                                }, 1000);
                                return false;
                            }
                        }

                       

                        if ($('#toggleFields').prop('checked')) {
                            var address = jQuery("#address").val();
                            if (address == '') {
                                jQuery('#address_for_arabic_error1').html("Please Enter Address");
                                jQuery('#address_for_arabic_error1').show().delay(0).fadeIn('show');
                                jQuery('#address_for_arabic_error1').show().delay(3000).fadeOut('show');
                                $('html, body').animate({
                                    scrollTop: $('#address').offset().top - 150
                                }, 1000);
                                return false;
                            }

                            var country = jQuery("#country").val();
                            if (country == '') {
                                jQuery('#country_error').html("Please Select Country");
                                jQuery('#country_error').show().delay(0).fadeIn('show');
                                jQuery('#country_error').show().delay(3000).fadeOut('show');
                                $('html, body').animate({
                                    scrollTop: $('#country').offset().top - 150
                                }, 1000);
                                return false;
                            }

                            var state = jQuery("#state").val();
                            if (state == '') {
                                jQuery('#state_error').html("Please Enter State");
                                jQuery('#state_error').show().delay(0).fadeIn('show');
                                jQuery('#state_error').show().delay(3000).fadeOut('show');
                                $('html, body').animate({
                                    scrollTop: $('#state').offset().top - 150
                                }, 1000);
                                return false;
                            }

                            var city = jQuery("#city").val();
                            if (city == '') {
                                jQuery('#city_error').html("Please Enter City");
                                jQuery('#city_error').show().delay(0).fadeIn('show');
                                jQuery('#city_error').show().delay(3000).fadeOut('show');
                                $('html, body').animate({
                                    scrollTop: $('#city').offset().top - 150
                                }, 1000);
                                return false;
                            }

                        }else{

                            var address = jQuery("#address").val();
                            if (address == '') {
                                jQuery('#address_for_arabic_error').html("Please Enter Address In Address Details");
                                jQuery('#address_for_arabic_error').show().delay(0).fadeIn('show');
                                jQuery('#address_for_arabic_error').show().delay(3000).fadeOut('show');
                                $('html, body').animate({
                                    scrollTop: $('#toggleFields').offset().top - 150
                                }, 1000);
                                return false;
                            }

                        }


                        if ($('#general_info').prop('checked')) {

                            var activeInactive = jQuery("#active_inactive").val();
                            if (activeInactive == '') {
                                jQuery('#active_inactive_error').html("Please Select Status");
                                jQuery('#active_inactive_error').show().delay(0).fadeIn('show');
                                jQuery('#active_inactive_error').show().delay(3000).fadeOut('show');
                                $('html, body').animate({
                                    scrollTop: $('#active_inactive').offset().top - 150
                                }, 1000);
                                return false;
                            }

                            var sales_person = jQuery("#sales_person").val();
                            if (sales_person == '') {
                                jQuery('#sales_person_error').html("Please Select Assigned To");
                                jQuery('#sales_person_error').show().delay(0).fadeIn('show');
                                jQuery('#sales_person_error').show().delay(3000).fadeOut('show');
                                $('html, body').animate({
                                    scrollTop: $('#sales_person').offset().top - 150
                                }, 1000);
                                return false;
                            }

                            var create_by = jQuery("#create_by").val();
                            if (create_by == '') {
                                jQuery('#create_by_error').html("Please Enter Created By");
                                jQuery('#create_by_error').show().delay(0).fadeIn('show');
                                jQuery('#create_by_error').show().delay(3000).fadeOut('show');
                                $('html, body').animate({
                                    scrollTop: $('#create_by').offset().top - 150
                                }, 1000);
                                return false;
                            }
                            // var modified_by = jQuery("#modified_by").val();
                            // if (modified_by == '') {
                            //     jQuery('#modified_by_error').html("Please Enter Last Modified By");
                            //     jQuery('#modified_by_error').show().delay(0).fadeIn('show');
                            //     jQuery('#modified_by_error').show().delay(3000).fadeOut('show');
                            //     $('html, body').animate({
                            //         scrollTop: $('#modified_by').offset().top - 150
                            //     }, 1000);
                            //     return false;
                            // }
                            // var desc = jQuery("#desc").val();
                            // if (desc == '') {
                            //     jQuery('#desc_error').html("Please Enter Description");
                            //     jQuery('#desc_error').show().delay(0).fadeIn('show');
                            //     jQuery('#desc_error').show().delay(3000).fadeOut('show');
                            //     $('html, body').animate({
                            //         scrollTop: $('#desc').offset().top - 150
                            //     }, 1000);
                            //     return false;
                            // }

                        }else{

                            var activeInactive = jQuery("#active_inactive").val();
                            if (activeInactive == '') {
                                jQuery('#general_info-section').html("Please Select Status In General Information");
                                jQuery('#general_info-section').show().delay(0).fadeIn('show');
                                jQuery('#general_info-section').show().delay(3000).fadeOut('show');
                                $('html, body').animate({
                                    scrollTop: $('#general_info').offset().top - 150
                                }, 1000);
                                return false;
                            }
                        }
                        $('#spinner_button').show();
                        $('#submit_button').hide();
                        $('#category_form').submit();
                   //}
               }
           });
            /*  */
        }
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
    <script type="text/javascript" language="javascript">
        $(document).ready(function() {
            var max_fields = 50;
            var wrapper = $(".input_fields_wrap12");
            var add_button = $("#add_field_button12");
            var b = 0;
            $(add_button).click(function(e) { //alert('ok');
                e.preventDefault();
                if (b < max_fields) {
                    b++;
                    $(wrapper).append(
                        '<div class="row"><div class="col-md-2"><div class = "form-group"><label for = "poc">P.O.C</label><input type = "text" id= "name" name = "name[]" class = "form-control" placeholder = "Enter P.O.C"></div></div ><div class = "col-md-2"><div class = "form-group"><label for = "poc">Email</label><input type = "text" id = "email" name = "email[]" class = "form-control" placeholder = "Enter Email"></div></div ><div class = "col-md-2"><div class = "form-group"><label for = "poc">Telephone </label><input type = "text" id = "telephone" name = "telephone[]" class = "form-control" placeholder = "Enter Telephone" onkeypress="return validateNumber(event)"></div></div><div class = "col-md-2"><div class = "form-group"><label for = "poc" >P.O.C Position/Title</label><input type = "text" id = "role" name = "role[]" class = "form-control" placeholder = "Enter P.O.C Position/Title"></div></div><a href = "#" class = "btn btn-danger pull-right remove_field1" style="margin-right: 0;margin-top: 23px;width: 10%;float: right;height:38px;margin-left: 127px;">Remove</a ></div>'
                    );
                }
            });
            $(wrapper).on("click", ".remove_field1", function(e) {
                e.preventDefault();
                $(this).parent('div').remove();
                b--;
            })
        });
    </script>
    <script>
        var countryData = {
            @foreach ($country_data as $country)
                "{{ $country->id }}": "{{ $country->country }}",
            @endforeach
        };
    </script>
       <script>
        $(function() {
            function formatDetails() {
                var address = $("#address").val();
                var countryId = $("#country").val();
                var state = $("#state").val();
                var city = $("#city").val();
                var countryName = countryData[countryId];
                var combinedText = address + " " + city + " " + state + " " + countryName;
                // combinedText = combinedText.toLowerCase();
                combinedText = combinedText.replace(/[^a-zA-Z0-9]+/g, ',');
                $("#add_details").val(combinedText);
            }
            $("#address, #country, #state, #city").keyup(formatDetails);
        });
    </script>
    <script>
        $(".multiple").select2({
            placeholder: "Select Sales Person" // Replace with your desired placeholder text
        });
    </script>
     <script>
        function Addressvisibility() {
            const checkbox = document.getElementById('toggleFields');
            const container = document.getElementById('address_fields');
            if (checkbox.checked) {
                container.classList.remove('hidden');
            } else {
                container.classList.add('hidden');
            }
        }
        function contactvisibility() {
            const checkbox = document.getElementById('contact_fields');
            const container = document.getElementById('add_more_fields');
            if (checkbox.checked) {
                container.classList.remove('hidden');
            } else {
                container.classList.add('hidden');
            }
        }
        function credit_termvisibility() {
            const checkbox = document.getElementById('credit_term');
            const container = document.getElementById('cerdit_terms');
            if (checkbox.checked) {
                container.classList.remove('hidden');
            } else {
                container.classList.add('hidden');
            }
        }
        function genearal_info_visibility() {
            const checkbox = document.getElementById('general_info');
            const container = document.getElementById('general_information');
            if (checkbox.checked) {
                container.classList.remove('hidden');
            } else {
                container.classList.add('hidden');
            }
        }
        function detailsvisibility() {
            const checkbox = document.getElementById('details');
            const container = document.getElementById('details_fields');
            if (checkbox.checked) {
                container.classList.remove('hidden');
            } else {
                container.classList.add('hidden');
            }
        }
        function contractsvisibility() {
            const checkbox = document.getElementById('contracts');
            const container = document.getElementById('contracts_fields');
            if (checkbox.checked) {
                container.classList.remove('hidden');
            } else {
                container.classList.add('hidden');
            }
        }
        function bank_detailsvisibility() {
            const checkbox = document.getElementById('bank_details');
            const container = document.getElementById('bank_details_fields');
            if (checkbox.checked) {
                container.classList.remove('hidden');
            } else {
                container.classList.add('hidden');
            }
        }
        function acc_typevisibility() {
            const checkbox = document.getElementById('acc_type');
            const container = document.getElementById('acc_type_fields');
            if (checkbox.checked) {
                container.classList.remove('hidden');
            } else {
                container.classList.add('hidden');
            }
        }
        function tax_exceptionvisibility() {
            const checkbox = document.getElementById('tax_exception');
            const container = document.getElementById('tax_exception_fields');
            if (checkbox.checked) {
                container.classList.remove('hidden');
            } else {
                container.classList.add('hidden');
            }
        }

        function trade_license_function() {
            const checkbox = document.getElementById('trade_license');
            const container = document.getElementById('trade_license_field');
            if (checkbox.checked) {
                container.classList.remove('hidden');
            } else {
                container.classList.add('hidden');
            }
        }
        function vat_certificate_function() {
            const checkbox = document.getElementById('vat_certificate');
            const container = document.getElementById('vat_certificate_field');
            if (checkbox.checked) {
                container.classList.remove('hidden');
            } else {
                container.classList.add('hidden');
            }
        }
        function eid_function() {
            const checkbox = document.getElementById('eid');
            const container = document.getElementById('eid_field');
            if (checkbox.checked) {
                container.classList.remove('hidden');
            } else {
                container.classList.add('hidden');
            }
        }
        function passport_visa_copies_function() {
            const checkbox = document.getElementById('passport_visa_copies');
            const container = document.getElementById('passport_visa_copies_field');
            if (checkbox.checked) {
                container.classList.remove('hidden');
            } else {
                container.classList.add('hidden');
            }
        }
        $(document).ready(function() {
                $('#country').select2();
            });
    </script>
@stop
