<!-- @extends('admin.includes.Template') -->
@section('content')
<style>
    .hidden {
        display: none;
    }
</style>
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Edit Organization</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('agent.index') }}">Agent</a></li>
                        <li class="breadcrumb-item active">Edit Organization</li>
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
                        <form id="service_form" action="{{ route('agent.update', $agent->id) }}" method="POST"
                            enctype="multipart/form-data">
                            <input type="hidden" name="agent_type" value="{{ $agent->agent_type }}">
                            @csrf
                            @method('PUT')
                            {{-- @php
                            echo "<pre>";print_r($agent);echo"</pre>";exit;@endphp --}}
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="country">Organization Id</label>
                                       <input type="text" name="organization_id" class="form-control" id="organization_id" value="{{ $agent->organization_id }}" readonly>
                                    </div>
                                </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="country">Organization type</label>
                                    <select class="form-control form-select select" id="agent_type" name="agent_type" onchange="checkOrganizeType(this.value);">
                                        <option value="">Select Organization type</option>
                                        @foreach ($agent_data as $agents)
                                            <option value="{{ $agents->id }}"
                                                {{ $agents->id == $agent->agent_type ? 'selected' : '' }}>
                                                {{ $agents->agent_type }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <p class="form-error-text" id="agent_error" style="color: red; margin-top: 10px;"></p>
                                </div>
                            </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name" id="organization-name-lable">Name</label>
                                        <input id="company_name" name="company_name" type="input" class="form-control"
                                            placeholder="Enter Name" value="{{ $agent->company_name }}" />
                                        <p class="form-error-text" id="company_name_error" style="color: red;"></p>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="name">Website Name</label>
                                        <input id="url" name="url" type="input" class="form-control"
                                            placeholder="Enter Website Name" value="{{ $agent->url }}" />
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
                                                <option value="{{ $data->id }}" {{ $agent->industry_type == $data->id ? 'selected' : '' }}>{{ $data->name }}</option>
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
                                                <option value="{{ $data->id }}" {{ $agent->industry_type == $data->id ? 'selected' : '' }}>{{ $data->name }}</option>
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
                                                <option value="{{ $data->id }}" {{ $data->id == $agent->branch ? 'selected' : '' }}>
                                                    {{ $data->branch }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <p class="form-error-text" id="branch_error" style="color: red; margin-top: 10px;">
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Phone</label>
                                        <input id="phone" name="phone" type="input"
                                            class="form-control" placeholder="Enter Phone" value="{{ $agent->phone }}">
                                        <p class="form-error-text" id="phone_error" style="color: red;"></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Others</label>
                                        <input id="others" name="others" type="input"
                                            class="form-control" placeholder="Enter  Others" value="{{ $agent->others }}">
                                        <p class="form-error-text" id="other_error" style="color: red;"></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Email</label>
                                        <input id="company_email" name="company_email" type="input" class="form-control"
                                            placeholder="Enter Email" value="{{ $agent->company_email }}" />
                                            <p class="form-error-text" id="email_error" style="color: red;"></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Mobile</label>
                                        <input id="company_telephone" name="company_telephone" type="input"
                                            class="form-control" placeholder="Enter Mobile"
                                            onkeypress="return validateNumber(event)"
                                            value="{{ $agent->company_telephone }}" />
                                            <p class="form-error-text" id="telephone_error" style="color: red;"></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="branch">No of Employees</label>
                                        <select class="form-control form-select select" id="no_of_emp" name="no_of_emp">
                                            <option value="">Select No of Employees</option>
                                            <option value="1-10" @if($agent->no_of_emp == "1-10") selected @endif>1-10</option>
                                            <option value="11-20" @if($agent->no_of_emp == "11-20") selected @endif>11-20</option>
                                            <option value="21-30" @if($agent->no_of_emp == "21-30") selected @endif>21-30</option>
                                            <option value="31-40" @if($agent->no_of_emp == "31-40") selected @endif>31-40</option>
                                            <option value="41-50" @if($agent->no_of_emp == "41-50") selected @endif>41-50</option>
                                            <option value="50 Above" @if($agent->no_of_emp == "50 Above") selected @endif>50 Above</option>
                                        </select>
                                        <p class="form-error-text" id="no_of_emp_error" style="color: red; margin-top: 10px;">
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="parent_company">Parent Company</label>
                                        <input id="parent_company" name="parent_company" type="input" class="form-control"
                                        placeholder="Enter Parent Company" value="{{ $agent->parent_company }}" />
                                        <p class="form-error-text" id="parent_company_error" style="color: red;"></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="branch">Annual Revenue</label>
                                        <select class="form-control form-select select" id="annual_revenue" name="annual_revenue">
                                        <option value="">Select Annual Revenue</option>
                                            <option value="1-10 Million" @if($agent->annual_revenue == "1-10 Million") selected @endif>1-10 Million</option>
                                            <option value="11-20 Million" @if($agent->annual_revenue == "11-20 Million") selected @endif>11-20 Million</option>
                                            <option value="21-30 Million" @if($agent->annual_revenue == "21-30 Million") selected @endif>21-30 Million</option>
                                            <option value="31-40 Million" @if($agent->annual_revenue == "31-40 Million") selected @endif>31-40 Million</option>
                                            <option value="41-50 Million" @if($agent->annual_revenue == "41-50 Million") selected @endif>41-50 Million</option>
                                            <option value="50 Above Million" @if($agent->annual_revenue == "50 Above Million") selected @endif>50 Above Million</option>
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
                                            <option value="{{$data->id}}" {{ $data->id == $agent->approved_agent_id ? 'selected' : '' }}>{{$data->name}}</option>
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
                                        class="form-control" placeholder="Enter Years In Business"
                                        value="{{ $agent->years_in_business }}" />
                                        <p class="form-error-text" id="years_in_business_error" style="color: red;"></p>
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="checkbox" id="toggleFields" name="toggleFields" onchange="Addressvisibility()" value="{{ $agent->toggleFields }}"  @if($agent->toggleFields == 0) checked @endif>
                                    <label for="toggleFields"><b>Address Details:</b></label>
                            </div>
                            <p class="form-error-text" id="address_for_arabic_error" style="color: red; margin-top: 10px;display:none;">
                            </p>
                            <div id="address_fields" class="hidden">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="name">Address</label>
                                            <input id="address" name="address" type="input" class="form-control add_val_blank"
                                                placeholder="Enter Address" value="{{ $agent->address }}" />
                                                <span class="form-error-text" id="address_for_arabic_error1" style="color: red; margin-top: 10px;">
                                                </span>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="name">Address for Arabic</label>
                                            <input id="address_for_arabic" name="address_for_arabic" type="input" class="form-control add_val_blank"
                                                placeholder="Enter Address for Arabic" value="{{ $agent->address_for_arabic }}" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="country">Country</label>
                                            <select class="form-control add_val_blank form-select select" id="country" name="country">
                                                <option value="">Select Country</option>
                                                @foreach ($country_data as $country)
                                                    <option value="{{ $country->id }}"
                                                        {{ $country->id == $agent->country ? 'selected' : '' }}>
                                                        {{ $country->country }}</option>
                                                @endforeach
                                            </select>
                                            <p class="form-error-text" id="country_error" style="color: red; margin-top: 10px;">
                                            </p>
                                        </div>
                                    </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="state">State</label>
                                        <input id="state" name="state" type="input" class="form-control add_val_blank" value="{{ $agent->state }}"
                                            placeholder="Enter State" value="" />
                                        <p class="form-error-text" id="state_error" style="color: red;"></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">City</label>
                                        <input id="city" name="city" type="input" class="form-control add_val_blank"
                                            placeholder="Enter City" value="{{ $agent->city }}" />
                                        <p class="form-error-text" id="city_error" style="color: red;"></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">ZIP/POST Code</label>
                                        <input id="z_code" name="z_code" type="input" class="form-control add_val_blank"
                                            placeholder="Enter ZIP/POST Code" value="{{ $agent->z_code }}" />
                                        <p class="form-error-text" id="z_code_error" style="color: red;"></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                    <input type="checkbox" id="primary_add" name="primary_add" class="add_val_blank" value="{{$agent->primary_add }}"  @if($agent->primary_add == 0) checked @endif>
                                    <label for="primary_add">Primary Address:</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">State Code</label>
                                    <input id="state_code" name="state_code" type="input" class="form-control add_val_blank"
                                        placeholder="Enter State Code" value="" />
                                        <p class="form-error-text" id="state_code_error" style="color: red;"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" id="details" name="details" onchange="detailsvisibility()" value="{{ $agent->details }}"  @if($agent->details == 0) checked @endif>
                                <label for="details"><b>Details:</b></label>
                            </div>
                            <p class="form-error-text" id="detai-section-error" style="color: red;display:none;"></p>
                            <div id="details_fields" class="hidden">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="name">Address</label>
                                        <input id="add_details" name="add_details" type="input" class="form-control detail_val_blank" value="{{ $agent->add_details }}" readonly>
                                        <p class="form-error-text" id="add-details-error" style="color: red;display:none;"></p>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="country">Subsidiary</label>
                                        <select class="form-control detail_val_blank form-select select" id="subsidiary" name="subsidiary" >
                                            <option value="">Select Subsidiary</option>
                                        </select>
                                        <p class="form-error-text" id="subsidiary-error" style="color: red;display:none;"></p>
                                    </div>
                                </div>
                                <div class="col-md-12 trn-no-div">
                                    <div class="form-group">
                                        <label for="trn_no">TRN NO.</label>
                                        <input id="trn_no" name="trn_no" type="text" value="{{ $agent->trn_no }}" class="form-control detail_val_blank"placeholder="Enter TRN NO">
                                        <p class="form-error-text" id="trn-no-error" style="color: red;display:none;"></p>
                                    </div>
                                </div>
                                <div class="col-md-12 company-vat-no-div" style="display: none;">
                                    <div class="form-group">
                                        <label for="name">Company VAT Number</label>
                                        <input id="company_vat_num" name="company_vat_num" type="text"
                                            class="form-control" placeholder="Enter Company Vat Num"
                                            value="{{ $agent->company_vat_num }}" />
                                        <p class="form-error-text" id="company_vat_num_error" style="color: red;"></p>
                                    </div>
                                </div>
                            </div>
                            </div>
                            <div class="form-group">
                                <input type="checkbox" id="contracts" name="contracts" onchange="contractsvisibility()" value="{{ $agent->contracts }}"  @if($agent->contracts == 0) checked @endif>
                                <label for="contracts"><b>Contracts:</b></label>
                            </div>
                                        <div id="contracts_fields" class="hidden">
                                        <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="name">Name</label>
                                                <input id="name_contracts" name="name_contracts" type="input" class="form-control contract_val_blank" value="{{ $agent->name_contracts }}">
                                            </div>
                                        </div>
                                </div>
                                </div>
                                {{-- add more start --}}
                    <div class="form-group">
                        <input type="checkbox" id="contact_fields" name="contact_fields" onchange="contactvisibility()" value="{{ $agent->contact_fields }}"  @if($agent->contact_fields == 0) checked @endif>
                        <label for="contact_fields"><b>Contact:</b></label>
                    </div>
                                <div id="add_more_fields" class="hidden">
                                <div class="row">
                                @if ($attribute_data != '')
                                    <input type="hidden" name="name1[]" value="">
                                    <input type="hidden" name="email1[]" value="">
                                    <input type="hidden" name="telephone1[]" value="">
                                    <input type="hidden" name="role1[]" value="">
                                    @for ($i = 0; $i < count($attribute_data); $i++)
                                        <div class="row">
                                            <input type="hidden" name="updateid1xxx[]"
                                                id="updateid1xxx{{ $i + 1 }}"
                                                value="{{ $attribute_data[$i]->id }}">
                                            <div class="col-md-2">
                                                <div class="form-group"> <label for="poc">P.O.C</label>
                                                    <input type="text" id="nameu" name="nameu[]"
                                                        class="form-control contact_del_blank" placeholder="Enter P.O.C"
                                                        value="{{ $attribute_data[$i]->name }}">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group"> <label for="poctitle">Email</label>
                                                    <input type="text" id="emailu" name="emailu[]"
                                                        class="form-control contact_del_blank" placeholder="Enter  Email"
                                                        value="{{ $attribute_data[$i]->email }}">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group"> <label for="email">Telephone</label>
                                                    <input type="text" id="telephoneu" name="telephoneu[]"
                                                        class="form-control contact_del_blank" placeholder="Enter Telephone"
                                                        value="{{ $attribute_data[$i]->telephone }}"
                                                        onkeypress="return validateNumber(event)">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group"> <label for="telephone">P.O.C Position/Title</label>
                                                    <input type="text" id="roleu" name="roleu[]"
                                                        class="form-control contact_del_blank" placeholder="Enter P.O.C Position/Title"
                                                        value="{{ $attribute_data[$i]->role }}">
                                                </div>
                                            </div>
                                            <a href="{{ route('add_new_inq', ['agent_id' => $attribute_data[$i]->agent_id, 'attr_id' => $attribute_data[$i]->id]) }}"
                                                class="btn btn-primary pull-right "
                                                style="margin-right: 0;margin-top: 22px;width: 9%;float: right;height: 40px;margin-left: 0px;">Add
                                                Inquiry</a>
                                            <a href="#"
                                                onclick="singledelete('{{ route('remove_agent_att', ['agent_id' => $attribute_data[$i]->agent_id, 'id' => $attribute_data[$i]->id]) }}')"
                                                class="btn btn-danger pull-right remove_field1"
                                                style="margin-right: 0;margin-top: 22px;width: 9%;float: right;height: 40px;margin-left: 80px;">Remove</a>
                                        </div>
                                    @endfor
                                @endif
                                @php
                                    $test = count($attribute_data);
                                    if ($test > 0) {
                                        $style = 'display:none';
                                    } else {
                                        $style = 'display:block';
                                    }
                                @endphp
                                <span style="@php echo $style; @endphp">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="form-group"> <label for="poc">P.O.C</label>
                                                <input type="text" id="name" name="name1[]" class="form-control"
                                                    placeholder="Enter P.O.C">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group"> <label for="poctitle">Email</label>
                                                <input type="text" id="email" name="email1[]"
                                                    class="form-control" placeholder="Enter Email">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group"> <label for="telephone">Telephone</label>
                                                <input type="text" id="telephone" name="telephone1[]"
                                                    onkeypress="return validateNumber(event)" class="form-control"
                                                    placeholder="Enter Telephone">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group"> <label for="email">P.O.C Position/Title</label>
                                                <input type="text" id="role" name="role1[]" class="form-control"
                                                    placeholder="Enter P.O.C Position/Title">
                                            </div>
                                        </div>
                                    </div>
                                </span>
                                <div class="input_fields_wrap12"> </div>
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <button
                                            style="border: medium none;margin-right: 50px;line-height: 26px;margin-top: -62px;"
                                            class="submit btn bg-purple pull-right" type="button"
                                            id="add_field_button12">Add</button>
                                    </div>
                                </div>
                                {{-- add more End --}}
                            </div>
                            </div>
                            <div class="form-group">
                                <input type="checkbox" id="bank_details" name="bank_details" onchange="bank_detailsvisibility()" value="{{ $agent->bank_details }}"  @if($agent->bank_details == 0) checked @endif>
                                <label for="bank_details"><b>Bank Account Details:</b></label>
                            </div>
                                <div id="bank_details_fields" class="hidden">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group"> <label for="poc">Account Title:</label>
                                            <input type="text" id="ac_title" name="ac_title" class="form-control"
                                                placeholder="Enter Account Title" value="{{ $agent->ac_title }}">
                                        </div>
                                        </div>
                                        <div class="col-md-6">
                                        <div class="form-group"> <label for="poc">IBAN:</label>
                                            <input type="text" id="iban" name="iban" class="form-control"
                                                placeholder="Enter IBAN" value="{{ $agent->iban }}">
                                        </div>
                                        </div>
                                        <div class="col-md-6">
                                        <div class="form-group"> <label for="poc">Account Number:</label>
                                            <input type="text" id="ac_num" name="ac_num" class="form-control"
                                                placeholder="Enter Account Number" value="{{ $agent->ac_num }}">
                                        </div>
                                        </div>
                                        <div class="col-md-6">
                                        <div class="form-group"> <label for="poc">BIC:</label>
                                            <input type="text" id="bic" name="bic" class="form-control"
                                                placeholder="Enter BIC" value="{{ $agent->bic }}">
                                        </div>
                                        </div>
                                        <div class="col-md-6">
                                        <div class="form-group"> <label for="poc">SWIFT:</label>
                                            <input type="text" id="swift" name="swift" class="form-control"
                                                placeholder="Enter SWIFT" value="{{ $agent->swift }}">
                                        </div>
                                        </div>
                                        <div class="col-md-6">
                                        <div class="form-group"> <label for="poc">Bank:</label>
                                            <input type="text" id="bank" name="bank" class="form-control"
                                                placeholder="Enter Bank" value="{{ $agent->bank }}">
                                        </div>
                                        </div>
                                        <div class="col-md-6">
                                        <div class="form-group"> <label for="poc">Branch Code:</label>
                                            <input type="text" id="branch_code" name="branch_code" class="form-control"
                                                placeholder="Enter Branch Code" value="{{ $agent->branch_code }}">
                                        </div>
                                        </div>
                                        <div class="col-md-6">
                                        <div class="form-group"> <label for="poc">Branch Name:</label>
                                            <input type="text" id="branch_name" name="branch_name" class="form-control"
                                                placeholder="Enter Branch Name" value="{{ $agent->branch_name }}">
                                        </div>
                                        </div>
                                </div>
                                </div>
                                <div class="form-group">
                                    <input type="checkbox" id="acc_type" name="acc_type" onchange="acc_typevisibility()" value="{{ $agent->acc_type }}"  @if($agent->acc_type == 0) checked @endif>
                                    <label for="acc_type"><b>Account Types:</b></label>
                                </div>
                                    <div id="acc_type_fields" class="hidden">
                                    <div class="row">
                                        <div class="col-md-12">
                                        <div class="form-group"> <label for="poc">Name</label>
                                            <input type="text" id="acc_type_name" name="acc_type_name" class="form-control acc_type_blank"
                                                placeholder="Enter Name" value="{{ $agent->acc_type_name }}">
                                        </div>
                                        </div>
                                    </div>
                                    </div>
                                <div class="form-group">
                                    <input type="checkbox" id="tax_exception" name="tax_exception" onchange="tax_exceptionvisibility()" value="{{ $agent->tax_exception }}"  @if($agent->tax_exception == 0) checked @endif>
                                    <label for="tax_exception"><b>Tax Exception:</b></label>
                                </div>
                                    <div id="tax_exception_fields" class="hidden">
                                    <div class="row">
                                        <div class="col-md-12">
                                        <div class="form-group"> <label for="poc">Name</label>
                                            <input type="text" id="tax_exception_name" name="tax_exception_name" class="form-control tex_val_blank" value="{{ $agent->tax_exception_name }}"
                                                placeholder="Enter Name">
                                        </div>
                                        </div>
                                    </div>
                                    </div>
                                    <div class="form-group">
                                        <input type="checkbox" id="general_info" name="general_info" onchange="genearal_info_visibility()" value="{{$agent->general_info }}"  @if($agent->general_info == 0) checked @endif>
                                        <label for="general_info"><b>General Information:</b></label>
                                        <p class="form-error-text" id="general_info-section" style="color: red;"></p>
                                    </div>
                                    <div id="general_information" class="hidden">
                                    <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="RMC_agent">Is RMC Agent</label>
                                                    <input type="checkbox" id="RMC_agent" name="RMC_agent" class="gen_info_blank" value="{{$agent->RMC_agent }}"  @if($agent->RMC_agent == 0) checked @endif>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="reference">Reference</label>
                                                    <select class="form-control form-select select" id="reference" name="reference">
                                                        <option value="">Select Reference</option>
                                                        @if ($reference_data && !empty($reference_data))
                                                        @foreach($reference_data as $data)
                                                            <option value="{{ $data->id }}" {{ $agent->reference == $data->id ? 'selected' : '' }}>{{ $data->name }}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                    {{-- <input type="text" id="reference" name="reference" class="form-control gen_info_blank" placeholder="Enter Reference" value="{{$agent->reference }}" > --}}
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="name">Active / Inactive</label>
                                                    <select id="active_inactive" name="active_inactive" class="form-control form-select gen_info_blank select">
                                                        <option value="">Select Active/Inactive</option>
                                                        <option value="active"
                                                            @if ($agent->active_inactive == 'active') {{ 'selected' }} @endif>Active</option>
                                                        <option value="inactive"
                                                            @if ($agent->active_inactive == 'inactive') {{ 'selected' }} @endif>Inactive</option>
                                                    </select>
                                                    <p class="form-error-text" id="active_inactive_error" style="color: red;"></p>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="grade">Grade</label>
                                                    <input type="text" id="grade" name="grade" class="form-control gen_info_blank" placeholder="Enter Grade" value="{{$agent->grade }}">
                                                </div>
                                            </div>

                                            @php
                                                $user_data = Auth::user();
                                                $is_read_only = $user_data->role_id != 1;
                                            @endphp


                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="grade">Assigned To</label>
                                                  <select class="form-control multiple gen_info_blank select" id="sales_person" name="sales_person" @if($is_read_only) disabled @endif>
                                                    <option value="">Select Salesperson</option>
                                                    @foreach ($salesman_data as $salesman)
                                                            <option value="{{ $salesman->id }}"{{ $salesman->id == $agent->sales_person ? 'selected' : '' }}>{{ $salesman->name }}</option>
                                                        @endforeach
                                                  </select>
                                                  <p class="form-error-text" id="sales_person_error" style="color: red;"></p>
                                                  @if($is_read_only)
                                                    <input type="hidden" name="sales_person" value="{{ $agent->sales_person }}">
                                                @endif
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="grade">Created By</label>
                                                    <input type="text" id="create_by" name="create_by" class="form-control gen_info_blank" placeholder="Enter Created By" value="{{$agent->create_by }}">
                                                    <p class="form-error-text" id="create_by_error" style="color: red;"></p>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="grade">Last Modified By</label>
                                                    <input type="text" id="modified_by" name="modified_by" class="form-control gen_info_blank" placeholder="Enter Last Modified By" value="{{$agent->modified_by }}">
                                                    <p class="form-error-text" id="modified_by_error" style="color: red;"></p>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <label for="description">Description</label>
                                                <div class="form-group ">
                                                   <textarea id="desc" name="desc" cols="70" rows="10" class="gen_info_blank form-control">{{$agent->desc}}</textarea>
                                                   <p class="form-error-text" id="desc_error" style="color: red;"></p>
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <input type="checkbox" id="credit_term" name="credit_term" onchange="credit_termvisibility()" value="{{$agent->credit_term }}"  @if($agent->credit_term == 0) checked @endif>
                                            <label for="credit_term"><b>Credit Terms:</b></label>
                                        </div>
                                    <div id="cerdit_terms" class="hidden">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <textarea name="credit_desc" id="credit_desc" cols="60" rows="10" class="credit_val_blank form-control">{{$agent->credit_desc}}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="name">Credit Limit in <span class="credit-currency-type">AED</span></label>
                                                <input id="limit_aed" name="limit_aed" type="text" class="form-control credit_val_blank"
                                                    placeholder="Enter Credit limit in AED" value="{{$agent->limit_aed}}" />
                                                <label for="name">Credit Period in Days</label>
                                                <input id="period_days" name="period_days" type="text" class="form-control credit_val_blank"
                                                    placeholder="Enter Credit Period in Days" value="{{$agent->period_days}}" />
                                            </div>
                                        </div>
                                    </div>
                                    </div>


                                    <div class="form-group">
                                        <input type="checkbox" id="trade_license" name="trade_license" onchange="trade_license_function()" value="0" class="add_val_blank" @if($agent->trade_license == 0) checked @endif>
                                        <label for="trade_license"><b>Trade license:</b></label>
                                    </div>
                                    <div id="trade_license_field" class="hidden">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="trade_license_file">Upload File</label>
                                                    <input type="file" name="trade_license_file" id="trade_license_file" class="form-control">
                                                    @if($agent->trade_license == 0 && $agent->trade_license_file !="")
                                                    <a href="{{ asset('public/upload/trade-license/' . $agent->trade_license_file) }}" download>Download</a>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="expiry_date">Expiry Date</label>
                                                    <input type="date" name="trade_license_expiry_date" id="trade_license_expiry_date" class="form-control" value="{{ $agent->trade_license_expiry_date }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <input type="checkbox" id="vat_certificate" name="vat_certificate" onchange="vat_certificate_function()" value="0"  class="add_val_blank" @if($agent->vat_certificate == 0) checked @endif>
                                        <label for="vat_certificate"><b>VAT certificate:</b></label>
                                    </div>
                                    <div id="vat_certificate_field" class="hidden">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="vat_certificate_file">Upload File</label>
                                                    <input type="file" name="vat_certificate_file" id="vat_certificate_file" class="form-control">
                                                    @if($agent->vat_certificate == 0 && $agent->vat_certificate_file !="")
                                                    <a href="{{ asset('public/upload/vat-certificate/' . $agent->vat_certificate_file) }}" download>Download</a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <input type="checkbox" id="eid" name="eid" onchange="eid_function()" value="0"  class="add_val_blank" @if($agent->eid == 0) checked @endif>
                                        <label for="eid" id="eid-label"><b>EID:</b></label>
                                    </div>
                                    <div id="eid_field" class="hidden">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="eid_file">Upload File</label>
                                                    <input type="file" name="eid_file" id="eid_file"  class="form-control">
                                                    @if($agent->eid == 0 && $agent->eid_file !="")
                                                    <a href="{{ asset('public/upload/eid/' . $agent->eid_file) }}" download>Download</a>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="expiry_date">Expiry Date</label>
                                                    <input type="date" name="eid_expiry_date" id="eid_expiry_date" class="form-control"  value="{{ $agent->eid_expiry_date }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group passport-visa-div">
                                        <input type="checkbox" id="passport_visa_copies" name="passport_visa_copies" onchange="passport_visa_copies_function()" value="0"  class="add_val_blank" @if($agent->passport_visa_copies == 0) checked @endif>
                                        <label for="passport_visa_copies"><b>Passport & Visa copies:</b></label>
                                    </div>
                                    <div id="passport_visa_copies_field" class="hidden passport-visa-div">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="passport_visa_copies_file">Upload File</label>
                                                    <input type="file" name="passport_visa_copies_file" id="passport_visa_copies_file"  class="form-control">
                                                    @if($agent->passport_visa_copies == 0 && $agent->passport_visa_copies_file !="")
                                                    <a href="{{ asset('public/upload/passport-visa-copies/' . $agent->passport_visa_copies_file) }}" download>Download</a>
                                                    @endif
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
                                <button type="button" class="btn btn-primary" onclick="javascript:category_validation()"
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
    <script>

        $( document ).ready(function() {

            const specificSelect = document.getElementById('agent_type');
            if (specificSelect) {
                specificSelect.setAttribute('disabled', true);
            }
           //alert($("#agent_type").val());
           let placeHolderLabel, labelName, industryName,industryLabel;
           let agentType = $("#agent_type").val();
           if(agentType == 1){
                placeHolderLabel = "Enter Agent Name";
                labelName = "Agent Name";
                industryName = "Company Role";
                industryLabel = "Select Company Role";
                $(".company-role-div").show();
                $(".industry-type-div").hide();

                $(".company-vat-no-div").show();
                $(".trn-no-div").hide();
                $(".approve-agent-div").show();
                $(".passport-visa-div").hide();
                $("#eid-label").html('<b>National ID : </b>');
           } else {
                placeHolderLabel = "Enter Company Name";
                labelName = "Company Name";
                industryName = "Industry Type";
                industryLabel = "Select Industry Type";
                $(".industry-type-div").show();
                $(".company-role-div").hide();

                $(".trn-no-div").show();
                $(".company-vat-no-div").hide();
                $(".approve-agent-div").hide();
                $(".passport-visa-div").show();
                $("#eid-label").html('<b>EID : </b/>');
            }

            const $inputElement = $('#company_name');
            if ($inputElement.length) {
                $inputElement.attr('placeholder', placeHolderLabel);
            }

            // Update organization name label
            const $nameLabel = $('#organization-name-lable');
            if ($nameLabel.length) {
                $nameLabel.html(labelName);
            }
        });
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
                $(".credit-currency-type").html('AED');
            }

            // Update input placeholder
            const $inputElement = $('#company_name');
            if ($inputElement.length) {
                $inputElement.attr('placeholder', placeHolderLabel);
            }

            // Update organization name label
            const $nameLabel = $('#organization-name-lable');
            if ($nameLabel.length) {
                $nameLabel.html(labelName);
            }

            const $crediLimitInput = $('#limit_aed');
            if ($crediLimitInput.length) {
                $crediLimitInput.attr('placeholder', creditCurrencyTypePlaceHolder);
            }

            // Hide or show .poc-section based on element value
           /*  if (element == 3) {
                $(".poc-section").hide();
            } else {
                $(".poc-section").show();
            } */
        }


        function category_validation() {

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
           
            var email = jQuery("#company_email").val();

            if (email == '') {
                jQuery('#email_error').html("Please Enter E-mail");
                jQuery('#email_error').show().delay(0).fadeIn('show');
                jQuery('#email_error').show().delay(4000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#company_email').offset().top - 150
                }, 1000);
                return false;
            }

            var emailPattern = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
            if (!emailPattern.test(email)) {

                jQuery('#email_error').html("Please enter a valid email address.");
                jQuery('#email_error').show().delay(0).fadeIn('show');
                jQuery('#email_error').show().delay(4000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#company_email').offset().top - 150
                }, 1000);
                return false;
            }

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
            $('#service_form').submit();
            /* $.ajax({
               type: "POST",
               url: "{{ url('check-email-exits') }}",
               data: {
                   "_token": "{{ csrf_token() }}",
                   "email": email,
               },
               success: function(responses) {

                   if (responses.message == 'EXITS') {

                        jQuery('#email_error').html("The email address already exists!");
                        jQuery('#email_error').show().delay(0).fadeIn('show');
                        jQuery('#email_error').show().delay(4000).fadeOut('show');
                        $('html, body').animate({
                            scrollTop: $('#company_email').offset().top - 150
                        }, 1000);
                        return false;
                   }else{
                        $('#spinner_button').show();
                        $('#submit_button').hide();
                        $('#category_form').submit();
                   }
               }
           }); */
            // var s_no = jQuery("#s_no").val();
            // if (s_no == '') {
            //     jQuery('#s_no_error').html("Please S_No");
            //     jQuery('#s_no_error').show().delay(0).fadeIn('show');
            //     jQuery('#s_no_error').show().delay(2000).fadeOut('show');
            //     $('html, body').animate({
            //         scrollTop: $('#s_no').offset().top - 150
            //     }, 1000);
            //     return false;
            // }
            // var company_name = jQuery("#company_name").val();
            // if (company_name == '') {
            //     jQuery('#company_name_error').html("Please Enter Company Name");
            //     jQuery('#company_name_error').show().delay(0).fadeIn('show');
            //     jQuery('#company_name_error').show().delay(2000).fadeOut('show');
            //     $('html, body').animate({
            //         scrollTop: $('#company_name').offset().top - 150
            //     }, 1000);
            //     return false;
            // }
            // var p_o_c_full = jQuery("#p_o_c_full").val();
            // if (p_o_c_full == '') {
            //     jQuery('#p_o_c_full_error').html("Please Enter P.O.C Full");
            //     jQuery('#p_o_c_full_error').show().delay(0).fadeIn('show');
            //     jQuery('#p_o_c_full_error').show().delay(2000).fadeOut('show');
            //     $('html, body').animate({
            //         scrollTop: $('#p_o_c_full').offset().top - 150
            //     }, 1000);
            //     return false;
            // }
            // var p_o_c_position_title = jQuery("#p_o_c_position_title").val();
            // if (p_o_c_position_title == '') {
            //     jQuery('#p_o_c_position_title_error').html("Please Enter P.O.C Position/Title");
            //     jQuery('#p_o_c_position_title_error').show().delay(0).fadeIn('show');
            //     jQuery('#p_o_c_position_title_error').show().delay(2000).fadeOut('show');
            //     $('html, body').animate({
            //         scrollTop: $('#p_o_c_position_title').offset().top - 150
            //     }, 1000);
            //     return false;
            // }
            // var company_email = jQuery("#company_email").val();
            // if (company_email == '') {
            //     jQuery('#company_email_error').html("Please Enter Company Email");
            //     jQuery('#company_email_error').show().delay(0).fadeIn('show');
            //     jQuery('#company_email_error').show().delay(2000).fadeOut('show');
            //     $('html, body').animate({
            //         scrollTop: $('#company_email').offset().top - 150
            //     }, 1000);
            //     return false;
            // }
            // var company_email = jQuery('#company_email').val();
            // var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
            // if (!filter.test(company_email)) {
            //     jQuery('#company_email_error').html("Enter Valid  Email");
            //     jQuery('#company_email_error').show().delay(0).fadeIn('show');
            //     jQuery('#company_email_error').show().delay(2000).fadeOut('show');
            //     $('html, body').animate({
            //         scrollTop: $('#company_email').offset().top - 150
            //     }, 1000);
            //     return false;
            // }
            // var company_telephone = jQuery("#company_telephone").val();
            // if (company_telephone == '') {
            //     jQuery('#company_telephone_error').html("Please Enter Company Telephone");
            //     jQuery('#company_telephone_error').show().delay(0).fadeIn('show');
            //     jQuery('#company_telephone_error').show().delay(2000).fadeOut('show');
            //     $('html, body').animate({
            //         scrollTop: $('#company_telephone').offset().top - 150
            //     }, 1000);
            //     return false;
            // }
            // if (company_telephone != '') {
            //     var filter = /^\d{7}$/;
            //     if (company_telephone.length < 7 || company_telephone.length > 15) {
            //         jQuery('#company_telephone_error').html("Please Enter Valid Phone Number");
            //         jQuery('#company_telephone_error').show().delay(0).fadeIn('show');
            //         jQuery('#company_telephone_error').show().delay(2000).fadeOut('show');
            //         $('html, body').animate({
            //             scrollTop: $('#company_telephone').offset().top - 150
            //         }, 1000);
            //         return false;
            //     }
            // }
            // var company_city = jQuery("#company_city").val();
            // if (company_city == '') {
            //     jQuery('#company_city_error').html("Please Enter Company City");
            //     jQuery('#company_city_error').show().delay(0).fadeIn('show');
            //     jQuery('#company_city_error').show().delay(2000).fadeOut('show');
            //     $('html, body').animate({
            //         scrollTop: $('#company_city').offset().top - 150
            //     }, 1000);
            //     return false;
            // }
            // var company_role = jQuery("#company_role").val();
            // if (company_role == '') {
            //     jQuery('#company_role_error').html("Please Enter Company Role");
            //     jQuery('#company_role_error').show().delay(0).fadeIn('show');
            //     jQuery('#company_role_error').show().delay(2000).fadeOut('show');
            //     $('html, body').animate({
            //         scrollTop: $('#company_role').offset().top - 150
            //     }, 1000);
            //     return false;
            // }
            // var active_inactive = jQuery("#active_inactive").val();
            // if (active_inactive == '') {
            //     jQuery('#active_inactive_error').html("Please Select Active/Inactive");
            //     jQuery('#active_inactive_error').show().delay(0).fadeIn('show');
            //     jQuery('#active_inactive_error').show().delay(2000).fadeOut('show');
            //     $('html, body').animate({
            //         scrollTop: $('#active_inactive').offset().top - 150
            //     }, 1000);
            //     return false;
            // }
            // var approved_agent = jQuery("#approved_agent").val();
            // if (approved_agent == '') {
            //     jQuery('#approved_agent_error').html("Please Enter Approved Agent");
            //     jQuery('#approved_agent_error').show().delay(0).fadeIn('show');
            //     jQuery('#approved_agent_error').show().delay(2000).fadeOut('show');
            //     $('html, body').animate({
            //         scrollTop: $('#approved_agent').offset().top - 150
            //     }, 1000);
            //     return false;
            // }
            // var approved_by = jQuery("#approved_by").val();
            // if (approved_by == '') {
            //     jQuery('#approved_by_error').html("Please Enter Approved By");
            //     jQuery('#approved_by_error').show().delay(0).fadeIn('show');
            //     jQuery('#approved_by_error').show().delay(2000).fadeOut('show');
            //     $('html, body').animate({
            //         scrollTop: $('#approved_by').offset().top - 150
            //     }, 1000);
            //     return false;
            // }
            // var company_payment_terms = jQuery("#company_payment_terms").val();
            // if (company_payment_terms == '') {
            //     jQuery('#company_payment_terms_error').html("Please Enter Company Payment Terms ");
            //     jQuery('#company_payment_terms_error').show().delay(0).fadeIn('show');
            //     jQuery('#company_payment_terms_error').show().delay(2000).fadeOut('show');
            //     $('html, body').animate({
            //         scrollTop: $('#company_payment_terms').offset().top - 150
            //     }, 1000);
            //     return false;
            // }
            // var company_vat_num = jQuery("#company_vat_num").val();
            // if (company_vat_num == '') {
            //     jQuery('#company_vat_num_error').html("Please Enter Company VAT Num");
            //     jQuery('#company_vat_num_error').show().delay(0).fadeIn('show');
            //     jQuery('#company_vat_num_error').show().delay(2000).fadeOut('show');
            //     $('html, body').animate({
            //         scrollTop: $('#company_vat_num').offset().top - 150
            //     }, 1000);
            //     return false;
            // }
            // var bill_company_through = jQuery("#bill_company_through").val();
            // if (bill_company_through == '') {
            //     jQuery('#bill_company_through_error').html("Please Enter Bill Company Through");
            //     jQuery('#bill_company_through_error').show().delay(0).fadeIn('show');
            //     jQuery('#bill_company_through_error').show().delay(2000).fadeOut('show');
            //     $('html, body').animate({
            //         scrollTop: $('#bill_company_through').offset().top - 150
            //     }, 1000);
            //     return false;
            // }
            // var client_source = jQuery("#client_source").val();
            // if (client_source == '') {
            //     jQuery('#client_source_error').html("Please Enter Client Source");
            //     jQuery('#client_source_error').show().delay(0).fadeIn('show');
            //     jQuery('#client_source_error').show().delay(2000).fadeOut('show');
            //     $('html, body').animate({
            //         scrollTop: $('#client_source').offset().top - 150
            //     }, 1000);
            //     return false;
            // }
            // var company_address = jQuery("#company_address").val();
            // if (company_address == '') {
            //     jQuery('#company_address_error').html("Please Enter Company Address ");
            //     jQuery('#company_address_error').show().delay(0).fadeIn('show');
            //     jQuery('#company_address_error').show().delay(2000).fadeOut('show');
            //     $('html, body').animate({
            //         scrollTop: $('#company_address').offset().top - 150
            //     }, 1000);
            //     return false;
            // }
            // var parent_company = jQuery("#parent_company").val();
            // if (parent_company == '') {
            //     jQuery('#parent_company_error').html("Please Enter Parent Company");
            //     jQuery('#parent_company_error').show().delay(0).fadeIn('show');
            //     jQuery('#parent_company_error').show().delay(2000).fadeOut('show');
            //     $('html, body').animate({
            //         scrollTop: $('#parent_company').offset().top - 150
            //     }, 1000);
            //     return false;
            // }
            // var years_in_business = jQuery("#years_in_business").val();
            // if (years_in_business == '') {
            //     jQuery('#years_in_business_error').html("Please Enter Years In Business ");
            //     jQuery('#years_in_business_error').show().delay(0).fadeIn('show');
            //     jQuery('#years_in_business_error').show().delay(2000).fadeOut('show');
            //     $('html, body').animate({
            //         scrollTop: $('#years_in_business').offset().top - 150
            //     }, 1000);
            //     return false;
            // }
            // $('#spinner_button').show();
            // $('#submit_button').hide();
            // $('#service_form').submit();
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
    <script>
        function singledelete(url) {
            var t = confirm('Are You Sure To Delete The Attribute ?');
            if (t) {
                window.location.href = url;
            } else {
                return false;
            }
        }
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
                        '<div class="row"><div class="col-md-2"><div class = "form-group"><label for = "poc">P.O.C</label><input type = "text" id= "name" name = "name1[]" class = "form-control" placeholder = "Enter P.O.C"></div></div ><div class = "col-md-2"><div class = "form-group"><label for = "poc">Email</label><input type = "text" id = "email" name = "email1[]" class = "form-control" placeholder = "Enter Email"></div></div ><div class = "col-md-2"><div class = "form-group"><label for = "poc">Telephone </label><input type = "text" id = "telephone" name = "telephone1[]" class = "form-control" placeholder = "Enter Telephone" onkeypress="return validateNumber(event)"></div></div><div class = "col-md-2"><div class = "form-group"><label for = "poc" >P.O.C Position/Title</label><input type = "text" id = "role" name = "role1[]" class = "form-control" placeholder = "Enter P.O.C Position/Title"></div></div><a href = "#" class = "btn btn-danger pull-right remove_field1" style="margin-right: 0;margin-top: 23px;width: 10%;float: right;height:38px;margin-left: 127px;">Remove</a ></div>'
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
            $('.add_val_blank').val('');
            container.classList.add('hidden');
        }
    }
    function contactvisibility() {
        const checkbox = document.getElementById('contact_fields');
        const container = document.getElementById('add_more_fields');
        if (checkbox.checked) {
            container.classList.remove('hidden');
        } else {
            $('.contact_del_blank').val('');
            container.classList.add('hidden');
        }
    }
    function credit_termvisibility() {
        let creditCurrencyTypePlaceHolder;

        const checkbox = document.getElementById('credit_term');
        const container = document.getElementById('cerdit_terms');
        const typeOfAgent = document.getElementById('agent_type').value;
        if (checkbox.checked) {
            if(typeOfAgent == 1){
                creditCurrencyTypePlaceHolder = "Enter Credit limit in USD";
                $(".credit-currency-type").html('USD');
            }else{
                creditCurrencyTypePlaceHolder = "Enter Credit limit in AED";
                $(".credit-currency-type").html('AED');
            }

            const $crediLimitInput = $('#limit_aed');
            if ($crediLimitInput.length) {
                $crediLimitInput.attr('placeholder', creditCurrencyTypePlaceHolder);
            }

            container.classList.remove('hidden');
        } else {
            $('.credit_val_blank').val('');
            container.classList.add('hidden');
        }
    }
    function genearal_info_visibility() {
        const checkbox = document.getElementById('general_info');
        const container = document.getElementById('general_information');
        if (checkbox.checked) {
            container.classList.remove('hidden');
        } else {
            $('.gen_info_blank').val('');
            container.classList.add('hidden');
        }
    }
    function detailsvisibility() {
        const checkbox = document.getElementById('details');
        const container = document.getElementById('details_fields');
        if (checkbox.checked) {
            container.classList.remove('hidden');
        } else {
            $('.detail_val_blank').val('');
            container.classList.add('hidden');
        }
    }
    function contractsvisibility() {
        const checkbox = document.getElementById('contracts');
        const container = document.getElementById('contracts_fields');
        if (checkbox.checked) {
            container.classList.remove('hidden');
        } else {
            $('.contract_val_blank').val('');
            container.classList.add('hidden');
        }
    }
    function bank_detailsvisibility() {
        const checkbox = document.getElementById('bank_details');
        const container = document.getElementById('bank_details_fields');
        if (checkbox.checked) {
            container.classList.remove('hidden');
        } else {
            $('.bank_val_blank').val('');
            container.classList.add('hidden');
        }
    }
    function acc_typevisibility() {
        const checkbox = document.getElementById('acc_type');
        const container = document.getElementById('acc_type_fields');
        if (checkbox.checked) {
            container.classList.remove('hidden');
        } else {
            $('.acc_type_blank').val('');
            container.classList.add('hidden');
        }
    }
    function tax_exceptionvisibility() {
        const checkbox = document.getElementById('tax_exception');
        const container = document.getElementById('tax_exception_fields');
        if (checkbox.checked) {
            container.classList.remove('hidden');
        } else {
            $('.tex_val_blank').val('');
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
    window.onload = codeAddress;
    function codeAddress(){
        @if($agent->toggleFields == 0)
        const container = document.getElementById('address_fields');
            container.classList.remove('hidden');
        @endif
        @if($agent->general_info == 0)
        const container1 = document.getElementById('general_information');
            container1.classList.remove('hidden');
        @endif
        @if($agent->contact_fields == 0)
        const container2 = document.getElementById('add_more_fields');
            container2.classList.remove('hidden');
        @endif
        @if($agent->credit_term == 0)
        const container3 = document.getElementById('cerdit_terms');
            container3.classList.remove('hidden');
        @endif
        @if($agent->details == 0)
        const container4 = document.getElementById('details_fields');
            container4.classList.remove('hidden');
        @endif
        @if($agent->contracts == 0)
        const container5 = document.getElementById('contracts_fields');
            container5.classList.remove('hidden');
        @endif
        @if($agent->bank_details == 0)
        const container6 = document.getElementById('bank_details_fields');
            container6.classList.remove('hidden');
        @endif
        @if($agent->acc_type == 0)
        const container7 = document.getElementById('acc_type_fields');
            container7.classList.remove('hidden');
        @endif
        @if($agent->tax_exception == 0)
        const container8 = document.getElementById('tax_exception_fields');
            container8.classList.remove('hidden');
        @endif

        @if($agent->trade_license == 0)
        const container9 = document.getElementById('trade_license_field');
            container9.classList.remove('hidden');
        @endif

        @if($agent->vat_certificate == 0)
        const container10 = document.getElementById('vat_certificate_field');
            container10.classList.remove('hidden');
        @endif

        @if($agent->eid == 0)
        const container11 = document.getElementById('eid_field');
            container11.classList.remove('hidden');
        @endif

        @if($agent->passport_visa_copies == 0)
        const container12 = document.getElementById('passport_visa_copies_field');
            container12.classList.remove('hidden');
        @endif
    }

    $(document).ready(function() {
        $('#country').select2();
    });
</script>
@stop
