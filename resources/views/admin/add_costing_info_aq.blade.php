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
            border:unset;
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
    </style>
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Costing</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('costing.index') }}">Costing</a></li>
                        <li class="breadcrumb-item active">Add Costing</li>
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
                        <form id="survey_form" action="{{ route('costing.info') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <input id="enquiry_hidden_id" name="enquiry_hidden_id" type="hidden" class="form-control"
                        value="{{ $followup_data->id }}"/>
                        <input type="hidden" name="action" value="{{ $action ?? "" }}">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="name">Costing ID:</label>
                                        <input id="costing_id" name="costing_id" type="text" class="form-control"
                                            value="{{ $followup_data->costing_id }}"  readonly/>

                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="name">Enquiry ID:</label>
                                        <input id="inquiry_id" name="inquiry_id" type="text" class="form-control"
                                            value="{{ $followup_data->quote_no }} "  readonly/>
                                        <p class="form-error-text" id="name_error" style="color: red;"></p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="survey_id">Survey ID:</label>
                                        <input id="survey_id" name="survey_id" type="text" value="{{ isset($followup_data->survey_id) ? $followup_data->survey_id : '' }}" class="form-control"  readonly/>

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Costing Date:</label>
                                        <input id="costing_date" name="costing_date" type="text" class="form-control" readonly/>
                                        <p class="form-error-text" id="costing_date_error" style="color: red;"></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Branch Code:</label>
                                        <input type="hidden" name="branch" value="{{ $followup_data->branch }}">
                                        <select name="branch_code" id="branch_code" class="form-control select" disabled/>
                                            <option value="">Select Branch</option>
                                            @foreach($branch_data as $data)
                                                <option value="{{ $data->id }}" {{ $data->id == $followup_data->branch ? 'selected' : '' }}>{{ $data->branch }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <input type="checkbox" id="costing_info_box" name="costing_info_box" onchange="costinginformationvisibilty()"
                                    value="0">
                                    <label for="costing_info_box" ><b class="checkbox-color">Costing Information:</b></label>
                                </div>

                                    <div id="costing_info_fields" class="hidden">
                                        <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="name">Location:</label>
                                                @if($followup_data->origin_country != '' && $followup_data->desti_country != '')
                                                    <input id="costing_address" name="costing_address" type="text" class="form-control"
                                                        value="{{
                                                            Helper::service($followup_data->service_id) .
                                                            ' ' . ($followup_data->origin_country ? Helper::countryname($followup_data->origin_country) : '') .
                                                            ($followup_data->origin_city ? ' (' . $followup_data->origin_city . ')' : '') .
                                                            ' To ' .
                                                            ($followup_data->desti_country ? Helper::countryname($followup_data->desti_country) : '') .
                                                            ($followup_data->desti_city ? ' (' . $followup_data->desti_city . ')' : '')
                                                        }}"
                                                        readonly
                                                    />
                                                @endif

                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <select name="service_id" id="service_id" class="form-control select">
                                                    <option value=""> Select Services Type</option>
                                                    @foreach ($service_data as $service)
                                                        <option value="{{ $service->id }}"
                                                            @if ($service->id == $followup_data->service_id) {{ 'selected' }} @endif>
                                                            {{ $service->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <select id="shipment_type" name="shipment_type" class="form-control select">
                                                <option value="">Select Shipment Type</option>
                                                @foreach($shipment_type as $shipment)
                                                    <option value="{{$shipment->id}}" @if($followup_data->shipment_type == $shipment->id) selected @endif>{{$shipment->name}}</option>
                                                @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                            <div class="form-group">
                                                <input id="value_1" name="value_1" type="text" value="{{ $followup_data->value_1 ?? "" }}" class="form-control" placeholder="Value" >
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <select id="option_1" name="option_1" class="form-control select form-select">
                                                    <option value="" @if(($followup_data->option_1 ?? '') == '') selected @endif>Select Option</option>
                                                    <option value="CBM Net" @if(($followup_data->option_1 ?? '') == 'CBM Net') selected @endif>CBM Net</option>
                                                    <option value="LBS Net" @if(($followup_data->option_1 ?? '') == 'LBS Net') selected @endif>LBS Net</option>
                                                    <option value="CFT Net" @if(($followup_data->option_1 ?? '') == 'CFT Net') selected @endif>CFT Net</option>
                                                    <option value="KG Net" @if(($followup_data->option_1 ?? '') == 'KG Net') selected @endif>KG Net</option>
                                                    <option value="Metric Ton" @if(($followup_data->option_1 ?? '') == 'Metric Ton') selected @endif>Metric Ton</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                            <div class="form-group">
                                                <input id="value_2" name="value_2" type="text" value="{{ $followup_data->value_2 ?? "" }}" class="form-control" placeholder="Value">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <select id="option_2" name="option_2" class="form-control select">
                                                    <option value="" @if(($followup_data->option_2 ?? '') == '') selected @endif>Select Option</option>
                                                    <option value="CBM Net" @if(($followup_data->option_2 ?? '') == 'CBM Net') selected @endif>CBM Net</option>
                                                    <option value="LBS Net" @if(($followup_data->option_2 ?? '') == 'LBS Net') selected @endif>LBS Net</option>
                                                    <option value="CFT Net" @if(($followup_data->option_2 ?? '') == 'CFT Net') selected @endif>CFT Net</option>
                                                    <option value="KG Net" @if(($followup_data->option_2 ?? '') == 'KG Net') selected @endif>KG Net</option>
                                                    <option value="Metric Ton" @if(($followup_data->option_2 ?? '') == 'Metric Ton') selected @endif>Metric Ton</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="name">Service Required:</label>
                                                <select name="service_required" id="service_required" class="form-control select">
                                                    <option value=""> Select Service Required</option>
                                                    @if($services_required !="" && !empty($services_required))
                                                        @foreach ($services_required as $services)
                                                            <option value="{{ $services->id }}"
                                                                @if ($services->id == $followup_data->service_required) {{ 'selected' }} @endif>
                                                                {{ $services->name }}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="name">Description Of Goods:</label>
                                                <select name="desc_of_goods" id="desc_of_goods" class="form-control select">
                                                    <option value="">Select Description Of Goods</option>
                                                    @if($goods_description !="" && !empty($goods_description))
                                                        @foreach ($goods_description as $goods_data)
                                                            <option value="{{ $goods_data->id }}"
                                                                @if ($goods_data->id == $followup_data->desc_of_goods) {{ 'selected' }} @endif>
                                                                {{ $goods_data->name }}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="name">Vendor Rate:</label>
                                                <input type="text" name="vendor_rate" class="form-control" placeholder="Value" value="{{ $followup_data->vendor_rate ?? "" }}">
                                            </div>
                                        </div>
                                        <div class="col-md-4 dollar-sign-btn">
                                            <ul class="icons-list">
                                                <li class="dollar-sign">
                                                    <i class='fas fa-dollar-sign'></i>
                                                </li>
                                            </ul>
                                        </div>
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
															<input type="text" name="head_description" class="form-control" value="{!! Helper::service($followup_data->service_id) !!}  {{ $followup_data->origin_city}} To {{ $followup_data->desti_city}}" />
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
															<input type="number" class="form-control" id="grand_prov_sum" name="grand_prov_sum" value="{{ isset($followup_data->prov_sum) ? $followup_data->prov_sum : "" }}" readonly/>
														</td>
														<td style="width:7%;">
															 <input type="number" class="form-control bg-color"/>
														</td>
														<td style="width:10%;">
															<input type="number" class="form-control" id="grand_total" name="grand_total" value="{{ isset($followup_data->grand_total) ? $followup_data->grand_total : "" }}" readonly/>
														</td>
														<td style="width:5%;" >
															<input type="number" class="form-control bg-color"/>
														</td>
													</tr>
                                                    {{-- <input type="hidden" class="form-control" id="code" name="code[]">
                                                    <input type="hidden" class="form-control" id="description" name="description[]">
                                                    <input type="hidden" class="form-control" id="qty" name="qty[]">
                                                    <input type="hidden" class="form-control" id="unit" name="unit[]">
                                                    <input type="hidden" class="form-control" id="prov" name="prov[]">
                                                    <input type="hidden" class="form-control" id="egp" name="egp[]">
                                                    <input type="hidden" class="form-control" id="egp_percentage" name="egp_percentage[]">
                                                    <input type="hidden" class="form-control" id="selling" name="selling[]">
                                                    <input type="hidden" class="form-control" id="prov_sum" name="prov_sum[]">
                                                    <input type="hidden" class="form-control" id="selling_sum" name="selling_sum[]">
                                                    <input type="hidden" class="form-control" id="total" name="total[]">
                                                    <input type="hidden" class="form-control" id="egp_sum"  name="egp_sum[]"> --}}
                                                    <div class="input_fields_wrap12">
                                                    </div>
                                                    @if($costing_attribute !="" && count($costing_attribute) > 0 && !empty($costing_attribute))
                                                        @foreach ($costing_attribute as $i => $costing)
                                                        <input type="hidden" name="updateid1xxx[]"
                                                                             id="updateid1xxx{{ $i + 1 }}"
                                                                             value="{{ $costing->id }}">
                                                            <tr>
                                                                <td style="width:7%;">
                                                                    <input type="text" class="form-control code-input" id="code" name="codeu[]" value="{{ $costing->code }}">
                                                                </td>
                                                                <td style="width:25%;">
                                                                    <input type="text" class="form-control" id="description" name="descriptionu[]" value="{{ $costing->description }}" autocomplete="off">
                                                                </td>
                                                                <td style="width:5%;">
                                                                    <input type="number" class="form-control qty" id="qty" name="qtyu[]" value="{{ $costing->qty }}">
                                                                </td>
                                                                <td style="width:10%;">
                                                                    <select class="form-control form-select" id="unit" name="unitu[]">
                                                                        <option value="nos" {{ $costing->unit == 'nos' ? 'selected' : '' }}>Nos.</option>
                                                                        <option value="unit" {{ $costing->unit == 'unit' ? 'selected' : '' }}>Unit</option>
                                                                    </select>
                                                                </td>
                                                                <td style="width:7%;">
                                                                    <input type="number" class="form-control prov" id="prov" name="provu[]" value="{{ $costing->prov }}">
                                                                </td>
                                                                <td style="width:5%;">
                                                                    <input type="number" class="form-control" id="egp" name="egpu[]" value="{{ $costing->egp }}">
                                                                </td>
                                                                <td style="width:7%;">
                                                                    <input type="number" class="form-control" id="egp_percentage" name="egp_percentageu[]" value="{{ $costing->egp_percent }}">
                                                                </td>
                                                                <td style="width:7%;">
                                                                    <input type="number" class="form-control" id="selling" name="sellingu[]" value="{{ $costing->selling }}">
                                                                </td>
                                                                <td style="width:7%;">
                                                                    <input type="number" class="form-control" id="prov_sum" name="prov_sumu[]" value="{{ $costing->prov_sum }}">
                                                                </td>
                                                                <td style="width:7%;">
                                                                    <input type="number" class="form-control" id="selling_sum" name="selling_sumu[]" value="{{ $costing->selling_sum }}">
                                                                </td>

                                                                <td style="width:10%;">
                                                                    <input type="number" class="form-control" id="total" name="totalu[]" value="{{ $costing->total }}" readonly>
                                                                </td>
                                                                <td style="width:5%;">
                                                                    <input type="number" class="form-control" id="egp_sum"  name="egp_sumu[]" value="{{ $costing->egp_sum }}">
                                                                </td>

                                                                <td class="add-remove text-end">

                                                                    @if(Route::currentRouteName() === "revise.request")
                                                                        <i class="fas fa-minus-circle" onclick="singledelete('{{ route('quote.costing.remove', ['enquiry_id' => $costing->enquiry_id, 'id' => $costing->id]) }}')"></i>
                                                                        @if($i === 0)
                                                                        <i class="fas fa-plus-circle add-row"></i>
                                                                        @endif
                                                                    @else
                                                                        <i class="fas fa-minus-circle" onclick="singledelete('{{ route('costing.remove', ['enquiry_id' => $costing->enquiry_id, 'id' => $costing->id]) }}')"></i>
                                                                        @if($i === 0)
                                                                        <i class="fas fa-plus-circle add-row"></i>
                                                                        @endif
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @else
													<tr>
														<td style="width:7%;">
															<input type="text" class="form-control code-input" id="code" name="code[]">
														</td>
														<td style="width:25%;">
															<input type="text" class="form-control" id="description" name="description[]" autocomplete="off">
														</td>
														<td style="width:5%;">
															<input type="number" class="form-control" id="qty" name="qty[]">
														</td>
														<td style="width:10%;">
                                                            <select class="form-control form-select" id="unit" name="unit[]">
                                                                <option value="nos">Nos.</option>
                                                                <option value="unit">Unit</option>
                                                            </select>
														</td>
														<td style="width:7%;">
															<input type="number" class="form-control" id="prov" name="prov[]">
														</td>
														<td style="width:5%;">
															<input type="number" class="form-control" id="egp" name="egp[]">
														</td>
														<td style="width:7%;">
															<input type="number" class="form-control" id="egp_percentage" name="egp_percentage[]">
														</td>
														<td style="width:7%;">
															<input type="number" class="form-control" id="selling" name="selling[]">
														</td>
														<td style="width:7%;">
															<input type="number" class="form-control" id="prov_sum" name="prov_sum[]">
														</td>
														<td style="width:7%;">
															 <input type="number" class="form-control" id="selling_sum" name="selling_sum[]">
														</td>
														<td style="width:10%;">
															<input type="number" class="form-control" id="total" name="total[]" readonly>
														</td>
														<td style="width:5%;">
															<input type="number" class="form-control" id="egp_sum"  name="egp_sum[]">
														</td>

														<td class="add-remove text-end">
															<i class="fas fa-plus-circle add-row"></i>
														</td>
													</tr>
                                                    @endif
												</tbody>
											</table>
										</div>
                                        <div class="col-md-4 mt-3">
                                            <div class="form-group row">
                                                <label class="col-form-label col-md-4">Survey Vol.:</label>
                                                <div class="col-md-5">
                                                    <input type="number" class="form-control" name="survey_vol" id="survey_vol" value="{{ isset($followup_data->survey_vol) ? $followup_data->survey_vol : "" }}" >
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mt-3">
                                            <div class="form-group row">
                                                <label class="col-form-label col-md-4">Quote Vol.:</label>
                                                <div class="col-md-5">
                                                    <input type="number" class="form-control" name="quote_vol"  id="quote_vol" value="{{ isset($followup_data->quote_vol) ? $followup_data->quote_vol : "" }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mt-3">
                                            <div class="form-group row">
                                                <label class="col-form-label col-md-4">Quote Wt.:</label>
                                                <div class="col-md-5">
                                                    <input type="number" class="form-control" name="quote_weight" id="quote_weight" value="{{ isset($followup_data->quote_weight) ? $followup_data->quote_weight : "" }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 mt-3">
                                            <div class="form-group">
                                                <label for="name">Margin %:</label>
                                                <input type="number" name="margin" class="form-control" id="margin" value="{{ isset($followup_data->margin_percent) ? $followup_data->margin_percent : "" }}">
                                            </div>
                                        </div>

                                        <div class="col-md-3 mt-3">
                                            <div class="form-group">
                                                <label for="name">Margin (AED):</label>
                                                <input type="number" name="margin_amount" class="form-control" id="margin_amount" value="{{ isset($followup_data->margin_amount) ? $followup_data->margin_amount : "" }}">
                                            </div>
                                        </div>

                                        <div class="col-md-4 mt-3">
                                            <div class="form-group">
                                                <label for="name">Selling Amt without Indiv Margin(AED):</label>
                                                <input type="number" name="with_margin_amount" class="form-control" id="with_margin_amount" value="{{ isset($followup_data->selling_amount) ? $followup_data->selling_amount : "" }}" readonly>
                                            </div>
                                        </div>

                                        <div class="col-md-2 mt-3">
                                            <div class="form-group">
                                                <label for="name">Total Sum(AED):</label>
                                                <input type="number" name="total_sum" class="form-control" id="total_sum" value="{{ isset($followup_data->total_sum) ?  $followup_data->total_sum : "" }}" readonly>
                                            </div>
                                        </div>


                                    </div>
                                </div>
                            </div>

                            <div class="form-group col-lg-6">
                                <label for="name">Status:</label>
                                <select name="status_id" id="status_id" class="form-control form-select gen_info_val_blank select">
                                    <option value="">Select Status</option>
                                    <option value="1" {{ $enquiry_status->status == '1' ? 'selected' : '' }}>Active</option>
                                    <option value="2" {{ $enquiry_status->status == '2' ? 'selected' : '' }}>Completed</option>
                                    <option value="3" {{ $enquiry_status->status == '3' ? 'selected' : '' }}>Followup</option>
                                    <option value="4" {{ $enquiry_status->status == '4' ? 'selected' : '' }}>Lost</option>
                                </select>
                            </div>

                            <div class="col-lg-6">
                                <div class="text-end mt-4">
                                    @if($action !="" && !empty($action))
                                    <a class="btn btn-primary" href="{{ route('quote.index') }}">
                                    @else
                                    <a class="btn btn-primary" href="{{ route('costing.index') }}">
                                    @endif
                                        Cancel</a>
                                    <button class="btn btn-primary mb-1" type="button" disabled id="spinner_button"
                                        style="display: none;">
                                        <span class="spinner-border spinner-border-sm" role="status"
                                            aria-hidden="true"></span>
                                        Loading...
                                    </button>
                                    <button type="button" class="btn btn-primary"
                                        onclick="javascript:costing_validation()" id="submit_button">Submit</button>
                                    <!-- <input type="submit" name="submit" value="Submit" class="btn btn-primary"> -->
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal custom-modal fade" id="similar_rate_model" role="dialog">
        <div class="modal-dialog modal-dialog-centered similar-rate-model">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="modal-text text-left">
                        <h5>Similar Rate</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                    </div>
                    <div class="modal-text text-center" id="dropdownreplace">
                        <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                            <table class="table table-hover mb-0">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>Costing ID</th>
                                        <th>Date</th>
                                        <th>Volume</th>
                                        <th>Weight</th>
                                        <th>Org.<br/>City/State/Country</th>
                                        <th>Desti.<br/>City/State/Country</th>
                                        <th>Amount</th>
                                        <th>FCY</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($similar_rate_data !="" && count($similar_rate_data) && !empty($similar_rate_data))
                                    @foreach($similar_rate_data as $data)
                                    <tr>
                                        <td>{{ $data->costing_id }}</td>
                                        <td>{{ date('d M Y', strtotime($data->s_date)) }}</td>
                                        <td>{{ $data->value_1." ".$data->option_1 }}</td>
                                        <td>{{ $data->value_2." ".$data->option_2 }}</td>
                                        <td>
                                            {!! $data->origin_country ? Helper::countryname($data->origin_country) : '' !!}/
                                            {{ $data->origin_city ?? '' }}
                                        </td>
                                        <td>
                                            {!! $data->desti_country ? Helper::countryname($data->desti_country) : '' !!}/
                                            {{ $data->desti_city ?? '' }}
                                        </td>
                                        <td>{{ $data->total_sum }} AED</td>
                                        <td>1164.00 AED</td>
                                        <td class="text-right">
                                            <a href="javascript:void(0);" class="btn btn-sm btn-white text-success me-2" onclick="similar_rate_view({{ $data->id }})">
                                                <i class="far fa-edit me-1"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr>
                                        <td colspan="9" class="text-center">No Data Found</td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="loader"></div>
                <div class="modal-body activities-tab-content activities-tab-show">
                    <div class="modal-text text-left">
                        <h5>Activities</h5>
                    </div>
                    <div class="modal-text text-center" id="dropdownreplace">
                        <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                            <table class="table table-hover mb-0">
                                <thead class="thead-dark">
                                    <tr>
                                        <th colspan="2">Description</th>
                                        <th>Prov.</th>
                                        <th>Selling</th>
                                        <th>Qty</th>
                                        <th>Prov. Sum</th>
                                        <th>Selling Sum</th>
                                        <th>Total</th>
                                        <th>GP</th>
                                        <th>GP %</th>
                                    </tr>
                                </thead>
                                <tbody id="similar_rate_data_replace">
                                    <tr>
                                        <td colspan="10" class="text-center">No Data Found</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="alert alert-success success_message_div" style="display: none;">
                        <strong>Success!</strong> <span id="success_message_activities"></span>
                      </div>
                </div>


                {{-- <div class="modal-footer text-center">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="quote_accept_form();">Submit</button>
                </div> --}}
            </div>
        </div>
    </div>


@stop
@section('footer_js')
    <script src="https://cdn.ckeditor.com/ckeditor5/35.4.0/classic/ckeditor.js"></script>
    <script src="https://code.jquery.com/ui/1.14.1/jquery-ui.js"></script>
    <script>
        function costing_validation() {

            $('#spinner_button').show();
            $('#submit_button').hide();
            $('#survey_form').submit();
        }
        function setTodayDate() {
            const today = new Date();
            const formattedDate = today.toISOString().split('T')[0];
            document.getElementById('costing_date').value = formattedDate;
        }

        $(document).ready(function() {
            // Add a click event listener to elements with the 'price' class
            $('.dollar-sign').on('click', function() {
                $('#similar_rate_model').modal('show');
            });
        });
        // window.onload = setTodayDate;
    </script>
     <script>
        function costinginformationvisibilty() {
                const checkbox = document.getElementById('costing_info_box');
                const container = document.getElementById('costing_info_fields');
                if (checkbox.checked ) {
                    container.classList.remove('hidden');
                } else {
                    container.classList.add('hidden');
                }
            }
        </script>
    <script type="text/javascript">
        $(function() {

            $('#moving_date').datepicker({
                format: 'yyyy-mm-dd', // Set the desired date format yyyy-mm-dd
                // autoclose: true,
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
    </script>
    <script type="text/javascript" language="javascript">
        function singledelete(url) {
            var t = confirm('Are You Sure To Delete The Attribute ?');
            if (t) {
                window.location.href = url;
            } else {
                return false;
            }
        }


        $(document).ready(function () {

            // Initialize autocomplete function
            function initializeAutocomplete() {
                $(".code-input").autocomplete({
                    source: @json($code_data),
                    minLength: 0, // Allows dropdown to appear even on focus
                    select: function (event, ui) {
                        // When an option is selected
                        $(this).val(ui.item.value);
                    },
                    change: function (event, ui) {
                        // Allow manual entry if no match is found
                        if (!ui.item) {
                            let inputValue = $(this).val();
                            // Optionally validate or handle the manual input here
                            console.log(`Manual entry: ${inputValue}`);
                        }
                    }
                }).on('focus', function () {
                    // Open the dropdown when the input is focused
                    $(this).autocomplete("search", "");
                });
            }

            // Initialize autocomplete for existing inputs
            initializeAutocomplete();
        // Initialize row counter
        let rowCounter = 1;

        // Add new row
        $(document).on('click', '.add-row', function () {
            let newRow = `<tr data-row-id="${rowCounter}">
                        <td style="width:7%;"><input type="text" class="form-control code-input" id="code" name="code[]" autocomplete="off"></td>
                        <td style="width:25%;"><input type="text" class="form-control" id="description" name="description[]"></td>
                        <td style="width:5%;"><input type="number" class="form-control qty" id="qty" name="qty[]" value="0"></td>
                        <td style="width:10%;"><select class="form-control form-select select" id="unit" name="unit[]"><option value="nos">Nos.</option><option value="unit">Unit</option></select></td>
                        <td style="width:7%;"><input type="number" class="form-control prov" id="prov" name="prov[]" value="0"></td>
                        <td style="width:5%;"><input type="number" class="form-control" id="egp" name="egp[]"></td>
                        <td style="width:7%;"><input type="number" class="form-control" id="egp_percentage" name="egp_percentage[]" ></td>
                        <td style="width:7%;"><input type="number" class="form-control" id="selling" name="selling[]"></td>
                        <td style="width:7%;"><input type="number" class="form-control" id="prov_sum" name="prov_sum[]"></td>
                        <td style="width:7%;"><input type="number" class="form-control" id="selling_sum" name="selling_sum[]"></td>
                        <td style="width:10%;"><input type="number" class="form-control total" id="total" name="total[]" readonly></td>
                        <td style="width:5%;"><input type="number" class="form-control" id="egp_sum" name="egp_sum[]"></td>
                        <td class="add-remove text-end"><i class="fas fa-minus-circle remove-row"></i></td>
                      </tr>`;

        // Append the new row to the table
        $(".add-more-fields table tbody").append(newRow);

        // Increment the row counter
        rowCounter++;

        // Recalculate totals after adding a new row
        calculateRowValues();
        initializeAutocomplete();
    });

        $(document).ready(function () {
            function calculateRowValues(changedBy = 'margin') {
                // Loop through each row and calculate the total
                $('tr').each(function () {
                    let row = $(this); // Get the current row
                    let qty = parseFloat(row.find('#qty').val()) || 0;
                    let prov = parseFloat(row.find('#prov').val()) || 0;
                    let margin = parseFloat($('#margin').val()) || 0;
                    let margin_amount = parseFloat($('#margin_amount').val()) || 0;
                    let total = qty * prov;

                    // Update the total field for the current row
                    row.find('#total').val(total.toFixed(2)); // Update total for the row

                    // Update the hidden input with the total value for each row
                    let hiddenFieldId = row.data('row-id') + '-total'; // Unique hidden field ID for each row
                    let hiddenField = $("#" + hiddenFieldId);

                    if (hiddenField.length === 0) {
                        // row.append(`<input type="hidden" id="${hiddenFieldId}" name="total741[]" value="${total.toFixed(2)}">`);
                    } else {
                        hiddenField.val(total.toFixed(2)); // Update existing hidden field value
                    }
                });

                // Call function to update the global total sum
                let margin = parseFloat($('#margin').val()) || 0;
                let margin_amount = parseFloat($('#margin_amount').val()) || 0;
                updateGlobalSum(margin,margin_amount,changedBy);
            }

            // Call the function on page load
            calculateRowValues();

            // Also call the function on input events as needed
            //$(document).on('input', '#qty, #prov ,#margin ,#margin_amount', calculateRowValues);

            // Initial load
               
            let editingField = null;
                // Input events for qty and prov (recalculate without margin change)
                $(document).on('input', '#qty, #prov', function () {

                    editingField = 'margin';
                    calculateRowValues('margin');
                });

                

                // Input event for margin percentage
                $(document).on('input', '#margin', function () {
                    if (editingField !== 'margin') {
                        editingField = 'margin';
                        calculateRowValues('margin');
                        editingField = null;
                    }
                });

                // Input event for margin amount
                $(document).on('input', '#margin_amount', function () {
                    if (editingField !== 'amount') {
                        editingField = 'amount';
                        calculateRowValues('amount');
                        editingField = null;
                    }
                });

                // // Input event for margin percentage
                // $(document).on('input', '#margin', function () {
                //     calculateRowValues('margin');
                // });

                // // Input event for margin amount
                // $(document).on('input', '#margin_amount', function () {
                //     calculateRowValues('amount');
                // });


        });

    // Calculate row values and global total
    function calculateRowValues(changedBy = 'margin') {
        $("table tbody tr").each(function () {
            let row = $(this); // Get the current row
            let qty = parseFloat(row.find('#qty').val()) || 0;
            let prov = parseFloat(row.find('#prov').val()) || 0;
            let margin = parseFloat($('#margin').val()) || 0;
            let margin_amount = parseFloat($('#margin_amount').val()) || 0;
            let total = qty * prov;

            // Update the total field for the current row
            row.find('#total').val(total.toFixed(2));

            // Update or create the hidden input for total
            let hiddenFieldId = row.data('row-id') + '-total';
            let hiddenField = $("#" + hiddenFieldId);

            /* if (hiddenField.length === 0) {
                row.append(`<input type="hidden" id="${hiddenFieldId}" name="total[]" value="${total.toFixed(2)}">`);
            } else {
                hiddenField.val(total.toFixed(2));
            } */
        });

        // Update the global total sum
        let margin = parseFloat($('#margin').val()) || 0;
        let margin_amount = parseFloat($('#margin_amount').val()) || 0;
        updateGlobalSum(margin,margin_amount,changedBy);
    }

    // Update the global sum of all rows
    function updateGlobalSum(margin,margin_amount,changedBy = 'margin') {
        let globalTotal = 0;

        // Sum up all 'total' fields in rows
        $("table tbody tr").each(function () {
            let rowTotal = parseFloat($(this).find('#total').val()) || 0;
            globalTotal += rowTotal;
        });


        // alert(editingField);
        // alert(changedBy);


        let marginValue = 0;
        let withMargin = 0;

        if (changedBy === 'margin') {
            marginValue = (globalTotal * (margin / 100)).toFixed(2);
            withMargin = (parseFloat(globalTotal) + parseFloat(marginValue)).toFixed(2);

            if (editingField !== 'amount') {
                $('#margin_amount').val(marginValue);
            }

        } else if (changedBy === 'amount') {
            marginValue = parseFloat(margin_amount);
            margin = ((marginValue / globalTotal) * 100).toFixed(2);
            withMargin = (parseFloat(globalTotal) + marginValue).toFixed(2);

            if (editingField !== 'margin') {
                $('#margin').val(margin);
            }
        }

        // Update the calculated fields
        // $('#margin_amount').val(marginAmount);
        // $('#with_margin_amount').val(withMargin);
        // $('#total_sum').val(withMargin);
        // $('#grand_total').val(withMargin);
        // $('#grand_prov_sum').val(globalTotal.toFixed(2));
        // $('#global-total-hidden').val(globalTotal.toFixed(2));

        $('#with_margin_amount').val(withMargin);
        $('#total_sum').val(withMargin);
        $('#grand_total').val(withMargin);
        $('#grand_prov_sum').val(globalTotal.toFixed(2));
        $('#global-total-hidden').val(globalTotal.toFixed(2));

        
    }

    // Handle row removal
    $(document).on('click', '.remove-row', function () {
        let row = $(this).closest('tr');
        row.remove(); // Remove the row

        // Recalculate totals after a row is removed
        calculateRowValues();
    });

    // Recalculate totals on input change
    //$(document).on('input', '#qty, #prov ,#margin ,#margin_amount', calculateRowValues);

    // Input events for qty and prov (recalculate without margin change)

    let editingField = 'margin';

                $(document).on('input', '#qty, #prov', function () {

                    editingField = 'margin';
                    calculateRowValues('margin');
                });

                

                    // Input event for margin percentage
                    $(document).on('input', '#margin', function () {
                        if (editingField !== 'margin') {
                            editingField = 'margin';
                            calculateRowValues('margin');
                            editingField = null;
                        }
                    });

                    // Input event for margin amount
                    $(document).on('input', '#margin_amount', function () {
                        if (editingField !== 'amount') {
                            editingField = 'amount';
                            calculateRowValues('amount');
                            editingField = null;
                        }
                    });

                // // Input event for margin percentage
                // $(document).on('input', '#margin', function () {
                //     calculateRowValues('margin');
                // });

                // // Input event for margin amount
                // $(document).on('input', '#margin_amount', function () {
                //     calculateRowValues('amount');
                // });
});


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
        const checkbox = document.getElementById('costing_info_box');
        checkbox.checked = true;  // Make sure it's checked

        // Call the function to update the visibility based on the checked state
        costinginformationvisibilty();
        setTodayDate();
    };

    function similar_rate_view(enquiry_id) {
        $('.loader').show();
        $('.activities-tab-show').addClass("activities-tab-content");
        $.ajax({
            url: "{{ route('costing.similar-rate') }}",
            type: 'POST',
            data: {
                "_token": "{{ csrf_token() }}",
                "enquiry_id": enquiry_id
            },
            success: function(response) {
                setTimeout(function() { // Add a delay of 5 seconds
                    if (response.status == 'success') {
                        $('.loader').hide(); // Hide the loader after the delay
                        $('.activities-tab-show').removeClass("activities-tab-content");
                        $('#similar_rate_data_replace').html(response.data);
                    } else {
                        $('.loader').hide(); // Hide the loader after the delay
                        alert('No data found');
                    }
                },1000); // 1000 milliseconds = 1 seconds
            }
        });
    }

    function add_similar_data(enquiryId){
        $.ajax({
            url: "{{ route('costing.add-similar-rate') }}",
            type: 'POST',
            data: {
                "_token": "{{ csrf_token() }}",
                "enquiry_id_from": enquiryId,
                "enquiry_id_to": @json($followup_data->id)
            },
            success: function(response) {
                if (response.status == 'success') {

                    $('#success_message_activities').html("Activities Data has been updated Successfully");
                    $('.success_message_div').show();
                    setTimeout(function() {
                        $('.success_message_div').hide();
                        location.reload();
                    }, 2000);
                }
            }
        });
    }

    function closePopupModal() {
        $('.activities-tab-show').addClass("activities-tab-content");
    }


    $(document).ready(function () {
    let editingField = null;

    function calculateRowValues(changedBy = 'margin') {
        $("table tbody tr").each(function () {
            let row = $(this);
            let qty = parseFloat(row.find('#qty').val()) || 0;
            let prov = parseFloat(row.find('#prov').val()) || 0;
            let total = qty * prov;

            // Update total field
            row.find('#total').val(total.toFixed(2));
        });

        let margin = parseFloat($('#margin').val()) || 0;
        let margin_amount = parseFloat($('#margin_amount').val()) || 0;
        updateGlobalSum(margin, margin_amount, changedBy);
    }

    function updateGlobalSum(margin, margin_amount, changedBy = 'margin') {
        let globalTotal = 0;

        $("table tbody tr").each(function () {
            let rowTotal = parseFloat($(this).find('#total').val()) || 0;
            globalTotal += rowTotal;
        });

        let marginValue = 0;
        let withMargin = 0;

        if (changedBy === 'margin') {
            marginValue = (globalTotal * (margin / 100)).toFixed(2);
            withMargin = (parseFloat(globalTotal) + parseFloat(marginValue)).toFixed(2);

            if (editingField !== 'amount') {
                $('#margin_amount').val(marginValue);
            }

        } else if (changedBy === 'amount') {
            marginValue = parseFloat(margin_amount);
            margin = ((marginValue / globalTotal) * 100).toFixed(2);
            withMargin = (parseFloat(globalTotal) + marginValue).toFixed(2);

            if (editingField !== 'margin') {
                $('#margin').val(margin);
            }
        }

        $('#with_margin_amount').val(withMargin);
        $('#total_sum').val(withMargin);
        $('#grand_total').val(withMargin);
        $('#grand_prov_sum').val(globalTotal.toFixed(2));
        $('#global-total-hidden').val(globalTotal.toFixed(2));
    }

    // 🔁 Initial load calculation
    calculateRowValues();

    // 📦 Input listeners
    $(document).on('input', '#qty, #prov', function () {
        editingField = 'margin';
        calculateRowValues('margin');
    });

    $(document).on('input', '#margin', function () {
        if (editingField !== 'margin') {
            editingField = 'margin';
            calculateRowValues('margin');
            editingField = null;
        }
    });

    $(document).on('input', '#margin_amount', function () {
        if (editingField !== 'amount') {
            editingField = 'amount';
            calculateRowValues('amount');
            editingField = null;
        }
    });

    // ❌ Remove row
    $(document).on('click', '.remove-row', function () {
        $(this).closest('tr').remove();
        calculateRowValues(); // Recalculate after removing
    });
});

    
    

    </script>
@stop
