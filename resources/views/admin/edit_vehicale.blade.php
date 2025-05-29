@extends('admin.includes.Template')
@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Edit Vehicle</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('vehicles.index') }}">Vehicle</a></li>
                        <li class="breadcrumb-item active">Edit Vehicle</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Page Header -->
        <div id="validate" class="alert alert-danger alert-dismissible fade show" style="display: none;">
            <span id="login_error"></span>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @if ($message = Session::get('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <strong>Success!</strong> {{ $message }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <!-- <h4 class="card-title">Basic Info</h4> -->
                        <form id="category_form" action="{{ route('vehicles.update', $vehicale_data->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                
                                <div class="form-group">
                                    <label for="vehicle_name">Vehicle</label>
                                    <input id="vehicle_name" name="vehicle_name" type="text" class="form-control"
                                        placeholder="Enter Vehicle" value="{{ $vehicale_data->vehicle_name }}" />
                                    <p class="form-error-text" id="vehicale_name_error" style="color: red; margin-top: 10px;"></p>
                                    @error('vehicle_name')
                                    <p class="form-error-text" id="vehicale_vali_name_error" style="color: red; margin-top: 10px;">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="name">Vehicle Number</label>
                                    <input id="vehicle_number" name="vehicle_number" type="text" class="form-control"
                                        placeholder="Enter Vehicle Number" value="{{ $vehicale_data->vehicle_number }}" />
                                    
                                    <p class="form-error-text" id="vehicale_number_error" style="color: red; margin-top: 10px;"></p>
                                    
                                    @error('vehicle_number')
                                    <p class="form-error-text" id="vehicale_vali_number_error" style="color: red; margin-top: 10px;">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            
                            <input type="hidden" name="driver_name1[]" value="">
                            <input type="hidden" name="driver_email1[]" value="">
                            <input type="hidden" name="driver_mobile_no1[]" value="">
                            @forelse ($vehicale_attribute_data as $data)
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group"> <label for="driver_name">Driver Name</label>
                                            <input type="hidden" name="updateid1xxx[]"
                                                id="updateid1xxx{{ $loop->index + 1 }}"
                                                value="{{ $data->id }}">
                                            <input type="text" id="driver_name" name="driver_nameu[]" class="form-control"
                                                placeholder="Enter Driver Name" value="{{ $data->driver_name }}">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group"> <label for="driver_email">Driver Email</label>
                                            <input type="text" id="driver_email" name="driver_emailu[]" class="form-control"
                                                placeholder="Enter Driver Email" value="{{ $data->driver_email }}">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group"> <label for="driver_mobile_no">Driver Mobile No</label>
                                            <input type="text" id="driver_mobile_no" name="driver_mobile_nou[]" class="form-control"
                                                placeholder="Enter Driver Mobile" onkeypress="return validateNumber(event)" value="{{ $data->driver_mobile_no }}">
                                        </div>
                                    </div>
                                    <a href="#"
                                        onclick="singledelete('{{ route('vehicle-attribute.delete', ['vehicle_id' => $data->vehicle_id, 'id' => $data->id]) }}')"
                                        class="btn btn-danger pull-right remove_field1"
                                        style="margin-right: 0;margin-top: 22px;width: 10%;float: right;height: 38px;margin-left: 128px;">Remove</a>
                                </div>
                            @empty
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group"> <label for="driver_name">Driver Name</label>
                                            <input type="text" id="driver_name" name="driver_name1[]" class="form-control"
                                                placeholder="Enter Driver Name">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group"> <label for="driver_email">Driver Email</label>
                                            <input type="text" id="driver_email" name="driver_email1[]" class="form-control"
                                                placeholder="Enter Driver Email">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group"> <label for="poc">Driver Mobile No</label>
                                            <input type="text" id="driver_mobile_no" name="driver_mobile_no1[]" class="form-control"
                                                placeholder="Enter Driver Mobile" onkeypress="return validateNumber(event)">
                                        </div>
                                    </div>
                                </div>
                            @endforelse
                            <div class="input_fields_wrap12"></div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <button
                                        style="border: medium none;margin-right: 125px;line-height: 25px;margin-top: -62px;color:#fff;"
                                        class="submit btn bg-purple pull-right" type="button"
                                        id="add_field_button12">Add</button>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="row form-group">
                                    @foreach($time_zone_data as $time_zone_data)
                                    <div class="col-md-3" style="padding: 10px;">
                                        @php
                                        $timeZoneIds = explode(',', $vehicale_data->time_zone_id);
                                        $is_checked = in_array($time_zone_data->id,$timeZoneIds) ? 'checked' : '';
                                        @endphp

                                    <input id="{{ $time_zone_data->time_zone }}_time_zone" name="time_zone[]" type="checkbox" value="{{$time_zone_data->id}}" {{$is_checked}} />
                                    <label for="{{ $time_zone_data->time_zone }}_time_zone">{{$time_zone_data->time_zone}}</label></div>
                                    @endforeach
                                    <p class="form-error-text" id="surveyor_name_error" style="color: red; margin-top: 10px;"></p>
                                </div>
                            </div>
                            <div class="text-end mt-4">
                                <a class="btn btn-primary" href="{{ route('vehicles.index') }}"> Cancel</a>
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
            var vehicaleName = jQuery("#vehicle_name").val();
            if (vehicaleName == '') {
                jQuery('#vehicale_name_error').html("Please Enter Vehicle Name");
                jQuery('#vehicale_name_error').show().delay(0).fadeIn('show');
                jQuery('#vehicale_name_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#vehicle_name').offset().top - 150
                }, 1000);
                return false;
            }
            var vehicaleNumber = jQuery("#vehicle_number").val();
            if (vehicaleNumber == '') {
                jQuery('#vehicale_number_error').html("Please Enter Vehicle Number");
                jQuery('#vehicale_number_error').show().delay(0).fadeIn('show');
                jQuery('#vehicale_number_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#vehicle_number').offset().top - 150
                }, 1000);
                return false;
            }
            $('#spinner_button').show();
            $('#submit_button').hide();
            $('#category_form').submit();
        }
    </script>
    <script type="text/javascript" language="javascript">
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
                        '<div class="row"><div class="col-md-3"><div class = "form-group"><label for = "driver_name">Driver Name</label><input type = "text" id= "driver_name" name = "driver_name1[]" class = "form-control" placeholder = "Enter Driver Name"></div></div ><div class = "col-md-3"><div class = "form-group"><label for = "driver_email">Driver Email</label><input type = "text" id = "driver_email" name = "driver_email1[]" class = "form-control" placeholder = "Enter Driver Email"></div></div ><div class = "col-md-3"><div class = "form-group"><label for = "driver_mobile">Driver Mobile </label><input type = "text" id = "driver_mobile_no" name = "driver_mobile_no1[]" class = "form-control" placeholder = "Enter Driver Mobile" onkeypress="return validateNumber(event)"></div></div><a href = "#" class = "btn btn-danger pull-right remove_field1" style="margin-right: 0;margin-top: 23px;width: 10%;float: right;height:38px;margin-left: 127px;">Remove</a ></div>'
                    );
                }
            });
            $(wrapper).on("click", ".remove_field1", function(e) {
                e.preventDefault();
                $(this).parent('div').remove();
                b--;
            })
        });

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

        function singledelete(url) {
            var t = confirm('Are You Sure To Delete The Attribute ?');
            if (t) {
                window.location.href = url;
            } else {
                return false;
            }
        }
    </script>
@stop