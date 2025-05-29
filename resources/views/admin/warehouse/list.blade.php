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
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Warehouse</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active">Warehouse</li>
                    </ul>
                </div>
                @if (in_array('53', $add_perm) || in_array('53', $delete_perm))
                    <div class="col-auto">
                        @if (in_array('53', $add_perm))
                        <a class="btn btn-primary me-1" href="{{  route('warehouse.create') }}">
                            <i class="fas fa-plus"></i> Add Warehouse
                        </a>
                        @endif
                        @if (in_array('53', $delete_perm))
                        <a class="btn btn-danger me-1" href="javascript:void('0');" onclick="delete_IndustryType();">
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
                        <form id="form" action="{{ route('warehouse.delete') }}" enctype="multipart/form-data">
                            <INPUT TYPE="hidden" NAME="hidPgRefRan" VALUE="<?php echo rand(); ?>">
                            @csrf
                            <div class="table-responsive">
                                <table class="table table-center table-hover datatable" id="header_lock">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Select</th>
                                            <th>Warehouse Name</th>
                                            <th>Contract Start Date</th>
                                            <th>Contract End Date</th>
                                            <th>Branch</th>
                                            <th>Warehouse Type</th>
                                            @if (in_array('53', $edit_perm))
                                                <th class="text-right">Actions</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($warehouses as $data)
                                            <tr>
                                                <td><input name="selected[]" id="selected[]" value="{{ $data->id }}"
                                                        type="checkbox" class="minimal-red"
                                                        style="height: 20px;width: 20px;border-radius: 0px;color: red;">
                                                </td>
                                                <td>
                                                    {{ $data->name }}
                                                </td>
                                                <td>
                                                   {{ date('d-m-Y', strtotime($data->contract_start_date)) }}
                                                </td>
                                                <td>
                                                    {{ date('d-m-Y', strtotime($data->contract_end_date)) }}
                                                </td>
                                                <td>
                                                    {{ Helper::branchname($data->branch)  }}
                                                </td>
                                                <td>
                                                    {{ $data->warehouse_type }}
                                                </td>
                                                @if (in_array('53', $edit_perm))
                                                    <td class="text-right">
                                                        <a class="btn btn-primary"
                                                            href="{{  route('warehouse.edit', $data->id) }}"><i
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
    <!-- Delete Industry Type Modal -->
    <div class="modal custom-modal fade" id="delete_IndustryType" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="modal-icon text-center mb-3">
                        <i class="fas fa-trash-alt text-danger"></i>
                    </div>
                    <div class="modal-text text-center">
                        <!-- <h3>Delete Expense Industry Type</h3> -->
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
    <!-- /Delete Industry Type Modal -->
    <!-- Select one record Industry Type Modal -->
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
    <!-- /Select one record Industry Type Modal -->
    <!-- set order Modal -->
    {{-- <div class="modal custom-modal fade" id="set_order_model" role="dialog">
 <div class="modal-dialog modal-dialog-centered">
     <div class="modal-content">
         <div class="modal-body">
             <div class="modal-text text-center">
                 <h3>Are you sure you want to Set order of Industry Type</h3>
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
        function delete_IndustryType() {
            // alert('test');
            var checked = $("#form input:checked").length > 0;
            if (!checked) {
                $('#select_one_record').modal('show');
            } else {
                $('#delete_IndustryType').modal('show');
            }
        }
        function form_sub() {
            $('#form').submit();
        }
    </script>
@stop
