@extends('admin.includes.Template')
@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Edit Survey</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('survey_assign.index') }}">Survey</a></li>
                        <li class="breadcrumb-item active">Edit Survey</li>
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
                        <form id="category_form" action="{{ route('survey_assign.update', $survey_assign->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            @php
                            $followup_data = DB::table('followups')->where('id',$survey_assign->enquiry_id)->first();

                            // echo"<pre>";print_r($followup_data);echo"</pre>";exit;
                            @endphp
                            <div class="row">
                                <div class="form-group">
                                <label for="shipper"><b>Shipper Details:</b></label>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Enquiry ID:</label>
                                        <input id="enquiry_id" name="enquiry_id" type="text" class="form-control"
                                        value="{{ $survey_assign->enquiry_id }}" readonly/>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Survey ID:</label>
                                        <input id="survey_id" name="survey_id" type="text" class="form-control"
                                        value="{{ $survey_assign->survey_id }}" readonly/>
                                     </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Branch:</label>
                                        <input id="branch" name="branch" type="text" class="form-control"
                                        value="{{ $followup_data->branch }}" readonly/>
                                     </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Survey Type:</label>
                                        <input id="survey_type" name="survey_type" type="text" class="form-control"
                                        value="{!! Helper::surveytype($followup_data->survey_type)!!}" readonly/>
                                     </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Date:</label>
                                        <input id="date" name="date" type="text" class="form-control"
                                        value=" " readonly/>
                                     </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Corporate Name:</label>
                                        <input id="company_name" name="company_name" type="text" class="form-control"
                                        value="{{$followup_data->company_name}}" readonly/>
                                     </div>
                                </div>
                                <div class="col-md-6"></div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Customer Name:</label>
                                        <input id="customer_name" name="customer_name" type="text" class="form-control"
                                        value="{{$followup_data->customer_name}}" readonly/>
                                     </div>
                                </div>
                                <div class="col-md-6"></div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Mobile:</label>
                                        <input id="customer_phone1" name="customer_phone1" type="text" class="form-control"
                                        value="{{$followup_data->customer_phone1}}" readonly/>
                                     </div>
                                </div>
                                <div class="form-group">
                                    <label for="client"><b>Move Details:</b></label>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Service Type:</label>
                                        <input id="service_id" name="service_id" type="text" class="form-control"
                                        value="{!! Helper::service($followup_data->service_id) !!}" readonly/>
                                     </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Product Type:</label>
                                        <input id="service_required" name="service_required" type="text" class="form-control"
                                        value="{{$followup_data->service_required}}" readonly/>
                                     </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Goods Type:</label>
                                        <input id="desc_of_goods" name="desc_of_goods" type="text" class="form-control"
                                        value="{{$followup_data->desc_of_goods}}" readonly/>
                                     </div>
                                </div>
                            </div>
                            <div class="text-end mt-4">
                                <a class="btn btn-primary" href="{{ route('survey_assign.index') }}"> Cancel</a>
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
            var country = jQuery("#country").val();
            if (country == '') {
                jQuery('#country_error').html("Please Enter Country");
                jQuery('#country_error').show().delay(0).fadeIn('show');
                jQuery('#country_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#country').offset().top - 150
                }, 1000);
                return false;
            }
            var branch = jQuery("#branch").val();
            if (branch == '') {
                jQuery('#branch_error').html("Please Enter Branch Name");
                jQuery('#branch_error').show().delay(0).fadeIn('show');
                jQuery('#branch_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#branch').offset().top - 150
                }, 1000);
                return false;
            }
            $('#spinner_button').show();
            $('#submit_button').hide();
            $('#category_form').submit();
        }
    </script>
@stop