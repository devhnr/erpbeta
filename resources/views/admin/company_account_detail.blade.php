@extends('admin.includes.Template')
@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Edit Company Account Details</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('branch.index') }}">Company Account Details</a></li>
                        <li class="breadcrumb-item active">Edit Company Account Details</li>
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
                        <form id="category_form" action="{{ route('account-details.update', 1) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                
                                <div class="form-group col-lg-6">
                                    <label for="name">Company Name</label>
                                    <input id="company_name" name="company_name" type="text" class="form-control"
                                        placeholder="Enter Company Name" value="{{ $company_account_data->company_name }}" />
                                    <p class="form-error-text" id="company_name_error" style="color: red; margin-top: 10px;"></p>
                                </div>
                                <div class="form-group col-lg-6">
                                    <label for="name">Bank Name</label>
                                    <input id="bank_name" name="bank_name" type="text" class="form-control"
                                        placeholder="Enter Bank Name" value="{{ $company_account_data->bank_name }}" />
                                    <p class="form-error-text" id="bank_name_error" style="color: red; margin-top: 10px;"></p>
                                </div>
                                <div class="form-group col-lg-6">
                                    <label for="name">Account Holder Name</label>
                                    <input id="account_holder_name" name="account_holder_name" type="text" class="form-control"
                                        placeholder="Enter Account Holder Name" value="{{ $company_account_data->account_holder_name }}" />
                                    <p class="form-error-text" id="account_holder_name_error" style="color: red; margin-top: 10px;"></p>
                                </div>
                                <div class="form-group col-lg-6">
                                    <label for="name">Account Number</label>
                                    <input id="account_number" name="account_number" type="text" class="form-control"
                                        placeholder="Enter Account Number" value="{{ $company_account_data->account_number }}" />
                                    <p class="form-error-text" id="account_number_error" style="color: red; margin-top: 10px;"></p>
                                </div>
                                <div class="form-group col-lg-6">
                                    <label for="name">IFSC Code</label>
                                    <input id="ifsc_code" name="ifsc_code" type="text" class="form-control"
                                        placeholder="Enter IFSC Code" value="{{ $company_account_data->ifsc_code }}" />
                                    <p class="form-error-text" id="ifsc_number_error" style="color: red; margin-top: 10px;"></p>
                                </div>
                                <div class="form-group col-lg-6">
                                    <label for="name">Swift Code</label>
                                    <input id="swift_code" name="swift_code" type="text" class="form-control"
                                        placeholder="Enter Swift Code" value="{{ $company_account_data->swift_code }}" />
                                    <p class="form-error-text" id="swift_code_error" style="color: red; margin-top: 10px;"></p>
                                </div>
                                <div class="form-group col-lg-6">
                                    <label for="name">IBAN</label>
                                    <input id="iban" name="iban" type="text" class="form-control"
                                        placeholder="Enter IBAN" value="{{ $company_account_data->iban }}" />
                                    <p class="form-error-text" id="iban_error" style="color: red; margin-top: 10px;"></p>
                                </div>
                                <div class="form-group col-lg-6">
                                    <label for="name">Branch Name</label>
                                    <input id="branch_name" name="branch_name" type="text" class="form-control"
                                        placeholder="Enter Branch Name" value="{{ $company_account_data->branch_name }}" />
                                    <p class="form-error-text" id="branch_name_error" style="color: red; margin-top: 10px;"></p>
                                </div>
                                <div class="form-group col-lg-6">
                                    <label for="name">Account Type</label>
                                    <input id="account_type" name="account_type" type="text" class="form-control"
                                        placeholder="Enter Account Type" value="{{ $company_account_data->account_type }}" />
                                    <p class="form-error-text" id="account_type_error" style="color: red; margin-top: 10px;"></p>
                                </div>
                            </div>
                            <div class="text-end mt-4">
                                <a class="btn btn-primary" href="{{ route('companyAccountDetails.edit',1) }}"> Cancel</a>
                                <button class="btn btn-primary mb-1" type="button" disabled id="spinner_button"
                                    style="display: none;">
                                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                    Loading...
                                </button>
                                <button type="button" class="btn btn-primary" id="submit_button"
                                    onclick="javascript:account_detail_validate()">Submit</button>
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
        function account_detail_validate() {
            var company_name = jQuery("#company_name").val();
            if (company_name == '') {
                jQuery('#company_name_error').html("Please Enter Company Name");
                jQuery('#company_name_error').show().delay(0).fadeIn('show');
                jQuery('#company_name_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#company_name').offset().top - 150
                }, 1000);
                return false;
            }
            var bank_name = jQuery("#bank_name").val();
            if (bank_name == '') {
                jQuery('#bank_name_error').html("Please Enter Bank Name");
                jQuery('#bank_name_error').show().delay(0).fadeIn('show');
                jQuery('#bank_name_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#bank_name').offset().top - 150
                }, 1000);
                return false;
            }
            var account_holder_name = jQuery("#account_holder_name").val();
            if (account_holder_name == '') {
                jQuery('#account_holder_name_error').html("Please Enter Account Holder Name");
                jQuery('#account_holder_name_error').show().delay(0).fadeIn('show');
                jQuery('#account_holder_name_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#account_holder_name').offset().top - 150
                }, 1000);
                return false;
            }
            var account_number = jQuery("#account_number").val();
            if (account_number == '') {
                jQuery('#account_number_error').html("Please Enter Account Number");
                jQuery('#account_number_error').show().delay(0).fadeIn('show');
                jQuery('#account_number_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#account_number').offset().top - 150
                }, 1000);
                return false;
            }
            var ifsc_code = jQuery("#ifsc_code").val();
            if (ifsc_code == '') {
                jQuery('#ifsc_number_error').html("Please Enter IFSC Code");
                jQuery('#ifsc_number_error').show().delay(0).fadeIn('show');
                jQuery('#ifsc_number_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#ifsc_code').offset().top - 150
                }, 1000);
                return false;
            }
            var branch_name = jQuery("#branch_name").val();
            if (branch_name == '') {
                jQuery('#branch_name_error').html("Please Enter Branch Name");
                jQuery('#branch_name_error').show().delay(0).fadeIn('show');
                jQuery('#branch_name_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#branch_name').offset().top - 150
                }, 1000);
                return false;
            }
            var account_type = jQuery("#account_type").val();
            if (account_type == '') {
                jQuery('#account_type_error').html("Please Enter Account Type");
                jQuery('#account_type_error').show().delay(0).fadeIn('show');
                jQuery('#account_type_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#account_type').offset().top - 150
                }, 1000);
                return false;
            }
            $('#spinner_button').show();
            $('#submit_button').hide();
            $('#category_form').submit();
        }
    </script>
@stop