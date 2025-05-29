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
                    <h3 class="page-title">{{ $moduleName }}</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active">{{ $moduleName }}</li>
                    </ul>
                </div>
                @if (in_array('26', $add_perm) || in_array('15', $delete_perm))
                    <div class="col-auto">
                        {{-- <a class="btn btn-primary me-1" href="javascript:void('0');" onclick="excel_download();">Excel
                            Download</a> --}}
                        {{-- @if($get_user_data->role_id != '7')
                        @if (in_array('26', $add_perm))
                        <a class="btn btn-primary me-1" href="{{ route('followup.create') }}"><i class="fas fa-plus"></i> Add Survey </a>
                        @endif --}}
                        {{-- <a class="btn btn-primary filter-btn" href="javascript:void(0);" id="filter_search">
                            <i class="fas fa-filter"></i> Filter
                        </a> --}}
                       {{--  @if (in_array('26', $delete_perm))
                        <a class="btn btn-danger me-1" href="javascript:void('0');" onclick="delete_category();">
                            <i class="fas fa-trash"></i> Delete
                        </a>
                        @endif
                        @endif --}}
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
        <form method="GET" action="{{ url('filter_data') }}" id="filter_data">
            <input type="hidden" name="startdate_fil" id="startdate_fil" value="{{ $startdate ?: '' }}">
            <input type="hidden" name="enddate_fil" id="enddate_fil" value="{{ $enddate ?: '' }}">
            <input type="hidden" name="filter_salep_id_fil" id="filter_salep_id_fil" value="{{ $filter_salep_id ?: '' }}">
            <input type="hidden" name="filter_service_id_fil" id="filter_service_id_fil" value="{{ $filter_service_id ?: '' }}">
        </form>
        <form method="post" action="{{ url('status_change') }}" id="status_change">
            @csrf
            <input type="hidden" name="inquiry_id" id="inquiry_id" value="">
            <input type="hidden" name="inquiry_status" id="inquiry_status" value="">
        </form>
        <!-- Search Filter -->
        @php
            if (!empty($filter_salep_id) || !empty($filter_service_id) || !empty($startdate) || !empty($enddate))   {
                $displayCard = 'display:block';
            } else {
                $displayCard = 'display:none';
            }
        @endphp
        <div id="validate" class="alert alert-success alert-dismissible fade show" style="display: none;">
            <span id="success-message-list"></span>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <div id="filter_inputs" class="card filter-card" style="@php echo $displayCard; @endphp">
            <div class="card-body pb-0">
                <form action="{{ route('followup-filter') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-sm-6 col-md-8">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>Start Date</label>
                                        <input type="type" class="form-control" name="s_date" id="s_date"
                                            value="{{ $startdate ?: '' }}">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>End Date</label>
                                        <input type="type" class="form-control" name="e_date" id="e_date"
                                            value="{{ $enddate ?: '' }}">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>Select Sales person</label>
                                        <select name="salesmanname" class="form-control" id="salesmanname">
                                            <option value="">Select Sales Person</option>
                                            @foreach ($salesman_data as $salesman_data_new)
                                                <option value="{{ $salesman_data_new->id }}"
                                                    @if ($salesman_data_new->id == $filter_salep_id) {{ 'selected' }} @endif>
                                                    {{ $salesman_data_new->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>Select Services</label>
                                        <select name="servicename" class="form-control" id="servicename">
                                            <option value="">Select Service</option>
                                            @foreach ($service_data as $service_data_new)
                                                <option value="{{ $service_data_new->id }}"
                                                    @if ($service_data_new->id == $filter_service_id) {{ 'selected' }} @endif>
                                                    {{ $service_data_new->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3 col-md-4" style="margin-top: 23px;">
                            <input class="btn btn-primary" value="Search" type="submit">
                            <a href="{{ route('followup.index') }}" class="btn btn-primary">Reset</a>
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
                        <form id="form" action="{{ route('delete_followup') }}" enctype="multipart/form-data">
                            <INPUT TYPE="hidden" NAME="hidPgRefRan" VALUE="<?php echo rand(); ?>">
                            @csrf
                            <div class="table-responsive">
                                <table class="table table-center table-hover datatable" id="header_lock">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Select</th>
                                            @if(Route::currentRouteName() === "survey.index")
                                                <th>Survey ID</th>
                                            @endif
                                            @if(Route::currentRouteName() === "costing.index")
                                                <th>Costing ID</th>
                                            @endif
                                            @if(Route::currentRouteName() === "quote.index" || Route::currentRouteName() === "accepted-quotation.index")
                                                <th>Qoute ID</th>
                                            @endif
                                            @if(Route::currentRouteName() === "job-order.index" || Route::currentRouteName() === "operation.index")
                                                <th>Job Order ID</th>
                                            @endif
                                            <th>Date</th>
                                            <th>Client Name</th>
                                            <th>Contact Person</th>
                                            <th>Client Mobile</th>
                                            {{-- <th>Sales Person</th> --}}
                                            <th>Client Email</th>
                                            {{-- <th>Handled By</th> --}}
                                            {{-- <th>Follow Update</th> --}}
                                            @if(Route::currentRouteName() === "survey.index")
                                                @if($get_user_data->role_id != '7')
                                                <th>Survey</th>
                                                @else
                                                <th>Survey Details</th>
                                                @endif
                                            @endif
                                            @if(Route::currentRouteName() === "costing.index")
                                                <th>Costing</th>
                                            @endif
                                            @if(Route::currentRouteName() === "quote.index" || Route::currentRouteName() === "accepted-quotation.index")
                                                @if(Route::currentRouteName() !== "accepted-quotation.index")
                                                <th>Add Quote</th>
                                                @endif
                                                @if(Route::currentRouteName() !== "accepted-quotation.index")
                                                    <th>Mail</th>
                                                    <th>Revise Request</th>
                                                    <th>Status</th>
                                                @endif
                                            @endif
                                            @if(Route::currentRouteName() === "accepted-quotation.index")
                                                <th>Status</th>
                                            @endif
                                            @if(Route::currentRouteName() === "job-order.index")
                                                <th>Add Job</th>
                                            @endif
                                            @if(Route::currentRouteName() === "operation.index")
                                            <th>Crew Leader</th>
                                            <th>Man Power</th>
                                            <th>Vehicles</th>
                                            <th>Packing Material</th>
                                            @endif
                                            @if(Route::currentRouteName() !== "job-order.index")
                                                <th>Detail</th>
                                            @endif
                                            @if(Route::currentRouteName() === "survey.index")
                                                @if (in_array('26', $edit_perm))
                                                    <th class="text-right">Actions</th>
                                                @endif
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($followup_data as $followup)
                                            <tr>
                                                <td><input name="selected[]" id="selected[]" value="{{ $followup->id }}"
                                                type="checkbox" class="minimal-red"
                                                style="height: 20px;width: 20px;border-radius: 0px;color: red;">
                                                </td>
                                                <td>
                                                    @if(Route::currentRouteName() === "survey.index")
                                                        {{ $followup->survey_id }}
                                                    @endif
                                                    @if(Route::currentRouteName() === "costing.index")
                                                        {{ $followup->costing_id }}
                                                    @endif
                                                    @if(Route::currentRouteName() === "quote.index" || Route::currentRouteName() === "accepted-quotation.index" || Route::currentRouteName() === "job-order.index" && Route::currentRouteName() !== "job-order.index")
                                                        {{ $followup->quote_id }}   <br/>
                                                        @if($followup->revise_quotation_count !== 0)
                                                            <p class="text-primary">{{ 'Rev '.$followup->revise_quotation_count ?? "" }}</p>
                                                        @endif
                                                    @endif
                                                    @if(Route::currentRouteName() === "job-order.index" || Route::currentRouteName() === "operation.index")
                                                        {{ $followup->job_order_id }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($followup->enquiry_date != '')
                                                             {{ $followup->enquiry_date }}
                                                    @else
                                                        {{ '-' }}
                                                    @endif
                                                </td>
                                                @php
                                                    $clientName = "";
                                                    if($followup->agent_id != '' && $followup->customer_type != '1'  && $followup->customer_type == '2'){
                                                        $clientName = Helper::getOrganizationName($followup->agent_id);
                                                    }else{
                                                        $clientName = $followup->f_name;
                                                    }
                                                @endphp
                                                <td>
                                                        {{ $clientName }}
                                                </td>
                                                <td>
                                                    @if ($followup->agent_attr_id != '')
                                                             {{ Helper::getOrganizationContactName($followup->agent_attr_id) }}
                                                    @else
                                                        {{ '-' }}
                                                    @endif
                                                </td>
                                                @php
                                                    $clientMobile = "";
                                                    if($followup->customer_phone1 != '' && $followup->customer_type != '1' && $followup->customer_type == '2'){

                                                        if($followup->customer_phone1 != ''){
                                                            $clientMobile = $followup->customer_phone1;
                                                        }else {
                                                            $clientMobile = $followup->customer_phone2;
                                                        }

                                                    }else{

                                                        if($followup->c_mobile != ''){
                                                            $clientMobile = $followup->c_mobile;
                                                        }else{
                                                            $clientMobile = $followup->c_phone;
                                                        }
                                                    }
                                                @endphp
                                                <td>
                                                    {{ $clientMobile }}
                                                </td>
                                                @php
                                                    $clientEmail = "";
                                                    if($followup->customer_email != '' && $followup->customer_type != '1' && $followup->customer_type == '2'){
                                                        $clientEmail = $followup->customer_email;
                                                    }else{
                                                        $clientEmail = $followup->c_email;
                                                    }
                                                @endphp
                                                <td>
                                                    {{ $clientEmail }}
                                                </td>
                                                {{-- <td>
                                                    @if($followup->status_id == '3')
                                                    <a class="btn btn-primary" href="javascript:void(0)"
                                                        onclick="add_follow_up('{{ $followup->id }}');">
                                                    Follow Up</a>
                                                    @else
                                                        {{ "-" }}
                                                    @endif
                                                </td> --}}
                                                @if(Route::currentRouteName() === "survey.index")
                                                    @if($get_user_data->role_id != '7')
                                                        @if ($followup->id != '')
                                                            <td>
                                                            <a class="btn btn-primary" href="{{ route('followup.survey_info', $followup->id) }}">
                                                            <i class="fa fa-user"></i>
                                                            </td>
                                                        @endif
                                                    @else
                                                        <td>
                                                            {{-- <a class="btn btn-primary" href="{{ route('surveyor_form',$followup->id) }}"> --}}
                                                            <i class="fa fa-user"></i>
                                                        </td>
                                                    @endif
                                                @endif
                                                @if(Route::currentRouteName() === "costing.index")
                                                    @if ($followup->id != '')
                                                        <td>
                                                            <a class="btn btn-primary"
                                                            href="{{ route('costing.add', $followup->id) }}">
                                                            <i class="fa fa-usd"></i>
                                                            </a>
                                                        </td>
                                                    @else
                                                        <td>
                                                            <a class="btn btn-primary" href="javascript:voidmain(0)"><i class="fa fa-usd"></i></a>
                                                        </td>
                                                    @endif
                                                @endif
                                                @if(Route::currentRouteName() === "quote.index" || Route::currentRouteName() === "accepted-quotation.index")
                                                    @if ($followup->id != '')
                                                    @if(Route::currentRouteName() !== "accepted-quotation.index")
                                                        <td>
                                                            <a class="btn btn-primary"
                                                            href="{{ route('quotation.add', $followup->id) }}">
                                                            <i class="fa fa-file-alt"></i>
                                                            </a>
                                                        </td>
                                                        @endif

                                                        @if(Route::currentRouteName() !== "accepted-quotation.index")
                                                        @if ($followup->mail_to_customer == 1)
                                                        <td>
                                                            <a class="btn btn-primary"
                                                            href="{{ route('customer.mail', $followup->id) }}">
                                                            <i class="fa fa-envelope"></i>
                                                            </a>
                                                        </td>
                                                        @else
                                                            <td>{{ "-" }}</td>
                                                        @endif
                                                        <td>
                                                            <a class="btn btn-primary"
                                                            href="{{ route('revise.request', $followup->id) }}">
                                                            <i class="fa fa-edit"></i>
                                                            </a>
                                                        </td>
                                                        <td>
                                                            <select name="admin_accept_quote" id="admin_accept_quote" class="gen_info_val_blank" onchange="acceptQuotationByAdmin(this.value, '{{ $followup->id }}')">
                                                                <option value="">Select Status</option>
                                                                <option value="1">Accept Quotation</option>
                                                            </select>
                                                        </td>
                                                        @endif

                                                    @else
                                                        <td>
                                                            <a class="btn btn-primary" href="javascript:voidmain(0)"><i class="fa fa-file-alt"></i></a>
                                                        </td>
                                                    @endif
                                                @endif
                                            @php
                                           $survey_data = DB::table('survey_assign')->where('enquiry_id', $followup->id)->first();
                                            @endphp
                                       {{--  @if (!is_null($survey_data) && isset($survey_data->survey_id) &&$survey_data->survey_id != '')
                                            @if ($followup->id != '')
                                                <td>
                                                    <a class="btn btn-primary"
                                                    href="{{ route('followup.costing', $followup->id) }}">
                                                    <i class="fa fa-usd"></i>
                                                    </a>
                                                </td>
                                            @endif
                                            @else
                                                <td>
                                                    <a class="btn btn-primary" href="javascript:voidmain(0)"><i class="fa fa-usd"></i></a>
                                                </td>
                                            @endif --}}
                                            @if(Route::currentRouteName() === "accepted-quotation.index")
                                                <td>
                                                    <select name="status_id" id="status_id_{{ $followup->id }}" class="form-control form-select select" onchange="acceptStatusChangeJobOrder(this.value, '{{ $followup->id }}')">
                                                        <option value="">Select Status</option>
                                                        <option value="1" {{ $enquiry_status->status == '1' ? 'selected' : '' }}>Active</option>
                                                        <option value="2" {{ $enquiry_status->status == '2' ? 'selected' : '' }}>Completed</option>
                                                        <option value="3" {{ $enquiry_status->status == '3' ? 'selected' : '' }}>Followup</option>
                                                        <option value="4" {{ $enquiry_status->status == '4' ? 'selected' : '' }}>Lost</option>
                                                    </select>
                                                </td>
                                            @endif
                                            @if(Route::currentRouteName() === "job-order.index")
                                            <td>
                                                <a class="btn btn-primary"
                                                   href="{{ route('job-order.edit', $followup->id) }}">
                                                <i class="fa fa-file-alt"></i>
                                                </a>
                                            </td>
                                            @endif
                                            @if(Route::currentRouteName() === "operation.index")
                                            <td>
                                                <a class="btn btn-primary"
                                                   href="{{ route('operation.edit', $followup->id) }}">
                                                   <i data-feather="user"></i>
                                                </a>
                                            </td>
                                            <td>
                                                <a class="btn btn-primary"
                                                   href="{{ route('man-power.edit', $followup->id) }}">
                                                   <i data-feather="users"></i>
                                                </a>
                                            </td>
                                            <td>
                                                <a class="btn btn-primary"
                                                   href="{{ route('operation-vehicles.edit', $followup->id) }}">
                                                   <i class="fas fa-truck"></i>
                                                </a>
                                            </td>
                                            <td>
                                                <a class="btn btn-primary"
                                                   href="{{ route('operation-packing.edit', $followup->id) }}">
                                                   <i class="fas fa-box"></i>
                                                </a>
                                            </td>
                                            @endif
                                            @if(Route::currentRouteName() !== "job-order.index")
                                            <td>
                                                @if(isset($routeMapping[$currentRoute]))
                                                    <a class="btn btn-sm btn-primary" href="{{ route($routeMapping[$currentRoute], $followup->id) }}">
                                                        <i class="far fa-eye me-1"></i> View
                                                    </a>
                                                @endif
                                            </td>
                                            @endif
                                            @if(Route::currentRouteName() === "survey.index")
                                                @if (in_array('26', $edit_perm))
                                                    <td class="text-right">
                                                        <a class="btn btn-primary"
                                                        href="{{ route('survey.edit', $followup->id) }}"><i
                                                        class="far fa-edit"></i>
                                                        </a>
                                                    </td>
                                                @endif
                                            @endif
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
        </div>
    </div>


@stop
@section('footer_js')
    <!-- Delete Category Modal -->
    <div class="modal custom-modal fade" id="delete_category" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="modal-icon text-center mb-3">
                        <i class="fas fa-trash-alt text-danger"></i>
                    </div>
                    <div class="modal-text text-center">
                        <!-- <h3>Delete Expense Category</h3> -->
                        <p>Are you sure want to delete?</p>
                    </div>
                </div>
                <div class="modal-footer text-center">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="form_sub();">Delete</button>
                </div>
            </div>
        </div>
    </div>
    <!-- /Delete Category Modal -->
    <!-- Followup  Modal -->
    <div class="modal custom-modal fade" id="add_follow_up_model" role="dialog">
        <div class="modal-dialog modal-dialog-centered folloup-modal">
            <div class="modal-content">
                <form id="followup_form" action="{{ url('followup_form') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="inquiry_id" id="inquiry_id_follow">
                    <div class="modal-body">
                        <div class="modal-text text-center">
                            <!-- <h3>Delete Expense Category</h3> -->
                        </div>
                        <div class="modal-text text-center" id="dropdownreplace">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="name">Follow Up Date</label>
                                    <input id="date" name="date" type="text" class="form-control"
                                        placeholder="Enter Follow Up Date" value="{{ date('m/d/Y') }}"/>
                                    <p class="form-error-text" id="date_error" style="color: red;"></p>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="name">Next Follow Up Date</label>
                                    <input id="next_date" name="next_date" type="text" class="form-control"
                                        placeholder="Enter Next Follow Up Date" />
                                    <p class="form-error-text" id="next_date_error" style="color: red;"></p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="name">Remarks</label>
                                <textarea id="remarks" name="remarks" class="form-control" cols="30" rows="2"
                                    placeholder="Enter Remark"></textarea>
                                <p class="form-error-text" id="remarks_error" style="color: red;"></p>
                            </div>
                        </div>
                        <p class="form-error-text" id="inquiry_id_error" style="color: red; margin-top: 10px;"></p>
                         <div id="follow_replace">
                        </div>
                    </div>
                    <div class="modal-footer text-center">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" onclick="form_sub_followup();">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        function form_sub_followup() {
            var date = jQuery("#date").val();
            if (date == '') {
                jQuery('#date_error').html("Please Enter Follow up Date");
                jQuery('#date_error').show().delay(0).fadeIn('show');
                jQuery('#date_error').show().delay(2000).fadeOut('show');
                return false;
            }
            var next_date = jQuery("#next_date").val();
            if (next_date == '') {
                jQuery('#next_date_error').html("Please Enter Next Follow up Date");
                jQuery('#next_date_error').show().delay(0).fadeIn('show');
                jQuery('#next_date_error').show().delay(2000).fadeOut('show');
                return false;
            }
            var remarks = jQuery("#remarks").val();
            if (remarks == '') {
                jQuery('#remarks_error').html("Please Enter remark");
                jQuery('#remarks_error').show().delay(0).fadeIn('show');
                jQuery('#remarks_error').show().delay(2000).fadeOut('show');
                return false;
            }
            $('#followup_form').submit();
        }
    </script>
    <!-- /Follow up Modal -->
    <!-- Select one record Category Modal -->
    <div class="modal custom-modal fade" id="select_one_record" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="modal-text text-center">
                        <h3>Please select at least one record to delete</h3>
                        <!-- <p>Are you sure want to delete?</p> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- < Status Model > --}}
    <div class="modal custom-modal fade" id="add_followup_status_model" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <input type="hidden" name="status_id" id="status_id">
                <div class="modal-body">
                    <div class="modal-text text-center">
                        <!-- <h3>Delete Expense Category</h3> -->
                    </div>
                    <div class="modal-text text-center" id="dropdownreplace">
                        <div class="form-group">
                            <label for="name"><b>Are You Sure Want to Change Status</b></label>
                            {{-- <p class="form-error-text" id="date_error" style="color: red;"></p> --}}
                        </div>
                    </div>
                    {{-- <p class="form-error-text" id="status_id_error" style="color: red; margin-top: 10px;"></p> --}}
                </div>
                <div class="modal-footer text-center">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="form_status_change();">Submit</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    {{-- < /Status Model> --}}
    <script>
        function delete_category() {
            // alert('test');
            var checked = $("#form input:checked").length > 0;
            if (!checked) {
                $('#select_one_record').modal('show');
            } else {
                $('#delete_category').modal('show');
            }
        }
        function form_sub() {
            $('#form').submit();
        }
        function add_follow_up(id) {
            $('#inquiry_id_follow').val(id);
            followup_data(id);
            $('#add_follow_up_model').modal('show');
        }
        function followup_data(id) {
            var url = '{{ url('followup_data') }}';
            $.ajax({
                url: url,
                type: 'post',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "id": id
                },
                success: function(msg) {
                    document.getElementById('follow_replace').innerHTML = msg;
                }
            });
        }
        function excel_download() {
            $('#filter_data').submit();
        }
        function statuschange(value, id) {
            $('#inquiry_id').val(id);
            $('#inquiry_status').val(value);
            $('#add_followup_status_model').modal('show');
        }
        function form_status_change() {
            $('#status_change').submit();
        }

        function acceptStatusChangeJobOrder(element, enquiry_id) {

            var url = '{{ url('accept-status-change') }}';
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "status_id": element,
                    "enquiry_id": enquiry_id
                },
                success: function(response) {
                    // alert(response.status);
                    if (response.status == 2) {
                        $('#success-message-list').html("Accepted Quotation Status has been changed successfully");
                        $('#validate').show();
                        setTimeout(function() {
                            window.location.href = "{{ route('job-order.index') }}";
                        }, 2000);
                    }else{
                        $('#success-message-list').html("Accepted Quotation Status has been changed successfully");
                        $('#validate').show();
                    }
                }
            });
        }
    </script>
    <script type="text/javascript">
        $(function() {
            $('#date').datepicker();
        });
        $(function() {
            $('#next_date').datepicker();
        });
        $(function() {
            $('#s_date').datepicker();
        });
        $(function() {
            $('#e_date').datepicker();
        });

        function acceptQuotationByAdmin(element, enquiry_id) {

            var url = '{{ route('accept-quotation.byadmin') }}';
            $.ajax({
                url: url,
                type: 'post',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "status_id": element,
                    "enquiry_id": enquiry_id
                },
                success: function(response) {
                    // alert(response.status);
                    if (response.status == "SUCCESS") {

                        $('#success-message-list').html("Quotation Accepted Successfully");
                        $('#validate').show();
                        setTimeout(function() {
                            window.location.href = "{{ route('accepted-quotation.index') }}";
                        }, 2000);

                    }
                }
            });
        }
    </script>
@stop
