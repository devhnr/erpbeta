<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;


class ServiceRequiredController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['service_required_data'] = DB::table('services_required')->orderBy('id','DESC')->get();

        return view('admin.list_service_required',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       
        return view('admin.add_service_required');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    //    echo "<pre>"; print_r($request->post()); echo "</pre>"; exit;

        $data['name']=$request->service_required_name;

        DB::table('services_required')->insert($data);

       return redirect()->route('services-required.index')->with('success','Service Required added successfully.');

    
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
        $data['service_required_data']= DB::table('services_required')->orderBy('id','DESC')->first();

         //echo "<pre>"; print_r($data); echo "</pre>"; exit;

         return view('admin.edit_service_required',$data);
    
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
        $data['name']=$request->service_required_name;

        DB::table('services_required')->where('id',$id)->update($data);

       return redirect()->route('services-required.index')->with('success','Service Required updated successfully.');

    

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

        DB::table('services_required')->whereIn('id',$delete_id)->delete();

        return redirect()->route('services-required.index')->with('success','Service Required deleted successfully.');
    }
}