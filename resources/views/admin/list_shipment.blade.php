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
                                            <th>Job Order ID</th>
                                            <th>Date</th>
                                            <th>Client Name</th>
                                            <th>Contact Person</th>
                                            <th>Client Mobile</th>
                                            <th>Client Email</th>
                                            <th>Status</th>
                                            <th>Detail</th>
                                            <th>Enquiry</th>
                                            <th class="text-right">Quote</th>
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
                                                        {{ $followup->job_order_id }}
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
                                                @if(Route::currentRouteName() !== "operation.index")
                                                <td>
                                                    @if ($followup->agent_attr_id != '')
                                                             {{ Helper::getOrganizationContactName($followup->agent_attr_id) }}
                                                    @else
                                                        {{ '-' }}
                                                    @endif
                                                </td>
                                                @endif
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
                                                @php
                                                    $enquiry_status = DB::table('enquiry_status_remark')
                                                                            ->where('enquiry_id', $followup->id)
                                                                            ->where('status','<>',2)
                                                                            ->orderBy('id','DESC')->value('status');
                                                @endphp
                                                <td>
                                                    <select name="status_id" id="status_id_{{ $followup->id }}" class="form-control form-select select" onchange="operationStatus(this.value, '{{ $followup->id }}')">
                                                        <option value="">Select Status</option>
                                                        <option value="1" {{ $enquiry_status == '1' ? 'selected' : '' }}>Active</option>
                                                        <option value="2" {{ $enquiry_status == '2' ? 'selected' : '' }}>Completed</option>
                                                        <option value="3" {{ $enquiry_status == '3' ? 'selected' : '' }}>Followup</option>
                                                        <option value="4" {{ $enquiry_status == '4' ? 'selected' : '' }}>Lost</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <a class="btn btn-sm btn-primary" href="{{ route('shipment.detail', $followup->id) }}">
                                                        <i class="far fa-eye me-1"></i> View
                                                    </a>
                                                </td>
                                                @if (in_array('32', $edit_perm))
                                                    <td class="text-right">
                                                        <a class="btn btn-primary"
                                                        href="{{ route('shipment.editinq', $followup->id) }}"><i
                                                        class="far fa-edit"></i>
                                                        </a>
                                                    </td>
                                                @endif
                                                @if (in_array('26', $delete_perm))
                                                <td>
                                                    <a class="btn btn-primary"
                                                    href="{{ route('revise.shipment', $followup->id) }}">
                                                    <i class="far fa-edit"></i>
                                                    </a>
                                                </td>
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

        function operationStatus(element, enquiry_id) {

            var url = '{{ route('shipment-status-change') }}';
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "status_id": element,
                    "enquiry_id": enquiry_id
                },
                success: function(response) {
                   
                    if (response.status == 2) {
                        $('#success-message-list').html("Shipment Status has been changed successfully");
                        $('#validate').show();
                        setTimeout(function() {
                            window.location.href = "{{ route('billing-invoice.index') }}";
                        }, 2000);
                    }else{
                        $('#success-message-list').html("Shipment Status has been changed successfully");
                        $('#validate').show();
                    }
                }
            });
        }

       /*  function operationStatus_old(element, enquiry_id) {

            var url = '{{ route('operation-status.update') }}';
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
                        $('#success-message-list').html("Operation Status has been changed successfully");
                        $('#validate').show();
                        setTimeout(function() {
                            window.location.href = "{{ route('billing-invoice.index') }}";
                        }, 2000);
                    }else{
                        $('#success-message-list').html("Operation Status has been changed successfully");
                        $('#validate').show();
                    }
                }
            });
        } */
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
