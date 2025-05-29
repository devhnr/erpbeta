@extends('admin.includes.Template')
@section('content')
<style>
       .hidden {
        display: none;
    }
    </style>
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Warehouse</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{  route('warehouse.lists') }}">Warehouse</a></li>
                        <li class="breadcrumb-item active">Add Warehouse</li>
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
                        <form id="category_form" action="{{  route('warehouse.store') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf

                            <div class="form-group" >
                                <label for="basic_details"><b class="checkbox-color">Basic Details:</b></label>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="name">Warehouse Name</label>
                                        <input id="name" name="name" type="text" class="form-control"
                                            placeholder="Enter Warehouse Name" value="{{ old('name') }}" />
                                        <p class="form-error-text" id="name_error" style="color: red; margin-top: 10px;"></p>
                                        @error('name')
                                            <p class="form-error-text" style="color: red; margin-top: 10px;">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-group">
                                        <label for="name">Contract Start Date</label>
                                        <input id="contract_start_date" name="contract_start_date" type="text" class="form-control"
                                            value="{{ old('contract_start_date') }}" placeholder="Select Contract Start Date" autocomplete="off"/>
                                        <p class="form-error-text" id="contract_start_date_error" style="color: red;"></p>
                                        @error('contract_start_date')
                                            <p class="form-error-text" style="color: red; margin-top: 10px;">{{ $message }}</p>
                                        @enderror
                                </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-group">
                                        <label for="name">Contract End Date</label>
                                        <input id="contract_end_date" name="contract_end_date" type="text" class="form-control"
                                            value="{{ old('contract_end_date') }}" placeholder="Select Contract End Date" autocomplete="off"/>
                                        <p class="form-error-text" id="contract_end_date_error" style="color: red;"></p>
                                        @error('contract_end_date')
                                            <p class="form-error-text" style="color: red; margin-top: 10px;">{{ $message }}</p>
                                        @enderror
                                </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-4">
                                    <div class="form-group">
                                        <label for="name">Branch</label>
                                        <select name="branch" id="branch" class="form-control form-select select">
                                            <option value="">Select Branch</option>
                                            @foreach($branch_data as $data)
                                            <option value="{{$data->id}}" {{ old('branch') == $data->id ? 'selected' : '' }}>{{$data->branch}}</option>
                                            @endforeach
                                        </select>
                                        <p class="form-error-text" id="branch_error" style="color: red;"></p>
                                        @error('branch')
                                            <p class="form-error-text" style="color: red; margin-top: 10px;">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label for="name">Mode</label>
                                        <select name="mode" id="mode" class="form-control form-select select">
                                            <option value="">Select Mode</option>
                                            <option value="Normal" {{ old('mode') == 'Normal' ? 'selected' : '' }}>Normal</option>
                                        </select>
                                        <p class="form-error-text" id="mode_error" style="color: red;"></p>
                                        @error('mode')
                                            <p class="form-error-text" style="color: red; margin-top: 10px;">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label for="name">Warehouse Type</label>
                                        <select name="warehouse_type" id="warehouse_type" class="form-control form-select select">
                                            <option value="">Select Warehouse Type</option>
                                            <option value="Owned"  {{ old('warehouse_type') == 'Owned' ? 'selected' : '' }}>Owned</option>
                                            <option value="Third Party"  {{ old('warehouse_type') == 'Third Party' ? 'selected' : '' }}>Third Party</option>
                                        </select>
                                        <p class="form-error-text" id="warehouse_type_error" style="color: red;"></p>
                                        @error('warehouse_type')
                                            <p class="form-error-text" style="color: red; margin-top: 10px;">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="name">Address</label>
                                        <textarea id="address" name="address" class="form-control" cols="50" rows="6">{{ old('address') }}</textarea>
                                        <p class="form-error-text" id="address_error" style="color: red;"></p>
                                        @error('address')
                                            <p class="form-error-text" style="color: red; margin-top: 10px;">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-3">
                                    <div class="form-group">
                                        <label for="country">Country</label>
                                        <select class="form-control form-select select" id="country" name="country">
                                            <option value="">Select Country</option>
                                            @foreach ($country_data as $country)
                                                <option value="{{ $country->id }}" {{ old('country') == $country->id ? 'selected' : '' }}>{{ $country->country }}</option>
                                            @endforeach
                                        </select>
                                        <p class="form-error-text" id="country_error" style="color: red;"></p>
                                        @error('country')
                                            <p class="form-error-text" style="color: red; margin-top: 10px;">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-group">
                                        <label for="name">State</label>
                                        <input id="state" name="state" type="text" class="form-control" placeholder="Enter State" value="{{ old('state') }}"/>
                                        <p class="form-error-text" id="state_error" style="color: red;"></p>
                                        @error('state')
                                            <p class="form-error-text" style="color: red; margin-top: 10px;">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                 <div class="col-3">
                                    <div class="form-group">
                                        <label for="name">City</label>
                                        <input id="city" name="city" type="text" class="form-control" placeholder="Enter City" value="{{ old('city') }}"/>
                                        <p class="form-error-text" id="city_error" style="color: red;"></p>
                                        @error('city')
                                            <p class="form-error-text" style="color: red; margin-top: 10px;">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-group">
                                        <label for="name">ZIP/POST Code</label>
                                        <input id="zip_post_code" name="zip_post_code" type="text" class="form-control" placeholder="Enter ZIP/POST Code" value="{{ old('zip_post_code') }}"/>
                                        <p class="form-error-text" id="zip_post_code_error" style="color: red;"></p>
                                        @error('zip_post_code')
                                            <p class="form-error-text" style="color: red; margin-top: 10px;">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group" >
                                <input type="checkbox" id="capacity_details" name="capacity_details" onchange="capacityvisibility()" value="0">
                                <label for="capacity_details"><b class="checkbox-color">Capacity Details:</b></label>
                            </div>

                            <div id="capacity_details_fields" class="hidden">

                                <div class="row">

                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="total_area">Total Area</label>
                                            <input id="total_area" name="total_area" type="text" class="form-control" placeholder="Enter Total Area" value="{{ old('total_area') }}"/>
                                            <p class="form-error-text" id="total_area_error" style="color: red;"></p>
                                            @error('total_area')
                                                <p class="form-error-text" style="color: red; margin-top: 10px;">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-2">
                                        <div class="form-group">
                                            <label for="country">Type</label>
                                            <select class="form-control form-select select" id="total_area_type" name="total_area_type">
                                                <option value="">Select Type</option>
                                                <option value="1" {{ old('total_area_type') == '1' ? 'selected' : '' }}>Sq Feet</option>
                                                <option value="2" {{ old('total_area_type') == '2' ? 'selected' : '' }}>CBM</option>
                                            </select>
                                            <p class="form-error-text" id="total_area_type_error" style="color: red;"></p>
                                            @error('total_area_type')
                                                <p class="form-error-text" style="color: red; margin-top: 10px;">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="maximum_stack_height">Maximum Stack Height</label>
                                            <input id="maximum_stack_height" name="maximum_stack_height" type="text" class="form-control" placeholder="Enter Maximum Stack Height" value="{{ old('maximum_stack_height') }}"/>
                                            <p class="form-error-text" id="maximum_stack_height_error" style="color: red;"></p>
                                            @error('maximum_stack_height')
                                                <p class="form-error-text" style="color: red; margin-top: 10px;">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-2">
                                        <div class="form-group">
                                            <label for="country">Type</label>
                                            <select class="form-control form-select select" id="maximum_stack_height_type" name="maximum_stack_height_type">
                                                <option value="">Select Type</option>
                                                <option value="1" {{ old('maximum_stack_height_type') == '1' ? 'selected' : '' }}>Feet</option>
                                                <option value="2" {{ old('maximum_stack_height_type') == '2' ? 'selected' : '' }}>Meter</option>
                                            </select>
                                            <p class="form-error-text" id="maximum_stack_height_type_error" style="color: red;"></p>
                                            @error('maximum_stack_height_type')
                                                <p class="form-error-text" style="color: red; margin-top: 10px;">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">

                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="pickup_area">Pickup Area</label>
                                            <input id="pickup_area" name="pickup_area" type="text" class="form-control" placeholder="Enter Pick Area" value="{{ old('pickup_area') }}"/>
                                            <p class="form-error-text" id="pickup_area_error" style="color: red;"></p>
                                            @error('pickup_area')
                                                <p class="form-error-text" style="color: red; margin-top: 10px;">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-2">
                                        <div class="form-group">
                                            <label for="country">Type</label>
                                            <select class="form-control form-select select" id="pickup_area_type" name="pickup_area_type" disabled>
                                                <option value="">Select Type</option>
                                                <option value="1" {{ old('pickup_area_type') == '1' ? 'selected' : '' }}>Sq Feet</option>
                                                <option value="2" {{ old('pickup_area_type') == '2' ? 'selected' : '' }}>CBM</option>
                                            </select>
                                            <p class="form-error-text" id="pickup_area_type_error" style="color: red;"></p>
                                            @error('pickup_area_type')
                                                <p class="form-error-text" style="color: red; margin-top: 10px;">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="receiving_area">Receiving Area</label>
                                            <input id="receiving_area" name="receiving_area" type="text" class="form-control" placeholder="Enter Receiving Area" value="{{ old('receiving_area') }}"/>
                                            <p class="form-error-text" id="receiving_area_error" style="color: red;"></p>
                                            @error('receiving_area')
                                                <p class="form-error-text" style="color: red; margin-top: 10px;">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-2">
                                        <div class="form-group">
                                            <label for="country">Type</label>
                                            <select class="form-control form-select select" id="receiving_area_type" name="receiving_area_type" disabled>
                                                <option value="">Select Type</option>
                                                <option value="1" {{ old('receiving_area_type') == '1' ? 'selected' : '' }}>Sq Feet</option>
                                                <option value="2" {{ old('receiving_area_type') == '2' ? 'selected' : '' }}>CBM</option>
                                            </select>
                                            <p class="form-error-text" id="receiving_area_type_error" style="color: red;"></p>
                                            @error('receiving_area_type')
                                                <p class="form-error-text" style="color: red; margin-top: 10px;">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">

                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="dispatch_area">Dispatch Area</label>
                                            <input id="dispatch_area" name="dispatch_area" type="text" class="form-control" placeholder="Enter Dispatch Area" value="{{ old('dispatch_area') }}"/>
                                            <p class="form-error-text" id="dispatch_area_error" style="color: red;"></p>
                                            @error('dispatch_area')
                                                <p class="form-error-text" style="color: red; margin-top: 10px;">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-2">
                                        <div class="form-group">
                                            <label for="country">Type</label>
                                            <select class="form-control form-select select" id="dispatch_area_type" name="dispatch_area_type" disabled>
                                                <option value="">Select Type</option>
                                                <option value="1" {{ old('dispatch_area_type') == '1' ? 'selected' : '' }}>Sq Feet</option>
                                                <option value="2" {{ old('dispatch_area_type') == '2' ? 'selected' : '' }}>CBM</option>
                                            </select>
                                            <p class="form-error-text" id="dispatch_area_type_error" style="color: red;"></p>
                                            @error('dispatch_area_type')
                                                <p class="form-error-text" style="color: red; margin-top: 10px;">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="receiving_area">Loading & Unloading</label>
                                            <input id="loading_unloading" name="loading_unloading" type="text" class="form-control" placeholder="Enter Loading & Unloading" value="{{ old('loading_unloading') }}"/>
                                            <p class="form-error-text" id="loading_unloading_error" style="color: red;"></p>
                                            @error('loading_unloading')
                                                <p class="form-error-text" style="color: red; margin-top: 10px;">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-2">
                                        <div class="form-group">
                                            <label for="country">Type</label>
                                            <select class="form-control form-select select" id="loading_unloading_type" name="loading_unloading_type" disabled>
                                                <option value="">Select Type</option>
                                                <option value="1" {{ old('loading_unloading_type') == '1' ? 'selected' : '' }}>Sq Feet</option>
                                                <option value="2" {{ old('loading_unloading_type') == '2' ? 'selected' : '' }}>CBM</option>
                                            </select>
                                            <p class="form-error-text" id="loading_unloading_type_error" style="color: red;"></p>
                                            @error('loading_unloading_type')
                                                <p class="form-error-text" style="color: red; margin-top: 10px;">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">

                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="storage_area">Storage Area</label>
                                            <input id="storage_area" name="storage_area" type="text" class="form-control" placeholder="Enter Storage Area" value="{{ old('storage_area') }}" readonly/>
                                            <p class="form-error-text" id="storage_area_error" style="color: red;"></p>
                                            @error('storage_area')
                                                <p class="form-error-text" style="color: red; margin-top: 10px;">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-2">
                                        <div class="form-group">
                                            <label for="country">Type</label>
                                            <select class="form-control form-select select" id="storage_area_type" name="storage_area_type" disabled>
                                                <option value="">Select Type</option>
                                                <option value="1" {{ old('storage_area_type') == '1' ? 'selected' : '' }}>Sq Feet</option>
                                                <option value="2" {{ old('storage_area_type') == '2' ? 'selected' : '' }}>CBM</option>
                                            </select>
                                            <p class="form-error-text" id="storage_area_type_error" style="color: red;"></p>
                                            @error('storage_area_type')
                                                <p class="form-error-text" style="color: red; margin-top: 10px;">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    

                                </div>
                                <div class="row">
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="receiving_area">Storage Capacity</label>
                                            <input id="storage_capacity" name="storage_capacity" type="text" class="form-control" placeholder="Enter Storage Capacity" value="{{ old('storage_capacity') }}"/>
                                            <p class="form-error-text" id="storage_capacity_error" style="color: red;"></p>
                                            @error('storage_capacity')
                                                <p class="form-error-text" style="color: red; margin-top: 10px;">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="receiving_area">Used Capacity</label>
                                            <input id="used_capacity" name="used_capacity" type="text" class="form-control" placeholder="Enter Used Capacity" value="{{ old('used_capacity') }}"/>
                                            <p class="form-error-text" id="used_capacity_error" style="color: red;"></p>
                                            @error('used_capacity')
                                                <p class="form-error-text" style="color: red; margin-top: 10px;">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="receiving_area">Available Capacity</label>
                                            <input id="available_capacity" name="available_capacity" type="text" class="form-control" placeholder="Enter Available Capacity" value="{{ old('available_capacity') }}"/>
                                            <p class="form-error-text" id="available_capacity_error" style="color: red;"></p>
                                            @error('available_capacity')
                                                <p class="form-error-text" style="color: red; margin-top: 10px;">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>


                            </div>

                            <div class="form-group" >
                                <input type="checkbox" id="partition_details" name="partition_details" onchange="partitionvisibility()" value="0">
                                <label for="partition_details"><b class="checkbox-color">Partition Details:</b></label>
                            </div>

                            <div id="partition_details_fields" class="hidden">

                                <div class="row">
                                    <div id="partition-wrapper">
                                         <div class="row partition-row">
                                            <div class="col-lg-10">
                                                <div class="row">
                                                    <div class="col-lg-3">
                                                        <div class="form-group">
                                                            <label>Position (Unit No.)</label>
                                                            <input name="position[]" id="position" type="text" class="form-control" placeholder="Enter Position (Unit No.)" />
                                                            <p class="form-error-text" style="color: red; margin-top: 10px;"></p>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <div class="form-group">
                                                            <label>Unit capacity in CBM</label>
                                                            <input name="unit_capacity_cbm[]" id="unit_capacity_cbm" type="text" class="form-control" placeholder="Enter Unit capacity in CBM" />
                                                            <p class="form-error-text" style="color: red; margin-top: 10px;"></p>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <div class="form-group">
                                                            <label>Level</label>
                                                            <select class="form-control form-select" id="level" name="level[]">
                                                                <option value="">Select Level</option>
                                                                <option value="1" {{ old('level') == '1' ? 'selected' : '' }}>Ground Level</option>
                                                                <option value="2" {{ old('level') == '2' ? 'selected' : '' }}>Mezzaninie Level</option>
                                                            </select>
                                                            <p class="form-error-text" style="color: red; margin-top: 10px;"></p>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <div class="form-group">
                                                            <label>Unit Area in CBM</label>
                                                            <input name="unit_area_cbm[]" id="unit_area_cbm" type="text" class="form-control" placeholder="Enter Unit capacity in CBM" />
                                                            <p class="form-error-text" style="color: red; margin-top: 10px;"></p>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <div class="form-group">
                                                            <label>Used Volume in CBM</label>
                                                            <input name="used_volume_cbm[]" id="used_volume_cbm" type="text" class="form-control" placeholder="Enter Used Volume in CBM" />
                                                            <p class="form-error-text" style="color: red; margin-top: 10px;"></p>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <div class="form-group">
                                                            <label>Mode</label>
                                                            <select class="form-control form-select" id="mode" name="partitionmode[]">
                                                                <option value="">Select Mode</option>
                                                                <option value="1" {{ old('mode') == '1' ? 'selected' : '' }}>Normal</option>
                                                            </select>
                                                            <p class="form-error-text" style="color: red; margin-top: 10px;"></p>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <div class="form-group">
                                                            <label>Max. Stack Height (CM/Meter)</label>
                                                            <input name="max_stack_height[]" id="max_stack_height" type="text" class="form-control" placeholder="Enter Max. Stack Height (CM/Meter)" />
                                                            <p class="form-error-text" style="color: red; margin-top: 10px;"></p>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <div class="form-group">
                                                            <label>Quantity</label>
                                                            <input name="quantity[]" id="quantity" type="text" class="form-control" placeholder="Enter Quantity" />
                                                            <p class="form-error-text" style="color: red; margin-top: 10px;"></p>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <div class="form-group">
                                                            <label>Unit Dimensions (L x W x H)</label>
                                                            <input name="unit_dimensions[]" id="unit_dimensions" type="text" class="form-control" placeholder="Enter Unit Dimensions (L x W x H)" />
                                                            <p class="form-error-text" style="color: red; margin-top: 10px;"></p>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <div class="form-group">
                                                            <label>Cost per cbm</label>
                                                            <input name="cost_per_cbm[]" id="cost_per_cbm" type="text" class="form-control" placeholder="Enter Cost per cbm" />
                                                            <p class="form-error-text" style="color: red; margin-top: 10px;"></p>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <div class="form-group">
                                                            <label>Cost per Sqft</label>
                                                            <input name="cost_per_sqft[]" id="cost_per_sqft" type="text" class="form-control" placeholder="Enter Cost per Sqft" />
                                                            <p class="form-error-text" style="color: red; margin-top: 10px;"></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-2 d-flex justify-content-center align-items-center">
                                                <i class="fas fa-plus-circle  add-row-partition" style="cursor: pointer; font-size: 24px;"></i>
                                            </div>

                                            <div class="col-lg-12">
                                                <hr>
                                            </div>

                                        </div>
                                        
                                    </div>                                    
                                </div>
                            </div>

                            <div class="form-group" >
                                <input type="checkbox" id="document_details" name="document_details" onchange="documentvisibility()" value="0">
                                <label for="document_details"><b class="checkbox-color">Document Details:</b></label>
                            </div>

                            <div id="document_details_fields" class="hidden">

                                <div id="inclusion-wrapper">
                                    <div class="row inclusion-row">
                                        <div class="col-lg-10">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label>Title</label>
                                                        <input name="title[]" id="doc_title" type="text" class="form-control" placeholder="Enter Title" />
                                                        <p class="form-error-text" style="color: red; margin-top: 10px;"></p>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label>Upload File</label>
                                                        <input type="file" id="upload_file" name="upload_file[]" class="form-control"
                                                placeholder="Enter Upload File" style="width: 102%;">
                                                        <p class="form-error-text" style="color: red; margin-top: 10px;"></p>
                                                    </div>
                                                </div>
                                                
                                            </div>
                                        </div>
                                        <div class="col-lg-2 d-flex justify-content-center align-items-center">
    <i class="fas fa-plus-circle  add-row-inclusion" style="cursor: pointer; font-size: 24px;"></i>
</div>

                                    </div>
                                </div>

                            </div>

                            <div class="form-group" >
                                <input type="checkbox" id="general_details" name="general_details" onchange="general_infovisibility()" value="0">
                                <label for="general_details"><b class="checkbox-color">General Details:</b></label>
                            </div>

                            <div id="general_details_fields" class="hidden">

                                <div class="row">
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="country">Status</label>
                                            <select class="form-control form-select select" id="status" name="status">
                                                <option value="">Select Status</option>
                                                <option value="Active" {{ old('status') == 'Active' ? 'selected' : '' }}>Active</option>
                                                <option value="Inactive" {{ old('status') == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                                               
                                            </select>
                                            <p class="form-error-text" id="status_error" style="color: red;"></p>
                                            @error('status')
                                                <p class="form-error-text" style="color: red; margin-top: 10px;">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="country">Created By</label>
                                            <input type="text" class="form-control" id="created_by" name="created_by"
                                                value="{{ Auth::user()->name }}" readonly>
                                            <p class="form-error-text" id="created_by_error" style="color: red;"></p>

                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="country">Last Modified Date</label>
                                            <input type="text" class="form-control" id="last_modified_date"
                                                name="last_modified_date" value="{{ date('Y-m-d')}}" readonly>
                                            <p class="form-error-text" id="last_modified_date_error" style="color: red;"></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="name">Description</label>
                                        <textarea id="description" name="description" class="form-control" cols="50" rows="6">{{ old('description') }}</textarea>
                                        <p class="form-error-text" id="description_error" style="color: red;"></p>
                                        @error('description')
                                                <p class="form-error-text" style="color: red; margin-top: 10px;">{{ $message }}</p>
                                            @enderror
                                    </div>
                                </div>
                            </div>
                            </div>

                            <div class="text-end mt-4">
                                <a class="btn btn-primary" href="{{  route('warehouse.lists') }}"> Cancel</a>
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

        $('#country').select2();
        //$('#level').select2();

        function category_validation() {
            var name = jQuery("#name").val();
            if (name == '') {
                jQuery('#name_error').html("Please Enter Name");
                jQuery('#name_error').show().delay(0).fadeIn('show');
                jQuery('#name_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#country').offset().top - 150
                }, 1000);
                return false;
            }

            var startDate = jQuery("#contract_start_date").val();
            var endDate = jQuery("#contract_end_date").val();

            // Clear previous errors
            jQuery('#contract_start_date_error').html('');
            jQuery('#contract_end_date_error').html('');

            if (startDate == '') {
                jQuery('#contract_start_date_error').html("Please select Contract Start Date");
                jQuery('#contract_start_date_error').show().delay(2000).fadeOut('slow');
                $('html, body').animate({
                    scrollTop: $('#contract_start_date').offset().top - 150
                }, 1000);
                return false;
            }

            if (endDate == '') {
                jQuery('#contract_end_date_error').html("Please select Contract End Date");
                jQuery('#contract_end_date_error').show().delay(2000).fadeOut('slow');
                $('html, body').animate({
                    scrollTop: $('#contract_end_date').offset().top - 150
                }, 1000);
                return false;
            }

            // Parse dates for comparison
            var start = new Date(startDate);
            var end = new Date(endDate);

            if (isNaN(start.getTime()) || isNaN(end.getTime())) {
                jQuery('#contract_end_date_error').html("Please enter valid dates");
                jQuery('#contract_end_date_error').show().delay(2000).fadeOut('slow');
                return false;
            }

            if (end < start) {
                jQuery('#contract_end_date_error').html("End Date must be after or equal to Start Date");
                jQuery('#contract_end_date_error').show().delay(2000).fadeOut('slow');
                $('html, body').animate({
                    scrollTop: $('#contract_end_date').offset().top - 150
                }, 1000);
                return false;
            }


            $('#spinner_button').show();
            $('#submit_button').hide();
            $('#category_form').submit();
        }

            $(function() {
                $('#contract_start_date').datepicker({
                    format: 'yyyy-mm-dd', // Set the desired date format yyyy-mm-dd
                    // autoclose: true,
                    todayHighlight: true
                });
                $('#contract_end_date').datepicker({
                    format: 'yyyy-mm-dd', // Set the desired date format yyyy-mm-dd
                    // autoclose: true,
                    todayHighlight: true
                });
            });

            function general_infovisibility() {
                const checkbox = document.getElementById('general_details');
                const container = document.getElementById('general_details_fields');
                if (checkbox.checked) {
                    container.classList.remove('hidden');
                } else {
                    container.classList.add('hidden');
                }
            }
            function documentvisibility() {
                const checkbox = document.getElementById('document_details');
                const container = document.getElementById('document_details_fields');
                if (checkbox.checked) {
                    container.classList.remove('hidden');
                } else {
                    container.classList.add('hidden');
                }
            }

            function capacityvisibility() {
                const checkbox = document.getElementById('capacity_details');
                const container = document.getElementById('capacity_details_fields');
                if (checkbox.checked) {
                    container.classList.remove('hidden');
                } else {
                    container.classList.add('hidden');
                }
            }
            function partitionvisibility() {
                const checkbox = document.getElementById('partition_details');
                const container = document.getElementById('partition_details_fields');
                if (checkbox.checked) {
                    container.classList.remove('hidden');
                } else {
                    container.classList.add('hidden');
                }
            }


            $(document).ready(function () {

        function updateIcons() {
            $('#inclusion-wrapper .inclusion-row').each(function (index, element) {
                let total = $('#inclusion-wrapper .inclusion-row').length;
                let icon = $(this).find('.col-lg-2 i');

                if (index === total - 1) {
                    icon.removeClass('fa-minus-circle text-danger remove-row-inclusion')
                        .addClass('fa-plus-circle  add-row-inclusion');
                } else {
                    icon.removeClass('fa-plus-circle  add-row-inclusion')
                        .addClass('fa-minus-circle text-danger remove-row-inclusion');
                }
            });
        }

    let editorCount = 1;
    let editorsMap = {};

        $('#inclusion-wrapper').on('click', '.add-row-inclusion', function () {
            let $clone = $(this).closest('.inclusion-row').clone();

            // Clear input values
            $clone.find('input').val('');
            $clone.find('textarea').val('');

            // Assign new unique ID to the textarea
            editorCount++;
            let newId = 'itinerary_detail_' + editorCount;
            let $textarea = $clone.find('textarea');
            $textarea.attr('id', newId);

            // Remove CKEditor DOM if cloned by mistake
            $textarea.siblings('.ck-editor').remove();

            $('#inclusion-wrapper').append($clone);

            // Initialize CKEditor on the new textarea (only once)
        

            updateIcons();
        });

        $('#inclusion-wrapper').on('click', '.remove-row-inclusion', function () {
            $(this).closest('.inclusion-row').remove();
            updateIcons();
        });

        updateIcons(); // Initial run
    });



        jQuery('#zip_post_code').on('keypress', function (e) {
            var charCode = (e.which) ? e.which : e.keyCode;
            if (charCode < 48 || charCode > 57) {
                e.preventDefault();
            }
        });

        jQuery('#zip_post_code').on('input', function () {
            this.value = this.value.replace(/[^0-9]/g, '');
        });

        $(document).ready(function () {
            allowDecimalOnly('#total_area');
            allowDecimalOnly('#maximum_stack_height');
            allowDecimalOnly('#pickup_area');
            allowDecimalOnly('#receiving_area');
            allowDecimalOnly('#dispatch_area');
            allowDecimalOnly('#loading_unloading');
            allowDecimalOnly('#storage_area');


            capacityCalculation('#total_area');
            capacityCalculation('#pickup_area');
            capacityCalculation('#receiving_area');
            capacityCalculation('#dispatch_area');
            capacityCalculation('#loading_unloading');
            capacityCalculation('#storage_area');
        });


        function allowDecimalOnly(selector) {
            $(document).on('input', selector, function () {
                var val = $(this).val();

                // Remove all characters except digits and dot
                var sanitized = val.replace(/[^0-9.]/g, '');

                // Keep only the first dot
                var parts = sanitized.split('.');
                if (parts.length > 2) {
                    sanitized = parts[0] + '.' + parts[1];
                }

                $(this).val(sanitized);
            });
        }

        function capacityCalculation(selector) {
            $(document).on('input', selector, function () {
                var total_area = parseFloat($('#total_area').val()) || 0;
                var pickup_area = parseFloat($('#pickup_area').val()) || 0;
                var receiving_area = parseFloat($('#receiving_area').val()) || 0;
                var dispatch_area = parseFloat($('#dispatch_area').val()) || 0;
                var loading_unloading = parseFloat($('#loading_unloading').val()) || 0;

                var storage_area_New = total_area - pickup_area - receiving_area - dispatch_area - loading_unloading ;
                $('#storage_area').val(storage_area_New.toFixed(2));
            });
        }

        $(document).ready(function() {
            $('#total_area_type').on('change', function() {
                let selectedValue = $(this).val();
                //alert("Selected value: " + selectedValue);

                // Apply the selected value to other dropdowns
                $('#pickup_area_type').val(selectedValue).trigger('change').prop('disabled', true);
                $('#receiving_area_type').val(selectedValue).trigger('change').prop('disabled', true);
                $('#dispatch_area_type').val(selectedValue).trigger('change').prop('disabled', true);
                $('#loading_unloading_type').val(selectedValue).trigger('change').prop('disabled', true);
                $('#storage_area_type').val(selectedValue).trigger('change').prop('disabled', true);
            });
        });


        $(document).ready(function () {

        function updateIconspartition() {
            $('#partition-wrapper .partition-row').each(function (index, element) {
                let total = $('#partition-wrapper .partition-row').length;
                let icon = $(this).find('.col-lg-2 i');

                if (index === total - 1) {
                    icon.removeClass('fa-minus-circle text-danger remove-row-partition')
                        .addClass('fa-plus-circle  add-row-partition');
                } else {
                    icon.removeClass('fa-plus-circle  add-row-partition')
                        .addClass('fa-minus-circle text-danger remove-row-partition');
                }
            });
        }

        let editorCount = 1;
        let editorsMap = {};

        $('#partition-wrapper').on('click', '.add-row-partition', function () {
            let $clone = $(this).closest('.partition-row').clone();

            // Clear input values
            $clone.find('input').val('');
            $clone.find('textarea').val('');

            // Assign new unique ID to the textarea
            editorCount++;
            let newId = 'itinerary_detail_' + editorCount;
            let $textarea = $clone.find('textarea');
            $textarea.attr('id', newId);

            // Remove CKEditor DOM if cloned by mistake
            $textarea.siblings('.ck-editor').remove();

            $('#partition-wrapper').append($clone);

            // Initialize CKEditor on the new textarea (only once)
        

            updateIconspartition();
        });

        $('#partition-wrapper').on('click', '.remove-row-partition', function () {
            $(this).closest('.partition-row').remove();
            updateIconspartition();
        });

        updateIconspartition(); // Initial run
    });
    </script>

   
@stop
