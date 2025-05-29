<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\admin\Warehouse;
use App\Models\admin\Warehousepartition;
use Illuminate\Support\Facades\DB;
use Auth;


use Illuminate\Support\Facades\Validator;

class Warehousecontroller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = Warehouse::query();
        $warehouses = $query->orderBy('id', 'desc');

        $warehouses = $query->get();

        return view('admin.warehouse.list', compact('warehouses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['branch_data']= DB::table('branch')->get();
        $data['country_data']= DB::table('countries')->get();
        return view('admin.warehouse.add',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //echo "<pre>";print_r($request->all());echo "</pre>";exit;

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'contract_start_date' => 'required|date',
            'contract_end_date' => 'required|date|after_or_equal:contract_start_date',
            // 'branch' => 'required',
            // 'mode' => 'required',
            // 'warehouse_type' => 'required',
            // 'address' => 'required|string',
            // 'country' => 'required',
            // 'state' => 'required|string',
            // 'city' => 'required|string',
            // 'zip_post_code' => 'required|string',
            // Add more rules as needed
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput(); // sends back old inputs
        }

        $warehouse = new Warehouse();
        $warehouse->name = $request->name;
        $warehouse->contract_start_date = $request->contract_start_date;
        $warehouse->contract_end_date = $request->contract_end_date;
        $warehouse->branch = $request->branch;
        $warehouse->mode = $request->mode;
        $warehouse->warehouse_type = $request->warehouse_type;
        $warehouse->address = $request->address;
        $warehouse->country = $request->country;
        $warehouse->state = $request->state;
        $warehouse->city = $request->city;
        $warehouse->zip_post_code = $request->zip_post_code;
        $warehouse->status = $request->status; 
        $warehouse->created_by = Auth::user()->name; 
        $warehouse->last_modified_date = date('Y-m-d'); 
        $warehouse->description = $request->description; 
        $warehouse->created_at = now(); 
        $warehouse->updated_at = now(); 

        if($request->document_details != ''){
            $document_details  = '0';
        }else{
            $document_details  = '1';
        }
        $warehouse->document_details = $document_details;


        if($request->general_details != ''){
            $general_details  = '0';
        }else{
            $general_details  = '1';
        }
        $warehouse->general_details = $general_details;

        /* Capacity store code store start */
        if($request->capacity_details != ''){
            $capacity_details  = '0';
        }else{
            $capacity_details  = '1';
        }
        $warehouse->capacity_details = $capacity_details;
        $warehouse->total_area = $request->total_area;
        $warehouse->total_area_type = $request->total_area_type;
        $warehouse->maximum_stack_height = $request->maximum_stack_height;
        $warehouse->maximum_stack_height_type = $request->maximum_stack_height_type;
        $warehouse->pickup_area = $request->pickup_area;
        $warehouse->pickup_area_type = $request->total_area_type;
        $warehouse->receiving_area = $request->receiving_area;
        $warehouse->receiving_area_type = $request->total_area_type;
        $warehouse->dispatch_area = $request->dispatch_area;
        $warehouse->dispatch_area_type = $request->total_area_type;
        $warehouse->loading_unloading = $request->loading_unloading;
        $warehouse->loading_unloading_type = $request->total_area_type;
        $warehouse->storage_area = $request->storage_area;
        $warehouse->storage_area_type = $request->total_area_type;
        $warehouse->storage_capacity = $request->storage_capacity;
        $warehouse->used_capacity = $request->used_capacity;
        $warehouse->available_capacity = $request->available_capacity;
        /* Capacity store code store End */



        $warehouse->save();

        $documents = $request->file('upload_file');
        $titles    = $request->input('title');

        if(!empty($documents) && !empty($titles)){

            foreach ($titles as $key => $title) {

                if (isset($documents[$key])) {
                    $document = $documents[$key];

                    // Generate unique filename
                    $documentName = time() . '.' . $document->getClientOriginalName();
                    $document->move(public_path('upload/warehouse_documents'), $documentName);

                    // Save the document details in the database
                    DB::table('warehouse_documents')->insert([
                        'warehouse_id' => $warehouse->id,
                        'title' => $title,
                        'document' => $documentName,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }

        }

        /* Partitison store code store Start */

        $position             = $request->input('position');
        $unit_capacity_cbm    = $request->input('unit_capacity_cbm');
        $level                = $request->input('level');
        $unit_area_cbm        = $request->input('unit_area_cbm');
        $used_volume_cbm      = $request->input('used_volume_cbm');
        $mode                 = $request->input('partitionmode');
        $max_stack_height     = $request->input('max_stack_height');
        $quantity             = $request->input('quantity');
        $unit_dimensions      = $request->input('unit_dimensions');
        $cost_per_cbm         = $request->input('cost_per_cbm');
        $cost_per_sqft        = $request->input('cost_per_sqft');

        if(!empty($position)){

            $data_partition = [];

            foreach ($position as $key => $pos) {
                $data_partition[] = [
                    'warehouse_id'       => $warehouse->id,
                    'position'           => $pos,
                    'unit_capacity_cbm'  => $unit_capacity_cbm[$key] ?? null,
                    'level'              => $level[$key] ?? null,
                    'unit_area_cbm'      => $unit_area_cbm[$key] ?? null,
                    'used_volume_cbm'    => $used_volume_cbm[$key] ?? null,
                    'mode'               => $mode[$key] ?? null,
                    'max_stack_height'   => $max_stack_height[$key] ?? null,
                    'quantity'           => $quantity[$key] ?? null,
                    'unit_dimensions'    => $unit_dimensions[$key] ?? null,
                    'cost_per_cbm'       => $cost_per_cbm[$key] ?? null,
                    'cost_per_sqft'      => $cost_per_sqft[$key] ?? null,
                    'created_at'         => now(),
                    'updated_at'         => now(),
                ];

                //Warehousepartition::insert($data_partition);
            }
            Warehousepartition::insert($data_partition);

        }

        /* Partitison store code store End */

        

        
        return redirect()->route('warehouse.lists')->with('success', 'Warehouse created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
        $data['warehouse'] = Warehouse::findOrFail($id);
        $data['branch_data'] = DB::table('branch')->get();
        $data['country_data'] = DB::table('countries')->get();
        $data['warehouse_documents'] = DB::table('warehouse_documents')
            ->where('warehouse_id', $id)
            ->get();
        $data['warehouse_partition'] = Warehousepartition::where('warehouse_id', $id)->get();

        return view('admin.warehouse.edit', $data);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //echo "<pre>";print_r($request->all());echo "</pre>";exit;

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'contract_start_date' => 'required|date',
            'contract_end_date' => 'required|date|after_or_equal:contract_start_date',
            // 'branch' => 'required',
            // 'mode' => 'required',
            // 'warehouse_type' => 'required',
            // 'address' => 'required|string',
            // 'country' => 'required',
            // 'state' => 'required|string',
            // 'city' => 'required|string',
            // 'zip_post_code' => 'required|string',
            // Add more rules as needed
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput(); // sends back old inputs
        }
        $warehouse = Warehouse::findOrFail($id);
        $warehouse->name = $request->name;
        $warehouse->contract_start_date = $request->contract_start_date;
        $warehouse->contract_end_date = $request->contract_end_date;
        $warehouse->branch = $request->branch;
        $warehouse->mode = $request->mode;
        $warehouse->warehouse_type = $request->warehouse_type;
        $warehouse->address = $request->address;
        $warehouse->country = $request->country;
        $warehouse->state = $request->state;
        $warehouse->city = $request->city;
        $warehouse->zip_post_code = $request->zip_post_code;
        $warehouse->status = $request->status;
        $warehouse->last_modified_date = date('Y-m-d');
        $warehouse->description = $request->description;
        $warehouse->updated_at = now();
        $warehouse->created_by = Auth::user()->name;
        if($request->document_details != ''){
            $document_details  = '0';
        }else{
            $document_details  = '1';
        }
        $warehouse->document_details = $document_details;
        if($request->general_details != ''){
            $general_details  = '0';
        }else{
            $general_details  = '1';
        }
        $warehouse->general_details = $general_details;

        /* Capacity store code store start */
        if($request->capacity_details != ''){
            $capacity_details  = '0';
        }else{
            $capacity_details  = '1';
        }
        $warehouse->capacity_details = $capacity_details;
        $warehouse->total_area = $request->total_area;
        $warehouse->total_area_type = $request->total_area_type;
        $warehouse->maximum_stack_height = $request->maximum_stack_height;
        $warehouse->maximum_stack_height_type = $request->maximum_stack_height_type;
        $warehouse->pickup_area = $request->pickup_area;
        $warehouse->pickup_area_type = $request->total_area_type;
        $warehouse->receiving_area = $request->receiving_area;
        $warehouse->receiving_area_type = $request->total_area_type;
        $warehouse->dispatch_area = $request->dispatch_area;
        $warehouse->dispatch_area_type = $request->total_area_type;
        $warehouse->loading_unloading = $request->loading_unloading;
        $warehouse->loading_unloading_type = $request->total_area_type;
        $warehouse->storage_area = $request->storage_area;
        $warehouse->storage_area_type = $request->total_area_type;
        $warehouse->storage_capacity = $request->storage_capacity;
        $warehouse->used_capacity = $request->used_capacity;
        $warehouse->available_capacity = $request->available_capacity;
        /* Capacity store code store End */

        $warehouse->save();

        $documents = $request->file('upload_file');
        $titles = $request->input('title');
        if (!empty($documents) && !empty($titles)) {
            foreach ($titles as $key => $title) {
                if (isset($documents[$key])) {
                    $document = $documents[$key];

                    // Generate unique filename
                    $documentName = time() . '.' . $document->getClientOriginalName();
                    $document->move(public_path('upload/warehouse_documents'), $documentName);

                    // Save the document details in the database
                    DB::table('warehouse_documents')->insert([
                        'warehouse_id' => $warehouse->id,
                        'title' => $title,
                        'document' => $documentName,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }

        $document_ids = $request->input('document_id');
        $titles = $request->input('titleu');
        $documents = $request->file('upload_fileu');

        if (!empty($document_ids) && !empty($titles)) {
            foreach ($document_ids as $key => $doc_id) {
                $title = $titles[$key] ?? '';
                $document = $documents[$key] ?? null;

                // Prepare update data
                $updateData = [
                    'title' => $title,
                    'updated_at' => now(),
                ];

                // If a new file is uploaded
                if ($document) {
                    $documentName = time() . '_' . $document->getClientOriginalName();
                    $document->move(public_path('upload/warehouse_documents'), $documentName);
                    $updateData['document'] = $documentName;
                }

                // Update the database
                DB::table('warehouse_documents')
                    ->where('id', $doc_id)
                    ->update($updateData);
            }
        }

        /* Partitison store code store Start */

        $position             = $request->input('position');
        $unit_capacity_cbm    = $request->input('unit_capacity_cbm');
        $level                = $request->input('level');
        $unit_area_cbm        = $request->input('unit_area_cbm');
        $used_volume_cbm      = $request->input('used_volume_cbm');
        $mode                 = $request->input('partitionmode');
        $max_stack_height     = $request->input('max_stack_height');
        $quantity             = $request->input('quantity');
        $unit_dimensions      = $request->input('unit_dimensions');
        $cost_per_cbm         = $request->input('cost_per_cbm');
        $cost_per_sqft        = $request->input('cost_per_sqft');

        if(!empty($position)){

            $data_partition = [];

            foreach ($position as $key => $pos) {

                if(isset($position[$key])){
                    

                
                $data_partition[] = [
                    'warehouse_id'       => $warehouse->id,
                    'position'           => $pos,
                    'unit_capacity_cbm'  => $unit_capacity_cbm[$key] ?? null,
                    'level'              => $level[$key] ?? null,
                    'unit_area_cbm'      => $unit_area_cbm[$key] ?? null,
                    'used_volume_cbm'    => $used_volume_cbm[$key] ?? null,
                    'mode'               => $mode[$key] ?? null,
                    'max_stack_height'   => $max_stack_height[$key] ?? null,
                    'quantity'           => $quantity[$key] ?? null,
                    'unit_dimensions'    => $unit_dimensions[$key] ?? null,
                    'cost_per_cbm'       => $cost_per_cbm[$key] ?? null,
                    'cost_per_sqft'      => $cost_per_sqft[$key] ?? null,
                    'created_at'         => now(),
                    'updated_at'         => now(),
                ];

                

                }
            }

            Warehousepartition::insert($data_partition);


        }

        $positionu             = $request->input('positionu');
        $unit_capacity_cbmu    = $request->input('unit_capacity_cbmu');
        $levelu               = $request->input('levelu');
        $unit_area_cbmu        = $request->input('unit_area_cbmu');
        $used_volume_cbmu      = $request->input('used_volume_cbmu');
        $modeu                 = $request->input('partitionmodeu');
        $max_stack_heightu     = $request->input('max_stack_heightu');
        $quantityu             = $request->input('quantityu');
        $unit_dimensionsu      = $request->input('unit_dimensionsu');
        $cost_per_cbmu         = $request->input('cost_per_cbmu');
        $cost_per_sqftu        = $request->input('cost_per_sqftu');
        $partition_id_attr          = $request->input('partition_id_attr');

        //echo "<pre>";print_r($partition_id_attr);echo "</pre>";

        if (!empty($partition_id_attr)) {
            foreach ($partition_id_attr as $key => $pid) {
                Warehousepartition::where('id', $pid)->update([
                    'warehouse_id'       => $warehouse->id,
                    'position'           => $positionu[$key] ?? null,
                    'unit_capacity_cbm'  => $unit_capacity_cbmu[$key] ?? null,
                    'level'              => $levelu[$key] ?? null,
                    'unit_area_cbm'      => $unit_area_cbmu[$key] ?? null,
                    'used_volume_cbm'    => $used_volume_cbmu[$key] ?? null,
                    'mode'               => $modeu[$key] ?? null,
                    'max_stack_height'   => $max_stack_heightu[$key] ?? null,
                    'quantity'           => $quantityu[$key] ?? null,
                    'unit_dimensions'    => $unit_dimensionsu[$key] ?? null,
                    'cost_per_cbm'       => $cost_per_cbmu[$key] ?? null,
                    'cost_per_sqft'      => $cost_per_sqftu[$key] ?? null,
                    'updated_at'         => now(),
                ]);
            }
        }

        //exit;

        /* Partitison store code store End */


        return redirect()->route('warehouse.lists')->with('success', 'Warehouse updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request  $request)
    {
        $delete_id = $request->selected;
        if (!empty($delete_id)) {
            foreach ($delete_id as $id) {
                $warehouse = Warehouse::find($id);
                if ($warehouse) {
                    // Delete associated documents
                    $documents = DB::table('warehouse_documents')->where('warehouse_id', $id)->get();
                    foreach ($documents as $document) {
                        $filePath = public_path('upload/warehouse_documents/' . $document->document);
                        if (file_exists($filePath)) {
                            unlink($filePath);
                        }
                    }
                    DB::table('warehouse_documents')->where('warehouse_id', $id)->delete();

                    // Delete warehouse record
                    $warehouse->delete();
                }
            }
            return redirect()->route('warehouse.lists')->with('success', 'Warehouse deleted successfully.');
        } else {
            return redirect()->route('warehouse.lists')->with('error', 'Please select at least one warehouse to delete.');
        }
    }

    public function deleteDocument($id)
    {
        $document = DB::table('warehouse_documents')->where('id', $id)->first();

        if ($document) {
            // Delete file from storage
            $filePath = public_path('upload/warehouse_documents/' . $document->document);
            if (file_exists($filePath)) {
                unlink($filePath);
            }

            // Delete DB record
            DB::table('warehouse_documents')->where('id', $id)->delete();

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 404);
    }

    public function deletepartition($id)
    {
        $document = Warehousepartition::where('id', $id)->first();

        if ($document) {
            
            Warehousepartition::where('id', $id)->delete();

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 404);
    }
}
