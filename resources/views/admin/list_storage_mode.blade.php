@extends('admin.includes.Template')
@section('content')
    @php
        $userId = Auth::id();
        // echo"<pre>";print_r($userId);echo"</pre>";exit;
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
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Storage Mode</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active">Storage Mode</li>
                    </ul>
                </div>
                @if (in_array('11', $add_perm) || in_array('11', $delete_perm))
                    <div class="col-auto">
                        @if (in_array('11', $add_perm))
                        <a class="btn btn-primary me-1" href="{{ route('storage_mode.create') }}">
                            <i class="fas fa-plus"></i> Add Storage Mode
                        </a>
                        @endif
                        @if (in_array('11', $delete_perm))
                        <a class="btn btn-danger me-1" href="javascript:void('0');" onclick="delete_storage_mode();">
                            <i class="fas fa-trash"></i> Delete
                        </a>
                        @endif
                        {{-- <a class="btn btn-primary filter-btn" href="javascript:void(0);" id="filter_search">
                            <i class="fas fa-filter"></i> Filter
                        </a> --}}
                    </div>
                @endif
            </div>
        </div>
        @if ($message = Session::get('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <strong>Success!</strong> {{ $message }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        <div class="alert alert-success alert-dismissible fade show success_show" style="display: none;">
            <strong>Success! </strong><span id="success_message"></span>
            <!-- <button type="button" class="btn-close" data-bs-dismiss="alert"></button> -->
        </div>
        <!-- Search Filter -->
        <div id="filter_inputs" class="card filter-card">
            <div class="card-body pb-0">
                <div class="row">
                    <div class="col-sm-6 col-md-3">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control">
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" class="form-control">
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="form-group">
                            <label>Phone</label>
                            <input type="text" class="form-control">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Search Filter -->
        <div class="row">
            <div class="col-sm-12">
                <div class="card card-table">
                    <div class="card-body">
                        <form id="form" action="{{ route('delete_storage_mode') }}" enctype="multipart/form-data">
                            <INPUT TYPE="hidden" NAME="hidPgRefRan" VALUE="<?php echo rand(); ?>">
                            @csrf
                            <div class="table-responsive">
                                <table class="table table-center table-hover datatable" id="header_lock">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Select</th>
                                            <th>Storage Mode</th>
                                            @if (in_array('11', $edit_perm))
                                                <th class="text-right">Actions</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($storage_mode as $data)
                                            <tr>
                                                <td><input name="selected[]" id="selected[]" value="{{ $data->id }}"
                                                        type="checkbox" class="minimal-red"
                                                        style="height: 20px;width: 20px;border-radius: 0px;color: red;">
                                                </td>
                                                <td>
                                                    {{ $data->storage_mode }}
                                                </td>
                                                @if (in_array('11', $edit_perm))
                                                    <td class="text-right">
                                                        <a class="btn btn-primary"
                                                            href="{{ route('storage_mode.edit', $data->id) }}"><i
                                                                class="far fa-edit"></i></a>
                                                    </td>
                                                @endif
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
@section('footer_js')
    <!-- Delete country Modal -->
    <div class="modal custom-modal fade" id="delete_storage_mode" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="modal-icon text-center mb-3">
                        <i class="fas fa-trash-alt text-danger"></i>
                    </div>
                    <div class="modal-text text-center">
                        <!-- <h3>Delete Expense country</h3> -->
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
    <!-- /Delete country Modal -->
    <!-- Select one record country Modal -->
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
    <!-- /Select one record country Modal -->
    <!-- set order Modal -->
    {{-- <div class="modal custom-modal fade" id="set_order_model" role="dialog">
 <div class="modal-dialog modal-dialog-centered">
     <div class="modal-content">
         <div class="modal-body">
             <div class="modal-text text-center">
                 <h3>Are you sure you want to Set order of country</h3>
                 <input type="hidden" name="set_order_val" id="set_order_val" value="">
                 <input type="hidden" name="set_order_id" id="set_order_id" value="">
                 <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                 <button type="button" class="btn btn-primary" onclick="updateorder();">Yes</button>
             </div>
         </div>
     </div>
 </div>
</div> --}}
    <!-- /set orderModal -->
    <script>
        function delete_storage_mode() {
            // alert('test');
            var checked = $("#form input:checked").length > 0;
            if (!checked) {
                $('#select_one_record').modal('show');
            } else {
                $('#delete_storage_mode').modal('show');
            }
        }
        function form_sub() {
            $('#form').submit();
        }
        // function updateorder_popup(val, id) {
        //     $('#set_order_val').val(val);
        //     $('#set_order_id').val(id);
        //     $('#set_order_model').modal('show');
        // }
        // function updateorder() {
        //     var id = $('#set_order_id').val();
        //     var val = $('#set_order_val').val();
        //     $.ajax({
        //         type: "POST",
        //         url: "{{ url('set_order_country') }}",
        //         data: {
        //             "_token": "{{ csrf_token() }}",
        //             "id": id,
        //             "val": val
        //         },
        //         success: function(returnedData) {
        //             // alert(returnedData);
        //             if (returnedData == 1) {
        //                 //alert('yes');
        //                 $('#success_message').text("Set Order has been Updated successfully");
        //                 //$('.success_show').show();
        //                 $('.success_show').show().delay(0).fadeIn('show');
        //                 $('.success_show').show().delay(5000).fadeOut('show');
        //                 $('#set_order_model').modal('hide');
        //             }
        //         }
        //     });
        // }
    </script>
@stop
