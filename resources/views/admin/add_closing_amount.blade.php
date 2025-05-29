@extends('admin.includes.Template')
@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Receipt Voucher</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('closing.index') }}">Receipt Voucher</a></li>
                        <li class="breadcrumb-item active">Add Receipt Voucher</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Page Header -->
        <div id="validate" class="alert alert-danger alert-dismissible fade show" style="display: none;">
            <span id="login_error"></span>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <!-- <h4 class="card-title">Basic Info</h4> -->
                        <form id="category_form" action="{{ route('closing.add_amount') }}" method="POST"
                            enctype="multipart/form-data">
                            <input type="hidden" name="enquiry_id" id="enquiry_id" value="{{ $enquiry_id }}">
                            @csrf
                            <div class="row">
                                
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="name">Voucher Date</label>
                                        <input id="voucher_date" name="voucher_date" type="date" class="form-control"
                                            placeholder="Enter Voucher Date" value="{{ old('voucher_date') }}" />
                                            @if ($errors->has('voucher_date'))
                                                <p class="form-error-text text-danger">{{ $errors->first('voucher_date') }}</p>
                                            @endif
                                        <p class="form-error-text" id="voucher_date_error" style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="name">Payment Mode</label>
                                        <select id="payment_mode" name="payment_mode" class="form-control form-select">
                                            <option value="">Select Payment Mode</option>
                                            <option value="Cheque" {{ old('payment_mode') == 'Cheque' ? 'selected' : '' }}>Cheque</option>
                                            <option value="Cash" {{ old('payment_mode') == 'Cash' ? 'selected' : '' }}>Cash</option>
                                            <option value="Online" {{ old('payment_mode') == 'Online' ? 'selected' : '' }}>Online</option>
                                        </select>
                                        @if ($errors->has('payment_mode'))
                                                <p class="form-error-text text-danger">{{ $errors->first('payment_mode') }}</p>
                                            @endif
                                        <p class="form-error-text" id="payment_mode_error" style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>
                                </div>
                                <div class="Cheque" id="Cheque" style="display: none;">
                                    <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="name">Bank</label>
                                            <input id="cheque_bank" name="cheque_bank" type="text" class="form-control"
                                            placeholder="Enter Bank" value="{{ old('cheque_bank')}}" />
                                            @if ($errors->has('cheque_bank'))
                                                <p class="form-error-text text-danger">{{ $errors->first('cheque_bank') }}</p>
                                            @endif
                                            <p class="form-error-text" id="cheque_bank_error" style="color: red; margin-top: 10px;"></p>
                                        </div>
                                    </div>
                                    </div>
                                    <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="name">Cheque No</label>
                                            <input id="cheque_no_bank" name="cheque_no_bank" type="text" class="form-control"
                                            placeholder="Enter Cheque No" value="{{ old('cheque_no_bank')}}" />
                                            @if ($errors->has('cheque_no_bank'))
                                                <p class="form-error-text text-danger">{{ $errors->first('cheque_no_bank') }}</p>
                                            @endif
                                            <p class="form-error-text" id="cheque_no_bank_error" style="color: red; margin-top: 10px;"></p>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="name">Cheque Date</label>
                                            <input id="cheque_date" name="cheque_date" type="date" class="form-control"
                                            placeholder="Enter Cheque No" value="{{ old('cheque_date')}}" />
                                            @if ($errors->has('cheque_date'))
                                            <p class="form-error-text text-danger">{{ $errors->first('cheque_date') }}</p>
                                        @endif
                                            <p class="form-error-text" id="cheque_date_error" style="color: red; margin-top: 10px;"></p>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="name">Reconciliation Date</label>
                                            <input id="cheque_reconciliation_date" name="cheque_reconciliation_date" type="date" class="form-control"
                                            placeholder="Enter Reconciliation Date" value="{{ old('cheque_reconciliation_date')}}" />
                                            @if ($errors->has('cheque_reconciliation_date'))
                                            <p class="form-error-text text-danger">{{ $errors->first('cheque_reconciliation_date') }}</p>
                                        @endif
                                            <p class="form-error-text" id="cheque_reconciliation_date_error" style="color: red; margin-top: 10px;"></p>
                                        </div>
                                    </div>
                                    </div>
                                    <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="name">Description</label>
                                            <textarea id="cheque_description" name="cheque_description" class="form-control"
                                            placeholder="Enter Description" value="">{{ old('cheque_description')}}</textarea>
                                            @if ($errors->has('cheque_description'))
                                                <p class="form-error-text text-danger">{{ $errors->first('cheque_description') }}</p>
                                            @endif
                                            <p class="form-error-text" id="cheque_description_error" style="color: red; margin-top: 10px;"></p>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                                <div class="Cash" id="Cash" style="display: none;">
                                    <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="name">Receive By</label>
                                            <input id="cash_receive_by" name="cash_receive_by" type="text" class="form-control"
                                            placeholder="Enter Receive By" value="{{ old('cash_receive_by')}}" />
                                            @if ($errors->has('cash_receive_by'))
                                                <p class="form-error-text text-danger">{{ $errors->first('cash_receive_by') }}</p>
                                            @endif
                                            <p class="form-error-text" id="cash_receive_by_error" style="color: red; margin-top: 10px;"></p>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="name">Receive Date</label>
                                            <input id="cash_receive_date" name="cash_receive_date" type="date" class="form-control"
                                            placeholder="Enter Receive Date" value="{{ old('cash_receive_date')}}" />
                                            @if ($errors->has('cash_receive_date'))
                                                <p class="form-error-text text-danger">{{ $errors->first('cash_receive_date') }}</p>
                                            @endif
                                            <p class="form-error-text" id="cash_receive_date_error" style="color: red; margin-top: 10px;"></p>
                                        </div>
                                    </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="name">Description</label>
                                                <textarea id="cash_receive_description" name="cash_receive_description" class="form-control"
                                                placeholder="Enter Description" value="">{{ old('cash_receive_description')}}</textarea>
                                                @if ($errors->has('cash_receive_description'))
                                                    <p class="form-error-text text-danger">{{ $errors->first('cash_receive_description') }}</p>
                                                @endif
                                                <p class="form-error-text" id="cash_receive_description_error" style="color: red; margin-top: 10px;"></p>
                                            </div>
                                        </div>
                                        </div>

                                </div>

                                <div class="Online" id="Online" style="display: none;">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="name">Receive By</label>
                                                <select id="online_receive_by" name="online_receive_by" class="form-control form-select">
                                                    <option value="">Select Receive By</option>
                                                    <option value="Bank" {{ old('online_receive_by') == 'Bank' ? 'selected' : '' }}>Bank</option>
                                                    <option value="Upi" {{ old('online_receive_by') == 'Upi' ? 'selected' : '' }}>Upi</option>
                                                </select>
                                                @if ($errors->has('online_receive_by'))
                                                    <p class="form-error-text text-danger">{{ $errors->first('online_receive_by') }}</p>
                                                @endif
                                                <p class="form-error-text" id="online_receive_by_error" style="color: red; margin-top: 10px;"></p>
                                            </div>
                                        </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label for="name">Bank Name</label>
                                                    <input id="online_bank" name="online_bank" type="text" class="form-control"
                                                    placeholder="Enter Bank Name" value="{{ old('online_bank')}}" />
                                                    @if ($errors->has('online_bank'))
                                                    <p class="form-error-text text-danger">{{ $errors->first('online_bank') }}</p>
                                                @endif
                                                    <p class="form-error-text" id="online_bank_error" style="color: red; margin-top: 10px;"></p>
                                                </div>
                                            </div>
                                            </div>
                                            <div class="row">

                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="name">Transaction No / Upi No</label>
                                                        <input id="online_trn_upi_no" name="online_trn_upi_no" type="text" class="form-control"
                                                        placeholder="Enter Transaction No / Upi No" value="{{ old('online_trn_upi_no')}}" />
                                                        @if ($errors->has('online_trn_upi_no'))
                                                    <p class="form-error-text text-danger">{{ $errors->first('online_trn_upi_no') }}</p>
                                                @endif
                                                        <p class="form-error-text" id="online_trn_upi_no_error" style="color: red; margin-top: 10px;"></p>
                                                    </div>
                                                </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="name">Receive Date</label>
                                                <input id="online_receive_date" name="online_receive_date" type="date" class="form-control"
                                                placeholder="Enter Receive Date" value="{{ old('online_receive_date')}}" />
                                                @if ($errors->has('online_receive_date'))
                                                    <p class="form-error-text text-danger">{{ $errors->first('online_receive_date') }}</p>
                                                @endif
                                                <p class="form-error-text" id="online_receive_date_error" style="color: red; margin-top: 10px;"></p>
                                            </div>
                                        </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label for="name">Description</label>
                                                    <textarea id="online_receive_description" name="online_receive_description" class="form-control"
                                                    placeholder="Enter Description" value="">{{ old('online_receive_description')}}</textarea>
                                                    @if ($errors->has('online_receive_description'))
                                                    <p class="form-error-text text-danger">{{ $errors->first('online_receive_description') }}</p>
                                                @endif
                                                    <p class="form-error-text" id="online_receive_description_error" style="color: red; margin-top: 10px;"></p>
                                                </div>
                                            </div>
                                            </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="name">Total Amount Receive</label>
                                            <input id="total_amount_receive" name="total_amount_receive" type="number" class="form-control"
                                            placeholder="Enter Total Amount Receive" value="{{ old('total_amount_receive')}}" />
                                            @if ($errors->has('total_amount_receive'))
                                                    <p class="form-error-text text-danger">{{ $errors->first('total_amount_receive') }}</p>
                                                @endif
                                            <p class="form-error-text" id="total_amount_receive_error" style="color: red; margin-top: 10px;"></p>
                                        </div>
                                    </div>
                                    </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="name">Message / Note</label>
                                            <textarea id="message_note" name="message_note" class="form-control"
                                            placeholder="Enter Message / Note" value="">{{ old('message_note')}}</textarea>
                                            @if ($errors->has('message_note'))
                                                    <p class="form-error-text text-danger">{{ $errors->first('message_note') }}</p>
                                                @endif
                                            <p class="form-error-text" id="message_note_error" style="color: red; margin-top: 10px;"></p>
                                        </div>
                                    </div>
                                    </div>
                                    <div id="result"></div>
                            <div class="text-end mt-4">
                                <a class="btn btn-primary" href="{{ route('closing.index') }}"> Cancel</a>
                                <button class="btn btn-primary mb-1" type="button" disabled id="spinner_button"
                                    style="display: none;">
                                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                    Loading...
                                </button>
                                <button type="button" class="btn btn-primary" id="submit_button"
                                    onclick="javascript:category_validation()">Submit</button>
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
            var voucher_date = jQuery("#voucher_date").val();
            if (voucher_date == '') {
                jQuery('#voucher_date_error').html("Please Select Voucher Date");
                jQuery('#voucher_date_error').show().delay(0).fadeIn('show');
                jQuery('#voucher_date_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#voucher_date').offset().top - 150
                }, 1000);
                return false;
            }
            var payment_mode = jQuery("#payment_mode").val();
            // if (payment_mode == '') {
            //     jQuery('#payment_mode_error').html("Please Select Payment Mode");
            //     jQuery('#payment_mode_error').show().delay(0).fadeIn('show');
            //     jQuery('#payment_mode_error').show().delay(2000).fadeOut('show');
            //     $('html, body').animate({
            //         scrollTop: $('#payment_mode').offset().top - 150
            //     }, 1000);
            //     return false;
            // }

            var cheque_bank = jQuery("#cheque_bank").val();
            var cheque_no_bank = jQuery("#cheque_no_bank").val();
            var cheque_date = jQuery("#cheque_date").val();
            var cheque_reconciliation_date = jQuery("#cheque_reconciliation_date").val();
            var cheque_description = jQuery("#cheque_description").val();

            if(payment_mode == 'Cheque'){
                    
                // if (cheque_bank == '') {
                //     jQuery('#cheque_bank_error').html("Please Enter Bank");
                //     jQuery('#cheque_bank_error').show().delay(0).fadeIn('show');
                //     jQuery('#cheque_bank_error').show().delay(2000).fadeOut('show');
                //     $('html, body').animate({
                //         scrollTop: $('#cheque_bank').offset().top - 150
                //     }, 1000);
                //     return false;
                // }
                 
                if (cheque_no_bank == '') {
                    jQuery('#cheque_no_bank_error').html("Please Enter Cheque No");
                    jQuery('#cheque_no_bank_error').show().delay(0).fadeIn('show');
                    jQuery('#cheque_no_bank_error').show().delay(2000).fadeOut('show');
                    $('html, body').animate({
                        scrollTop: $('#cheque_no_bank').offset().top - 150
                    }, 1000);
                    return false;
                }
                 
                if (cheque_date == '') {
                    jQuery('#cheque_date_error').html("Please Select Cheque Date");
                    jQuery('#cheque_date_error').show().delay(0).fadeIn('show');
                    jQuery('#cheque_date_error').show().delay(2000).fadeOut('show');
                    $('html, body').animate({
                        scrollTop: $('#cheque_date').offset().top - 150
                    }, 1000);
                    return false;
                }
               
                if (cheque_reconciliation_date == '') {
                    jQuery('#cheque_reconciliation_date_error').html("Please Select Reconciliation Date");
                    jQuery('#cheque_reconciliation_date_error').show().delay(0).fadeIn('show');
                    jQuery('#cheque_reconciliation_date_error').show().delay(2000).fadeOut('show');
                    $('html, body').animate({
                        scrollTop: $('#cheque_reconciliation_date').offset().top - 150
                    }, 1000);
                    return false;
                }
                
                if (cheque_description == '') {
                    jQuery('#cheque_description_error').html("Please Enter Description");
                    jQuery('#cheque_description_error').show().delay(0).fadeIn('show');
                    jQuery('#cheque_description_error').show().delay(2000).fadeOut('show');
                    $('html, body').animate({
                        scrollTop: $('#cheque_description').offset().top - 150
                    }, 1000);
                    return false;
                }

            }

            var cash_receive_by = jQuery("#cash_receive_by").val();
            var cash_receive_date = jQuery("#cash_receive_date").val();
            var cash_receive_description = jQuery("#cash_receive_description").val();

            if(payment_mode == 'Cash'){
                
                if (cash_receive_by == '') {
                    jQuery('#cash_receive_by_error').html("Please Enter Receive By");
                    jQuery('#cash_receive_by_error').show().delay(0).fadeIn('show');
                    jQuery('#cash_receive_by_error').show().delay(2000).fadeOut('show');
                    $('html, body').animate({
                        scrollTop: $('#cash_receive_by').offset().top - 150
                    }, 1000);
                    return false;
                }
             
                if (cash_receive_date == '') {
                    jQuery('#cash_receive_date_error').html("Please Select Receive Date");
                    jQuery('#cash_receive_date_error').show().delay(0).fadeIn('show');
                    jQuery('#cash_receive_date_error').show().delay(2000).fadeOut('show');
                    $('html, body').animate({
                        scrollTop: $('#cash_receive_date').offset().top - 150
                    }, 1000);
                    return false;
                }
               
                if (cash_receive_description == '') {
                    jQuery('#cash_receive_description_error').html("Please Enter Description");
                    jQuery('#cash_receive_description_error').show().delay(0).fadeIn('show');
                    jQuery('#cash_receive_description_error').show().delay(2000).fadeOut('show');
                    $('html, body').animate({
                        scrollTop: $('#cash_receive_description').offset().top - 150
                    }, 1000);
                    return false;
                }

            }
            var online_receive_by = jQuery("#online_receive_by").val();
            var online_bank = jQuery("#online_bank").val();
            var online_trn_upi_no = jQuery("#online_trn_upi_no").val();
            var online_receive_date = jQuery("#online_receive_date").val();
            var online_receive_description = jQuery("#online_receive_description").val();

            if(payment_mode == 'Online'){
                 
                if (online_receive_by == '') {
                    jQuery('#online_receive_by_error').html("Please Select Receive By");
                    jQuery('#online_receive_by_error').show().delay(0).fadeIn('show');
                    jQuery('#online_receive_by_error').show().delay(2000).fadeOut('show');
                    $('html, body').animate({
                        scrollTop: $('#online_receive_by').offset().top - 150
                    }, 1000);
                    return false;
                }
                 
                if (online_bank == '') {
                    jQuery('#online_bank_error').html("Please Enter Bank Name");
                    jQuery('#online_bank_error').show().delay(0).fadeIn('show');
                    jQuery('#online_bank_error').show().delay(2000).fadeOut('show');
                    $('html, body').animate({
                        scrollTop: $('#online_bank').offset().top - 150
                    }, 1000);
                    return false;
                }
                
                if (online_trn_upi_no == '') {
                    jQuery('#online_trn_upi_no_error').html("Please Enter Transaction No / Upi No");
                    jQuery('#online_trn_upi_no_error').show().delay(0).fadeIn('show');
                    jQuery('#online_trn_upi_no_error').show().delay(2000).fadeOut('show');
                    $('html, body').animate({
                        scrollTop: $('#online_trn_upi_no').offset().top - 150
                    }, 1000);
                    return false;
                }
                
                if (online_receive_date == '') {
                    jQuery('#online_receive_date_error').html("Please Select Receive Date");
                    jQuery('#online_receive_date_error').show().delay(0).fadeIn('show');
                    jQuery('#online_receive_date_error').show().delay(2000).fadeOut('show');
                    $('html, body').animate({
                        scrollTop: $('#online_receive_date').offset().top - 150
                    }, 1000);
                    return false;
                }
                
                if (online_receive_description == '') {
                    jQuery('#online_receive_description_error').html("Please Enter Description");
                    jQuery('#online_receive_description_error').show().delay(0).fadeIn('show');
                    jQuery('#online_receive_description_error').show().delay(2000).fadeOut('show');
                    $('html, body').animate({
                        scrollTop: $('#online_receive_description').offset().top - 150
                    }, 1000);
                    return false;
                }



            }
             var total_amount_receive = jQuery("#total_amount_receive").val();
            if (total_amount_receive == '') {
                jQuery('#total_amount_receive_error').html("Please Enter Total Amount Receive");
                jQuery('#total_amount_receive_error').show().delay(0).fadeIn('show');
                jQuery('#total_amount_receive_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#total_amount_receive').offset().top - 150
                }, 1000);
                return false;
            }
             var message_note = jQuery("#message_note").val();
            if (message_note == '') {
                jQuery('#message_note_error').html("Please Enter Message / Note");
                jQuery('#message_note_error').show().delay(0).fadeIn('show');
                jQuery('#message_note_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#message_note').offset().top - 150
                }, 1000);
                return false;
            }
            // If all validations pass, show the spinner and submit the form
            // $('#spinner_button').show();
            // $('#submit_button').hide();
            // $('#category_form').submit();
            var enquiry_id = jQuery("#enquiry_id").val();
            var formData = {
                enquiry_id: enquiry_id,
                voucher_date: voucher_date,
                payment_mode: payment_mode,
                cheque_bank: cheque_bank,
                cheque_no_bank: cheque_no_bank,
                cheque_date: cheque_date,
                cheque_reconciliation_date: cheque_reconciliation_date,
                cheque_description: cheque_description,
                cash_receive_by: cash_receive_by,
                cash_receive_date: cash_receive_date,
                cash_receive_description: cash_receive_description,
                online_receive_by: online_receive_by,
                online_bank: online_bank,
                online_trn_upi_no: online_trn_upi_no,
                online_receive_date: online_receive_date,
                online_receive_description: online_receive_description,
                total_amount_receive: total_amount_receive,
                message_note: message_note,
                _token: "{{ csrf_token() }}" // CSRF token for Laravel
            };

            $.ajax({
                type: 'POST',
                url: '{{ route('closing.add_amount') }}',
                data: formData,
                success: function(responses) {
                    if ($.trim(responses.message) == 'TRUE') {
                        window.location.href = responses.redirect; 

                    } else if ($.trim(responses.message) == 'GRATER') {
                        $('#result').html(
                            '<div class="alert alert-success alert-dismissible mt-2"><a href="javascript:void(0);" class="close" data-bs-dismiss="alert" aria-label="close" style="float: inline-end;">&times;</a><span style="color:red">Total received amount exceeds the order total.</span></div>'
                        );
                        $("#submit_button").show();
                        $("#spinner_button").hide();
                    } else {
                        $('#result').html(
                            '<div class="alert alert-success alert-dismissible mt-2"><a href="javascript:void(0);" class="close" data-bs-dismiss="alert" aria-label="close" style="float: inline-end;">&times;</a><span style="color:red">Message not sent.</span></div>'
                        );
                        $("#submit_button").show();
                        $("#spinner_button").hide();
                    }

                },

                error: function (xhr) {
                    $('#submit_button').show();
                    $('#spinner_button').hide();
                    
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        $('#voucher_date_error').text(errors.voucher_date ? errors.voucher_date[0] : '');
                        $('#payment_mode_error').text(errors.payment_mode ? errors.payment_mode[0] : '');
                        $('#cheque_bank_error').text(errors.cheque_bank ? errors.cheque_bank[0] : '');
                        $('#cheque_no_bank_error').text(errors.cheque_no_bank ? errors.cheque_no_bank[0] : '');
                        $('#cheque_date_error').text(errors.cheque_date ? errors.cheque_date[0] : '');
                        $('#cheque_reconciliation_date_error').text(errors.cheque_reconciliation_date ? errors.cheque_reconciliation_date[0] : '');
                        $('#cheque_description_error').text(errors.cheque_description ? errors.cheque_description[0] : '');
                        $('#cash_receive_by_error').text(errors.cash_receive_by ? errors.cash_receive_by[0] : '');
                        $('#cash_receive_date_error').text(errors.cash_receive_date ? errors.cash_receive_date[0] : '');
                        $('#cash_receive_description_error').text(errors.cash_receive_description ? errors.cash_receive_description[0] : '');
                        $('#online_receive_by_error').text(errors.online_receive_by ? errors.online_receive_by[0] : '');
                        $('#online_bank_error').text(errors.online_bank ? errors.online_bank[0] : '');
                        $('#online_trn_upi_no_error').text(errors.online_trn_upi_no ? errors.online_trn_upi_no[0] : '');
                        $('#online_receive_date_error').text(errors.online_receive_date ? errors.online_receive_date[0] : '');
                        $('#online_receive_description_error').text(errors.online_receive_description ? errors.online_receive_description[0] : '');
                        $('#total_amount_receive_error').text(errors.total_amount_receive ? errors.total_amount_receive[0] : '');
                        $('#message_note_error').text(errors.message_note ? errors.message_note[0] : '');
                    } else {
                        $('#result').html('<div class="alert alert-danger">Something went wrong. Please try again.</div>');
                    }
                }
            });

        }
        document.addEventListener("DOMContentLoaded", function () {
            let paymentModeSelect = document.getElementById("payment_mode");

            function togglePaymentSections() {
                let selectedValue = paymentModeSelect.value;

                // Hide all payment sections
                document.getElementById("Cheque").style.display = "none";
                document.getElementById("Cash").style.display = "none";
                document.getElementById("Online").style.display = "none";

                // Show the selected section
                if (selectedValue) {
                    document.getElementById(selectedValue).style.display = "block";
                }
            }

            // Run on page load to restore state after form submission
            togglePaymentSections();

            // Run on change event
            paymentModeSelect.addEventListener("change", togglePaymentSections);
        });

    </script>
@stop