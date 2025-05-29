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
 </style>
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Edit Man Power</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('operation.index') }}">Man Power</a></li>
                        <li class="breadcrumb-item active">Edit Man Power</li>
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
                        <form id="category_form" action="{{ route('man-power.update', $followup->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')
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

                                <div class="form-group">
                                    
                                    <div id="planned_details_fields" class="">
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
                                    <div class="form-group col-lg-4">
                                        <label for="name">Man Power Pack Date From:</label>
                                        <input id="operation_pack_date" name="assigned_date" type="text"
                                                class="form-control" placeholder="Select Pack Date From"
                                                value="{{ $assigned_date ?? $quotation_data->packing_move_date ?? now()->format('Y-m-d') }}" autocomplete="off"/>
                                    </div>
                                </div>

                                    <div id="surveyor_sections" class="">
                                        @foreach($manPower_data as $data)
                                        <div id="man_power_section_{{ $data->id }}" class="row form-group" style="margin-top: 10px; margin-left: 3px;">
                                            <div class="row">
                                                <div class="col-md-2" style="border: 1px solid; padding: 6px; border-right: none; align-items: center; display: flex;">
                                                    <!-- Checkboxes of Supervisor's Name  button -->
                                                    <div class="form-check">
                                                        <input class="form-check-input surveyor-radio surveyor_radio_checked"
                                                               type="checkbox"
                                                               name="man_power_time_zone_name[]"
                                                               id="man_power_time_zone_name_{{ $data->id }}"
                                                               value="{{ $data->id }}"
                                                               data-surveyor-id="{{ $data->id }}"
                                                               @if($manpower_assign_data->contains('men_power_id', $data->id)) checked @endif
                                                        >
                                                        <label class="form-check-label" for="man_power_time_zone_name_{{ $data->id }}">
                                                            {{ $data->name }}
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="row col-md-10" style="border: 1px solid; padding: 10px;">
                                                    @php
                                                        $time_zone_ids = explode(',', $data->time_zone_id);
                                                    @endphp

                                                  @foreach($time_zone_ids as $time_zone_id)

                                                  @php
                                                    // Initialize variables
                                                    $disabledCheckbox = "";
                                                    $inputDisabled = "";

                                                    // Check if the supervisor is assigned to the given time zone
                                                    if ($date_wise_manpower_data->contains('men_power_id', $data->id) &&
                                                        in_array($time_zone_id, explode(',', $date_wise_manpower_data->firstWhere('men_power_id', $data->id)->time_zones))) {
                                                        $disabledCheckbox = "disabled-checkbox";
                                                        $inputDisabled = "disabled";
                                                    } else {
                                                        $disabledCheckbox = ""; // No class if not disabled
                                                        $inputDisabled = ""; // No disabled attribute if not disabled
                                                    }
                                                    @endphp
                                                  <div class="form-check col-md-2 ajax_replace" style="margin-top: 5px;">
                                                    <input class="form-check-input time-zone-radio surveyor-{{ $data->id }} {{ $disabledCheckbox }}"
                                                                type="checkbox"
                                                                name="man_power_time_zone_{{ $data->id }}[]"
                                                                id="man_power_time_zone_{{ $data->id }}_{{ $time_zone_id }}"
                                                                value="{{ $time_zone_id }}"
                                                                @if($manpower_assign_data->contains('men_power_id', $data->id) && in_array($time_zone_id, explode(',', $manpower_assign_data->firstWhere('men_power_id', $data->id)->time_zones))) checked @endif
                                                                {{ $inputDisabled }}
                                                            />
                                                    <label class="form-check-label" for="man_power_time_zone_{{ $data->id }}_{{ $time_zone_id }}">
                                                        {!! Helper::time_zonename($time_zone_id) !!}
                                                      </label>
                                                </div>
                                              @endforeach

                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>

                                <div class="text-end mt-4">
                                    <a class="btn btn-primary" href="{{ route('operation.index') }}"> Cancel</a>
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
        function category_validation() {
            var customer_type = jQuery("#customer_type").val();
            if (customer_type == '') {
                jQuery('#customer_type_error').html("Please Select Man Power Type");
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
            $('#operation_pack_date').datepicker({
                format: 'yyyy-mm-dd', // Set the desired date format yyyy-mm-dd
                // autoclose: true,
                todayHighlight: true
            });
        });
    </script>
    <script>
        $(document).ready(function () {
            $("#operation_pack_date").on("change", function () {
                var selectedDate = $(this).val();

                $.ajax({
                    url: "{{ route('checkManPowerDate') }}", // Define route in web.php
                    type: "POST",
                    data: {
                        date: selectedDate,
                        _token: "{{ csrf_token() }}" // Pass CSRF token
                    },
                    success: function (response) {
                        console.log(response);
                        if (response.length > 0) {
                            disableCheckBoxes(response);
                        } else {
                            enableAllCheckBoxes(); // Enable checkboxes if the date is not found in the table
                        }
                    },
                    error: function () {
                        alert("Error checking date availability.");
                    }
                });
            });
        });

        function disableCheckBoxes(assignments) {
            assignments.forEach(assign => {
                let supervisorId = assign.men_power_id;
                let timeZones = assign.time_zones.split(',');

                // Disable the Supervisor Checkbox
                // $(`#supervisor_time_zone_name_${supervisorId}`).prop('disabled', true);


                // Disable the time zone checkboxes related to this supervisor
                timeZones.forEach(timeZoneId => {
                    $(`#man_power_time_zone_${supervisorId}_${timeZoneId}`)
                            .prop('disabled', true)
                            .addClass('disabled-checkbox');
                    });
                });
        }

        function enableAllCheckBoxes() {
            // Enable all supervisor checkboxes
            // $('.surveyor-radio').prop('disabled', false);

            // Enable all time zone checkboxes
            $('.time-zone-radio').prop('disabled', false).removeClass('disabled-checkbox');
        }
    </script>

@stop
