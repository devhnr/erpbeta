@extends('admin.includes.Template')
@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Material</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('materials.index') }}">Material</a></li>
                        <li class="breadcrumb-item active">Add Material</li>
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
                       
                        <form id="category_form" action="{{ route('materials.store') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input id="name" name="name" type="text" class="form-control"
                                        placeholder="Enter Name" value="{{ old('name') }}" />
                                    <p class="form-error-text" id="name_error" style="color: red; margin-top: 10px;"></p>
                                    @error('name')
                                    <p class="form-error-text" id="material_name_error" style="color: red; margin-top: 10px;">{{ $message }}</p>
                                    @enderror
                                </div>
                                </div>
                                <div class="col-md-6">
                                <div class="form-group">
                                    <label for="in">IN</label>
                                    <input id="in" name="in" type="text" class="form-control"
                                        placeholder="Enter in" value="{{ old('in') }}" />
                                    <p class="form-error-text" id="in_error" style="color: red; margin-top: 10px;"></p>
                                    @error('in')
                                    <p class="form-error-text" id="in_error" style="color: red; margin-top: 10px;">{{ $message }}</p>
                                    @enderror
                                </div>
                                </div>

                                @foreach($godown_data as $godown)
                                <div class="form-group col-lg-4">
                                    @if ($loop->first)
                                        <label for="godown">Godown Name</label>
                                    @endif
                                    <input type="hidden" 
                                        name="godown_id[]" 
                                        value="{{ $godown->id }}" 
                                        class="form-control"
                                        readonly
                                    />
                                    <input type="text" 
                                        name="godown_name[]" 
                                        value="{{ $godown->name }}" 
                                        class="form-control"
                                        readonly
                                    />
                                </div>
                                <div class="form-group col-lg-4">
                                    @if ($loop->first)
                                    <label for="stock">Stock</label>
                                    @endif
                                    <input type="text" 
                                        name="stock[]" 
                                        value="" 
                                        class="form-control"
                                    />
                                </div>
                                <div class="form-group col-lg-4">
                                    @if ($loop->first)
                                    <label for="price">Price</label>
                                    @endif
                                    <input type="text" 
                                        name="price[]" 
                                        value="" 
                                        class="form-control"
                                    />
                                </div>
                            @endforeach
                            </div>
                            <div class="text-end mt-4">
                                <a class="btn btn-primary" href="{{ route('materials.index') }}"> Cancel</a>
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
            var materials = jQuery("#name").val();
            if (materials == '') {
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
@stop