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
                    <h3 class="page-title">Download Reports</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('operation.index') }}">Reports</a></li>
                        <li class="breadcrumb-item active">Download Reports</li>
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
                        <form id="category_form" action="{{ route('operation-vehicle.update', $followup->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')
                           
                            <div class="row">
                                {{-- <div class="form-group col-lg-4">
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
                                </div> --}}
                                

                                <div class="form-group col-lg-6">
                                </div>

                                <!-- Report Download Buttons -->
                                <div class="d-flex">
                                    <a href="{{ route('client-care-report.download',$followup->id) }}" class="btn btn-primary btn-download">Download Client Care Report</a>&nbsp;&nbsp;

                                    <a href="{{ route('job-cost-report.download',$followup->id) }}" class="btn btn-primary btn-download">Download Job Cost Report</a>
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
            var customer_type = jQuery("#customer_type").val();
            if (customer_type == '') {
                jQuery('#customer_type_error').html("Please Select Labels Type");
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

@stop
