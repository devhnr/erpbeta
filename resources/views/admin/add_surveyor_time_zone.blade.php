@extends('admin.includes.Template')
@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Surveyor Time Zone</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('surveyor_time_zone.index') }}">Surveyor Time Zone</a></li>
                        <li class="breadcrumb-item active">Add Surveyor Time Zone</li>
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
                        <form id="category_form" action="{{ route('surveyor_time_zone.store') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="form-group">
                                    <label for="name">Time Zone</label>
                                    <input type="text" name="time_zone" id="time_zone" placeholder="Enter Time Zone" class="form-control" >
                                    <p class="form-error-text" id="time_zone_error" style="color: red; margin-top: 10px;"></p>
                                </div>
                            </div>
                        </div>
                            <div class="text-end mt-4">
                                <a class="btn btn-primary" href="{{ route('surveyor_time_zone.index') }}"> Cancel</a>
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
            // var country = jQuery("#country").val();
            // if (country == '') {
            //     jQuery('#country_error').html("Please Enter Country");
            //     jQuery('#country_error').show().delay(0).fadeIn('show');
            //     jQuery('#country_error').show().delay(2000).fadeOut('show');
            //     $('html, body').animate({
            //         scrollTop: $('#country').offset().top - 150
            //     }, 1000);
            //     return false;
            // }
            var surveyor_name = jQuery("#surveyor_name").val();
            if (surveyor_name == '') {
                jQuery('#surveyor_name_error').html("Please Enter Surveyor Name");
                jQuery('#surveyor_name_error').show().delay(0).fadeIn('show');
                jQuery('#surveyor_name_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#surveyor_name').offset().top - 150
                }, 1000);
                return false;
            }
            $('#spinner_button').show();
            $('#submit_button').hide();
            $('#category_form').submit();
        }
    </script>
@stop