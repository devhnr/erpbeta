@extends('admin.includes.Template')
@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Edit Supervisor</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('supervisor.index') }}">Supervisor</a></li>
                        <li class="breadcrumb-item active">Edit Supervisor</li>
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
                        <form id="category_form" action="{{ route('supervisor.update', $supervisor->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="name">Supervisor Name</label>
                                        <input id="surveyor_name" name="surveyor_name" type="text" class="form-control"
                                            placeholder="Enter Supervisor Name" value="{{ $supervisor->name }}" />
                                        <p class="form-error-text" id="surveyor_name_error" style="color: red; margin-top: 10px;"></p>
                                    </div>
                                    <div class="form-group">
                                        <input id="user_name" name="user_name" type="hidden" class="form-control" value="{{$supervisor->user_name}}"
                                            placeholder="Enter  Name" value="" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Supervisor Mobile</label>
                                        <input id="surveyor_mobile" name="surveyor_mobile" type="number" class="form-control"
                                            placeholder="Enter Supervisor Mobile" value="{{ $supervisor->mobile }}" />
                                        <p class="form-error-text" id="surveyor_mobile_error" style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Email For Login</label>
                                        <input id="email" name="email" type="text" class="form-control" value="{{ $supervisor->email }}"
                                            placeholder="Enter Email" readonly/>
                                        <p class="form-error-text" id="email_error"
                                            style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>
                                {{-- <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Password</label>
                                        <input id="password" name="password" type="password" class="form-control"
                                            placeholder="Enter Password" />
                                        <p class="form-error-text" id="password_error"
                                            style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div> --}}
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="name">Supervisor Address</label>
                                        <textarea name="surveyor_add" id="surveyor_add" cols="5" rows="5" class="form-control"
                                            placeholder="Enter Supervisor Address">{{ $supervisor->surveyor_add }}</textarea>
                                        </textarea>
                                        <p class="form-error-text" id="surveyor_add_error" style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>

                                <div class="row form-group">
                                    @foreach($surveyor_time_zone as $time_zone_data)
                                    <div class="col-md-3" style="padding: 10px;">
                                        @php
                                        $timeZoneIds = explode(',', $supervisor->time_zone_id);
                                        $is_checked = in_array($time_zone_data->id,$timeZoneIds) ? 'checked' : '';
                                        @endphp

                                    <input id="{{$time_zone_data->time_zone}}_time_zone" name="time_zone[]" type="checkbox" value="{{$time_zone_data->id}}" {{$is_checked}} />
                                    <label for="{{$time_zone_data->time_zone}}_time_zone">{{$time_zone_data->time_zone}}</label></div>
                                    @endforeach
                                    <p class="form-error-text" id="surveyor_name_error" style="color: red; margin-top: 10px;"></p>
                                </div>
                                </div>
                            <div class="text-end mt-4">
                                <a class="btn btn-primary" href="{{ route('supervisor.index') }}"> Cancel</a>
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

</script>
    <script>
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
                jQuery('#email_error').html("Enter Valid Email Address.");
                jQuery('#email_error').show().delay(0).fadeIn('show');
                jQuery('#email_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#email').offset().top - 150
                }, 1000);
                return false;
            }


            var surveyor_mobile = jQuery("#surveyor_mobile").val();
            var filter = /^\d{10}$/;

            if (surveyor_mobile != '' && !filter.test(surveyor_mobile)) {

                jQuery('#surveyor_mobile_error').html("Please Enter Valid Mobile");
                jQuery('#surveyor_mobile_error').show().delay(0).fadeIn('show');
                jQuery('#surveyor_mobile_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#surveyor_mobile').offset().top - 150
                }, 1000);
                return false;

            }

            $('#spinner_button').show();

            $('#submit_button').hide();

            $('#category_form').submit();


        }
    </script>
@stop
