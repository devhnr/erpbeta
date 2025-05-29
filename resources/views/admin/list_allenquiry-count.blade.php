@extends('admin.includes.Template')
@section('content')
    @php
        $userId = Auth::id();
    //
        $get_user_data = Helper::get_user_data($userId);
        $get_permission_data = Helper::get_permission_data($get_user_data->role_id);
        // echo"<pre>";print_r($get_user_data->role_id);echo"</pre>";exit;
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
    .folloup-modal { max-width: 670px !important; }

  .popup-content {
      word-wrap: break-word;
      white-space: normal; /* Ensures long text wraps to the next line */
  }

</style>

    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Enquiry Count</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active">Enquiry Count</li>
                    </ul>
                </div>

                @if (in_array('50', $add_perm) || in_array('50', $delete_perm))
                    <div class="col-auto">
                        {{-- <a class="btn btn-primary me-1" href="javascript:void('0');" onclick="excel_download();">Excel
                            Download</a> --}}
                        @if($get_user_data->role_id != '7')
                       
                        <a class="btn btn-primary filter-btn" href="javascript:void(0);" id="filter_search">
                            <i class="fas fa-filter"></i> Filter
                        </a>
                        
                        @endif
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
            if (!empty($salespersonsFilter))   {
                $displayCard = 'display:block';
            } else {
                $displayCard = 'display:none';
            }
        @endphp
        <div id="filter_inputs" class="card filter-card" style="@php echo $displayCard; @endphp">
            <div class="card-body pb-0">
                <form action="{{ route('allenquiry.allenquiry-count-filter') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-sm-6 col-md-10">
                            <div class="row">
                                
                                <div class="col-lg-10">
                                    <div class="form-group">
                                        <label>Sales Persons</label>
                                        <select name="salespersonsFilter" class="form-control">
                                            <option value="">-- Select Sales Persons --</option>
                                            
                                            @foreach($salesperson_data as $salesperson)
                                            <option value="{{ $salesperson->id }}" {{ $salespersonsFilter == $salesperson->id ? 'selected' : '' }}>{{ $salesperson->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                        <div class="col-sm-3 col-md-2" style="margin-top: 23px;">
                            <input class="btn btn-primary" value="Search" type="submit">
                            <a href="{{ route('allenquiry.count') }}" class="btn btn-primary">Reset</a>
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
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered mb-0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Status</th>
                                            <th>Count</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($statusCounts as $status => $count)
                                            <tr>
                                                <td>
                                                    {{ $status }}
                                                   {{-- @if(isset($statusRoutes[$status]))
                                                        <a href="{{ $statusRoutes[$status] }}">
                                                            {{ $status }}
                                                        </a>
                                                    @else
                                                        {{ $status }}
                                                    @endif --}}
                                                </td>
                                                <td>{{ $count }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>


@stop
@section('footer_js')
    
@stop
