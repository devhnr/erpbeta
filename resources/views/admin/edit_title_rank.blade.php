@extends('admin.includes.Template')
@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Edit Title/Rank</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('title_rank.index') }}">Title/Rank</a></li>
                        <li class="breadcrumb-item active">Edit Title/Rank</li>
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
                        <form id="category_form" action="{{ route('title_rank.update', $title_rank->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="form-group">
                                    <label for="name">Title/Rank</label>
                                    <input id="title_rank" name="title_rank" type="text" class="form-control"
                                        placeholder="Enter Title/Rank" value="{{ $title_rank->title_rank }}" />
                                    <p class="form-error-text" id="title_rank_error" style="color: red; margin-top: 10px;"></p>
                                </div>
                            </div>
                            <div class="text-end mt-4">
                                <a class="btn btn-primary" href="{{ route('title_rank.index') }}"> Cancel</a>
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
            var title_rank = jQuery("#title_rank").val();
            if (title_rank == '') {
                jQuery('#title_rank_error').html("Please Enter Title/Rank");
                jQuery('#title_rank_error').show().delay(0).fadeIn('show');
                jQuery('#title_rank_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#title_rank').offset().top - 150
                }, 1000);
                return false;
            }
            $('#spinner_button').show();
            $('#submit_button').hide();
            $('#category_form').submit();
        }
    </script>
@stop