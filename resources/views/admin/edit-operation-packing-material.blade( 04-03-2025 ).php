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
 </style>
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Edit Packing Material Receipt Return</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('operation.index') }}">Packing Material Receipt Return</a></li>
                        <li class="breadcrumb-item active">Edit Packing Material Receipt Return</li>
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
                        <form id="category_form" action="{{ route('operation-vehicle.update', $followup->id) }}" method="POST"
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
                                       {{--  <div class="form-group col-lg-4">
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
                                        </div> --}}
                                    </div>
                                    {{-- <div class="form-group col-lg-4">
                                        <label for="name">Packing Material Receipt Return Pack Date From:</label>
                                        <input id="operation_pack_date" name="pack_date" type="text"
                                                class="form-control" placeholder="Select Pack Date From"
                                                value="{{ $pack_date != '0000-00-00' ? $pack_date : ($quotation_data->packing_move_date != '0000-00-00' ? $quotation_data->packing_move_date : '') }}" autocomplete="off"/>
                                    </div> --}}
                                </div>

                                <div class="col-lg-12">
                                    <div class="table-responsive driver-detail-tab">
                                        <table class="table table-hover mb-0">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Name</th>
                                                    <th>Stock</th>
                                                    <th>Allocate</th>
                                                    <th>Total Cost</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <input type="hidden" name="unchecked_vehicles" id="unchecked_vehicles" value="">
                                                @forelse ($material_data as $data)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $data->name }}</td>
                                                        <td>
                                                            {{ Helper::getSumOfMaterialStocks($data->id).' Boxes' }}
                                                        </td>
                                                        <td class="allocate-input">
                                                            <input type="text" class="form-control" name="allocate[]" id="allocate" value="{{ Helper::getTotalAllocateQty($followup->id,$data->id) }}" readonly><i class="fas fa-plus-circle add-row" data-bs-toggle="modal" data-bs-target="#exampleModalCenter{{ $data->id }}"></i>
                                                        </td>
                                                        <td class="amount-input">
                                                            <input type="text" class="form-control" name="total_cost[]" id="total_cost" value="{{ Helper::getMaterialTotalCosts($followup->id,$data->id) }}" readonly></td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="5" class="text-center">No Data Found</td>
                                                    </tr>
                                                @endforelse
                                                
                                            </tbody>
                                        </table>
                                    </div>
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

    @forelse ($material_data as $data)
    <div class="modal fade warehouse-popup-table custom-modal" id="exampleModalCenter{{ $data->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle{{ $data->id }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form id="warehouse_allocateForm{{ $data->id }}" action="{{ route('warehouse.allocate') }}" method="POST">
                    @csrf
                    <input type="hidden" name="material_id" value="{{ $data->id }}">
                    <input type="hidden" name="enquiry_id" value="{{ $followup->id }}">
                    <div class="modal-header">
                        <h5 class="modal-title text-center" id="exampleModalLongTitle{{ $data->id }}">{{ $data->name }}</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                
                    <div class="modal-body text-center" style="max-height: 400px; overflow-y: auto;">
                        <table class="table table-hover mb-0 warehouse-table">
                            <thead class="thead-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Warehouse</th>
                                    {{-- <th>Vendor</th> --}}
                                    <th>PO No</th>
                                    <th>Qty</th>
                                    <th>Unit Cost</th>
                                    <th>Allocate</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data->attributes as $index => $warehouse)
                                <tr>
                                    <td draggable="false">{{ $loop->iteration }}</td>
                                    <td draggable="false">
                                        {{ Helper::getGodownName($warehouse->godown_id) }}
                                        <input type="hidden" name="godown_id[]" value="{{ $warehouse->godown_id }}">
                                    </td>
                                    <td draggable="false">{{ $quotation_data->purchase_order_no ?? "" }}</td>
                                    <td draggable="false">{{ $warehouse->stock }} Boxes</td>
                                    <td draggable="false">{{ $warehouse->price }}</td>
                                    <td draggable="false">
                                        <input type="text" 
                                               class="form-control" 
                                               id="allocate_{{ $data->id }}" 
                                               name="allocate[]" 
                                               value="{{ Helper::getEnteredAllocat($followup->id,$data->id,$warehouse->godown_id) }}"
                                        />
                                        <p style="color: red;" id="allocate-input-error_{{ $data->id }}"></p>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="warehouse_submit_button{{ $data->id }}" onclick="warehouse_allocateSubmit_{{ $data->id }}();">Save changes</button>
                        <button class="btn btn-primary mb-1" type="button" disabled id="warehouse_spinner_button{{ $data->id }}"
                            style="display: none;">
                            <span class="spinner-border spinner-border-sm" role="status"
                                aria-hidden="true"></span>
                            Loading...
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endforeach
@stop
@section('footer_js')
    <script>
        function category_validation() {
            var customer_type = jQuery("#customer_type").val();
            if (customer_type == '') {
                jQuery('#customer_type_error').html("Please Select Packing Material Receipt Return Type");
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
    <script>
        @forelse ($material_data as $data)
        function warehouse_allocateSubmit_{{ $data->id }}() {
            var customer_type = jQuery("#allocate_{{ $data->id }}").val();
            if (customer_type == '') {
                jQuery("#allocate-input-error_{{ $data->id }}").html("Please Enter Allocate");
                jQuery("#allocate-input-error_{{ $data->id }}").show().delay(0).fadeIn('show');
                jQuery("#allocate-input-error_{{ $data->id }}").show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#customer_type').offset().top - 150
                }, 1000);
                return false;
            }

            $("#warehouse_spinner_button{{ $data->id }}").show();
            $("#warehouse_submit_button{{ $data->id }}").hide();
            $("#warehouse_allocateForm{{ $data->id }}").submit();
        }
        @endforeach
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
                    url: "{{ route('checkVehicleDate') }}", // Define route in web.php
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
                let vehicleId = assign.vehicle_id;
                let timeZones = assign.time_zone_id.split(', ');

                // Disable the Supervisor Checkbox
                // $(`#supervisor_time_zone_name_${supervisorId}`).prop('disabled', true);


                // Disable the time zone checkboxes related to this supervisor
                timeZones.forEach(timeZoneId => {
                    $(`#vehicle_time_zone_${vehicleId}_${timeZoneId}`)
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

        function updateDriver(driverId, vehicleId, enquiryId) {
            if (driverId !== "") {
                $.ajax({
                    url: "{{ route('update.driver') }}", // Define this route in your web.php
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}", // CSRF token for security
                        enquiry_id: enquiryId,
                        vehicle_id: vehicleId,
                        driver_id: driverId
                    },
                    success: function(response) {
                        if (response.status === "success") {

                            console.log(response.status);
                            // alert("Driver updated successfully!");
                        } else {
                            console.log("Failed to update driver.");
                            // alert("Failed to update driver.");
                        }
                    },
                    error: function(xhr) {
                        console.log("Something went wrong! Please try again.");
                        // alert("Something went wrong! Please try again.");
                        console.log(xhr.responseText);
                    }
                });
            }
        }

        function getDriverContactInfo(driverId, vehicleId){
            var enquiryId = @json($followup->id);
            if (driverId === "") {
                $("#mobile_" + vehicleId).html("");
                $("#driver_mobile_no_" + vehicleId).val('');
                return;
            }

            $.ajax({
                url: "{{ route('get.driver.info') }}",  // Replace with your actual route
                type: "GET",
                data: { 
                        driver_id: driverId      
                },
                success: function(response) {
                    if (response.success) {
                        $("#mobile_" + vehicleId).html(response.mobile);
                        $("#driver_mobile_no_" + vehicleId).val(response.mobile);
                        updateDriver(driverId, vehicleId, enquiryId);
                    } else {
                        $("#mobile_" + vehicleId).html("Not Found");
                    }
                },
                error: function(xhr) {
                    console.error(xhr);
                }
            });

        }


        $(document).ready(function() {
            $(".vehicle-checkbox").on("change", function() {
                let uncheckedVehicles = $("#unchecked_vehicles").val().split(',').filter(id => id !== "");
                let vehicleId = $(this).val();

                if (!$(this).prop("checked")) {
                    // Add to unchecked list if not already present
                    if (!uncheckedVehicles.includes(vehicleId)) {
                        uncheckedVehicles.push(vehicleId);
                    }
                } else {
                    // Remove from unchecked list if checked again
                    uncheckedVehicles = uncheckedVehicles.filter(id => id !== vehicleId);
                }

                // Store updated list in hidden input
                $("#unchecked_vehicles").val(uncheckedVehicles.join(','));
            });
        });

    </script>

@stop
