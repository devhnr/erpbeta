<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\admin\IndustryType;

class IndustryTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['industry_type_data'] = IndustryType::orderBy('id','DESC')->get();
        return view('admin.list-industry-type',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.add_industry_type');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $industryType = new IndustryType;
        $industryType->name = $request->name;
        $industryType->save();
        return redirect()->route('industry-type.index')->with('success','Industry type Added Successfully');
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
    public function edit(IndustryType $industryType)
    {
        return view('admin.edit_industry_type',compact('industryType'));
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
        $industryType = IndustryType :: find($id);
        $industryType->name = $request->name;
        $industryType->save();
        return redirect()->route('industry-type.index')->with('success','Industry type Updated Successfully');
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
        IndustryType::whereIn('id',$delete_id)->delete();
        return redirect()->route('industry-type.index')->with('success','Industry type deleted successfully.');
    }
}
