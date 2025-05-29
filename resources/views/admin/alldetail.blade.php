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
.bg-color {
    background-color: #ccc;
    pointer-events: none;
    cursor: not-allowed;
}
.table-responsive .form-control {
    padding: 2px;
}
.table > tbody > tr > td {
    padding: 2px;
}
.heading_four{
    background: #eee;
    padding: 5px;
    margin-top: 15px;
}
.driver-detail-tab thead{
    background-color: #3484C3;
    color: #fff;
    text-align: center;
}

.driver-detail-tab .table > tbody > tr > td {
    padding: 15px;
}
 </style>
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col">
                    <h3 class="page-title">All Detail</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a></li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('closing.index') }}">Closed</a>
                        </li>
                        <li class="breadcrumb-item active">All Detail</li>
                    </ul>
                </div>
                <div class="col-auto">
                    <div class="btn-group btn-group-sm">
                        <a href="{{ route('closing.index') }}" class="btn btn-primary me-1">Back</a>
                    </div>
                    </div>
            </div>
        </div>
        {{-- <a class="btn btn-primary" href="{{ route('closing.index') }}">Back</a> --}}
        <!-- /Page Header -->
        <div id="validate" class="alert alert-danger alert-dismissible fade show" style="display: none;">
            <span id="login_error"></span>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body invoice-item">
                        <form id="category_form" action="" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            
                            <div class="row">
                                <div class="col-md-12">
                                    <h4 class="heading_four">Survey Detail</h4>
                
                                </div>
                            </div>
                            <div class="row mt-3 mb-3">
                                <div class="col-md-3">
                                    <p class="">
                                        <strong>Survey ID:</strong>
                                        {{ $followup->survey_id }}
                                    </p>
                                </div>
                                @php
                                    $survey_type = Helper::surveytype($followup->survey_type);
                                @endphp
                                <div class="col-md-3">
                                    <p class="">
                                        <strong>Survey Type:</strong>
                                        {{ $survey_type }}
                                    </p>
                                </div>
                                <div class="col-md-3">
                                    <p class="">
                                        <strong>Survey Date:</strong>
                                        {{ \Carbon\Carbon::parse($followup->s_date)->format('d-m-Y') }}
                                    </p>
                                </div>

                                @php
                                    $surveyor = Helper::salesmanname($followup->surveyor);
                                @endphp
                                <div class="col-md-3">
                                    <p class="">
                                        <strong>Surveyor Name:</strong>
                                        {{ $surveyor }}
                                    </p>
                                </div>
                                
                                
                            </div>
                            <div class="row mt-3">
                                @php
                                    $surveyor_time_zone = Helper::time_zonename($survey_assign->surveyor_time_zone);
                                @endphp
                                <div class="col-md-3">
                                    <p class="">
                                        <strong>Survey Time:</strong>
                                        {{ $surveyor_time_zone }}
                                    </p>
                                </div>
                            </div>
                            <div class="row mt-3">
                                    <div class="col-md-12">
                                        <h4 class="heading_four">Costing Detail</h4>
                                    </div>
                            </div>
                            <div class="row mt-3 mb-3">
                                <div class="col-md-3">
                                    <p class="">
                                        <strong>Costing ID:</strong>
                                        {{ $followup->costing_id }}
                                    </p>
                                </div>
                                <div class="col-md-3">
                                    <p class="">
                                        <strong>Costing Date:</strong>
                                        {{ \Carbon\Carbon::parse($followup->costing_date)->format('d-m-Y') }}
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <p class="">
                                        <strong>Location:</strong>
                                        {{ $followup->costing_address }}
                                    </p>
                                </div>
                            </div>
                            <div class="row mt-3 mb-3">
                                @php
                                    $service_id = Helper::service($followup->service_id);
                                @endphp
                                <div class="col-md-3">
                                    <p class="">
                                        <strong>Service Type:</strong>
                                        {{ $service_id }}
                                    </p>
                                </div>
                                @php
                                    $shipment_type = Helper::service($followup->shipment_type);
                                @endphp
                                <div class="col-md-3">
                                    <p class="">
                                        <strong>Shipment Type:</strong>
                                        {{ $shipment_type }}
                                    </p>
                                </div>
                                <div class="col-md-3">
                                    <p class="">
                                        <strong></strong>
                                        {{ $followup->value_1 }} {{ $followup->option_1 }}
                                    </p>
                                </div>
                                <div class="col-md-3">
                                    <p class="">
                                        <strong></strong>
                                        {{ $followup->value_2 }} {{ $followup->option_2 }}
                                    </p>
                                </div>
                            </div>
                            <div class="row mt-3 mb-3">
                                @php
                                    $service_required = Helper::services_required($followup->service_required);
                                @endphp
                                <div class="col-md-3">
                                    <p class="">
                                        <strong>Service Required:</strong>
                                        {{ $service_required }}
                                    </p>
                                </div>
                                @php
                                    $desc_of_goods = Helper::descriptionOfGoods($followup->desc_of_goods);
                                @endphp
                                <div class="col-md-3">
                                    <p class="">
                                        <strong>Description Of Goods:</strong>
                                        {{ $desc_of_goods }}
                                    </p>
                                </div>
                                <div class="col-md-3">
                                    <p class="">
                                        <strong>Vendor Rate:</strong>
                                        {{ $followup->vendor_rate }}
                                    </p>
                                </div>
                            </div>

                            <div class="row mt-3 mb-3">
                                <div class="table-responsive mt-4 add-more-fields">
                                    <table class="table table-center table-hover">
                                        <thead style="background-color:#3484C3">
                                            <tr>
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
                                                <td style="width:7%;">
                                                    <input type="text" class="form-control bg-color">
                                                </td>
                                                <td style="width:25%;">
                                                    <input type="text" name="head_description" class="form-control" value="{!! Helper::service($followup->service_id) !!}  {{ $followup->origin_city}} To {{ $followup->desti_city}}" readonly/>
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
                                                    <input type="number" class="form-control" id="grand_prov_sum" name="grand_prov_sum" value="{{ isset($followup->prov_sum) ? $followup->prov_sum : "" }}" readonly/>
                                                </td>
                                                <td style="width:7%;">
                                                        <input type="number" class="form-control bg-color"/>
                                                </td>
                                                <td style="width:10%;">
                                                    <input type="number" class="form-control" id="grand_total" name="grand_total" value="{{ isset($followup->grand_total) ? $followup->grand_total : "" }}" readonly/>
                                                </td>
                                                <td style="width:5%;" >
                                                    <input type="number" class="form-control bg-color"/>
                                                </td>
                                            </tr>
                                            @if($costing_attribute !="" && count($costing_attribute) > 0 && !empty($costing_attribute))
                                                @foreach ($costing_attribute as $i => $costing)
                                                    <tr>
                                                        <td style="width:7%;">
                                                                    <input type="text" class="form-control code-input" id="code" name="codeu[]" value="{{ $costing->code }}" readonly>
                                                                </td>
                                                                <td style="width:25%;">
                                                                    <input type="text" class="form-control" id="description" name="descriptionu[]" value="{{ $costing->description }}" autocomplete="off" readonly>
                                                                </td>
                                                                <td style="width:5%;">
                                                                    <input type="number" class="form-control qty" id="qty" name="qtyu[]" value="{{ $costing->qty }}" readonly>
                                                                </td>
                                                                <td style="width:10%;">
                                                                    <select class="form-control form-select" id="unit" name="unitu[]" disabled >
                                                                        <option value="nos" {{ $costing->unit == 'nos' ? 'selected' : '' }}>Nos.</option>
                                                                        <option value="unit" {{ $costing->unit == 'unit' ? 'selected' : '' }}>Unit</option>
                                                                    </select>
                                                                </td>
                                                                <td style="width:7%;">
                                                                    <input type="number" class="form-control prov" id="prov" name="provu[]" value="{{ $costing->prov }}" readonly>
                                                                </td>
                                                                <td style="width:5%;">
                                                                    <input type="number" class="form-control" id="egp" name="egpu[]" value="{{ $costing->egp }}" readonly>
                                                                </td>
                                                                <td style="width:7%;">
                                                                    <input type="number" class="form-control" id="egp_percentage" name="egp_percentageu[]" value="{{ $costing->egp_percent }}" readonly>
                                                                </td>
                                                                <td style="width:7%;">
                                                                    <input type="number" class="form-control" id="selling" name="sellingu[]" value="{{ $costing->selling }}" readonly>
                                                                </td>
                                                                <td style="width:7%;">
                                                                    <input type="number" class="form-control" id="prov_sum" name="prov_sumu[]" value="{{ $costing->prov_sum }}" readonly>
                                                                </td>
                                                                <td style="width:7%;">
                                                                    <input type="number" class="form-control" id="selling_sum" name="selling_sumu[]" value="{{ $costing->selling_sum }}" readonly>
                                                                </td>

                                                                <td style="width:10%;">
                                                                    <input type="number" class="form-control" id="total" name="totalu[]" value="{{ $costing->total }}" readonly>
                                                                </td>
                                                                <td style="width:5%;">
                                                                    <input type="number" class="form-control" id="egp_sum"  name="egp_sumu[]" value="{{ $costing->egp_sum }}" readonly>
                                                                </td>

                                                                
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row mt-3 mb-3">
                                <div class="col-md-3">
                                    <p class="">
                                        <strong>Survey Vol:</strong>
                                        {{ $followup->survey_vol }}
                                    </p>
                                </div>
                                <div class="col-md-3">
                                    <p class="">
                                        <strong>Quote Vol:</strong>
                                        {{ $followup->quote_vol }}
                                    </p>
                                </div>
                                <div class="col-md-3">
                                    <p class="">
                                        <strong>Quote Wt:</strong>
                                        {{ $followup->quote_weight }}
                                    </p>
                                </div>
                                
                            </div>
                             <div class="row mt-3 mb-3">
                                <div class="col-md-3">
                                    <p class="">
                                        <strong>Margin %:</strong>
                                        {{ $followup->margin_percent }}
                                    </p>
                                </div>
                                <div class="col-md-3">
                                    <p class="">
                                        <strong>Margin (AED):</strong>
                                        {{ $followup->margin_amount }}
                                    </p>
                                </div>
                                <div class="col-md-3">
                                    <p class="">
                                        <strong>Selling Amt without Indiv Margin(AED):</strong>
                                        {{ $followup->selling_amount }}
                                    </p>
                                </div>
                                <div class="col-md-3">
                                    <p class="">
                                        <strong>Total Sum(AED):</strong>
                                        {{ $followup->total_sum }}
                                    </p>
                                </div>
                            </div>
                            <div class="row mt-3 mb-3">
                                <div class="col-md-3">
                                    <p class="">
                                        <strong>Prepared By:</strong>
                                        {{ $followup->prepared_by }}
                                    </p>
                                </div>
                                <div class="col-md-3">
                                    <p class="">
                                        <strong>Est Time to Complete:</strong>
                                        {{ $followup->est_time_to_complete }}
                                    </p>
                                </div>
                            </div>
                            <div class="row mt-3 mb-3">
                                <div class="col-md-11">
                                    <h4 class="heading_four">Quotation Details</h4>
                                    
                                </div>
                                <div class="col-md-1" style="text-align: right;">
                                    <a href="javascript:void(0)" onclick="javascript:download_quotation('{{$followup->id}}')" class="btn btn-primary" style="
    margin-top: 15px;
"><i class="fa fa-download"></i></a>
                                </div>
                            </div>
                            <div class="row mt-3 mb-3">
                                <div class="col-md-3">
                                    <p class="">
                                        <strong>Quotation ID:</strong>
                                        {{ $followup->quote_id }}
                                    </p>
                                </div>
                                <div class="col-md-3">
                                    <p class="">
                                        <strong>Quotation Date:</strong>
                                        {{ \Carbon\Carbon::parse($quotation_data->quotation_date)->format('d-m-Y') }}
                                    </p>
                                </div>
                                @php
                                    if($quotation_data->include_insurance == "1"){
                                        $insurance = "Yes";
                                    }else{
                                        $insurance = "No";
                                    }
                                @endphp
                                <div class="col-md-3">
                                    <p class="">
                                        <strong>Include Insurance:</strong>
                                        {{ $insurance }}
                                    </p>
                                </div>
                                @php
                                    if($quotation_data->vat_charge == "1"){
                                        $vat_charge = "Yes";
                                    }else{
                                        $vat_charge = "No";
                                    }
                                @endphp
                                <div class="col-md-3">
                                    <p class="">
                                        <strong>VAT ( 5% ):</strong>
                                        {{ $vat_charge }}
                                    </p>
                                </div>
                            </div>
                            <div class="row mt-3 mb-3">
                                <div class="col-md-12">
                                    <h4 class="heading_four">Operation Details</h4>
                                    
                                </div>
                            </div>
                            @if(isset($supervisor_assign_data) && count($supervisor_assign_data) > 0)
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <h5>Crew Leader</h5>
                                </div>
                                @foreach ($supervisor_assign_data as $i => $supervisor)

                                @php
                                    $supervisors_id = Helper::salesmanname($supervisor->supervisors_id);
                                @endphp
                                <div class="col-md-6">
                                    <p class="">
                                        <strong>Crew Name:</strong>
                                        {{ $supervisors_id }}
                                    </p>
                                </div>
                                 @php
                                    $time_zonenamenew = Helper::time_zonenamenew($supervisor->time_zones);
                                @endphp
                                <div class="col-md-6">
                                    <p class="">
                                        <strong>Crew Time:</strong>
                                        {{ $time_zonenamenew }}
                                    </p>
                                </div>
                                @endforeach

                                
                                
                            </div>
                            @endif

                            @if(isset($manpower_assign_data) && count($manpower_assign_data) > 0)
                            <div class="row mt-3 mb-3">
                                <div class="col-md-12">
                                    <h5>Man Power</h5>
                                </div>
                                @foreach ($manpower_assign_data as $i => $manpower)

                                @php
                                    $men_power_id = Helper::salesmanname($manpower->men_power_id);
                                @endphp
                                <div class="col-md-6">
                                    <p class="">
                                        <strong>Man Power Name:</strong>
                                        {{ $men_power_id }}
                                    </p>
                                </div>
                                 @php
                                    $time_zonenamenew = Helper::time_zonenamenew($manpower->time_zones);
                                @endphp
                                <div class="col-md-6">
                                    <p class="">
                                        <strong>Man Power Time:</strong>
                                        {{ $time_zonenamenew }}
                                    </p>
                                </div>
                                @endforeach
                                
                            </div>
                            @endif

                             @if(isset($VehiclesAssignOperation) && count($VehiclesAssignOperation) > 0)
                            <div class="row mt-3 mb-3">
                                <div class="col-md-12">
                                    <h5>Vehicles Information</h5>
                                </div>

                                <div class="col-lg-12">
                                    <div class="table-responsive driver-detail-tab">
                                        <table class="table table-hover mb-0">
                                            <thead>
                                                <tr>
                                                    <th>Vehicle Name</th>
                                                    <th>Vehicle Number</th>
                                                    <th>Driver Name</th>
                                                    <th>Mobile</th>
                                                    <th>No. Of Trip</th>
                                                    <th>Amount</th>
                                                    <th>Time</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($VehiclesAssignOperation as $i => $VehiclesAssign)
                                                @php
                                                    $Datavehicle = Helper::vehicle($VehiclesAssign->vehicle_id);
                                                    // $driver_name =  Helper::getDriverInfo($followup->id,$VehiclesAssign->id,$VehiclesAssign->driver_id);
                                                    // echo"<pre>";print_r($driver_name);exit;
                                                @endphp

                                                @php
                                                    $time_zonenamenew = Helper::time_zonenamenew($VehiclesAssign->time_zone_id);

                                                    $driver_name = DB::table('vehical_attributes')->where('id',$VehiclesAssign->driver_id)->first();
                                                @endphp
                                                <tr>
                                                    <td>{{ $Datavehicle->vehicle_name  ?? '-'}}</td>
                                                    <td>{{ $Datavehicle->vehicle_number ?? '-' }}</td>
                                                    <td>{{ $driver_name->driver_name ?? '-' }}</td>
                                                    <td>{{ $VehiclesAssign->driver_mobile_no ?? '-' }}</td>
                                                    <td>{{ $VehiclesAssign->no_of_trip ?? '-' }}</td>
                                                    <td>{{ $VehiclesAssign->amount ?? '-' }}</td>
                                                    <td>{{ $time_zonenamenew ?? '-' }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                
                                
                            </div>
                            @endif

                            @if(isset($quotation_packing_material) && count($quotation_packing_material) > 0)
                            <div class="row mt-3 mb-3">
                                <div class="col-md-12">
                                    <h5>Packing Material</h5>
                                </div>
                                <div class="col-lg-12">
                                    <div class="table-responsive driver-detail-tab">
                                        <table class="table table-hover mb-0">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Name</th>
                                                    <th>Allocate</th>
                                                    <th>Total Cost</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($quotation_packing_material as $i => $packing)
                                                @php
                                                    $materialData = Helper::materialname($packing->material_id);
                                                @endphp
                                                <tr>
                                                    <td>{{ $i+1 }}</td>
                                                    <td>{{ $materialData->name }} {{ $materialData->materal_def }}</td>
                                                    <td>{{ $packing->total_allocate }}</td>
                                                    <td>{{ $packing->total_price }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            @endif

                             @if(isset($uploaded_documents) && count($uploaded_documents) > 0)
                                <div class="row mt-3 mb-3">
                                    <div class="col-md-12">
                                        <h5>Documents Information</h5>
                                    </div>
                                    <div class="col-md-12 driver-detail-tab">
                                        <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Title</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($uploaded_documents as $document)
                                                <tr>
                                                    <td>{{ $document->title }}</td>
                                                    <td>
                                                        <a href="{{ route('download.document', $document->id) }}" class="btn btn-primary btn-sm">
                                                            Download
                                                            <i class="fas fa-download"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        </table>
                                    
                                    </div>
                                </div>
                            @endif

                            <div class="row mt-3 mb-3">
                                <div class="col-md-9">
                                    <h4 class="heading_four">Invoice Information</h4>
                                    
                                </div>
                                <div class="col-md-3 mt-15" style="text-align: right;">
                                    <button type="button" class="btn btn-primary"
                                        onclick="javascript:download_Invoice()" id="download_button_2" style="
    margin-top: 15px;">
                                        Download TAX Invoice <i class="fa fa-download"></i></button>

                                        <button class="btn btn-primary mb-1" type="button" disabled id="spinner_download_button_2"
                                            style="display: none;margin-top: 15px;">
                                            <span class="spinner-border spinner-border-sm" role="status"
                                                aria-hidden="true"></span>
                                            Downloading...
                                        </button>
                                </div>
                            </div>
                            <div class="row mt-3 mb-3">
                                <div class="col-md-3">
                                    <p class="">
                                        <strong>Invoice No:</strong>
                                        {{ $followup->order_number }}
                                    </p>
                                </div>
                                <div class="col-md-3">
                                    <p class="">
                                        <strong>Invoice Date:</strong>
                                        {{ \Carbon\Carbon::parse($invoice_data->invoice_date)->format('d-m-Y') }}
                                    </p>
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
<script>
    function download_quotation(enquiry_id) {
            var mail_format = 1; // Get the selected value from the dropdown

            $('#spinner_download_button').show();
            $('#download_button').hide();

            var url = "{{ route('qoutation.download') }}"; // Laravel route
            //var enquiry_id = 1;
            // Construct query parameters
            var queryParams = new URLSearchParams({
                "_token": "{{ csrf_token() }}",
                "formatType": mail_format,
                "enquiry_id": enquiry_id
            }).toString();

            // Redirect to the download route
            window.location.href = url + "?" + queryParams;

            setTimeout(function () {
                $('#spinner_download_button').hide();
                $('#download_button').show();
            }, 2000);
        }

        function download_Invoice() {
            var mail_format = "2";
            
            $('#spinner_download_button_2').show();
            $('#download_button_2').hide();
            
            var url = "{{ route('invoice-bill.download') }}"; // Laravel route

            // Construct query parameters
            var queryParams = new URLSearchParams({
                "_token": "{{ csrf_token() }}",
                "formatType": mail_format,
                "enquiry_id": @json($followup->id)
            }).toString();

            // Redirect to the download route
            window.location.href = url + "?" + queryParams;

            setTimeout(function () {
                $('#spinner_download_button_2').hide();
                $('#download_button_2').show();
            }, 2000);
        }
    </script>
@stop
