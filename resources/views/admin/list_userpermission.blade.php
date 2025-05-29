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
                    <h3 class="page-title">Permission</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active">Permission</li>
                    </ul>
                </div>
                @if (in_array('2', $add_perm) || in_array('2', $delete_perm))
                    <div class="col-auto">
                        @if(in_array('2', $add_perm))
                        <a class="btn btn-primary me-1" href="{{ route('userpermission.create') }}">
                            <i class="fas fa-plus"></i> Add User Permission
                        </a>
                        @endif
                        @if(in_array('2', $delete_perm))
                        <a class="btn btn-danger me-1" href="javascript:void('0');" onclick="delete_category();">
                            <i class="fas fa-trash"></i> Delete
                        </a>
                        @endif
                        <!--  <a class="btn btn-primary filter-btn" href="javascript:void(0);" id="filter_search">
                                                                                                                                                                                                                                                                    <i class="fas fa-filter"></i> Filter
                                                                                                                                                                                                                                                                  </a> -->
                    </div>
                @endif
            </div>
        </div>
        <!-- /Page Header -->
        <!-- @if ($message = Session::get('success'))
    <div class="alert alert-success">
   <p>{{ $message }}</p>
      </div>
    @endif -->
        @if ($message = Session::get('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <strong>Success!</strong> {{ $message }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
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
                        <form id="form" action="{{ route('delete_permission') }}" enctype="multipart/form-data">
                            <INPUT TYPE="hidden" NAME="hidPgRefRan" VALUE="<?php echo rand(); ?>">
                            @csrf
                            <div class="table-responsive">
                                <table class="table table-center table-hover datatable" id="example">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Select</th>
                                            <th>User Type</th>
                                            {{-- <th>Permissions</th> --}}
                                            @if (in_array('2', $edit_perm))
                                                <th class="text-right">Actions</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($permission_data as $data)
                                            <tr>
                                                <td><input name="selected[]" id="selected[]" value="{{ $data->id }}"
                                                        type="checkbox" class="minimal-red"
                                                        style="height: 20px;width: 20px;border-radius: 0px;color: red;">
                                                </td>
                                                <td>
                                                    {{ $data->cname }}
                                                </td>
                                                {{-- <td>
                                                    <?php
                                                    
                                                    /*$data1 = explode(',', $data->permission);
                                                    
                                                    // echo "<pre>";print_r($data1);echo "</pre>";exit;
                                                    
                                                    $permissionName = DB::table('permissions')
                                                        ->whereIn('id', $data1)
                                                        ->get(['pname']);
                                                    
                                                    // echo "<pre>";print_r($permissionName);echo "</pre>";exit;
                                                    
                                                    $permissionArray = $permissionName->toArray();
                                                    
                                                    $num_of_items = count($permissionArray);
                                                    
                                                    $num_count = 0;
                                                    
                                                    foreach ($permissionArray as $permissionName) {
                                                        echo $permissionName->pname;
                                                    
                                                        $num_count = $num_count + 1;
                                                    
                                                        if ($num_count < $num_of_items) {
                                                            echo ', ';
                                                        }
                                                    }*/
                                                    
                                                    ?>
                                                </td> --}}
                                                @if (in_array('1', $edit_perm))
                                                    <td class="text-right">
                                                        <a class="btn btn-primary"
                                                            href="{{ route('userpermission.edit', $data->id) }}"><i
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
</script>
<script>
    if ($.fn.DataTable.isDataTable('#example')) {
        $('#example').DataTable().destroy();
    }
    $(document).ready(function() {
        $('#example').dataTable({
            "searching": true
        });
    })
</script>
@stop