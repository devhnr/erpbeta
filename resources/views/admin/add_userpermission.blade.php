@extends('admin.includes.Template')
@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Permission</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('userpermission.index') }}">Permission</a></li>
                        <li class="breadcrumb-item active">Add Permission</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Page Header -->
        <div id="validate" class="alert alert-danger alert-dismissible fade show" style="display: none;">
            <span id="login_error"></span>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @if ($message = Session::get('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <strong>Success!</strong> {{ $message }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <!-- <h4 class="card-title">Basic Info</h4> -->
                        <form id="category_form" action="{{ route('userpermission.store') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="form-group">
                                    <label for="name">User Type</label>
                                    <input id="name" name="cname" type="text" class="form-control"
                                        placeholder="Enter User Type" value="" />
                                </div>
                                <style>
                                    table,
                                    th,
                                    td {
                                        border: 1px solid black;
                                    }
                                </style>
                                <table class="table table-bordered table-striped datatable dataTable">
                                    <tr>
                                        <th>Feature</th>
                                        <th>View</th>
                                        <th>Add</th>
                                        <th>Edit</th>
                                        <th>Delete</th>
                                        <!-- <th>Delete</th> -->
                                    </tr>
                                    @foreach ($permission as $per_data)
                                        <tr>
                                            <td>
                                                {{ $per_data->pname }}
                                            </td>
                                            <td>
                                                <input type="checkbox" name="permission[]" id="perm"
                                                    value="{{ $per_data->id }}" multiple="multiple">
                                            </td>
                                            <td>
                                                <input type="checkbox" name="add_perm[]" id="add_perm"
                                                    value="{{ $per_data->id }}" multiple="multiple">
                                            </td>
                                            <td>
                                                <input type="checkbox" name="edit_perm[]" id="edit_perm"
                                                    value="{{ $per_data->id }}" multiple="multiple">
                                            </td>
                                            <td>
                                                <input type="checkbox" name="delete_perm[]" id="delete_perm"
                                                    value="{{ $per_data->id }}" multiple="multiple">
                                            </td>
                                            <!-- <td>
                   <form action="{{ route('destroyPermission') }}">
                   @csrf
                   @method('DELETE')
                   <input type="hidden" name="per_id" id="per_id" value="{{ $per_data->id }}">
                   <button type="submit" class="btn btn-danger" style="line-height: 16px;">Delete</button>
                   </form>
                   </td> -->
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                            <div class="text-end mt-4">
                                <a class="btn btn-primary" href="{{ route('userpermission.index') }}"> Cancel</a>
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
        function category_validation()
        {
            var name = jQuery("#name").val();
            if (name == '') {
                jQuery('#validate').html("Please Enter User Type");
                jQuery('#validate').show().delay(0).fadeIn('show');
                jQuery('#validate').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#validate').offset().top - 150
                }, 1000);
                return false;
            }
            if ($('#perm:checked').length == 0)
            {
                jQuery('#validate').html("Please Select Atleast One Permission");
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
@stop
