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
 </style>
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Edit Labels</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('operation.index') }}">Labels</a></li>
                        <li class="breadcrumb-item active">Edit Labels</li>
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
                        <form id="category_form" action="{{ route('operation-label.update', $followup->id) }}" method="POST"
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
                                        <div class="form-group col-lg-12">
                                            <label for="name">Pack Date From:</label>
                                            <input id="pack_date_from" name="packing_move_date" type="text"
                                                    class="form-control" placeholder="Select Pack Date From"
                                                    value="{{ $quotation_data->packing_move_date ?? "" }}" autocomplete="off"/>
                                        </div>
                                        <div class="form-group col-lg-4">
                                            <label for="name">Item/Box No:</label>
                                            <input id="label_number" 
                                                   name="label_number" 
                                                   type="text"
                                                   class="form-control" 
                                                   placeholder="Enter Item/Box No"
                                                   value="{{ $followup->label_number ?? "" }}"
                                                   onkeypress="return validateNumber(event)"
                                                   autocomplete="off"
                                            />
                                            <p class="form-error-text" id="label_number_error" style="color: red;"></p>
                                            @error('label_number')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-lg-4">
                                            <label for="name">No. of Labels:</label>
                                            <input id="no_of_labels" 
                                                   name="no_of_labels" 
                                                   type="text"
                                                   class="form-control" 
                                                   placeholder="Enter No. of Labels"
                                                   value="{{ $followup->no_of_labels ?? "" }}"
                                                   onkeypress="return validateNumber(event)"
                                                   autocomplete="off"
                                            />
                                            <p class="form-error-text" id="no_of_labels_error" style="color: red;"></p>
                                            @error('no_of_labels')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-lg-4">
                                            <label for="name">From No:</label>
                                            <input id="from_no" 
                                                   name="from_no" 
                                                   type="text"
                                                   class="form-control" 
                                                   placeholder="Enter From No"
                                                   value="{{ $followup->from_no ?? "" }}"
                                                   onkeypress="return validateNumber(event)"
                                                   autocomplete="off"
                                            />
                                            <p class="form-error-text" id="from_no_error" style="color: red;"></p>
                                            @error('from_no')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <label for="name">Name:</label>
                                            <input id="label_name"
                                                   name="label_name"
                                                   type="text"
                                                   class="form-control" 
                                                   placeholder="Enter Name"
                                                   value="{{ $followup->label_name ?? "" }}"  
                                                   autocomplete="off"
                                            />
                                            <p class="form-error-text" id="label_name_error" style="color: red;"></p>
                                            @error('label_name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <label for="name">Label Description:</label>
                                            <input id="label_description" 
                                                   name="label_description" 
                                                   type="text"
                                                   class="form-control" 
                                                   placeholder="Enter Label Description"
                                                   value="{{ $followup->label_description ?? "" }}"  
                                                   autocomplete="off"
                                            />
                                            <p class="form-error-text" id="label_description_error" style="color: red;"></p>
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <label for="name">Footer:</label>
                                            <input id="label_footer" 
                                                   name="label_footer" 
                                                   type="text"
                                                   class="form-control" placeholder="Enter Footer"
                                                   value="{{ $followup->label_footer ?? "" }}"
                                                   autocomplete="off"
                                            />
                                            <p class="form-error-text" id="label_footer_error" style="color: red;"></p>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="Surveyor">Product Types:</label>
                                            <select name="storage_product_type" id="storage_product_type" class="form-control form-select storage_val_blank select">
                                                <option value=""> Select Product Types</option>
                                                @foreach($product_type_data as $product_type)
                                                <option value="{{ $product_type->id }}" @if($product_type->id == $followup->storage_product_type){{'selected'}} @endif>{{ $product_type->product_type }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="name">Service Type</label>
                                            <select name="service_id" id="service_id" class="form-control form-select select">
                                                <option value=""> Select Services Type</option>
                                                @foreach ($service_data as $service)
                                                    <option value="{{ $service->id }}"
                                                        @if ($service->id == $followup->service_id) {{ 'selected' }} @endif>
                                                        {{ $service->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="name">Origin City:</label>
                                                <input id="origin_city" name="origin_city" type="text" class="form-control"
                                                placeholder="Enter Origin City" value="{{ $followup->origin_city }}" />
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="name">Desti. City:</label>
                                                <input id="desti_city" name="desti_city" type="text" class="form-control"
                                                placeholder="Enter Destination City" value="{{$followup->desti_city}}" />
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="Surveyor">Description Of Goods:</label>
                                            <select name="desc_of_goods" id="desc_of_goods" class="form-control form-select origin_desti_val_blank select">
                                                <option value="">Select Description Of Goods</option>
                                                @foreach ($goods_description as $goods_data)
                                                    <option value="{{ $goods_data->id }}"
                                                        @if ($goods_data->id == $followup->desc_of_goods) {{ 'selected' }} @endif>
                                                        {{ $goods_data->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-lg-4">
                                            <label for="name">Shipment Date:</label>
                                            <input id="shipment_date" name="shipment_date" type="text"
                                                    class="form-control" placeholder="Select Shipment Date"
                                                    value="{{ $followup->shipment_date ?? "" }}" autocomplete="off"/>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <input type="checkbox" id="toggleLabel" name="show_label" @if($followup->show_label == 1) checked @endif> <label for="toggleLabel">Show Label</label>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group" id="replace_mail_html_content">
                                            </div>
                                        </div>
                                        <div class="loader"></div>
                                        <a href="{{ route('label.preview',$followup->id) }}" target="_blank"> <button type="button" class="btn btn-primary preview-btn preview-btn-hide">Preview</button>
                                        
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
        

        $(document).ready(function () {
            function toggleLabelFunction() {
                $('.loader').show();
                let isChecked = $('#toggleLabel').is(':checked');

                let labelName = $('#label_name').val();
                let labelDescription = $('#label_description').val();
                let labelFooter = $('#label_footer').val();
                let labelNumber = $('#label_number').val();
                let noOfLabels = $('#no_of_labels').val();
                let fromNo = $('#from_no').val();
                let shipmentDate = $('#shipment_date').val();
                let originCity = $('#origin_city').val();
                let destiCity = $('#desti_city').val();
                let productType = $('#storage_product_type').val();
                let goodsType = $('#desc_of_goods').val();

                let data = {
                    labelName: labelName,
                    labelDescription: labelDescription,
                    labelFooter: labelFooter,
                    labelNumber: labelNumber,
                    noOfLabels: noOfLabels,
                    fromNo: fromNo,
                    shipmentDate: shipmentDate,
                    originCity: originCity,
                    destiCity: destiCity,
                    productType: productType,
                    goodsType: goodsType,
                    _token: "{{ csrf_token() }}"
                };

                $.ajax({
                    url: "{{ route('toggle.label') }}",
                    type: "POST",
                    data: data,
                    success: function (response) {
                        setTimeout(function () { 
                            $('.loader').hide();
                            if (response.status === 'success') {
                                if (isChecked) {
                                    $(".preview-btn").removeClass("preview-btn-hide");
                                    $("#replace_mail_html_content").html(response.data); // Show label
                                } else {
                                    $(".preview-btn").addClass("preview-btn-hide");
                                    $("#replace_mail_html_content").html(''); // Hide label when unchecked
                                }
                            } else {
                                console.error("Error updating label:", response);
                            }
                        }, 1000);
                    },
                    error: function (xhr) {
                        console.error("AJAX error:", xhr.responseText);
                    }
                });
            }

            // Trigger function when checkbox changes
            $('#toggleLabel').change(toggleLabelFunction);

            // Trigger function when any input or dropdown changes
            $('input, select').on('input change', function () {
                if ($('#toggleLabel').is(':checked')) {
                    toggleLabelFunction();
                }
            });
        });


        function category_validation() {
            var label_number = jQuery("#label_number").val();
            if (label_number == '') {
                jQuery('#label_number_error').html("Please Enter Item/Box No");
                jQuery('#label_number_error').show().delay(0).fadeIn('show');
                jQuery('#label_number_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#label_number').offset().top - 150
                }, 1000);
                return false;
            }

            let no_of_labels = jQuery("#no_of_labels").val();
            if (no_of_labels == '') {
                jQuery('#no_of_labels_error').html("Please Enter No. of Labels");
                jQuery('#no_of_labels_error').show().delay(0).fadeIn('show');
                jQuery('#no_of_labels_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#no_of_labels').offset().top - 150
                }, 1000);
                return false;
            }
            let from_no = jQuery("#from_no").val();
            if (from_no == '') {
                jQuery('#from_no_error').html("Please Enter From No");
                jQuery('#from_no_error').show().delay(0).fadeIn('show');
                jQuery('#from_no_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#from_no').offset().top - 150
                }, 1000);
                return false;
            }
            let label_name = jQuery("#label_name").val();
            if (label_name == '') {
                jQuery('#label_name_error').html("Please Enter Name");
                jQuery('#label_name_error').show().delay(0).fadeIn('show');
                jQuery('#label_name_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#label_name').offset().top - 150
                }, 1000);
                return false;
            }
            let label_description = jQuery("#label_description").val();
            if (label_description == '') {
                jQuery('#label_description_error').html("Please Enter Label Description");
                jQuery('#label_description_error').show().delay(0).fadeIn('show');
                jQuery('#label_description_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#label_description').offset().top - 150
                }, 1000);
                return false;
            }
            let label_footer = jQuery("#label_footer").val();
            if (label_footer == '') {
                jQuery('#label_footer_error').html("Please Enter Footer");
                jQuery('#label_footer_error').show().delay(0).fadeIn('show');
                jQuery('#label_footer_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#label_footer').offset().top - 150
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
            $('#shipment_date').datepicker({
                format: 'yyyy-mm-dd', // Set the desired date format yyyy-mm-dd
                // autoclose: true,
                todayHighlight: true
            });
        });
    </script>
@stop
