@extends('admin.includes.Template')
@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Edit Service</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('service.index') }}">Service</a></li>
                        <li class="breadcrumb-item active">Edit Service</li>
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
                        <form id="service_form" action="{{ route('service.update', $service->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="form-group">
                                    <label for="name">Service Name</label>
                                    <input id="local_storage_export" name="name" type="text" class="form-control"
                                        placeholder="Enter Service Name" value="{{ $service->name }}" />
                                    <p class="form-error-text" id="name_error" style="color: red;"></p>
                                </div>
                                <div class="form-group">
                                    <label for="name">Validity of the quotation</label>
                                    <input id="validity" name="validity" type="text" class="form-control"
                                        placeholder="Enter Validity of the quotation" value="{{ $service->validity }}" />
                                    <p class="form-error-text" id="validity_error" style="color: red;"></p>
                                </div>
                                <div class="form-group">
                                    <label for="name">Cover Letter</label>
                                    <textarea class="form-control" name="cover_letter" id="cover_letter" placeholder="Enter Cover Letter">{{ $service->cover_letter }}</textarea>
                                    <p class="form-error-text" id="cover_letter_error" style="color: red;"></p>
                                </div>
                                <div class="form-group">
                                    <label for="name">Term & Conditions</label>
                                    <textarea class="form-control" name="term_and_condittion" id="term_and_condittion" placeholder="Enter Term & Conditions">{{ $service->term_and_condittion }}</textarea>
                                    <p class="form-error-text" id="term_condition_error" style="color: red;"></p>
                                </div>
                                <div class="form-group">
                                    <label for="name">Price Includes</label>
                                    <textarea class="form-control" name="price_include" id="price_include" placeholder="Enter Price Include">{{ $service->price_include }}</textarea>
                                    <p class="form-error-text" id="price_include_error" style="color: red;"></p>
                                </div>
                                <div class="form-group">
                                    <label for="name">Price Excludes</label>
                                    <textarea class="form-control" name="price_exclude" id="price_exclude" placeholder="Enter Price Excludes">{{ $service->price_exclude }}</textarea>
                                    <p class="form-error-text" id="price_exclude_error" style="color: red;"></p>
                                </div>
                                <div class="form-group">
                                    <label for="name">Insurances</label>
                                    <textarea class="form-control" name="insurances" id="insurances" placeholder="Enter Insurances">{{ $service->insurances }}</textarea>
                                    <p class="form-error-text" id="insurances_error" style="color: red;"></p>
                                </div>
                                <div class="form-group">
                                    <label for="name">Price Note</label>
                                    <textarea class="form-control" name="price_note" id="price_note" placeholder="Enter Price Note">{{ $service->price_note }}</textarea>
                                    <p class="form-error-text" id="price_note_error" style="color: red;"></p>
                                </div>
                                <div class="form-group">
                                    <label for="name">Payment Terms</label>
                                    <textarea class="form-control" name="payment_terms" id="payment_terms" placeholder="Enter Payment Terms">{{ $service->payment_terms }}</textarea>
                                    <p class="form-error-text" id="payment_terms_error" style="color: red;"></p>
                                </div>
                                <div class="form-group">
                                    <label for="name">Payment Options</label>
                                    <textarea class="form-control" name="payment_options" id="payment_options" placeholder="Enter Payment Options">{{ $service->payment_options }}</textarea>
                                    <p class="form-error-text" id="payment_options_error" style="color: red;"></p>
                                </div>
                            </div>
                            <div class="text-end mt-4">
                                <a class="btn btn-primary" href="{{ route('service.index') }}"> Cancel</a>
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
    {{-- <script src="https://cdn.ckeditor.com/ckeditor5/35.4.0/classic/ckeditor.js"></script> --}}
    <script src="{{ asset('public/admin/assets/ckeditor/build/ckeditor.js') }}"></script>
    {{-- <script src="https://cdn.ckeditor.com/ckeditor5/34.2.0/classic/ckeditor.js"></script> --}}
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
            .create(document.querySelector('#insurances'))
            .catch(error => {
                console.error(error);
            });
        ClassicEditor
            .create(document.querySelector('#price_note'))
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
        ClassicEditor
            .create(document.querySelector('#cover_letter'))
            .catch(error => {
                console.error(error);
            });
        ClassicEditor
            .create(document.querySelector('#term_and_condittion'))
            .catch(error => {
                console.error(error);
            });
    </script>
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
            var validity = jQuery("#validity").val();
            if (validity == '') {
                jQuery('#validity_error').html("Please Enter Validity of the quotation");
                jQuery('#validity_error').show().delay(0).fadeIn('show');
                jQuery('#validity_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#validity').offset().top - 150
                }, 1000);
                return false;
            }
            $('#spinner_button').show();
            $('#submit_button').hide();
            $('#service_form').submit();
        }
    </script>
@stop
