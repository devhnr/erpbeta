@extends('admin.includes.Template')

@section('content')

    <div class="content container-fluid">



        <!-- Page Header -->

        <div class="page-header">

            <div class="row">

                <div class="col-sm-12">

                    <h3 class="page-title">Description Of Goods
                    </h3>

                    <ul class="breadcrumb">

                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a></li>

                        <li class="breadcrumb-item active">Add Description Of Goods
                        </li>

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

                        <form id="description_of_goods_form" action="{{ route('description-of-goods.store') }}" method="POST"
                            enctype="multipart/form-data">

                            @csrf

                            <div class="row">



                                <div class="form-group">

                                    <label for="name">Name</label>

                                    <input id="description_of_goods_name" name="description_of_goods_name" type="text" class="form-control"
                                        placeholder="Enter Name" value="" />

                                    <p class="form-error-text" id="description_of_goods_name_error" style="color: red;"></p>

                                </div>

                            </div>

                            <div class="text-end mt-4">

                                <a class="btn btn-primary" href="{{ route('description-of-goods.index') }}"> Cancel</a>

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


            var description_of_goods_name = jQuery("#description_of_goods_name").val();
            if (description_of_goods_name == '') {
                jQuery('#description_of_goods_name_error').html("Please Enter Name");
                jQuery('#description_of_goods_name_error').show().delay(0).fadeIn('show');
                jQuery('#description_of_goods_name_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#description_of_goods_name').offset().top - 150
                }, 1000);
                return false;
            }

            $('#spinner_button').show();

            $('#submit_button').hide();

            $('#description_of_goods_form').submit();

        }
    </script>

@stop
