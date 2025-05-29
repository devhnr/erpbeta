@extends('admin.includes.Template')

@section('content')

    <div class="content container-fluid">



        <!-- Page Header -->

        <div class="page-header">

            <div class="row">

                <div class="col-sm-12">

                    <h3 class="page-title">Edit Moving Cost</h3>

                    <ul class="breadcrumb">

                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a></li>

                        <li class="breadcrumb-item"><a href="{{ route('movingcost.index') }}">Moving Cost</a></li>

                        <li class="breadcrumb-item active">Edit Moving Cost</li>

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

                        <form id="category_form" action="{{ route('movingcost.update', $movingcost->id) }}" method="POST"

                            enctype="multipart/form-data">

                            @csrf

                            @method('PUT')

                            <div class="row">

                                <div class="form-group">

                                    <label for="adminuser">Moving Cost</label>

                                    

                                </div>

                                <div class="form-group">

                                    <label for="name">Name</label>

                                    <input id="name" name="name" type="input" class="form-control"

                                        placeholder="Enter Name" value="{{ $movingcost->name }}" />
                                    
                                        <p class="form-error-text" id="name_error" style="color: red;"></p>

                                </div>

                                                                                            

                            <div class="text-end mt-4">

                                <a class="btn btn-primary" href="{{ route('movingcost.index') }}"> Cancel</a>

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

