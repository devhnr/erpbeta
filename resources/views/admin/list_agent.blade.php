@extends('admin.includes.Template')
<style>
    .approve-by-name{font-size: small !important;}
</style>
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
                    <h3 class="page-title">Organization</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active">Organization</li>
                    </ul>
                </div>
                @if (in_array('14', $add_perm) || in_array('14', $delete_perm))
                    <div class="col-auto">
                        {{-- <a class="btn btn-primary me-1" href="{{ route('download.agent') }}">
                            <i class="fas fa-plus"></i> Download Format
                        </a> --}}
                        {{-- <a class="btn btn-primary me-1" href="{{ route('bulk_agent') }}">
                            <i class="fas fa-plus"></i> Bulk Organization
                        </a> --}}
                    @if(in_array('14', $add_perm))
                    <a class="btn btn-primary me-1" href="{{ route('agent.create') }}">
                            <i class="fas fa-plus"></i> Add Organization
                        </a>
                    @endif
                    @if(in_array('14', $delete_perm))
                    <a class="btn btn-danger me-1" href="javascript:void('0');" onclick="delete_category();">
                            <i class="fas fa-trash"></i> Delete</a>
                    @endif
                            {{-- <a class="btn btn-primary filter-btn" href="javascript:void(0);" id="filter_search">
                                <i class="fas fa-filter"></i> Filter

                            </a> --}}
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
        @php

        if (!empty($filter_country_id)) {
            $displayCard = 'display:block';
        } else {
            $displayCard = 'display:none';
        }
        @endphp
        <!-- Search Filter -->
        <div id="filter_inputs" class="card filter-card" style="@php echo $displayCard; @endphp">
            <div class="card-body pb-0">
                <form action="{{ route('agent_filter') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-sm-6 col-md-8">
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label>Select Country</label>
                                        <select name="countryname" class="form-control" id="countryname">
                                            <option value="">Select Country</option>
                                            @foreach ($country_data as $data)
                                                <option value="{{ $data->id }}"
                                                    @if ($data->id == $filter_country_id) {{ 'selected' }} @endif>
                                                    {{ $data->country }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3 col-md-4" style="margin-top: 23px;">
                            <input class="btn btn-primary" value="Search" type="submit">
                            <a href="{{ route('agent.index') }}" class="btn btn-primary">Reset</a>
                        </div>
                    </div>
            </div>
            </form>
        </div>
        <!-- /Search Filter -->
        <div class="row">
            <div class="col-sm-12">
                <div class="card card-table">
                    <div class="card-body">
                        <form id="form" action="{{ route('delete_agent') }}" enctype="multipart/form-data">
                            <INPUT TYPE="hidden" NAME="hidPgRefRan" VALUE="<?php echo rand(); ?>">
                            @csrf
                            <div class="table-responsive">
                                <table class="table table-center table-hover datatable" id="header_lock">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Select</th>
                                            <th>Created At</th>
                                            <th>Organization ID</th>
                                            <th>Organization Type</th>
                                            <th>Name</th>
                                            <th>Mobile</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Sales Person</th>
                                            {{-- <th>Last Activity</th> --}}
                                            @if (in_array('14', $edit_perm))
                                            <th>Status </th></th>
                                            @endif
                                            <th>View</th>
                                            <th>Detail</th>
                                            @if (in_array('14', $edit_perm))
                                                <th class="text-right">Actions</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>

                                         @for ($i = 0; $i < count($agent_data); $i++)
                                            <tr>
                                                <td><input name="selected[]" id="selected[]"
                                                        value="{{ $agent_data[$i]->id }}" type="checkbox"
                                                        class="minimal-red"
                                                        style="height: 20px;width: 20px;border-radius: 0px;color: red;">
                                                </td>
                                                <td>
                                                    @if($agent_data[$i]->added_date != "0000-00-00")
                                                    {{ date("d-m-Y",strtotime($agent_data[$i]->added_date)) }}
                                                    @else
                                                    {{ "-" }}
                                                    @endif
                                                </td>
                                                <td>
                                                    {{ $agent_data[$i]->organization_id }}
                                                </td>
                                                <td>
                                                    @if($agent_data[$i]->agent_type !="" && !empty($agent_data[$i]->agent_type))
                                                    {{ Helper::agentname($agent_data[$i]->agent_type) }}
                                                    @endif
                                                </td>
                                                <td>
                                                    {{ $agent_data[$i]->company_name }}
                                                </td>
                                              <td>
                                                    {{ $agent_data[$i]->company_telephone }}
                                                </td>
                                                <td>
                                                    {{ $agent_data[$i]->company_email }}
                                                </td>
                                                <td>
                                                    {{ $agent_data[$i]->phone }}
                                                </td>
                                                <td>
                                                    {!! Helper::salesmanname($agent_data[$i]->sales_person) !!}
                                                </td>
                                                {{-- <td></td> --}}
                                                @if (in_array('14', $edit_perm))
                                                @php
                                                    $username = Helper::getusername($agent_data[$i]->is_approved_by);
                                                @endphp
                                                <td>
                                                    @if($agent_data[$i]->is_approved == 1)
                                                    <span class="badge badge-pill bg-success-light">Approved</span><br>
                                                     <p class="approve-by-name mt-2">Approved By: {{ $username }}</p>
                                                    @else
                                                    <span class="badge badge-pill bg-danger-light">Not Approved</span>
                                                    @endif

                                                    {{-- <select name="is_approved_status" id="is_approved_status" class="form-control" onchange="is_approved(this.value,'{{ $agent_data[$i]->id }}')">
                                                        <option value="0">Select</option>
                                                        <option value="1" @if($agent_data[$i]->is_approved == 1) selected @endif>Approve</option>
                                                    </select> --}}
                                                </td>
                                                @endif
                                                <td>
                                                    <a class="btn btn-sm btn-primary" href="javascript:void(0)"
                                                        onclick="agent_detail('{{ $agent_data[$i]->id }}');">View</a>
                                                </td>

                                                <td>
                                                    <a class="btn btn-sm btn-primary" href="{{ route('agent-detail',$agent_data[$i]->id) }}">
                                                        <i class="far fa-eye me-1"></i> View
                                                    </a>
                                                </td>
                                                @if (in_array('14', $edit_perm))
                                                    <td class="text-right">
                                                        <a class="btn btn-primary"
                                                            href="{{ route('agent.edit', $agent_data[$i]->id) }}"><i
                                                                class="far fa-edit"></i></a>
                                                    </td>
                                                @endif
                                            </tr>
                                        @endfor

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
@foreach ($attribute_data as $agent_id => $attribute_new_data)
    <div class="modal custom-modal fade" id="show_comment_model_{{$agent_id}}" role="dialog">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 80% !important;">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="modal-text text-center"></div>
                    <div class="modal-text text-center" id="dropdownreplace">
                        <div class="row">
                            <div id="agent_detail">
                                @if($attribute_new_data)
                                    <div class="table-responsive mb-30" style="margin-bottom: 40px;">
                                        <table class="table mb-30" id="refresh-table">
                                            <thead>
                                                <tr>
                                                    <th>P.O.C</th>
                                                    <th>Email</th>
                                                    <th>Telephone</th>
                                                    <th>P.O.C Position/Title</th>
                                                    {{-- <th>Add inquiry</th> --}}
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($attribute_new_data as $attribute)
                                                    <tr>
                                                        <td>{{ $attribute->name }}</td>
                                                        <td>{{ $attribute->email }}</td>
                                                        <td>{{ $attribute->telephone }}</td>
                                                        <td>{{ $attribute->role }}</td>
                                                        {{-- <td>
                                                <a href="{{ route('add_new_inq', ['agent_id' => $attribute->agent_id, 'attr_id' => $attribute->id]) }}"
                                                class="btn btn-primary pull-right">Add
                                                Inquiry</a></td> --}}
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <div>No Agent Data Found.</div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach
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
        function agent_detail(id) {
            $('#show_comment_model_'+ id).modal('show');
        }

    </script>
@stop
