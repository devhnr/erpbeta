<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\admin\ApprovedAgents;

class ApprovedAgentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['approved_agent_data'] = ApprovedAgents::orderBy('id','DESC')->get();
        return view('admin.list-approved-agent',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.add-approved-agent');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $approvedAgents = new ApprovedAgents;
        $approvedAgents->name = $request->name;
        $approvedAgents->save();
        return redirect()->route('approved-agents.index')->with('success','Approved Agents Added Successfully');
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
    public function edit(ApprovedAgents $approved,$id)
    {
        $approvedAgents = ApprovedAgents::find($id);
        return view('admin.edit-approved-agent',compact('approvedAgents'));
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
        $approvedAgents = ApprovedAgents::find($id);
        $approvedAgents->name = $request->name;
        $approvedAgents->save();
        return redirect()->route('approved-agents.index')->with('success','Approved Agents Updated Successfully');
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
        ApprovedAgents::whereIn('id',$delete_id)->delete();
        return redirect()->route('approved-agents.index')->with('success','Approved Agents deleted successfully.');
    }
}
