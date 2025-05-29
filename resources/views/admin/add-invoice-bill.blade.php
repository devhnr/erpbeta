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
    .disabled-checkbox {
        background-color: red !important;
        opacity: 0.6; /* Makes it look disabled */
        pointer-events: none; /* Prevents clicks */
    }
    .driver-detail-tab thead,.warehouse-table thead{
        background-color: #3484C3;
        color: #fff;
        text-align: center;
    }
    .no-of-trip-input{
        width:13%;
    }
    .amount-input{
        width:15%;
    }
    .allocate-input{position: relative;width: 15%;}
    .allocate-input .add-row{position: absolute;top: 40%;left: 85%;}
    .allocate-input input{width: 90%;}
    .modal-dialog {
        max-width: 67%;
    }
    .warehouse-popup-table .close {
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
        border:unset;
    }

    .warehouse-popup-table .table > tbody > tr > td {
        padding: 2px;
    }
    .warehouse-popup-table .table-responsive .form-control {
        padding: 2px;
    }
    .warehouse-popup-table .card-body{
        padding: 10px 5px;
    }

    .warehouse-popup-table table thead th{
        background: #3484C3;
        color: #fff;
    }

    .warehouse-popup-table .table > tbody > tr > td {
        padding: 10px;
    }
    .warehouse-popup-table .modal-body h5{
        color: #3484C3;
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
    .preview-btn-hide{display: none;}
    .self-section,.cor-section{display: none;}

    .table > tbody > tr > td {
        padding: 2px;
    }
    .table-responsive .form-control {
        padding: 2px;
    }
    .card-body{
        padding: 10px 20px;
    }
    .bg-color{
        background-color: #ccc;
        pointer-events: none; /* Disable any interaction */
        cursor: not-allowed; /* Change cursor to indicate no interaction */
    }
 </style>
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Edit Invoice</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('operation.index') }}">Invoice</a></li>
                        <li class="breadcrumb-item active">Edit Invoice</li>
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
        @if ($message = Session::get('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                <strong>Error!</strong> {{ $message }}
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
                        <form id="category_form" action="{{ route('invoice-bill.update', $followup->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')
                           
                            <div class="row">
                                <div class="form-group col-lg-4">
                                    <label for="name">Order ID : </label>
                                    <input id="order_number" name="order_number" type="text" class="form-control"
                                        placeholder="Enter Order ID" value="{{ $followup->order_number }}"
                                        readonly/>
                                    <p class="form-error-text" id="quote_no_error" style="color: red;"></p>
                                </div>
                                <div class="form-group col-lg-4">
                                    <label for="name">Job Order ID : </label>
                                    <input id="quote_no" name="quote_no" type="text" class="form-control"
                                        placeholder="Enter Job Order ID" value="{{ $followup->job_order_id }}"
                                        readonly/>
                                    <p class="form-error-text" id="quote_no_error" style="color: red;"></p>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="name">Quotation ID :</label>
                                        <input id="quote_id" name="quote_id" type="text" class="form-control"
                                            value="{{ $followup->quote_id }}"  readonly/>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Invoice Date :</label>
                                        <input id="invoice_date" name="invoice_date" type="text" class="form-control date-input-picker"
                                        value="{{ old('invoice_date', isset($invoice_data->invoice_date) ? \Carbon\Carbon::parse($invoice_data->invoice_date)->format('d-m-Y') : now()->format('d-m-Y')) }}"
autocomplete="off"/>
                                    </div>
                                </div>
                                <div class="form-group col-lg-6">
                                    <label for="name">Customer Type : </label>
                                    <select name="customer_type" id="customer_type" class="form-control form-select select" onchange="customerType(this.value);" disabled>
                                        <option value="">Select Customer Type</option>
                                        @foreach ($customer_type as $customer_type_data)
                                        <option value="{{ $customer_type_data->id }}"
                                            @if ($customer_type_data->id == $followup->customer_type) {{ 'selected' }} @endif>
                                    {{ $customer_type_data->customer_type }}
                                        </option>
                                    @endforeach
                                    </select>
                                </div>

                                <div class="row client-section-corporate">
                                    <div class="form-group col-lg-12">
                                        <label for="name">Payment By : </label>
                                        <select name="payment_by" id="payment_by" class="form-control form-select select" onchange="getPaymentType(this.value);">
                                            <option value="">Select</option>
                                            @if(!empty($invoice_data->payment_by))
                                                <option value="Self" @if($invoice_data->payment_by == "Self") selected @endif>Self</option>
                                                <option value="Corporate" @if($invoice_data->payment_by == "Corporate") selected @endif>Corporate</option>
                                            @else
                                                <option value="Self">Self</option>
                                                <option value="Corporate">Corporate</option>
                                            @endif
                                        </select>
                                    </div>
                                    @php
                                        // Client Mobile Number
                                        $mobileNo = '';
                                        if(!empty($followup->customer_phone1)){
                                            $mobileNo = $followup->customer_phone1;
                                        }else{
                                            $mobileNo = $followup->c_mobile;
                                        }

                                        // Client Phone Number
                                        $phoneNo = '';
                                        if(!empty($followup->customer_phone2)){
                                            $phoneNo = $followup->customer_phone2;
                                        }else{
                                            $phoneNo = $followup->c_phone;
                                        }

                                        // Client Email Address
                                        $clientEmail = '';
                                        if(!empty($followup->customer_email)){
                                            $clientEmail = $followup->customer_email;
                                        }else{
                                            $clientEmail = $followup->c_email;
                                        }

                                        if($followup->customer_type == 1){ // individual
                                            $addClass = "cor-section";
                                            $selfAddClass = "";
                                        }
                                        
                                        if($followup->customer_type == 2){  // corporate
                                            $selfAddClass = "self-section";
                                            $addClass = "";
                                        }
                                    @endphp
                                    <div class="corporate-section row {{ $addClass }}">
                                        <div class="form-group col-lg-12">
                                            <label for="name">Name : </label>
                                            <input id="customer_name" name="customer_name" type="input" class="form-control"
                                                value="{{ $clientName }}" />
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <label for="name">Phone : </label>
                                            <input id="customer_phone2" name="customer_phone2" type="input" class="form-control"
                                                value="{{ $phoneNo }}" onclick="validateNumber();" />
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <label for="name">Mobile : </label>
                                            <input id="customer_phone1" name="customer_phone1" type="input" class="form-control"
                                                value="{{ $mobileNo }}" onclick="validateNumber();" />
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <label for="name">Email : </label>
                                            <input id="customer_email" name="customer_email" type="input" class="form-control"
                                                value="{{ $clientEmail }}" />
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <label for="name">City : </label>
                                            <input id="city" name="city" type="input" class="form-control"
                                                value="{{ $city }}" />
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <label for="name">State : </label>
                                            <input id="state" name="state" type="input" class="form-control"
                                                value="{{ $state }}" />
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <label for="name">Country : </label>
                                            <input id="country" name="country" type="input" class="form-control"
                                                value="{{ $country_name }}" />
                                        </div>
                                        <div class="form-group col-lg-12">
                                            <label for="name">Address : </label>
                                            <textarea name="address" id="address" cols="5" rows="5" class="form-control"
                                                placeholder="Enter Address">{{ $followup->address }}</textarea>
                                        </div>
                                    </div>
                                    <div class="individual-section row {{ $selfAddClass }}">
                                        <div class="form-group col-lg-6">
                                            <label for="name">Bank Account : </label>
                                            <input id="bank_name" 
                                                   name="bank_name" 
                                                   type="input" 
                                                   class="form-control"
                                                    value="{{ $account_detail_data->account_number }} - {{ $account_detail_data->account_holder_name }}" 
                                                    readonly
                                            />
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <label for="name">Bank Name : </label>
                                            <input id="bank_name" name="bank_name" type="input" class="form-control"
                                                value="{{ $account_detail_data->bank_name }}" readonly/>
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <label for="name">Account No : </label>
                                            <input id="account_number" name="account_number" type="input" class="form-control"
                                                value="{{ $account_detail_data->account_number }}" readonly />
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <label for="name">Account Name: </label>
                                            <input id="account_number" name="account_number" type="input" class="form-control"
                                                value="{{ $account_detail_data->account_holder_name }}" readonly/>
                                        </div>
                                        <div class="form-group col-lg-4">
                                            <label for="name">Name : </label>
                                            <input id="customer_name" name="customer_name" type="input" class="form-control"
                                                value="{{ $individual_customer_name }}" />
                                        </div>
                                        <div class="form-group col-lg-4">
                                            <label for="name">Phone : </label>
                                            <input id="customer_phone2" name="customer_phone2" type="input" class="form-control"
                                                value="{{ $individual_customer_phone }}" onclick="validateNumber();" />
                                        </div>
                                        <div class="form-group col-lg-4">
                                            <label for="name">Mobile : </label>
                                            <input id="customer_phone1" name="customer_phone1" type="input" class="form-control"
                                                value="{{ $individual_customer_mobile }}" onclick="validateNumber();" />
                                        </div>
                                        <div class="form-group col-lg-4">
                                            <label for="name">Email : </label>
                                            <input id="customer_email" name="customer_email" type="input" class="form-control"
                                                value="{{ $individual_customer_email }}" />
                                        </div>
                                        <div class="form-group col-lg-4">
                                            <label for="name">City : </label>
                                            <input id="city" name="city" type="input" class="form-control"
                                                value="{{ $individual_customer_city }}" />
                                        </div>
                                        <div class="form-group col-lg-4">
                                            <label for="name">Country : </label>
                                            <input id="country" name="country" type="input" class="form-control"
                                                value="{{ $individual_customer_country }}" />
                                        </div>
                                        <div class="form-group col-lg-12">
                                            <label for="name">Address : </label>
                                            <textarea name="address" id="address" cols="5" rows="5" class="form-control">{{ $individual_customer_address }}</textarea>
                                        </div>
                                    </div>

                                    <div class="form-group col-lg-6">
                                        <label for="name">TRN No : </label>
                                        <input id="trn_no" name="trn_no" type="input" class="form-control"
                                            value="{{ $invoice_data->trn_no ?? "" }}" />
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label for="name">Place Of Supply / Service : </label>
                                        <input id="place_of_service" name="place_of_service" type="input" class="form-control"
                                            value="{{ $invoice_data->place_of_service ?? "" }}" />
                                    </div>
                                    @php
                                        $service_date = "";
                                        if (!empty($invoice_data) && 
                                            !empty($invoice_data->service_date) && $invoice_data->service_date != "0000-00-00") {
                                            $service_date = $invoice_data->service_date;
                                        }
                                    @endphp
                                    <div class="form-group col-lg-6">
                                        <label for="name">Service Date : </label>
                                        <input id="service_date" name="service_date" type="input" class="form-control date-input-picker"
                                            value="{{ $service_date ?? "" }}" />
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label for="name">Service Code ( HSN/SAC ) : </label>
                                        <input id="service_code" name="service_code" type="input" class="form-control"
                                            value="{{ $invoice_data->service_code ?? "" }}" />
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label for="name">Ref No : </label>
                                        <input id="ref_no" name="ref_no" type="input" class="form-control"
                                            value="{{ $invoice_data->ref_no ?? "" }}" />
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label for="name">Service Description : </label>
                                        <input id="service_description" name="service_description" type="input" class="form-control"
                                            value="{{ $invoice_data->service_description ?? "" }}" />
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label for="name">Ship to Address/Delivery Address : </label>
                                        <textarea name="ship_address" id="ship_address" class="form-control">{{ $invoice_data->ship_address ?? "" }}</textarea>
                                    </div>
                                </div>

                                <div class="table-responsive mt-4 add-more-fields">
                                    <table class="table table-center table-hover">
                                        <thead style="background-color:#3484C3">
                                            <tr>
                                                <th>Select</th>
                                                <th>Code</th>
                                                <th>Description</th>
                                                <th>Qty</th>
                                                <th>Unit</th>
                                                <th>Prov.</th>
                                                <th>EGP</th>
                                                <th>EGP %</th>
                                                <th>Selling</th>
                                                <th>Prov. Sum</th>
                                                <th>Selling Sum</th>
                                                <th>Total</th>
                                                <th>EGP SUM</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="text-center">
                                                    <input type="checkbox" id="selectAll" name="selectAll[]">
                                                </td>
                                                <td style="width:7%;">
                                                    <input type="text" class="form-control bg-color">
                                                </td>
                                                <td style="width:25%;">
                                                    <input type="text" name="head_description" class="form-control" value="{!! Helper::service($followup->service_id) !!}  {{ $followup->origin_city}} To {{ $followup->desti_city}}" />
                                                </td>
                                                <td style="width:5%;">
                                                    <input type="number" class="form-control bg-color"/>
                                                </td>
                                                <td style="width:10%;">
                                                    <input type="number" class="form-control bg-color"/>
                                                </td>
                                                <td style="width:7%;">
                                                    <input type="number" class="form-control bg-color"/>
                                                </td>
                                                <td style="width:5%;">
                                                    <input type="number" class="form-control bg-color"/>
                                                </td>
                                                <td style="width:7%;">
                                                    <input type="number" class="form-control bg-color"/>
                                                </td>
                                                <td style="width:7%;">
                                                    <input type="number" class="form-control bg-color"/>
                                                </td>
                                                <td style="width:7%;">
                                                    <input type="number" class="form-control" id="grand_prov_sum" name="grand_prov_sum" value="{{ isset($followup->prov_sum) ? $followup->prov_sum : "" }}"/>
                                                </td>
                                                <td style="width:7%;">
                                                     <input type="number" class="form-control bg-color"/>
                                                </td>
                                                <td style="width:10%;">
                                                    <input type="number" class="form-control" id="grand_total" name="grand_total" value="{{ isset($followup->prov_sum) ? $followup->prov_sum + ($followup->prov_sum * $followup->margin_percent) / 100 : "" }}"/>
                                                </td>
                                                <td style="width:5%;" >
                                                    <input type="number" class="form-control bg-color"/>
                                                </td>
                                            </tr>
                                            
                                            <div class="input_fields_wrap12">
                                            </div>
                                            @if($costing_attribute !="" && count($costing_attribute) > 0 && !empty($costing_attribute))
                                                @foreach ($costing_attribute as $i => $costing)
                                                <input type="hidden" name="updateid1xxx[]"
                                                                     id="updateid1xxx{{ $i + 1 }}"
                                                                     value="{{ $costing->id }}">
                                                    <tr>
                                                        <td class="text-center">
                                                            <input type="checkbox" 
                                                                   id="selectAll" 
                                                                   name="selectOne[]" 
                                                                   value="{{ $costing->id }}" 
                                                                   @if($costing->is_checked == 1) checked @endif
                                                            />
                                                        </td>
                                                        <td style="width:7%;">
                                                            <input type="text" class="form-control code-input" id="code" name="code[]" value="{{ $costing->code }}">
                                                        </td>
                                                        <td style="width:25%;">
                                                            <input type="text" class="form-control" id="description" name="description[]" value="{{ $costing->description }}" autocomplete="off">
                                                        </td>
                                                        <td style="width:5%;">
                                                            <input type="number" class="form-control qty" id="qty" name="qty[]" value="{{ $costing->qty }}">
                                                        </td>
                                                        <td style="width:10%;">
                                                            <select class="form-control form-select" id="unit" name="unit[]">
                                                                <option value="nos" {{ $costing->unit == 'nos' ? 'selected' : '' }}>Nos.</option>
                                                                <option value="unit" {{ $costing->unit == 'unit' ? 'selected' : '' }}>Unit</option>
                                                            </select>
                                                        </td>
                                                        <td style="width:7%;">
                                                            <input type="number" class="form-control prov" id="prov" name="prov[]" value="{{ $costing->prov }}">
                                                        </td>
                                                        <td style="width:5%;">
                                                            <input type="number" class="form-control" id="egp" name="egp[]" value="{{ $costing->egp }}">
                                                        </td>
                                                        <td style="width:7%;">
                                                            <input type="number" class="form-control" id="egp_percentage" name="egp_percentage[]" value="{{ $costing->egp_percent }}">
                                                        </td>
                                                        <td style="width:7%;">
                                                            <input type="number" class="form-control" id="selling" name="selling[]" value="{{ $costing->selling }}">
                                                        </td>
                                                        <td style="width:7%;">
                                                            <input type="number" class="form-control" id="prov_sum" name="prov_sum[]" value="{{ $costing->prov_sum }}">
                                                        </td>
                                                        <td style="width:7%;">
                                                            <input type="number" class="form-control" id="selling_sum" name="selling_sum[]" value="{{ $costing->selling_sum }}">
                                                        </td>

                                                        <td style="width:10%;">
                                                            <input type="number" class="form-control" id="total" name="total[]" value="{{ $costing->total }}" readonly>
                                                        </td>
                                                        <td style="width:5%;">
                                                            <input type="number" class="form-control" id="egp_sum"  name="egp_sum[]" value="{{ $costing->egp_sum }}">
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                                
                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-form-label col-md-4">Provisional Sum : </label>
                                            <div class="col-md-5">
                                                <input type="number" 
                                                       class="form-control" 
                                                       name="provisional_sum" 
                                                       id="provisional_sum" 
                                                       value="{{ isset($followup->prov_sum) ? $followup->prov_sum : "" }}" 
                                                       readonly
                                                />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-form-label col-md-4">Selling Sum : </label>
                                            <div class="col-md-5">
                                                <input type="text" 
                                                       class="form-control" 
                                                       name="selling_amount" 
                                                       id="selling_amount" 
                                                       value="{{ isset($followup->selling_amount) ? $followup->selling_amount : "" }}" 
                                                       onkeypress="return validateNumber(event)"
                                                />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">

                                            <input type="checkbox" 
                                                   name="include_insurance" 
                                                   id="include_insurance" 
                                                   value="1"
                                                   @if(isset($invoice_data) && $invoice_data->is_insurance == "1") checked @endif
                                            />
                                            <label for="include_insurance">Include Insurance?</label>
                                        </div>
                                        <div class="form-group">

                                            <input type="checkbox" 
                                                   name="vat_charge" 
                                                   id="vat_charge" 
                                                   value="1"
                                                   @if(isset($invoice_data) && $invoice_data->vat_charge == "1") checked @endif
                                            />
                                            <label for="vat_charge">VAT ( 5% )</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-form-label col-md-4"><b>Grand Total :</b></label>
                                            <div class="col-md-5">
                                                <input type="text" 
                                                       class="form-control" 
                                                       name="grand_total_new"  
                                                       id="grand_total_new" 
                                                       value="{{ isset($followup->grand_total) ? $followup->grand_total : "" }}" onkeypress="return validateNumber(event)"
                                                />
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="newgrandtotal" id="newgrandtotal" value="{{ isset($followup->grand_total_with_vat) ? $followup->grand_total_with_vat : "" }}">
                                </div>
                                

                                <div class="text-end mt-4">
                                    <a class="btn btn-primary" href="{{ route('billing-invoice.index') }}"> Cancel</a>
                                    <button class="btn btn-primary mb-1" type="button" disabled id="spinner_button"
                                        style="display: none;">
                                        <span class="spinner-border spinner-border-sm" role="status"
                                            aria-hidden="true"></span>
                                        Loading...
                                    </button>
                                    <button type="button" class="btn btn-primary"
                                        onclick="javascript:category_validation()" id="submit_button">Submit</button>
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
        function category_validation() {
            var customer_type = $("#customer_type").val();
            if (customer_type == '') {
                $('#customer_type_error').html("Please Select Invoice Type");
                $('#customer_type_error').show().delay(0).fadeIn('show');
                $('#customer_type_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#customer_type').offset().top - 150
                }, 1000);
                return false;
            }

            $('#spinner_button').show();
            $('#submit_button').hide();
            $('#category_form').submit();
        }

        function getPaymentType(payment_by) {

            if (payment_by == 'Corporate') {
                
                $( ".individual-section" ).addClass( "self-section" );
                $( ".corporate-section" ).removeClass( "cor-section" );

            } else if(payment_by == "Self") {

                $( ".individual-section" ).removeClass( "self-section" );
                $( ".corporate-section" ).addClass( "cor-section" );
            }
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
            $('.date-input-picker').datepicker({
                format: 'dd-mm-yyyy', // Ensure this format matches backend expectation
                autoclose: true,
                todayHighlight: true
            }).on('changeDate', function(e) {
                $(this).datepicker('hide'); // Hide datepicker after selection
            });
        });

        /* $(document).ready(function () {
        // When #selectAll is checked or unchecked
            $('#selectAll').on('change', function () {
                $('input[name="selectOne[]"]').prop('checked', this.checked);
            });

            // When any selectOne checkbox is unchecked, uncheck #selectAll
            $('input[name="selectOne[]"]').on('change', function () {
                if ($('input[name="selectOne[]"]:checked').length === $('input[name="selectOne[]"]').length) {
                    $('#selectAll').prop('checked', true);
                } else {
                    $('#selectAll').prop('checked', false);
                }
            });
        }); */

        $(document).ready(function () {
            let marginPercentage = @json($followup->margin_percent) || 0;
            let isVatCharge = @json($quotation_data->vat_charge ?? 0) || 0;
            if (isVatCharge) {
                $('#vat_charge').prop('checked', true);
            }
            function calculateSum() {
                let totalSum = 0;
                let checkedBoxes = $("input[name='selectOne[]']:checked").length;
                let totalCheckboxes = $("input[name='selectOne[]']").length;

                if (checkedBoxes > 0) {
                    $("input[name='selectOne[]']:checked").each(function () {
                        let rowTotal = parseFloat($(this).closest("tr").find("input[name='total[]']").val()) || 0;
                        totalSum += rowTotal;
                    });

                    let marginCal = (totalSum * parseFloat(marginPercentage)) / 100;
                    let sumOfTotal = totalSum + marginCal;

                    $("#provisional_sum").val(totalSum.toFixed(2));
                    $("#grand_total_new").val(sumOfTotal.toFixed(2));
                    $("#newgrandtotal").val(sumOfTotal.toFixed(2));
                    $("#selling_amount").val(sumOfTotal.toFixed(2));

                    // Apply VAT if checked
                    if ($('#vat_charge').is(':checked')) {
                        applyVAT();
                    }
                } else {
                    // If no checkboxes are checked, set grand_total_new to grand_total
                    let grandTotal = parseFloat($("#grand_total").val()) || 0;
                    $("#provisional_sum").val(parseFloat($('#grand_prov_sum').val()).toFixed(2));
                    $("#grand_total_new").val(grandTotal.toFixed(2));
                    $("#newgrandtotal").val(grandTotal.toFixed(2));
                    $("#selling_amount").val(grandTotal.toFixed(2));

                    if ($('#vat_charge').is(':checked')) {
                        applyVAT();
                    }
                }
            }

            function applyVAT() {
                let grandTotal = parseFloat($("#grand_total_new").val()) || 0;

                if ($('#vat_charge').is(':checked') && grandTotal > 0) {
                    let vatCharge = grandTotal * 5 / 100;
                    grandTotal += vatCharge;
                }

                $("#grand_total_new").val(grandTotal.toFixed(2));
                $("#newgrandtotal").val(grandTotal.toFixed(2));
            }

            // Handle checkbox selection change
            $(document).on("change", "input[name='selectOne[]']", function () {
                calculateSum();
            });

            // Handle VAT checkbox change
            $('#vat_charge').on('change', function () {
                calculateSum();
            });

            // Handle "Select All" functionality
            $("#selectAll").on("change", function () {
                let isChecked = $(this).is(":checked");
                $("input[name='selectOne[]']").prop("checked", isChecked);
                calculateSum();
            });

            // Initial calculation on page load
            calculateSum();
        });


    </script>
@stop
