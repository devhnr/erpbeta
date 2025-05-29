<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;


class Source_of_ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['source_of_contact_data'] = DB::table('source_leads')->orderBy('id','DESC')->get();

        return view('admin.list_source_of_contact',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       
        return view('admin.add_source_of_contact');
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

        $data['name']=$request->name;

        DB::table('source_leads')->insert($data);

       return redirect()->route('source-of-contact.index')->with('success','Source Of Contact added successfully.');

    
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
        $data['source_of_contact_data']= DB::table('source_leads')->orderBy('id','DESC')->first();

         //echo "<pre>"; print_r($data); echo "</pre>"; exit;

         return view('admin.edit_source_of_contact',$data);
    
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
        $data['name']=$request->name;

        DB::table('source_leads')->where('id',$id)->update($data);

       return redirect()->route('source-of-contact.index')->with('success','Source Of Contact updated successfully.');

    

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

        DB::table('source_leads')->whereIn('id',$delete_id)->delete();

        return redirect()->route('source-of-contact.index')->with('success','Source Of Contact deleted successfully.');
    }
}