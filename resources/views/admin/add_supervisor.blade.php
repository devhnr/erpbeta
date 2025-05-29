@extends('admin.includes.Template')
@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Supervisor</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('supervisor.index') }}">Supervisor</a></li>
                        <li class="breadcrumb-item active">Add Supervisor</li>
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
                        <form id="category_form" action="{{ route('supervisor.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="name">Supervisor Name</label>
                                        <input id="surveyor_name" name="surveyor_name" type="text" class="form-control" placeholder="Enter Supervisor Name" value="" />
                                        <p class="form-error-text" id="surveyor_name_error" style="color: red; margin-top: 10px;"></p>
                                    </div>
                                    <div class="form-group">
                                        <input id="user_name" name="user_name" type="hidden" class="form-control" placeholder="Enter Name" value="" />
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Supervisor Mobile</label>
                                        <input id="surveyor_mobile" name="surveyor_mobile" type="text" class="form-control" placeholder="Enter Supervisor Mobile" value="" />
                                        <p class="form-error-text" id="surveyor_mobile_error" style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Email For Login</label>
                                        <input id="email" name="email" type="text" class="form-control" placeholder="Enter Email" />
                                        <p class="form-error-text" id="email_error" style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Password</label>
                                        <input id="password" name="password" type="password" class="form-control" placeholder="Enter Password" />
                                        <p class="form-error-text" id="password_error" style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Confirm Password</label>
                                        <input id="conf_password" name="conf_password" type="password" class="form-control" placeholder="Enter Confirm Password" />
                                        <p class="form-error-text" id="confirm_password_error" style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="name">Supervisor Address</label>
                                        <textarea name="surveyor_add" id="surveyor_add" cols="5" rows="5" class="form-control" placeholder="Enter Supervisor Address"></textarea>
                                        <p class="form-error-text" id="surveyor_add_error" style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="row form-group">
                                        @foreach($surveyor_time_zone as $time_zone_data)
                                            <div class="col-md-3" style="padding: 10px;">
                                                <input id="{{$time_zone_data->time_zone}}_time_zone" name="time_zone[]" type="checkbox" value="{{$time_zone_data->id}}" />
                                                <label for="{{$time_zone_data->time_zone}}_time_zone">{{$time_zone_data->time_zone}}</label>
                                            </div>
                                        @endforeach
                                        <p class="form-error-text" id="surveyor_name_error" style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>
                            </div>

                            <div class="text-end mt-4">
                                <a class="btn btn-primary" href="{{ route('supervisor.index') }}">Cancel</a>
                                <button class="btn btn-primary mb-1" type="button" disabled id="spinner_button" style="display: none;">
                                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                    Loading...
                                </button>
                                <button type="button" class="btn btn-primary" id="submit_button" onclick="javascript:category_validation()">Submit</button>
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
        $(document).ready(function() {
            var role_id = jQuery("#role_id").val();
            $("#hidden_role_id").val(role_id);
        });

        $(function() {
            $("#surveyor_name").keyup(function() {
                var Text = $(this).val();
                Text = Text.toLowerCase();
                Text = Text.replace(/[^a-zA-Z0-9]+/g, ' ');
                $("#user_name").val(Text);
            });
        });

        function category_validation() {
            var surveyor_name = jQuery("#surveyor_name").val();
            if (surveyor_name == '') {
                jQuery('#surveyor_name_error').html("Please Enter Supervisor Name");
                jQuery('#surveyor_name_error').show().delay(0).fadeIn('show');
                jQuery('#surveyor_name_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#surveyor_name').offset().top - 150
                }, 1000);
                return false;
            }

            var email = jQuery("#email").val();
            if (email == '') {
                jQuery('#email_error').html("Please Enter Email");
                jQuery('#email_error').show().delay(0).fadeIn('show');
                jQuery('#email_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#email').offset().top - 150
                }, 1000);
                return false;
            }

            var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
            if (!filter.test(email)) {
                jQuery('#email_error').html("Please Enter Valid Email");
                jQuery('#email_error').show().delay(0).fadeIn('show');
                jQuery('#email_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#email').offset().top - 150
                }, 1000);
                return false;
            }

            var url = '{{ url('surveyor_check_mail') }}';
            $.ajax({
                url: url,
                type: 'post',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "email": email
                },
                success: function(msg) {
                    if (msg == 1) {
                        jQuery('#email_error').html("Email Address Already Exists");
                        jQuery('#email_error').show().delay(0).fadeIn('show');
                        jQuery('#email_error').show().delay(2000).fadeOut('show');
                        $('html, body').animate({
                            scrollTop: $('#email').offset().top - 150
                        }, 1000);
                        return false;
                    } else {
                        var password = jQuery("#password").val();
                        if (password == '') {
                            jQuery('#password_error').html("Please Enter Password");
                            jQuery('#password_error').show().delay(0).fadeIn('show');
                            jQuery('#password_error').show().delay(2000).fadeOut('show');
                            $('html, body').animate({
                                scrollTop: $('#password').offset().top - 150
                            }, 1000);
                            return false;
                        }

                        var conf_password = jQuery("#conf_password").val();
                        if (conf_password == '') {
                            jQuery('#confirm_password_error').html("Please Enter Confirm-Password");
                            jQuery('#confirm_password_error').show().delay(0).fadeIn('show');
                            jQuery('#confirm_password_error').show().delay(2000).fadeOut('show');
                            $('html, body').animate({
                                scrollTop: $('#conf_password').offset().top - 150
                            }, 1000);
                            return false;
                        }

                        if (conf_password != password) {
                            jQuery('#confirm_password_error').html("Confirm Password Doesn't Match Password");
                            jQuery('#confirm_password_error').show().delay(0).fadeIn('show');
                            jQuery('#confirm_password_error').show().delay(2000).fadeOut('show');
                            $('html, body').animate({
                                scrollTop: $('#conf_password').offset().top - 150
                            }, 1000);
                            return false;
                        }

                        var surveyor_mobile = jQuery("#surveyor_mobile").val();
                        if (surveyor_mobile == '') {
                            jQuery('#surveyor_mobile_error').html("Please Enter Supervisor Mobile");
                            jQuery('#surveyor_mobile_error').show().delay(0).fadeIn('show');
                            jQuery('#surveyor_mobile_error').show().delay(2000).fadeOut('show');
                            $('html, body').animate({
                                scrollTop: $('#surveyor_mobile').offset().top - 150
                            }, 1000);
                            return false;
                        }

                        if (surveyor_mobile != '') {
                            var filter = /^\d{7}$/;
                            if (surveyor_mobile.length < 7 || surveyor_mobile.length > 15) {
                                jQuery('#surveyor_mobile_error').html("Please Enter Valid Mobile Number");
                                jQuery('#surveyor_mobile_error').show().delay(0).fadeIn('show');
                                jQuery('#surveyor_mobile_error').show().delay(2000).fadeOut('show');
                                $('html, body').animate({
                                    scrollTop: $('#surveyor_mobile').offset().top - 150
                                }, 1000);
                                return false;
                            }
                        }

                        $('#spinner_button').show();
                        $('#submit_button').hide();
                        $('#category_form').submit();
                    }
                }
            });
        }
    </script>
@stop
