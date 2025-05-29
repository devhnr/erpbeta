<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\admin\Cbm;
use DB;

class CbmController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['user_data']=DB::table('cbms')->orderBy('id','DESC')->get();

        return view('admin.list_cbm',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user_data['user_category'] = Cbm::get();

        return view('admin.add_cbm',$user_data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = new Cbm;

        $data->name =$request->name;
        $data->crew_req =$request->crew_req;
        $data->crew_day =$request->crew_day;
        $data->truck =$request->truck;
        $data->days =$request->days;

        $data->save();

        return redirect()->route('cbm.index')->with('success','Cbm added successfully.');
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
       // echo $id;exit;
        $cbm = DB::table('cbms')->Where('id' , '=' , $id)->first();

        return view('admin.edit_cbm',compact('cbm'));
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
        $data= Cbm::find($id);

        $data->name = $request->name;
        $data->crew_req =$request->crew_req;
        $data->crew_day =$request->crew_day;
        $data->truck =$request->truck;
        $data->days =$request->days;


        $data->save();

        return redirect()->route('cbm.index')->with('success','Cbm updated successfully.');
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

        DB::table('cbms')->whereIn('id',$delete_id)->delete();

        return redirect()->route('cbm.index')->with('success','Cbm deleted successfully.');

    }
}
