<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class ShipmentTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['shipment_type_data']=DB::table('shipment_type')->orderBy('id','DESC')->get();

        return view('admin.list_shipment_type',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.add_shipment_type');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data['name'] = $request->name;

        DB::table('shipment_type')->insert($data);

        return redirect()->route('shipment-type.index')->with('success','Shipment Type added successfully.');
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

        $shipment_type = DB::table('shipment_type')->Where('id' , '=' , $id)->first();

        return view('admin.edit_shipment_type',compact('shipment_type'));

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
        $data['name'] = $request->name;

        DB::table('shipment_type')->where('id',$id)->update($data);

        return redirect()->route('shipment-type.index')->with('success','Shipment Type updated successfully.');
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
      
    DB::table('shipment_type')->where('id', $delete_id)->delete();

    return redirect()->route('shipment-type.index')->with('success','Shipment Type deleted successfully.');
}

}