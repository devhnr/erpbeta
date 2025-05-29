@extends('admin.includes.Template')

@section('content')

    <div class="content container-fluid">



        <!-- Page Header -->

        <div class="page-header">

            <div class="row">

                <div class="col-sm-12">

                    <h3 class="page-title">User</h3>

                    <ul class="breadcrumb">

                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a></li>

                        <li class="breadcrumb-item"><a href="{{ route('adminuser.index') }}">User</a></li>

                        <li class="breadcrumb-item active">Add User</li>

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

                        <form id="category_form" action="{{ route('adminuser.store') }}" method="POST"

                            enctype="multipart/form-data">

                            @csrf

                            <div class="row">

                                <div class="form-group">

                                    <label for="category">User Category</label>

                                    <select class="form-control" id="user_id" name="user_id">

                                        <option value="" selected>Select User Category</option>

                                        @foreach ($user_category as $user_data)

                                            <option value="{{ $user_data->id }}">{{ $user_data->cname }}</option>

                                        @endforeach

                                    </select>

                                </div>

                                <div class="form-group">

                                    <label for="name">Name</label>

                                    <input id="name" name="name" type="text" class="form-control"

                                        placeholder="Enter Name" value="" />

                                </div>

                                <div class="form-group">

                                    <label for="name">User Name</label>

                                    <input id="user_name" name="user_name" type="text" class="form-control"

                                        placeholder="Enter User Name" value="" />

                                </div>

                                <div class="form-group">

                                    <label for="name">Password</label>

                                    <input id="password" name="password" type="password" class="form-control"

                                        placeholder="Enter Password" value="" />

                                </div>

                                <div class="form-group">

                                    <label for="name">Confirm Password</label>

                                    <input id="conf_password" name="conf_password" type="password" class="form-control"

                                        placeholder="Enter Confirm Password" value="" />

                                </div>

                                <div class="form-group">

                                    <label for="name">Email</label>

                                    <input id="email" name="email" type="text" class="form-control"

                                        placeholder="Enter Email" value="" />

                                </div>

                                <div class="form-group">

                                    <label for="name">Mobile No.</label>

                                    <input id="mobile" name="mobile" type="text" class="form-control"

                                        placeholder="Enter Mobile No." onkeypress="return validateNumber(event)"

                                        value="" />

                                </div>

                            </div>

                            <div class="text-end mt-4">

                                <a class="btn btn-primary" href="{{ route('adminuser.index') }}"> Cancel</a>

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

            var select = jQuery("#select").val();

            if (select == '') {

                jQuery('#validate').html("Please Select User Category");

                jQuery('#validate').show().delay(0).fadeIn('show');

                jQuery('#validate').show().delay(2000).fadeOut('show');

                $('html, body').animate({

                    scrollTop: $('#validate').offset().top - 150

                }, 1000);

                return false;

            }



            var name = jQuery("#name").val();

            if (name == '') {

                jQuery('#validate').html("Please Enter Name");

                jQuery('#validate').show().delay(0).fadeIn('show');

                jQuery('#validate').show().delay(2000).fadeOut('show');

                $('html, body').animate({

                    scrollTop: $('#validate').offset().top - 150

                }, 1000);

                return false;

            }



            var user_name = jQuery("#user_name").val();

            if (user_name == '') {

                jQuery('#validate').html("Please Enter User Name");

                jQuery('#validate').show().delay(0).fadeIn('show');

                jQuery('#validate').show().delay(2000).fadeOut('show');

                $('html, body').animate({

                    scrollTop: $('#validate').offset().top - 150

                }, 1000);

                return false;

            }



            var password = jQuery("#password").val();

            if (password == '') {

                jQuery('#validate').html("Please Enter Password");

                jQuery('#validate').show().delay(0).fadeIn('show');

                jQuery('#validate').show().delay(2000).fadeOut('show');

                $('html, body').animate({

                    scrollTop: $('#validate').offset().top - 150

                }, 1000);

                return false;

            }



            var conf_password = jQuery("#conf_password").val();

            if (conf_password == '') {

                jQuery('#validate').html("Please Enter Confirm Password");

                jQuery('#validate').show().delay(0).fadeIn('show');

                jQuery('#validate').show().delay(2000).fadeOut('show');

                $('html, body').animate({

                    scrollTop: $('#validate').offset().top - 150

                }, 1000);

                return false;

            }



            if (conf_password != password) {

                jQuery('#validate').html("Confirm Password Doesn't Match Password");

                jQuery('#validate').show().delay(0).fadeIn('show');

                jQuery('#validate').show().delay(2000).fadeOut('show');

                $('html, body').animate({

                    scrollTop: $('#validate').offset().top - 150

                }, 1000);

                return false;

            }



            var email = jQuery("#email").val();

            if (email == '') {

                jQuery('#validate').html("Please Enter Email");

                jQuery('#validate').show().delay(0).fadeIn('show');

                jQuery('#validate').show().delay(2000).fadeOut('show');

                $('html, body').animate({

                    scrollTop: $('#validate').offset().top - 150

                }, 1000);

                return false;

            }



            var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

            if (!filter.test(email)) {

                jQuery('#validate').html("Enter Valid Email Address.");

                jQuery('#validate').show().delay(0).fadeIn('show');

                jQuery('#validate').show().delay(2000).fadeOut('show');

                $('html, body').animate({

                    scrollTop: $('#validate').offset().top - 150

                }, 1000);

                return false;

            }



            var mobile = jQuery("#mobile").val();

            if (mobile == '') {

                jQuery('#validate').html("Please Enter Mobile");

                jQuery('#validate').show().delay(0).fadeIn('show');

                jQuery('#validate').show().delay(2000).fadeOut('show');

                $('html, body').animate({

                    scrollTop: $('#validate').offset().top - 150

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

@stop

