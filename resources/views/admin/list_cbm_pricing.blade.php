@extends('admin.includes.Template')

@section('content')

    @php

        $userId = Auth::id();

        $get_user_data = Helper::get_user_data($userId);

        $get_permission_data = Helper::get_permission_data($get_user_data->role_id);

        $edit_perm = [];

        

        if ($get_permission_data->editperm != '') {

            $edit_perm = $get_permission_data->editperm;

            $edit_perm = explode(',', $edit_perm);

        }

        

    @endphp



    <div class="content container-fluid">



        <!-- Page Header -->

        <div class="page-header">

            <div class="row align-items-center">

                <div class="col">

                    <h3 class="page-title">CBM Pricing</h3>

                    <ul class="breadcrumb">

                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a>

                        </li>   

                        <li class="breadcrumb-item active">CBM Pricing</li>

                    </ul>

                </div>

                @if (in_array('29', $edit_perm))

                    <div class="col-auto">



                        {{-- <a class="btn btn-primary me-1" href="{{ route('cbm.create') }}">

                            <i class="fas fa-plus"></i> Add CBM Pricing

                        </a> --}}

                        {{-- <a class="btn btn-danger me-1" href="javascript:void('0');" onclick="delete_category();">

                            <i class="fas fa-trash"></i> Delete

                        </a> --}}

                        <!--  <a class="btn btn-primary filter-btn" href="javascript:void(0);" id="filter_search">
                                                                                                                                                                                                                                                                   </a> -->

                    </div>

                @endif

            </div>

        </div>

        <!-- /Page Header -->



        <!-- @if ($message = Session::get('success'))

    <div class="alert alert-success">

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

                        <form id="form" action="{{ route('cbm_pricing_store') }}" enctype="multipart/form-data" method="post">
                            @csrf
                            <INPUT TYPE="hidden" NAME="hidPgRefRan" VALUE="<?php echo rand(); ?>">

                            @csrf

                            <div class="table-responsive">

                                <table class="table table-bordered">
                                    <thead>
                                      <tr> 
                                        <th>Local Move</th>
                                        {{-- <th>CBM</th> --}}
                                            
                                        @foreach($cbm as $cbm_data)
                                        <input type="hidden" name="cbm_id[]" value="{{$cbm_data->id}}" >
                                            <th>{{$cbm_data->name}}</th>
                                        @endforeach
                                        
                                      </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $array_new = array();
                                        @endphp

                                        @foreach($service as $service_data)
                                        <input type="hidden" name="service_id[]" value="{{$service_data->id}}" >

                                        @php
                                            $array_new[] = $service_data->id;
                                        @endphp
                                      <tr>
                                        <td>{{$service_data->name}}</td>

                                        
                                     
                                        @foreach($cbm as $cbm_data)

                                        @php
                                      
                                            $price_data = DB::table('cbm_price')->where('service_id',$service_data->id)->where('cbm_id',$cbm_data->id)->first();

                                            if(isset($price_data)){
                                                $value = $price_data->cbm_value;
                                            }else{
                                                $value =0;
                                            }
                                                
                                        @endphp

                                            <td><input type="text" name="cbm_{{$service_data->id}}_{{$cbm_data->id}}" value="{{$value}}"></td>
                                        @endforeach
                                      </tr>
                                      @endforeach

                                      @php
                                        //echo"<pre>";print_r($array_new);echo"";exit;
                                      @endphp
                                      <tr>  
                                        <td><b>Total</b></td>
                                        @foreach($cbm as $cbm_data)

                                        @php
                                      
                                            $price_data = DB::table('cbm_price')
                                            ->where('cbm_id', $cbm_data->id)
                                            ->sum('cbm_value');

                                         @endphp
                                     
                                       
                                        <td><input type="text" name="cbm_total_{{$cbm_data->id}}" id="cbm_total_{{$cbm_data->id}}" value="{{$price_data}}" readonly></td>
                                        @endforeach
                                      </tr>
                                      <tr>  
                                        <td><b>Mark Up (%)</b> <br/>
                                            <input type="text" name="markup_percentage" id="markup_percentage" onchange="change(this.value);"value="10" >
                                        </td>
                                        @foreach($cbm as $cbm_data)

                                        @php
                                      
                                            $price_data = DB::table('cbm_price')
                                            ->where('cbm_id', $cbm_data->id)
                                            ->sum('cbm_value');

                                            $discount = $price_data *10/100;

                                         @endphp


                                        <td><input type="text" name="markup_{{$cbm_data->id}}" id="markup_{{$cbm_data->id}}" value="{{$discount}}" readonly></td>
                                        @endforeach
                                      </tr>
                                      <tr>  
                                        <td><b>Total Cost</b></td>
                                        @foreach($cbm as $cbm_data)

                                        @php
                                      
                                            $price_data = DB::table('cbm_price')
                                            ->where('cbm_id', $cbm_data->id)
                                            ->sum('cbm_value');

                                            $discount = $price_data *10/100;

                                            $total_cost = $price_data+ $discount;

                                         @endphp

                                        <td><input type="text" name="total_cost_{{$cbm_data->id}}" id="total_cost_{{$cbm_data->id}}" value="{{$total_cost}}" readonly></td>
                                        @endforeach
                                      </tr>

                                      <tr>  
                                        <td><b>Crew Req For job</b></td>
                                        @foreach($cbm as $cbm_data)

                                        <td><input type="text" name="crew_req_{{$cbm_data->id}}" id="crew_req_{{$cbm_data->id}}" value="{{$cbm_data->crew_req}}"></td>
                                        @endforeach
                                      </tr>

                                      <tr>  
                                        <td><b>Crew Every day</b></td>
                                        @foreach($cbm as $cbm_data)

                                        <td><input type="text" name="crew_day_{{$cbm_data->id}}" id="crew_day_{{$cbm_data->id}}" value="{{$cbm_data->crew_day}}"></td>
                                        @endforeach
                                      </tr>

                                      <tr>  
                                        <td><b>Truck</b></td>
                                        @foreach($cbm as $cbm_data)

                                        <td><input type="text" name="truck_{{$cbm_data->id}}" id="truck_{{$cbm_data->id}}" value="{{$cbm_data->truck}}"></td>
                                        @endforeach
                                      </tr>
                                      
                                      <tr>  
                                        <td><b>Days</b></td>
                                        @foreach($cbm as $cbm_data)

                                        <td><input type="text" name="day_{{$cbm_data->id}}" id="day_{{$cbm_data->id}}" value="{{$cbm_data->days}}"></td>
                                        @endforeach
                                      </tr>

                                      
                                      
                                    </tbody>
                                  </table>

                                <span style="float: left;"> </span>

                            </div>

                            <div class="text-end mt-4">

                                

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

    function category_validation(){

        $('#form').submit();
    }

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

    function change(val){

        <?php  foreach($cbm as $cbm_data){ ?>

             var total = $('#cbm_total_<?php echo $cbm_data->id ;?>').val();
             var discount = total * val/100;
             //alert(discount);
             var total_mark =parseFloat(total) + parseFloat(discount); 
             var total = $('#markup_<?php echo $cbm_data->id ;?>').val(discount);
             //alert(discount);

             var total = $('#total_cost_<?php echo $cbm_data->id ;?>').val(total_mark);

        <?php } ?>

            //alert(val);

    }
</script>





@stop