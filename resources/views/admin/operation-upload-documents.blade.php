@extends('admin.includes.Template')
@section('content')
<style>
    .hidden {
        display: none;
    }
    #allowance_table,th,td{
        border: 1px solid black;
    }
    #allowance_table{
        width: 50%;
    }
    .checkbox-color{
        color: #0f548e !important;
    }
    input[type="checkbox"] {
        accent-color: #0f548e; /* Set the desired color */
    }
    .disabled-checkbox {
        background-color: red !important;
        opacity: 0.6; /* Makes it look disabled */
        pointer-events: none; /* Prevents clicks */
    }
    .table thead{
        background-color: #3484C3;
        color: #fff;
        text-align: center;
    }
    tbody{
        text-align: center;
    }
    .no-of-trip-input{
        width:13%;
    }
    .amount-input{
        width:15%;
    }
    .allocate-input{position: relative;width: 15%;}
    .allocate-input .add-row{position: absolute;top: 40%;left: 85%;}
    .allocate-input input{width: 90%;}
    .modal-dialog {
        max-width: 67%;
    }
    .warehouse-popup-table .close {
        background-color: #3484C3 !important;
        border-color: #3484C3;
        border-radius: 50%;
        color: #fff;
        font-size: 13px;
        height: 25px;
        line-height: 20px;
        margin: 0;
        opacity: 1;
        padding: 0;
        position: absolute;
        right: 10px;
        top: 10px;
        width: 25px;
        z-index: 99;
        border:unset;
    }

    .warehouse-popup-table .table > tbody > tr > td {
        padding: 2px;
    }
    .warehouse-popup-table .table-responsive .form-control {
        padding: 2px;
    }
    .warehouse-popup-table .card-body{
        padding: 10px 5px;
    }

    .warehouse-popup-table table thead th{
        background: #3484C3;
        color: #fff;
    }

    .warehouse-popup-table .table > tbody > tr > td {
        padding: 10px;
    }
    .warehouse-popup-table .modal-body h5{
        color: #3484C3;
    }

    .loader {
        display: block;
        margin: 0 auto;
        width: 80px;
        height: 80px;
        background: url('{{ asset('public/admin/assets/img/loader.gif') }}') repeat center center;
        background-size: contain;
    }
    .loader {
        display: none;
    }
    .number-pagination{
        margin-left: 77%;
    }
 </style>
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Edit Upload Documents</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('operation.index') }}">Upload Documents</a></li>
                        <li class="breadcrumb-item active">Edit Upload Documents</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Page Header -->
        @if ($message = Session::get('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <strong>Success!</strong> {{ $message }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if ($message = Session::get('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                <strong>Error!</strong> {{ $message }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div id="validate" class="alert alert-danger alert-dismissible fade show" style="display: none;">
            <span id="login_error"></span>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form id="category_form" action="{{ route('upload.documents', $followup->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')
                            <div class="row">
                                <div class="form-group col-lg-4">
                                    <label for="name">Job Order ID</label>
                                    <input id="quote_no" name="quote_no" type="text" class="form-control"
                                        placeholder="Enter Job Order ID" value="{{ $followup->job_order_id }}"
                                        readonly/>
                                    <p class="form-error-text" id="quote_no_error" style="color: red;"></p>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="name">Quotation ID:</label>
                                        <input id="quote_id" name="quote_id" type="text" class="form-control"
                                            value="{{ $followup->quote_id }}"  readonly/>
                                    </div>
                                </div>
                                
                                <div class="form-group col-lg-4">
                                    <label for="name">Branch</label>
                                    <input type="hidden" name="branch" value="{{ $followup->branch }}">
                                    <select name="branch_dis" id="branch_dis" class="form-control form-select select" disabled>
                                        <option value="">Select Branch</option>
                                        @foreach($branch_data as $data)
                                            <option value="{{ $data->id }}" {{ $data->id == $followup->branch ? 'selected' : '' }}>
                                                {{ $data->branch }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="doc_title">Title</label>
                                            <input type="text" id="doc_title" name="title[]" class="form-control"
                                                placeholder="Enter Title">
                                        </div>
                                    </div>
                                    <div class="col-md-6" style="margin-left: 10px;">
                                        <div class="form-group">
                                            <label for="upload_file-file">Upload File</label>
                                            <input type="file" id="upload_file" name="upload_file[]" class="form-control"
                                                placeholder="Enter Upload File" style="width: 102%;">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="input_fields_wrap12"></div>
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <button
                                        style="border: medium none;margin-right: 107px;line-height: 25px;margin-top: -62px;color:#fff;"
                                        class="submit btn bg-purple pull-right text-light" type="button"
                                        id="add_field_button12">Add</button>
                                    </div>
                                </div>


                            </div> <!-- Closing div for .row -->

                            @if($uploaded_documents->count() > 0)
                            <div class="container">
                                <div class="row">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Title</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($uploaded_documents as $document)
                                                <tr>
                                                    <td>{{ $document->title }}</td>
                                                    <td>
                                                        <a href="{{ route('download.document', $document->id) }}" class="btn btn-primary btn-sm">
                                                            Download
                                                            <i class="fas fa-download"></i>
                                                        </a>
                                                        <a href="{{ route('delete.documents', $document->id) }}" class="btn btn-danger btn-sm delete-document">
                                                            Delete
                                                            <i class="fas fa-trash"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                             <!-- Pagination with Numbered Links -->
                                <div class="d-flex justify-content-center number-pagination">
                                    {{ $uploaded_documents->links() }}
                                </div>
                            @endif

                            <div class="text-end mt-4">
                                <a class="btn btn-primary" href="{{ route('operation.index') }}"> Cancel</a>
                                <button class="btn btn-primary mb-1" type="button" disabled id="spinner_button"
                                    style="display: none;">
                                    <span class="spinner-border spinner-border-sm" role="status"
                                        aria-hidden="true"></span>
                                    Loading...
                                </button>
                                <button type="button" class="btn btn-primary"
                                    onclick="javascript:category_validation()" id="submit_button">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div> <!-- Closing div for .col-md-12 -->
        </div> <!-- Closing div for .row -->
    </div> <!-- Closing div for .content.container-fluid -->

@stop
@section('footer_js')
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            document.querySelectorAll(".delete-document").forEach(function (button) {
                button.addEventListener("click", function (event) {
                    event.preventDefault(); // Prevent the default delete action

                    var confirmDelete = confirm("Are you sure you want to delete this document?");
                    if (confirmDelete) {
                        window.location.href = this.getAttribute("href"); // Proceed with deletion
                    }
                });
            });
        });

        function category_validation() {
            var customer_type = jQuery("#customer_type").val();
            if (customer_type == '') {
                jQuery('#customer_type_error').html("Please Select Upload Documents Type");
                jQuery('#customer_type_error').show().delay(0).fadeIn('show');
                jQuery('#customer_type_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#customer_type').offset().top - 150
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
    <script type="text/javascript" language="javascript">
        $(document).ready(function() {
            var max_fields = 50;
            var wrapper = $(".input_fields_wrap12");
            var add_button = $("#add_field_button12");
            var b = 0;
            $(add_button).click(function(e) { //alert('ok');
                e.preventDefault();
                if (b < max_fields) {
                    b++;
                    $(wrapper).append(
                        '<div class="row"><div class="col-md-4"><div class="form-group"> <label for="doc_title">Title</label><input type="text" id="doc_title" name="title[]" class="form-control" placeholder="Enter Title"></div></div><div class="col-md-6"><div class="form-group"> <label for="poc">Upload File</label><input type="file" id="upload_file" name="upload_file[]" class="form-control" placeholder="Enter Upload File"></div></div><a href = "#" class = "btn btn-danger pull-right remove_field1" style="margin-right: 0;margin-top: 23px;width: 10%;float: right;height:38px;margin-left: 65px;">Remove</a ></div>'
                    );
                }
            });
            $(wrapper).on("click", ".remove_field1", function(e) {
                e.preventDefault();
                $(this).parent('div').remove();
                b--;
            })
        });
    </script>
    
@stop