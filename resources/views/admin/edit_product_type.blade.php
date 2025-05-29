@extends('admin.includes.Template')

@section('content')

    <div class="content container-fluid">



        <!-- Page Header -->

        <div class="page-header">

            <div class="row">

                <div class="col-sm-12">

                    <h3 class="page-title">Edit Product Type</h3>

                    <ul class="breadcrumb">

                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a></li>

                        <li class="breadcrumb-item"><a href="{{ route('product-type.index') }}">Product Type</a></li>

                        <li class="breadcrumb-item active">Edit Product Type</li>

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

                        <form id="service_form" action="{{ route('product-type.update', $product_type_data->id) }}" method="POST"
                            enctype="multipart/form-data">

                            @csrf

                            @method('PUT')

                            <div class="row">


                                <div class="form-group">

                                    <label for="name">Name</label>

                                    <input id="product_type" name="product_type" type="text" class="form-control"
                                        placeholder="Enter Name" value="{{ $product_type_data->product_type }}" />

                                    <p class="form-error-text" id="product_type_error" style="color: red;"></p>

                                </div>

                            </div>

                            <div class="text-end mt-4">

                                <a class="btn btn-primary" href="{{ route('product-type.index') }}"> Cancel</a>

                                <button class="btn btn-primary mb-1" type="button" disabled id="spinner_button"
                                    style="display: none;">

                                    <span class="spinner-border spinner-border-sm" role="status"
                                        aria-hidden="true"></span>

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


            var product_type = jQuery("#product_type").val();
            if (product_type == '') {
                jQuery('#product_type_error').html("Please Enter Name");
                jQuery('#product_type_error').show().delay(0).fadeIn('show');
                jQuery('#product_type_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#product_type').offset().top - 150
                }, 1000);
                return false;
            }

            $('#spinner_button').show();

            $('#submit_button').hide();

            $('#service_form').submit();

        }
    </script>

@stop
