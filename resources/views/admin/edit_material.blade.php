@extends('admin.includes.Template')
<style>
    .stock-popup-btn{
    /* display: block; */
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    font-size: 18px;
    /* border-radius: 50px; */
    box-shadow: 0px 2px 3px rgb(215 197 255);
    border: 1px solid #e6ebf1;
    color: #7638ff;
    margin: 5px;
}
.stock-parent-div{
    position: relative;
}
.stock-parent-div button{
    position: absolute;
    margin-top: -12%;
    margin-left: 85%;
}
</style>
@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Edit Material</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('materials.index') }}">Material</a></li>
                        <li class="breadcrumb-item active">Edit Material</li>
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

        <div id="validate" class="alert alert-danger alert-dismissible fade show" style="display: none;">
            <span id="login_error"></span>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form id="category_form" action="{{ route('materials.update', $material->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input id="name" name="name" type="text" class="form-control"
                                        placeholder="Enter Name" value="{{ $material->name }}" />
                                    <p class="form-error-text" id="name_error" style="color: red; margin-top: 10px;"></p>
                                </div>
                                </div>
                                <div class="col-md-6">
                                <div class="form-group">
                                    <label for="in">IN</label>
                                    <input id="in" name="in" type="text" class="form-control"
                                        placeholder="Enter in" value="{{$material->materal_def}}" />
                                    <p class="form-error-text" id="in_error" style="color: red; margin-top: 10px;"></p>
                                    @error('in')
                                    <p class="form-error-text" id="in_error" style="color: red; margin-top: 10px;">{{ $message }}</p>
                                    @enderror
                                </div>
                                </div>
                                @forelse($material->attributes as $godown)
                                <div class="form-group col-lg-4">
                                    @if ($loop->first)
                                        <label for="godown">Godown Name</label>
                                    @endif
                                    <input type="hidden" 
                                        name="update_id[]" 
                                        value="{{ $godown->id }}" 
                                        class="form-control"
                                        readonly
                                    />
                                    <input type="hidden" 
                                        name="godown_idu[]" 
                                        value="{{ $godown->godown_id }}" 
                                        class="form-control"
                                        readonly
                                    />
                                    <input type="text" 
                                        name="godown_name[]" 
                                        value="{{ Helper::getGodownName($godown->godown_id) }}" 
                                        class="form-control"
                                        readonly
                                    />
                                </div>
                                <div class="form-group col-lg-4 stock-parent-div">
                                    @if ($loop->first)
                                    <label for="stock">Stock</label>
                                    @endif
                                    <input type="text" 
                                        name="stocku[]" 
                                        {{-- value="{{ Helper::getMaterialStocks($material->id,$godown->godown_id) }}"  --}}
                                        value="{{ $godown->stock }}" 
                                        class="form-control"
                                        readonly
                                    />
                                    <button class="stock-popup-btn" type="button" onclick="stock_popup_form('{{ $godown->godown_id }}','{{ $godown->id }}');"><i class="ti-plus" data-bs-toggle="tooltip" title="Stock Add"></i></button>
                                </div>
                                <div class="form-group col-lg-4">
                                    @if ($loop->first)
                                    <label for="price">Price</label>
                                    @endif
                                    <input type="text" 
                                        name="priceu[]" 
                                        value="{{ $godown->price }}" 
                                        class="form-control"
                                    />
                                </div>
                                @empty
                                    @foreach($godown_data as $data)
                                    <div class="form-group col-lg-4">
                                        @if ($loop->first)
                                            <label for="godown">Godown Name</label>
                                        @endif
                                        <input type="hidden" 
                                            name="godown_id[]" 
                                            value="{{ $data->id }}" 
                                            class="form-control"
                                            readonly
                                        />
                                        <input type="text" 
                                            name="godown_name[]" 
                                            value="{{ $data->name }}" 
                                            class="form-control"
                                            readonly
                                        />
                                    </div>
                                    <div class="form-group col-lg-4">
                                        @if ($loop->first)
                                        <label for="stock">Stock</label>
                                        @endif
                                        <input type="text" 
                                            name="stock[]" 
                                            value="" 
                                            class="form-control"
                                        />
                                    </div>
                                    <div class="form-group col-lg-4">
                                        @if ($loop->first)
                                        <label for="price">Price</label>
                                        @endif
                                        <input type="text" 
                                            name="price[]" 
                                            value="" 
                                            class="form-control"
                                        />
                                    </div>
                                    @endforeach
                                @endforelse

                            @if (!empty($material->attributes) && count($material->attributes) > 0)

                                @foreach($godown_data as $data)
                                <div class="form-group col-lg-4">
                                    @if ($loop->first)
                                    @if (empty($material->attributes) && count($material->attributes) < 0)
                                        <label for="godown">Godown Name</label>
                                        @endif
                                    @endif
                                    <input type="hidden" 
                                        name="godown_id[]" 
                                        value="{{ $data->id }}" 
                                        class="form-control"
                                        readonly
                                    />
                                    <input type="text" 
                                        name="godown_name[]" 
                                        value="{{ $data->name }}" 
                                        class="form-control"
                                        readonly
                                    />
                                </div>
                                <div class="form-group col-lg-4">
                                    @if ($loop->first)
                                        @if (empty($material->attributes) && count($material->attributes) < 0)
                                        <label for="stock">Stock</label>
                                        @endif
                                    @endif
                                    <input type="text" 
                                        name="stock[]" 
                                        value="" 
                                        class="form-control"
                                    />
                                </div>
                                <div class="form-group col-lg-4">
                                    @if ($loop->first)
                                        @if (empty($material->attributes) && count($material->attributes) < 0)
                                        <label for="price">Price</label>
                                        @endif
                                    @endif
                                    <input type="text" 
                                        name="price[]" 
                                        value="" 
                                        class="form-control"
                                    />
                                </div>
                            @endforeach
                                
                            @endif
                                
                            </div>
                            <div class="text-end mt-4">
                                <a class="btn btn-primary" href="{{ route('materials.index') }}"> Cancel</a>
                                <button class="btn btn-primary mb-1" type="button" disabled id="spinner_button"
                                    style="display: none;">
                                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                    Loading...
                                </button>
                                <button type="button" class="btn btn-primary" id="submit_button"
                                    onclick="javascript:category_validation()">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal custom-modal fade" id="add_follow_up_model" role="dialog">
        <div class="modal-dialog modal-dialog-centered folloup-modal">
            <div class="modal-content">
                <form id="stock_form" action="{{ route('material-stock.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="inquiry_id" id="inquiry_id_follow">
                    <div class="modal-body">
                        <div class="modal-text text-center">
                            <h5>Stock</h5>
                        </div>
                        <div class="modal-text text-center" id="dropdownreplace">
                            <div class="row">
                                <div class="form-group col-md-12">
                                    {{-- <label for="name">Stock</label> --}}
                                    <input id="stock" name="stock" type="text" class="form-control"
                                        placeholder="Enter Stock" value=""/>

                                        <input type="hidden" name="material_id" value="{{ $material->id }}">
                                        <input type="hidden" name="godown_id" id="godown_id" value="">
                                        <input type="hidden" name="material_attribute_id" id="material_attribute_id" value="">
                                    <p class="form-error-text" id="stock_error" style="color: red;"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer text-center">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" onclick="stockForomSubmit();">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop
@section('footer_js')
    <script>
        function category_validation() {
            var name = jQuery("#name").val();
            if (name == '') {
                jQuery('#name_error').html("Please Enter Name");
                jQuery('#name_error').show().delay(0).fadeIn('show');
                jQuery('#name_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#name').offset().top - 150
                }, 1000);
                return false;
            }
            $('#spinner_button').show();
            $('#submit_button').hide();
            $('#category_form').submit();
        }

        function stock_popup_form(godownId,materialAttributeId) {
            $("#material_attribute_id").val(materialAttributeId);
            $("#godown_id").val(godownId);
            $('#add_follow_up_model').modal('show');
        }

        function stockForomSubmit(){
            var stock = jQuery("#stock").val();
            if (stock == '') {
                jQuery('#stock_error').html("Please Enter Stock");
                jQuery('#stock_error').show().delay(0).fadeIn('show');
                jQuery('#stock_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#stock').offset().top - 150
                }, 1000);
                return false;
            }
            $('#stock_form').submit();
        }
    </script>
@stop