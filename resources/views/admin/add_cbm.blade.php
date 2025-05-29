@extends('admin.includes.Template')

@section('content')

    <div class="content container-fluid">



        <!-- Page Header -->

        <div class="page-header">

            <div class="row">

                <div class="col-sm-12">

                    <h3 class="page-title">CBM</h3>

                    <ul class="breadcrumb">

                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a></li>

                         <li class="breadcrumb-item active">Add CBM</li>

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

                        <form id="category_form" action="{{ route('cbm.store') }}" method="POST"

                            enctype="multipart/form-data">

                            @csrf

                            <div class="row">

                                <div class="form-group">

                                    <label for="name">Name</label>

                                    <input id="name" name="name" type="input" class="form-control"

                                        placeholder="Enter Name" value="" />

                                        <p class="form-error-text" id="name_error" style="color: red;"></p>

                                </div>

                                <div class="form-group">

                                    <label for="name">Crew Req For Job</label>

                                    <input id="crew_req" name="crew_req" type="input" class="form-control"

                                        placeholder="Enter Crew Req For Job" value="" />

                                        <p class="form-error-text" id="crew_req_error" style="color: red;"></p>

                                </div>

                                <div class="form-group">

                                    <label for="name">Crew Every Day</label>

                                    <input id="crew_day" name="crew_day" type="input" class="form-control"

                                        placeholder="Enter Crew Every Day" value="" />

                                        <p class="form-error-text" id="crew_day_error" style="color: red;"></p>

                                </div>

                                
                                <div class="form-group">

                                    <label for="name">Truck</label>

                                    <input id="truck" name="truck" type="input" class="form-control"

                                        placeholder="Enter Truck" value="" />

                                        <p class="form-error-text" id="truck_error" style="color: red;"></p>

                                </div>

                                
                                <div class="form-group">

                                    <label for="name">Days</label>

                                    <input id="days" name="days" type="input" class="form-control"

                                        placeholder="Enter Days" value="" />

                                        <p class="form-error-text" id="days_error" style="color: red;"></p>

                                </div>

                                
                               

                            </div>

                            <div class="text-end mt-4">

                                <a class="btn btn-primary" href="{{ route('cbm.index') }}"> Cancel</a>

                                <button class="btn btn-primary mb-1" type="button" disabled id="spinner_button"

                                    style="display: none;">

                                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>

                                    Loading...

                                </button>

                                <button type="button" class="btn btn-primary" onclick="javascript:category_validation()"

                                    id="submit_button">Submit</button>

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

    <!-- /Main Wrapper -->



    <!-- <script>

        $(function() {

            $("#name").keyup(function() {

                var Text = $(this).val();

                Text = Text.toLowerCase();

                Text = Text.replace(/[^a-zA-Z0-9]+/g, '-');

                $("#page_url").val(Text);

            });

        });

    </script> -->



    <script>

        function category_validation() {


            var name = jQuery("#name").val();
            if (name == '') {
                jQuery('#name_error').html("Please Enter Name");
                jQuery('#name_error').show().delay(0).fadeIn('show');
                jQuery('#name_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#name').offset().top - 150
                }, 1000);
                return false;
            }
            var crew_req = jQuery("#crew_req").val();
            if (crew_req == '') {
                jQuery('#crew_req_error').html("Please Enter Crew Req For Job");
                jQuery('#crew_req_error').show().delay(0).fadeIn('show');
                jQuery('#crew_req_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#crew_req').offset().top - 150
                }, 1000);
                return false;
            }
            var crew_day = jQuery("#crew_day").val();
            if (crew_day == '') {
                jQuery('#crew_day_error').html("Please Enter Crew Every Day");
                jQuery('#crew_day_error').show().delay(0).fadeIn('show');
                jQuery('#crew_day_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#crew_day').offset().top - 150
                }, 1000);
                return false;
            }
            var truck = jQuery("#truck").val();
            if (truck == '') {
                jQuery('#truck_error').html("Please Enter Truck");
                jQuery('#truck_error').show().delay(0).fadeIn('show');
                jQuery('#truck_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#truck').offset().top - 150
                }, 1000);
                return false;
            }
            var days = jQuery("#days").val();
            if (days == '') {
                jQuery('#days_error').html("Please Enter Days");
                jQuery('#days_error').show().delay(0).fadeIn('show');
                jQuery('#days_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#days').offset().top - 150
                }, 1000);
                return false;
            }

           

            
           
            $('#spinner_button').show();

            $('#submit_button').hide();

            $('#category_form').submit();
           
        }

    </script>

@stop

