<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\admin\Vehicale;
use App\Models\admin\VehicalAttribute;
use Illuminate\Support\Facades\DB;

class VehicaleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $data['vehicales_data'] = Vehicale::orderBy('id','DESC')->get();
        return view('admin.list_vehicale',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['time_zone_data'] = DB::table('surveyor_time_zone')->orderBy('id','ASC')->get();
        return view('admin.add_vehicale',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        // Validate the form input
        // echo "<pre>";print_r($request->all());echo "</pre>";exit;
        $request->validate([
            'vehicle_name' => 'required|string|max:255',
            'vehicle_number' => 'required|string|max:255',
        ]);

        // If validation passes, store data
        $data['time_zone_id'] = '';
        if(isset($request->time_zone) && !empty($request->time_zone)){
            $data['time_zone_id'] = implode(',',$request->time_zone);
        }

        $vehicle = Vehicale::create([
                        'vehicle_name' => $request->vehicle_name,
                        'vehicle_number' => $request->vehicle_number,
                        'time_zone_id' => $data['time_zone_id'],
                    ]);
        
        $lastInsertedVehicleId = $vehicle->id;

        if (count($_POST['driver_name']) > 0 && $_POST['driver_name'] != '') {
            $countOfDriverName = count($_POST['driver_name']);
            for ($i = 0; $i < $countOfDriverName; $i++) {
                if($_POST['driver_name'][$i] != '')
                {
                    $content['vehicle_id'] = $lastInsertedVehicleId;
                    $content['driver_name'] = $_POST['driver_name'][$i];
                    $content['driver_email'] = $_POST['driver_email'][$i];
                    $content['driver_mobile_no'] = $_POST['driver_mobile_no'][$i];
                    $this->insert_attribute($content);
                }
            }
        }

        return redirect()->route('vehicles.index')->with('success', 'Vehicle added successfully!');
    }

    function insert_attribute($content)
    {
        $data['vehicle_id'] = $content['vehicle_id'];
        $data['driver_name'] = $content['driver_name'];
        $data['driver_email'] = $content['driver_email'];
        $data['driver_mobile_no'] = $content['driver_mobile_no'];
        VehicalAttribute::create($data);
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
        $data['vehicale_data']           = Vehicale::findorfail($id);
        $data['vehicale_attribute_data'] = VehicalAttribute::where('vehicle_id',$id)->get();
        $data['time_zone_data'] = DB::table('surveyor_time_zone')->orderBy('id','ASC')->get();
        return view('admin.edit_vehicale',$data);
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
        $request->validate([
            'vehicle_name' => 'required|string|max:255',
            'vehicle_number' => 'required|string|max:255',
        ]);

        $update['vehicle_name']   = $request->vehicle_name;
        $update['vehicle_number'] = $request->vehicle_number;
        if($request->time_zone != ''){
            $update['time_zone_id']   = implode(',',$request->time_zone);
        }else{
            $update['time_zone_id']   = NULL;
        }
        Vehicale::where('id',$id)->update($update);

        if (!empty($request->driver_name1)) {
            $countOfDriverName = count($request->driver_name1);
            for ($i = 0; $i < $countOfDriverName; $i++) {
                if($request->driver_name1[$i] != ''){
                    $content['vehicle_id'] = $id;
                    $content['driver_name'] = $request->driver_name1[$i];
                    $content['driver_email'] = $request->driver_email1[$i];
                    $content['driver_mobile_no'] = $request->driver_mobile_no1[$i];
                    $this->insert_attribute($content);
                }
            }
        }
        if (!empty($request->driver_nameu)) {
            $countOfDriverName = count($request->driver_nameu);
            for ($i = 0; $i < $countOfDriverName; $i++) {
                if($request->driver_nameu[$i] != ''){
                    $content['vehicle_id'] = $id;
                    $content['driver_name'] = $request->driver_nameu[$i];
                    $content['driver_email'] = $request->driver_emailu[$i];
                    $content['driver_mobile_no'] = $request->driver_mobile_nou[$i];
                    if (!empty($request->updateid1xxx[$i])) {
                        $content['id'] = $request->updateid1xxx[$i];
                        $this->update_attribute($content);
                    }
                }
            }
        }

        return redirect()->route('vehicles.index')->with('success', 'Vehicle updated successfully!');
    }

    function update_attribute($content){
        $data['vehicle_id'] = $content['vehicle_id'];
        $data['driver_name'] = $content['driver_name'];
        $data['driver_email'] = $content['driver_email'];
        $data['driver_mobile_no'] = $content['driver_mobile_no'];
        VehicalAttribute::where('id',$content['id'])->update($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $delete_id = $request->selected;
        Vehicale::whereIn('id',$delete_id)->delete();
        VehicalAttribute::whereIn('vehicle_id',$delete_id)->delete();
        return redirect()->route('vehicles.index')->with('success','Vehicle deleted successfully.');
    }

    public function remove_vehicle_attribute(Request $request){
        $vehicle_id = $request->vehicle_id;
        $id = $request->id;
        VehicalAttribute::where('vehicle_id', '=',$vehicle_id)->where('id', '=',$id)->delete();
        return redirect()->route('vehicles.edit',$vehicle_id)->with('success','Vehicle Attribute deleted successfully');
    }
}
