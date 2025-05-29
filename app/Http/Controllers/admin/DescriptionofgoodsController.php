<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;


class DescriptionofgoodsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['description_of_goods_data'] = DB::table('goods_description')->orderBy('id','DESC')->get();

        return view('admin.list_description_of_goods',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       
        return view('admin.add_description_of_goods');
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

        $data['name']=$request->description_of_goods_name;

        DB::table('goods_description')->insert($data);

       return redirect()->route('description-of-goods.index')->with('success','Description of goods added successfully.');

    
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
        $data['description_of_goods_data']= DB::table('goods_description')->orderBy('id','DESC')->first();

         //echo "<pre>"; print_r($data); echo "</pre>"; exit;

         return view('admin.edit_description_of_goods',$data);
    
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
        $data['name']=$request->description_of_goods_name;

        DB::table('goods_description')->where('id',$id)->update($data);

       return redirect()->route('description-of-goods.index')->with('success','Description of goods updated successfully.');

    

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

        DB::table('goods_description')->whereIn('id',$delete_id)->delete();

        return redirect()->route('description-of-goods.index')->with('success','Description of goods deleted successfully.');
    }
}