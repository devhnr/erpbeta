<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\admin\Service;
use DB;


class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['service_data'] = DB::table('services')->orderBy('id','DESC')->get();
        return view('admin.list_service',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('admin.add_service');
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

        $service =new Service;
        $service->name                  = $request->name;
        $service->validity              = $request->validity;
        $service->cover_letter          = $request->cover_letter;
        $service->term_and_condittion   = $request->term_and_condittion;
        $service->price_include         = $request->price_include;
        $service->price_exclude         = $request->price_exclude;
        $service->insurances            = $request->insurances;
        $service->price_note            = $request->price_note;
        $service->payment_terms         = $request->payment_terms;
        $service->payment_options       = $request->payment_options;
        $service->save();
       return redirect()->route('service.index')->with('success','Service added successfully.');
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
    public function edit(Service $service)
    {
        $data['service_data']= Service::orderBy('id','DESC')->get();
        return view('admin.edit_service',compact('service'),$data);
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
        $service                        = Service :: find($id);
        $service->name                  = $request->name;
        $service->validity              = $request->validity;
        $service->cover_letter          = $request->cover_letter;
        $service->term_and_condittion   = $request->term_and_condittion;
        $service->price_include         = $request->price_include;
        $service->price_exclude         = $request->price_exclude;
        $service->insurances            = $request->insurances;
        $service->price_note            = $request->price_note;
        $service->payment_terms         = $request->payment_terms;
        $service->payment_options       = $request->payment_options;
        $service->save();
       return redirect()->route('service.index')->with('success','Service added successfully.');
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

        DB::table('services')->whereIn('id',$delete_id)->delete();

        return redirect()->route('service.index')->with('success','Service deleted successfully.');
    }
}
