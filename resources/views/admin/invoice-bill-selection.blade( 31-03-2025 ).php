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
        .checkbox-color {
            color: #0f548e !important;
        }
        table thead th {
            background-color: #3484C3;
            color: #fff;
        }
        #terms_condition_fields .nav-tabs{
            width: 50%;
        }
        #terms_condition_fields .nav-tabs.nav-tabs-solid > li > a {
            color: #333 !important;
            padding: 10px 23px !important;
        }
        #terms_condition_fields .nav-tabs.nav-tabs-solid > li > a.active, .nav-tabs.nav-tabs-solid > li > a.active:hover, .nav-tabs.nav-tabs-solid > li > a.active:focus {
            background-color: #3484C3 !important;
            border-color: #3484C3 !important;
            color: #fff !important;
            padding: 10px 23px !important;
        }
        .subject-hidden,.cc-email-hidden,.to-mail-hidden{
            display: none;
        }
        .form-action-buttons{width: 68% !important;}
    </style>
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Invoice</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('quote.index') }}">Invoice</a></li>
                        <li class="breadcrumb-item active">Add Invoice</li>
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
        <div class="alert alert-success alert-dismissible fade show success-message" style="display: none;">
            <strong>Success!</strong> <span id="success-message"></span>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <div id="validate" class="alert alert-danger alert-dismissible fade show" style="display: none;">
            <span id="login_error"></span>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <div class="alert alert-danger alert-dismissible fade show error-message" style="display: none;">
            <strong>Error!</strong> <span id="error-message"></span>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <!-- <h4 class="card-title">Basic Info</h4> -->
                        <form id="survey_form" action="#" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="action" value="add-qoutation">
                            <input id="enquiry_hidden_id" name="enquiry_hidden_id" type="hidden" class="form-control"
                        value=""/>
                            <div class="row">
                                {{-- <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="name">Mail Formats:</label>
                                        <select name="mail_format" id="mail_format" class="form-controll form-select select" onchange="mailFormatChange(this.value,'{{ $enquiry_id }}');">
                                            <option value="">Select</option>
                                            <option value="1">Format 1</option>
                                            <option value="2">Format 2</option>
                                        </select>
                                        <p id="mail-format-errror" style="color:red;"></p>
                                    </div>
                                </div> --}}

                                {{-- <div class="col-md-12">
                                    <div class="form-group" id="replace_mail_html_content">
                                    </div>
                                </div> --}}

                                <div class="loader"></div>

                                <div class="col-md-6">
                                    <button type="button" class="btn btn-primary"
                                        onclick="javascript:download_Invoice_profoma()" id="download_button_1">
                                        Download Profoma Invoice <i class="fa fa-download"></i></button>

                                        <button class="btn btn-primary mb-1" type="button" disabled id="spinner_download_button_1"
                                            style="display: none;">
                                            <span class="spinner-border spinner-border-sm" role="status"
                                                aria-hidden="true"></span>
                                            Downloading...
                                        </button>

                                        <button type="button" class="btn btn-primary"
                                        onclick="javascript:download_Invoice()" id="download_button_2">
                                        Download TAX Invoice <i class="fa fa-download"></i></button>

                                        <button class="btn btn-primary mb-1" type="button" disabled id="spinner_download_button_2"
                                            style="display: none;">
                                            <span class="spinner-border spinner-border-sm" role="status"
                                                aria-hidden="true"></span>
                                            Downloading...
                                        </button>

                                </div>
                                <div class="col-md-6">
                                   
                                </div>


                            </div>

                            <div class="col-lg-12 form-action-buttons">
                                <div class="text-center mt-4" style="margin-left: 250px;">
                                    <a class="btn btn-primary" href="{{ route('billing-invoice.index') }}"> Cancel</a>
                                    <button class="btn btn-primary mb-1" type="button" disabled id="spinner_button"
                                        style="display: none;">
                                        <span class="spinner-border spinner-border-sm" role="status"
                                            aria-hidden="true"></span>
                                        Loading...
                                    </button>
                                    {{-- <button type="button" class="btn btn-primary"
                                        onclick="javascript:quote_validation()" id="submit_button">
                                        Send Mail <i class="fa fa-envelope"></i></button> --}}

                                        {{-- <button type="button" class="btn btn-primary"
                                        onclick="javascript:download_Invoice()" id="download_button">
                                        Download Invoice <i class="fa fa-download"></i></button> --}}

                                        
                                    <!-- <input type="submit" name="submit" value="Submit" class="btn btn-primary"> -->

                                    <button type="button" class="btn btn-primary loader-btn" style="display: none;"
                                        onclick="javascript:void(0);" id="submit_button" disabled>
                                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                        Loading...
                                        </button>
                                    <!-- <input type="submit" name="submit" value="Submit" class="btn btn-primary"> -->
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
    {{-- <script src="https://cdn.ckeditor.com/ckeditor5/35.4.0/classic/ckeditor.js"></script> --}}

    {{-- CKEditor CDN --}}

    <script>

        function mailFormatChange(formatType,enquiry_id){
            if(formatType !=""){
                // alert(enquiry_id);
                $('.loader').show();
                var url = '{{ route('invoice-format-type') }}';
                $.ajax({
                    url: url,
                    type: 'post',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "formatType": formatType,
                        "enquiry_id": enquiry_id
                    },
                    success: function(response) {
                        
                        setTimeout(function() { // Add a delay of 5 seconds
                            if (response.status == 'success') {
                                $('.loader').hide(); // Hide the loader after the delay
                                $("#replace_mail_html_content").html(response.data);
                                
                            }else if(response.status == 'fail'){
                                $('.loader').hide();
                                $('.error-message').show();
                                $('#error-message').html(response.error);
                            }else {
                                $('.loader').hide(); // Hide the loader after the delay
                            }
                        },1000); // 1000 milliseconds = 1 seconds
                    }
                });

            }
        }
        function quote_validation() {

            var mail_format = document.getElementById('mail_format').value;
            let mailSubject = $("#mail_subject").val();

            if (mail_format == '') {
                jQuery('#mail-format-errror').html("Please Select Mail Format");
                jQuery('#mail-format-errror').show().delay(0).fadeIn('show');
                jQuery('#mail-format-errror').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#mail_format').offset().top - 150
                }, 1000);
                return false;
            }

            // Get selected checkbox values
            let selectedEmails = [];
            $("input[name='cc_email[]']:checked").each(function() {
                selectedEmails.push($(this).val());
            });

            let toMail = $("#to_mail").val();

            if (mail_format !== '') {

                $('#spinner_button').show();
                $('#submit_button').hide();

                var url = '{{ url('send-Invoice-mail') }}';
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "formatType": mail_format,
                        "enquiry_id": @json($enquiry_id),
                        "mailSubject": mailSubject,
                        "cc_emails": selectedEmails,
                        "to_mail": toMail
                    },
                    success: function(response) {
                        setTimeout(function() { // Add a delay of 5 seconds
                            if (response.status == 'SUCCESS') {

                                $('#spinner_button').hide();
                                $('#submit_button').show();
                                $('.success-message').show();
                                $('#success-message').html(response.message);
                                $('html, body').animate({
                                    scrollTop: $('.success-message').offset().top - 150
                                }, 1000);
                            }
                        },1000); // 1000 milliseconds = 1 seconds
                    },
                    error: function(xhr, status, error) {
                        // Handle server error responses here
                        alert('Error: ' + xhr.responseJSON.message);
                        $('#spinner_button').hide();
                        $('#submit_button').show();
                        $('.error-message').show();
                        $('#error-message').html(xhr.responseJSON.message);
                        $('html, body').animate({
                            scrollTop: $('.error-message').offset().top - 150
                        }, 1000);
                    }
                });
            }
            // $('#survey_form').submit();
        }

        function download_Invoice_profoma() {
            var mail_format = "1";
            // var mail_format = document.getElementById('mail_format').value;

            // if (mail_format == '') {
            //     jQuery('#mail-format-errror').html("Please Select Format");
            //     jQuery('#mail-format-errror').show().delay(0).fadeIn('show');
            //     jQuery('#mail-format-errror').show().delay(2000).fadeOut('show');
            //     $('html, body').animate({
            //         scrollTop: $('#mail_format').offset().top - 150
            //     }, 1000);
            //     return false;
            // }

            $('#spinner_download_button_1').show();
            $('#download_button_1').hide();
            
            var url = "{{ route('invoie-bill.download') }}"; // Laravel route

            // Construct query parameters
            var queryParams = new URLSearchParams({
                "_token": "{{ csrf_token() }}",
                "formatType": mail_format,
                "enquiry_id": @json($enquiry_id)
            }).toString();

            // Redirect to the download route
            window.location.href = url + "?" + queryParams;

            setTimeout(function () {
                $('#spinner_download_button_1').hide();
                $('#download_button_1').show();
            }, 2000);
        }
        function download_Invoice() {
            var mail_format = "2";
            // var mail_format = document.getElementById('mail_format').value;

            // if (mail_format == '') {
            //     jQuery('#mail-format-errror').html("Please Select Format");
            //     jQuery('#mail-format-errror').show().delay(0).fadeIn('show');
            //     jQuery('#mail-format-errror').show().delay(2000).fadeOut('show');
            //     $('html, body').animate({
            //         scrollTop: $('#mail_format').offset().top - 150
            //     }, 1000);
            //     return false;
            // }

            $('#spinner_download_button_2').show();
            $('#download_button_2').hide();
            
            var url = "{{ route('invoie-bill.download') }}"; // Laravel route

            // Construct query parameters
            var queryParams = new URLSearchParams({
                "_token": "{{ csrf_token() }}",
                "formatType": mail_format,
                "enquiry_id": @json($enquiry_id)
            }).toString();

            // Redirect to the download route
            window.location.href = url + "?" + queryParams;

            setTimeout(function () {
                $('#spinner_download_button_2').hide();
                $('#download_button_2').show();
            }, 2000);
        }

        function setTodayDate() {
            const today = new Date();
            const formattedDate = today.toISOString().split('T')[0];
            document.getElementById('quote_date').value = formattedDate;
        }

        $(document).ready(function() {
            // Add a click event listener to elements with the 'price' class
            $('.dollar-sign').on('click', function() {
                $('#similar_rate_model').modal('show');
            });

            shippingVisibility();
            termConditionVisibility();
            generalInfoVisibility();
        });
        // window.onload = setTodayDate;
    </script>
     <script>
        function quoteinformationvisibilty() {
                const checkbox = document.getElementById('quote_info_box');
                const container = document.getElementById('quote_info_fields');
                if (checkbox.checked ) {
                    container.classList.remove('hidden');
                } else {
                    container.classList.add('hidden');
                }
            }
        </script>
    <script>
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
        const checkbox = document.getElementById('quote_info_box');
        checkbox.checked = true;  // Make sure it's checked

        // Call the function to update the visibility based on the checked state
        quoteinformationvisibilty();
        setTodayDate();
    };


    $(document).ready(function () {

        let costingId = $('#costing_format_id').val();
        // alert(costingId);
        if (costingId && costingId !== '') {
            $("#costing_detail_box").prop('checked', true);
            clientvisibility();
        }
    });


    </script>

    <script src="{{ asset('public/admin/assets/ckeditor/build/ckeditor.js') }}"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/34.2.0/classic/ckeditor.js"></script>
    {{-- <script src="https://cdn.ckeditor.com/ckeditor5/35.4.0/classic/ckeditor.js"></script> --}}

    <script>
    ClassicEditor
            .create( document.querySelector( '#cover_letter_desc' ),{
                ckfinder: {
                    uploadUrl: "{{route('ckeditor.upload').'?_token='.csrf_token()}}",
                }
            })
            .catch( error => {} );


    ClassicEditor
            .create( document.querySelector( '#term_condition_desc' ),{
                ckfinder: {
                    uploadUrl: "{{route('ckeditor.upload').'?_token='.csrf_token()}}",
                }
            })
            .catch( error => {

            } );
    ClassicEditor
            .create( document.querySelector( '#footer_desc' ),{
                ckfinder: {
                    uploadUrl: "{{route('ckeditor.upload').'?_token='.csrf_token()}}",
                }
            })
            .catch( error => {

            } );
    </script>


@stop

