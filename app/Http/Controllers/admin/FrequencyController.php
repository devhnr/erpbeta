<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\admin\Frequency;

class FrequencyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['frequency_data'] = Frequency::orderBy('id','DESC')->get();
        return view('admin.list-frequency',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.add-frequency');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $frequencyObj = new Frequency;
        $frequencyObj->name = $request->name;
        $frequencyObj->save();
        return redirect()->route('frequencies.index')->with('success','Frequency Added Successfully');
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
    public function edit(Frequency $frequency)
    {
        // $frequency = Frequency::find($id);
        return view('admin.edit-frequency',compact('frequency'));
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
        $frequencyObj = Frequency::find($id);
        $frequencyObj->name = $request->name;
        $frequencyObj->save();
        return redirect()->route('frequencies.index')->with('success','Frequency Updated Successfully');
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
        Frequency::whereIn('id',$delete_id)->delete();
        return redirect()->route('frequencies.index')->with('success','Frequency deleted successfully.');
    }
}
