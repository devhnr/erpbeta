@extends('admin.includes.Template')
@section('content')
     <style type="text/css">
        ul li {
            list-style: inherit;
        }
    </style>
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Survey Asssign</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ url('/followup') }}">Enquiry</a></li>
                        <li class="breadcrumb-item active">Add Survey Asssign</li>
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
                        <form id="survey_form" action="{{ route('survey_information') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                @php
                                  
                                    $survey_data = DB::table('survey_assign')
                                    ->where('enquiry_id', $inquiry_id)->first();
                                    // $survey_data = DB::table('survey_assign')->first();
                                    // echo"<pre>";print_r($survey_data);echo"</pre>";exit;
                                    
                                    $followup_data = DB::table('followups')->where('id',$inquiry_id)->first();
                                    
                                    $surveyorName_new = DB::table('survey_assign')
                                                        ->where('survey_date', $followup_data->s_date)
                                                        ->select('surveyor_name', 'surveyor_time_zone')
                                                        ->get()
                                                        ->groupBy('surveyor_name')
                                                        ->mapWithKeys(function($group, $key) {
                                                            return [$key => $group->pluck('surveyor_time_zone')->toArray()];
                                                        })
                                                        ->toArray();

                                    $surveyorTimeZones = [];
                                    foreach ($surveyorName_new as $surveyor => $timeZones) {
                                        $surveyorTimeZones = array_merge($surveyorTimeZones, $timeZones);
                                    }
                                                                                
                                    //  echo"<pre>";print_r($surveyorTimeZones);echo"</pre>";

                                @endphp
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="name">Enquiry Id</label>
                                        <input id="inquiry_id" name="inquiry_id" type="text" class="form-control"
                                            value="{{ $inquiry_id }}" />
                                        <input id="survey_id" name="survey_id" type="hidden" class="form-control" value="QSR-SUR-{{ $inquiry_id }}" />
                                        <p class="form-error-text" id="name_error" style="color: red;"></p>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="name">Corporate Name</label>
                                        <input id="survey_company_name" name="survey_company_name" type="text" class="form-control"
                                            value="{{ $followup_data->company_name }}" readonly/>
                                        <p class="form-error-text" id="search_company_error" style="color: red;"></p>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="name">Customer Name</label>
                                        <input id="survey_customer_name" name="survey_customer_name" type="text" class="form-control"
                                            value="{{ $followup_data->customer_name }}" readonly/>
                                        <p class="form-error-text" id="survey_customer_name" style="color: red;"></p>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="name">Customer Mobile</label>
                                        <input id="survey_customer_mobile" name="survey_customer_mobile" type="text" class="form-control"
                                            value="{{ $followup_data->customer_phone1 }}" readonly/>
                                        <p class="form-error-text" id="survey_customer_mobile" style="color: red;"></p>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="name">Address:</label>
                                        @if($followup_data->origin_country !='' && $followup_data->desti_country !='')
                                        <input id="survey_customer_address" name="survey_customer_address" type="text" class="form-control"
                                            value="{!! Helper::countryname($followup_data->origin_country) !!} to {!! Helper::countryname($followup_data->desti_country) !!}" readonly/>
                                            @endif
                                        <p class="form-error-text" id="customer_mobile_error" style="color: red;"></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Survey Type:</label>
                                       <select class="form-control form-select" id="survey_type" name="survey_type">
                                        <option value="">Select Survey Type</option>
                                        @foreach ($surveyor_type as $surveyor_type_data)
                                        <option value="{{ $surveyor_type_data->id }}" @if($surveyor_type_data->id == $followup_data->survey_type)  {{'selected'}} @endif >
                                            {{ $surveyor_type_data->surveyor_type }}
                                        </option>
                                    @endforeach 
                                       </select>
                                        <p class="form-error-text" id="customer_mobile_error" style="color: red;"></p>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="name">From:</label>
                                        <input id="time_from" name="time_from" type="time" class="form-control" value="{{ $survey_data ? $survey_data->time_from : '' }}" />
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="name">To:</label>
                                        <input id="time_to" name="time_to" type="time" class="form-control" value="{{ $survey_data ? $survey_data->time_to : '' }}" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Survey Date:</label>
                                        <input id="survey_date" name="survey_date" type="text" class="form-control"
                                            value="{{ $followup_data->s_date }}" readonly/>
                                        <p class="form-error-text" id="survey_date_error" style="color: red;"></p>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="name">Surveyor:</label>
                                        <select name="surveyor_name" id="surveyor_name" class="form-control form-select">
                                            <option value="">Select Surveyor</option>
                                            @foreach($surveyor_data as $data)
                                            <option value="{{$data->id}}" data-timezones="{{ $data->time_zone_id }}" @if($data->id == $followup_data->surveyor) {{ 'selected' }} @endif>{{$data->surveyor_name}}</option>
                                            @endforeach
                                        </select>
                                        <p class="form-error-text" id="survey_date_error" style="color: red;"></p>
                                    </div>
                                </div>
                               
                                <div id="surveyor_sections" class="surevyour_section_replace">
                                    @foreach($surveyor_data as $data)
                                    <div id="surveyor_section_{{ $data->id }}" class="row form-group" style="margin-top: 10px; margin-left: 3px; display: none;">
                                        <div class="row">
                                            <div class="col-md-2" style="border: 1px solid; padding: 6px; border-right: none; align-items: center; display: flex;">
                                                <!-- Surveyor name radio button -->
                                                <div class="form-check">
                                                    <input class="form-check-input surveyor-radio surveyor_radio_checked" type="radio" name="surveyor_time_zone_name" id="surveyor_time_zone_name_{{ $data->id }}" value="{{ $data->id }}" data-surveyor-id="{{ $data->id }}" {{ (!empty($survey_data) && $survey_data->surveyor_name == $data->id) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="surveyor_time_zone_name_{{ $data->id }}">
                                                        {{ $data->surveyor_name }}
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="row col-md-10" style="border: 1px solid; padding: 10px;">
                                                @php
                                                $time_zone_ids = explode(',', $data->time_zone_id);
                                                @endphp
                                              @foreach($time_zone_ids as $time_zone_id)
                                              <div class="form-check col-md-2 ajax_replace" style="margin-top: 5px;">
                                                <input class="form-check-input time-zone-radio surveyor-{{ $data->id }}"
                                                type="radio"
                                                name="surveyor_time_zone_{{ $data->id }}"
                                                id="surveyor_time_zone_{{ $data->id }}_{{ $time_zone_id }}"
                                                value="{{ $time_zone_id }}"
                                                {{ (!empty($survey_data) && $survey_data->surveyor_time_zone == $time_zone_id) ? 'checked' : '' }}
                                                @if(array_key_exists($data->id, $surveyorName_new) && in_array($time_zone_id, $surveyorName_new[$data->id])) disabled style="background-color: red;" @endif />
                                         
                                            <label class="form-check-label" for="surveyor_time_zone_{{ $data->id }}_{{ $time_zone_id }}">
                                                    {!! Helper::time_zonename($time_zone_id) !!}
                                                  </label>
                                              </div>
                                          @endforeach
                                          
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                
                            </div>

                            <div class="col-lg-6">
                                <div class="text-end mt-4">
                                    <a class="btn btn-primary" href="{{ route('followup.index') }}"> Cancel</a>
                                    <button class="btn btn-primary mb-1" type="button" disabled id="spinner_button"
                                        style="display: none;">
                                        <span class="spinner-border spinner-border-sm" role="status"
                                            aria-hidden="true"></span>
                                        Loading...
                                    </button>
                                    <button type="button" class="btn btn-primary"
                                        onclick="javascript:survey_info_validation()" id="submit_button">Submit</button>
                                    <!-- <input type="submit" name="submit" value="Submit" class="btn btn-primary"> -->
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal custom-modal fade" id="get_quote_accept_model" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="modal-text text-center">
                        <!-- <h3>Delete Expense Category</h3> -->
                    </div>
                    <div class="modal-text text-center" id="dropdownreplace">
                        <div class="form-group">
                            <label for="name"><b>Are You Sure Want to Accept Quote</b></label>
                            {{-- <p class="form-error-text" id="date_error" style="color: red;"></p> --}}
                        </div>
                    </div>
                    {{-- <p class="form-error-text" id="status_id_error" style="color: red; margin-top: 10px;"></p> --}}
                </div>
                <div class="modal-footer text-center">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="quote_accept_form();">Submit</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <form method="post" action="{{ url('quote_accept_form') }}" id="quote_accept_form">
        @csrf
        <input type="hidden" name="inquiry_id" id="inquiry_id_hidden">
    </form>
    <div class="modal custom-modal fade" id="get_quote_reject_model" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="modal-text text-center">
                        <!-- <h3>Delete Expense Category</h3> -->
                    </div>
                    <form method="post" action="{{ url('quote_reject_form') }}" id="quote_reject_form">
                        @csrf
                        <input type="hidden" name="inquiry_id" id="reject_inquiry_id_hidden">
                        <div class="modal-text text-center" id="dropdownreplace">
                            <label>Enter Reject Reason</label>
                            <div class="form-group">
                                <textarea id="reject_reason" name="reject_reason" class="form-control" cols="25" rows="5"
                                    placeholder="Enter Reject Reason" value="" /></textarea>
                                <p class="form-error-text" id="reject_reason_error" style="color: red; display:none;">
                                </p>
                            </div>
                        </div>
                    </form>
                    {{-- <p class="form-error-text" id="status_id_error" style="color: red; margin-top: 10px;"></p> --}}
                </div>
                <div class="modal-footer text-center">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="quote_reject_form();">Submit</button>
                </div>
                </form>
            </div>
        </div>
    </div>
@stop
@section('footer_js')
    <script src="https://cdn.ckeditor.com/ckeditor5/35.4.0/classic/ckeditor.js"></script>
    <script>
        ClassicEditor
            .create(document.querySelector('#price_include'))
            .catch(error => {
                console.error(error);
            });
        ClassicEditor
            .create(document.querySelector('#price_exclude'))
            .catch(error => {
                console.error(error);
            });
        ClassicEditor
            .create(document.querySelector('#price_note'))
            .catch(error => {
                console.error(error);
            });
        ClassicEditor
            .create(document.querySelector('#insurances'))
            .catch(error => {
                console.error(error);
            });
        ClassicEditor
            .create(document.querySelector('#payment_terms'))
            .catch(error => {
                console.error(error);
            });
        ClassicEditor
            .create(document.querySelector('#payment_options'))
            .catch(error => {
                console.error(error);
            });
    </script>
    <script>
        function survey_info_validation() {

            $('#spinner_button').show();
            $('#submit_button').hide();
            $('#survey_form').submit();
        }
    </script>
    <script type="text/javascript">
        $(function() {

            $('#moving_date').datepicker({
                format: 'yyyy-mm-dd', // Set the desired date format yyyy-mm-dd
                // autoclose: true,
                todayHighlight: true
            });
        });
        $(function() {
            $('#survey_date').datepicker({
                format: 'yyyy-mm-dd', // Set the desired date format yyyy-mm-dd
                // autoclose: true,
                todayHighlight: true
            });
        });
        $(function() {
            $('#quotetion_date').datepicker({
                format: 'yyyy-mm-dd', // Set the desired date format yyyy-mm-dd
                // autoclose: true,
                todayHighlight: true
            });
        });
    </script>
    <script type="text/javascript" language="javascript">
        function singledelete(url) {
            var t = confirm('Are You Sure To Delete The Attribute ?');
            if (t) {
                window.location.href = url;
            } else {
                return false;
            }
        }
        $(document).ready(function() {
            var max_fields = 50;
            var wrapper = $(".input_fields_wrap12");
            var add_button = $("#add_field_button12");
            var b = 0;
            $(add_button).click(function(e) { //alert('ok');
                e.preventDefault();
                if (b < max_fields) {
                    b++;
                    $(wrapper).append(
                        '<div class="row"><div class="col-md-4"><div class="form-group"><label for="poc">Particulars</label><input type="text" id="particulars" name="particulars[]" class="form-control" placeholder="Enter Particulars"></div></div><div class="col-md-4"><div class="form-group"><label for="poc">Amount(AED)</label><input type="text" id="amount" name="amount[]" class="form-control" placeholder="Enter Amount(AED)" onkeypress="return validateNumber(event)"></div></div><a href="#" class="btn btn-danger pull-right remove_field1" style="margin-right: 0;margin-top: 23px;width: 10%;float: right;height: 38px;margin-left: 127px;">Remove</a></div>'
                    );
                }
            });
            $(wrapper).on("click", ".remove_field1", function(e) {
                e.preventDefault();
                $(this).parent('div').remove();
                b--;
            })
        });

        function reject(id) {
            $('#reject_inquiry_id_hidden').val(id);
            $('#get_quote_reject_model').modal('show');
        }

        function accept(id) {
            $('#inquiry_id_hidden').val(id);
            $('#get_quote_accept_model').modal('show');
        }

        function quote_accept_form() {
            $('#quote_accept_form').submit();
        }

        function quote_reject_form() {
            var reject_reason = jQuery("#reject_reason").val();
            if (reject_reason == '') {
                jQuery('#reject_reason_error').html("Please Enter Reject Reason");
                jQuery('#reject_reason_error').show().delay(0).fadeIn('show');
                jQuery('#reject_reason_error').show().delay(2000).fadeOut('show');
                return false;
            }
            $('#quote_reject_form').submit();
        }

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

        <script>
            $(document).ready(function() {
                $(document).on('change', 'input.surveyor-radio', function() {
                    var selectedSurveyorId = $(this).val();
                    $('#surveyor_name').val(selectedSurveyorId);
                });
                $(document).on('change', '#surveyor_name', function() {
                    var selectedSurveyorId = $(this).val();
                    $('input.surveyor-radio[value="' + selectedSurveyorId + '"]').prop('checked', true);
                });
            });
        </script>

        <script>
           $(document).ready(function() {
            $('#surveyor_name').change(function() {
                //  alert('chanage123');
                var surveyorId = $(this).val().trim();
                $('.time-zone-radio').prop('disabled', true); 
                if (surveyorId === "") {
                    $('.surveyor-radio').change(function() {
                        var surveyorId = $(this).data('surveyor-id');
                        // alert('chanage');
                        $('.time-zone-radio').prop('disabled', true); 
                        $('#surveyor_sections > div').hide();
                        $('#surveyor_section_' + surveyorId).show();
                        $('.time-zone-radio.surveyor-' + surveyorId).each(function() {
                            if (!$(this).hasClass('disabled-by-server')) {
                                $(this).prop('disabled', false); 
                            }
                        });
                    }); 
                } else {
                    // alert('else');
                    $('.time-zone-radio.surveyor-' + surveyorId).each(function() {
                        if (!$(this).hasClass('disabled-by-server')) {
                            $(this).prop('disabled', false); 
                        }
                    });
                }
            });
            $('.time-zone-radio:disabled').addClass('disabled-by-server');
        });
        </script>
			
        <script> 
            $(document).ready(function() {
                function showAllSurveyorSections() {
                    // alert('teset');
                    $('#surveyor_sections > div').show(); 
                    $('.surveyor_radio_checked').prop('checked', false);
                    $('.time-zone-radio').prop('checked', false) ;
                    // var specificRadioButtonId = "surveyor_time_zone_{{ $data->id }}_{{ $time_zone_id }}";
                    // $('#' + specificRadioButtonId).prop('checked', false);
                }
                $('#surveyor_name').change(function() {
                    var selectedSurveyorId = $(this).val();                 
                    $('#surveyor_sections > div').hide();
                    if (selectedSurveyorId) {
                    // alert(selectedSurveyorId);
                    $.ajax({
                    url: '{{url('surveyor_time_selected')}}', 
                    type: 'POST',
                    data: {
                        "_token" : "{{csrf_token()}}",
                        "surveyor_name": selectedSurveyorId,
                        "survey_date": @json($followup_data->s_date)
                    },
                    success: function(response) {
                        // alert(response);
                        $('#surveyor_sections > div').hide();
                        $('#surveyor_section_' + selectedSurveyorId).show();
                        $('.surveyor_radio_checked').prop('checked', false);
                        $('.time-zone-radio').prop('checked', false).prop('disabled', true);
                        var elements = document.getElementsByClassName('surevyour_section_replace');
                        for (var i = 0; i < elements.length; i++) {
                            elements[i].innerHTML = response;
                        }
                    $('.time-zone-radio:disabled').addClass('disabled-by-server');
                    },
                    error: function(error) {
                        console.error(error);
                    }
                }); 
                 }else {
                        showAllSurveyorSections();
                    }
                });
                var initialSurveyorId = $('#surveyor_name').val();
                // alert(initialSurveyorId)
                if (initialSurveyorId) {
                    $('#surveyor_section_' + initialSurveyorId).show();
                 }else{
                        showAllSurveyorSections();
                    }
            });
        </script>
    
        
@stop
