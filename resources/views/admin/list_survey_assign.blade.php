@extends('admin.includes.Template')
@section('content')
    @php
        $userId = Auth::id();
        $get_user_data = Helper::get_user_data($userId);
        $get_permission_data = Helper::get_permission_data($get_user_data->role_id);
        $add_perm = [];
        $edit_perm = [];
        $delete_perm = [];

        if ($get_permission_data->add_perm != '') {
            $add_perm = $get_permission_data->add_perm;
            $add_perm = explode(',', $add_perm);
        }
        if ($get_permission_data->editperm != '') {
            $edit_perm = $get_permission_data->editperm;
            $edit_perm = explode(',', $edit_perm);
        }
        if ($get_permission_data->delete_perm != '') {
            $delete_perm = $get_permission_data->delete_perm;
            $delete_perm = explode(',', $delete_perm);
        }
    @endphp
<style>
    div.container { max-width: 1200px }
</style>
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Surveys</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active">Surveys</li>
                    </ul>
                </div>
                @if (in_array('16', $add_perm) || in_array('16', $delete_perm))
                    <div class="col-auto">
                        {{-- <a class="btn btn-primary me-1" href="javascript:void('0');" onclick="excel_download();">Excel
                            Download</a> --}}
                        {{--
                        @if (in_array('16', $add_perm))
                        <a class="btn btn-primary me-1" href="{{ route('followup.create') }}">
                            <i class="fas fa-plus"></i> Add Enquiry
                        </a>
                        @endif
                        --}}
                        {{--
                        <a class="btn btn-primary filter-btn" href="javascript:void(0);" id="filter_search">
                            <i class="fas fa-filter"></i> Filter
                        </a> --}}
                        {{--
                        @if (in_array('16', $delete_perm))
                         <a class="btn btn-danger me-1" href="javascript:void('0');" onclick="delete_category();">
                            <i class="fas fa-trash"></i> Delete
                        </a>
                        @endif
                        --}}
                    </div>
                @endif
            </div>
        </div>
        <!-- /Page Header -->
        @if ($message = Session::get('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <strong>Success!</strong> {{ $message }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        <!-- /Search Filter -->
        <div class="row">
            <div class="col-sm-12">
                <div class="card card-table">
                    <div class="card-body container">
                        <form id="form" action="{{ route('survey_assign') }}" enctype="multipart/form-data">
                            <INPUT TYPE="hidden" NAME="hidPgRefRan" VALUE="<?php echo rand(); ?>">
                            @csrf
                            <div class="table-responsive">
                                <table class="table table-center table-hover datatable" id="header_lock">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Select</th>
                                            <th>Survey Id</th>
                                            <th>Enquiry Id</th>
                                            <th>Enquiry Date</th>
                                            <th>Name</th>
                                            <th>Contact</th>
                                            <th>Mobile</th>
                                            <th>Origin City/Port</th>
                                            <th>Dest. City/Port</th>
                                            <th>Surveyor</th>
                                            {{-- <th>Start Time</th> --}}
                                            <th>Scheduled</th>
                                            <th>Comptetion</th>
                                            <th>Dispatch</th>
                                            @if (in_array('16', $edit_perm))
                                                <th class="text-right">Actions</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($survey_assign_data as $data)
                                        @php
                                        $inquiry_data = DB::table('followups')->where('id',$data->enquiry_id)->first();
                                        // echo"<pre>";print_r($inquiry_data);echo"</pre>";exit;
                                        @endphp
                                            <tr>
                                                <td><input name="selected[]" id="selected[]" value="{{ $data->id }}"
                                                        type="checkbox" class="minimal-red"
                                                        style="height: 20px;width: 20px;border-radius: 0px;color: red;">
                                                </td>
                                                <td>{{$data->survey_id}}</td>
                                                <td>{{$data->enquiry_id}}</td>
                                                
                                                <td>@if(isset($inquiry_data->enquiry_date)){{$inquiry_data->enquiry_date}}
                                                    @else{{ "-" }}
                                                @endif</td>
                                                <td>{{$data->survey_company_name}}</td>
                                                <td>{{$data->survey_customer_name}}</td>
                                                <td>{{$data->survey_customer_mobile}}</td>
                                                <td>
                                                @if(isset($inquiry_data) && $inquiry_data->origin_country != "")
                                                        {!! Helper::countryname($inquiry_data->origin_country) !!}/{{$inquiry_data->origin_state}}
                                                @else
                                                        {{"-"}}/{{$inquiry_data->origin_state ?? "-"}}
                                                @endif
                                                    </td>

                                                <td>
                                                @if(isset($inquiry_data) && $inquiry_data->desti_country !="")
                                                {!! Helper::countryname($inquiry_data->desti_country)!!}/{{$inquiry_data->desti_state}}
                                                @else
                                                {{"-"}}/{{"-"}}
                                                @endif
                                                </td>

                                                <td>
                                                    {!! Helper::surveyorname($data->surveyor_name)!!}
                                                </td>

                                                {{-- <td>{{$data->time_from}}</td> --}}
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                @if (in_array('16', $edit_perm))
                                                    <td class="text-right">
                                                        <a class="btn btn-primary"
                                                            href="{{ route('survey_assign.edit', $data->id) }}"><i
                                                                class="far fa-edit"></i>
                                                        </a>
                                                    </td>
                                                @endif
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <span style="float: left;"> </span>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
@section('footer_js')
    <!-- Delete Category Modal -->
    <div class="modal custom-modal fade" id="delete_category" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="modal-icon text-center mb-3">
                        <i class="fas fa-trash-alt text-danger"></i>
                    </div>
                    <div class="modal-text text-center">
                        <!-- <h3>Delete Expense Category</h3> -->
                        <p>Are you sure want to delete?</p>
                    </div>
                </div>
                <div class="modal-footer text-center">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="form_sub();">Delete</button>
                </div>
            </div>
        </div>
    </div>
    <!-- /Delete Category Modal -->
    <!-- Followup  Modal -->
    <div class="modal custom-modal fade" id="add_follow_up_model" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="followup_form" action="{{ url('followup_form') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="inquiry_id" id="inquiry_id_follow">
                    <div class="modal-body">
                        <div class="modal-text text-center">
                            <!-- <h3>Delete Expense Category</h3> -->
                        </div>
                        <div id="follow_replace">
                        </div>
                        <div class="modal-text text-center" id="dropdownreplace">
                            <div class="form-group">
                                <label for="name">Follow Up Date</label>
                                <input id="date" name="date" type="text" class="form-control"
                                    placeholder="Enter Follow Up Date" />
                                <p class="form-error-text" id="date_error" style="color: red;"></p>
                            </div>
                            <div class="form-group">
                                <label for="name">Next Follow Up Date</label>
                                <input id="next_date" name="next_date" type="text" class="form-control"
                                    placeholder="Enter Next Follow Up Date" />
                                <p class="form-error-text" id="next_date_error" style="color: red;"></p>
                            </div>
                            <div class="form-group">
                                <label for="name">Remarks</label>
                                <textarea id="remarks" name="remarks" class="form-control" cols="30" rows="5"
                                    placeholder="Enter Remark"></textarea>
                                <p class="form-error-text" id="remarks_error" style="color: red;"></p>
                            </div>
                        </div>
                        <p class="form-error-text" id="inquiry_id_error" style="color: red; margin-top: 10px;"></p>
                    </div>
                    <div class="modal-footer text-center">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" onclick="form_sub_followup();">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        function form_sub_followup() {
            var date = jQuery("#date").val();
            if (date == '') {
                jQuery('#date_error').html("Please Enter Follow up Date");
                jQuery('#date_error').show().delay(0).fadeIn('show');
                jQuery('#date_error').show().delay(2000).fadeOut('show');
                return false;
            }
            var next_date = jQuery("#next_date").val();
            if (next_date == '') {
                jQuery('#next_date_error').html("Please Enter Next Follow up Date");
                jQuery('#next_date_error').show().delay(0).fadeIn('show');
                jQuery('#next_date_error').show().delay(2000).fadeOut('show');
                return false;
            }
            var remarks = jQuery("#remarks").val();
            if (remarks == '') {
                jQuery('#remarks_error').html("Please Enter remark");
                jQuery('#remarks_error').show().delay(0).fadeIn('show');
                jQuery('#remarks_error').show().delay(2000).fadeOut('show');
                return false;
            }
            $('#followup_form').submit();
        }
    </script>
    <!-- /Follow up Modal -->
    <!-- Select one record Category Modal -->
    <div class="modal custom-modal fade" id="select_one_record" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="modal-text text-center">
                        <h3>Please select at least one record to delete</h3>
                        <!-- <p>Are you sure want to delete?</p> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- < Status Model > --}}
    <div class="modal custom-modal fade" id="add_followup_status_model" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <input type="hidden" name="status_id" id="status_id">
                <div class="modal-body">
                    <div class="modal-text text-center">
                        <!-- <h3>Delete Expense Category</h3> -->
                    </div>
                    <div class="modal-text text-center" id="dropdownreplace">
                        <div class="form-group">
                            <label for="name"><b>Are You Sure Want to Change Status</b></label>
                            {{-- <p class="form-error-text" id="date_error" style="color: red;"></p> --}}
                        </div>
                    </div>
                    {{-- <p class="form-error-text" id="status_id_error" style="color: red; margin-top: 10px;"></p> --}}
                </div>
                <div class="modal-footer text-center">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="form_status_change();">Submit</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    {{-- < /Status Model> --}}
    <script>
        function delete_category() {
            // alert('test');
            var checked = $("#form input:checked").length > 0;
            if (!checked) {
                $('#select_one_record').modal('show');
            } else {
                $('#delete_category').modal('show');
            }
        }
        function form_sub() {
            $('#form').submit();
        }
        function add_follow_up(id) {
            $('#inquiry_id_follow').val(id);
            followup_data(id);
            $('#add_follow_up_model').modal('show');
        }
        function followup_data(id) {
            var url = '{{ url('followup_data') }}';
            $.ajax({
                url: url,
                type: 'post',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "id": id
                },
                success: function(msg) {
                    document.getElementById('follow_replace').innerHTML = msg;
                }
            });
        }
        function excel_download() {
            $('#filter_data').submit();
        }
        function statuschange(value, id) {
            $('#inquiry_id').val(id);
            $('#inquiry_status').val(value);
            $('#add_followup_status_model').modal('show');
        }
        function form_status_change() {
            $('#status_change').submit();
        }
    </script>

    <script type="text/javascript">
        $(function() {
            $('#date').datepicker();
        });
        $(function() {
            $('#next_date').datepicker();
        });
        $(function() {
            $('#s_date').datepicker();
        });
        $(function() {
            $('#e_date').datepicker();
        });
    </script>
@stop
