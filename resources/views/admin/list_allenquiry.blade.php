@extends('admin.includes.Template')
@section('content')
    @php
        $userId = Auth::id();
    //
        $get_user_data = Helper::get_user_data($userId);
        $get_permission_data = Helper::get_permission_data($get_user_data->role_id);
        // echo"<pre>";print_r($get_user_data->role_id);echo"</pre>";exit;
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

</style>

    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">All Enquiry</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active">All Enquiry</li>
                    </ul>
                </div>
                @if (in_array('49', $add_perm) || in_array('49', $delete_perm))
                    <div class="col-auto">
                        {{-- <a class="btn btn-primary me-1" href="javascript:void('0');" onclick="excel_download();">Excel
                            Download</a> --}}
                        @if($get_user_data->role_id != '7')
                       
                        <a class="btn btn-primary filter-btn" href="javascript:void(0);" id="filter_search">
                            <i class="fas fa-filter"></i> Filter
                        </a>
                        
                        @endif
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
            if (!empty($fil_enq_id) || !empty($clientNameFilter) || !empty($clientMobileFilter) || !empty($clientEmailFilter) || !empty($statusFilter) || !empty($salespersonsFilter))   {
                $displayCard = 'display:block';
            } else {
                $displayCard = 'display:none';
            }
        @endphp
        <div id="filter_inputs" class="card filter-card" style="@php echo $displayCard; @endphp">
            <div class="card-body pb-0">
                <form action="{{ route('allenquiry.allenquiry-filter') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-sm-6 col-md-10">
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label>Enquiry ID</label>
                                        <input type="text" class="form-control" name="fil_enq_id" id="fil_enq_id"
                                            value="{{ $fil_enq_id ?: '' }}">
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label>Client Name</label>
                                        <input type="text" class="form-control" name="clientNameFilter" id="clientNameFilter"
                                            value="{{ $clientNameFilter ?: '' }}">
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label>Client Mobile</label>
                                        <input type="text" class="form-control" name="clientMobileFilter" id="clientMobileFilter"
                                            value="{{ $clientMobileFilter ?: '' }}">
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label>Client Email</label>
                                        <input type="text" class="form-control" name="clientEmailFilter" id="clientEmailFilter"
                                            value="{{ $clientEmailFilter ?: '' }}">
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label>Status</label>
                                        <select name="statusFilter" class="form-control">
                                            <option value="">-- All Status --</option>
                                            @foreach(['Enquiry', 'Survey', 'Costing', 'Quotation', 'Accepted Quotation', 'Job Order', 'Operation', 'Shipment', 'Invoice', 'Closed'] as $option)
                                                <option value="{{ $option }}" {{ $statusFilter == $option ? 'selected' : '' }}>
                                                    {{ $option }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label>Sales Persons</label>
                                        <select name="salespersonsFilter" class="form-control">
                                            <option value="">-- Select Sales Persons --</option>
                                            
                                            @foreach($salesperson_data as $salesperson)
                                            <option value="{{ $salesperson->id }}" {{ $salespersonsFilter == $salesperson->id ? 'selected' : '' }}>{{ $salesperson->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                {{-- <div class="col-lg-4">
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
                                </div> --}}
                            </div>
                        </div>
                        <div class="col-sm-3 col-md-2" style="margin-top: 23px;">
                            <input class="btn btn-primary" value="Search" type="submit">
                            <a href="{{ route('allenquiry.lists') }}" class="btn btn-primary">Reset</a>
                        </div>
                    </div>
            </div>
            </form>
        </div>
        
        <!-- /Search Filter -->
        <div class="row">
            <div class="col-sm-12">
                <div class="card card-table"> 
                    <div class="card-body">
                        <form id="form" action="{{ route('delete_followup') }}" enctype="multipart/form-data">
                            <INPUT TYPE="hidden" NAME="hidPgRefRan" VALUE="<?php echo rand(); ?>">
                            @csrf
                        <div class="table-responsive">
                            <table class="table table-stripped table-hover">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Select</th>
                                        <th>Enquiry Id</th>
                                        <th>Date</th>
                                        <th>Client Name</th>
                                        <th>Contact Person</th>
                                        <th>Client Mobile</th>
                                        <th>Client Email</th>
                                        <th>Status</th>
                                        <th class="text-end">Detail</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(count($followup_data) > 0)

                                    @foreach ($followup_data as $followup)
                                    <tr>
                                        <td><input name="selected[]" id="selected[]" value="{{ $followup->id }}"
                                            type="checkbox" class="minimal-red"
                                            style="height: 20px;width: 20px;border-radius: 0px;color: red;"></td>
                                        <td>
                                            {{ $followup->quote_no }}
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
                                        <td>
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
                                            {{ $clientMobile }}
                                        </td>
                                        <td>
                                            @php
                                                $clientEmail = "";
                                                if($followup->customer_email != '' && $followup->customer_type != '1' && $followup->customer_type == '2'){
                                                     $clientEmail = $followup->customer_email;
                                                }else{
                                                    $clientEmail = $followup->c_email;
                                                }
                                            @endphp
                                             {{ $clientEmail }}

                                         </td>
                                        <td>
                                            @php
                                                    $status = 'Accepted';
                                                    $badgeClass = 'bg-success-light';

                                                    if ($followup->enquiry_level == 0) {
                                                        $status = 'Enquiry';
                                                        $badgeClass = 'bg-warning-light';
                                                    } elseif ($followup->survey_level == 0) {
                                                        $status = 'Survey';
                                                        $badgeClass = 'bg-warning-light';
                                                    } elseif ($followup->costing_level == 0) {
                                                        $status = 'Costing';
                                                        $badgeClass = 'bg-warning-light';
                                                    } elseif ($followup->quote_level == 0) {
                                                        $status = 'Quotation';
                                                        $badgeClass = 'bg-warning-light';
                                                    } elseif ($followup->accept_quote_level == 0) {
                                                        $status = 'Accepted Quotation';
                                                        $badgeClass = 'bg-warning-light';
                                                    } elseif ($followup->job_order_level == 0) {
                                                        $status = 'Job Order';
                                                        $badgeClass = 'bg-warning-light';
                                                    } elseif ($followup->operation_level == 0) {
                                                        $status = 'Operation';
                                                        $badgeClass = 'bg-warning-light';
                                                    } elseif ($followup->shipment_level == 0) {
                                                        $status = 'Shipment';
                                                        $badgeClass = 'bg-warning-light';
                                                    } elseif ($followup->billing_level == 0) {
                                                        $status = 'Invoice';
                                                        $badgeClass = 'bg-warning-light';
                                                    } elseif ($followup->closing_level == 0) {
                                                        $status = 'Closed';
                                                        $badgeClass = 'bg-warning-light';
                                                    }
                                                @endphp
                                            
                                                <span class="badge {{$badgeClass}}">{{$status}}</span>
                                        
                                        </td>
                                        <td class="text-end">
                                            <a class="btn btn-sm btn-primary" href="{{ route('allenquiry.detail',$followup->id) }}">
                                                <i class="far fa-eye me-1"></i> View
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr>
                                        <td colspan="10" class="text-center">No data found.</td>
                                    </tr>
                                @endif
                                    
                                </tbody>
                            </table>
                        </div>
                        </form>
                    </div>
                    {{ $followup_data->links('pagination::bootstrap-4') }}
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
    </script>
@stop
