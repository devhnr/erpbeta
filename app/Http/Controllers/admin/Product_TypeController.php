<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;


class Product_TypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['product_type_data'] = DB::table('product_type')->orderBy('id','DESC')->get();

        return view('admin.list_product_type',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       
        return view('admin.add_product_type');
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

        $data['product_type']=$request->product_type;

        DB::table('product_type')->insert($data);

       return redirect()->route('product-type.index')->with('success','Product Type added successfully.');

    
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
        $data['product_type_data']= DB::table('product_type')->orderBy('id','DESC')->first();

         //echo "<pre>"; print_r($data); echo "</pre>"; exit;

         return view('admin.edit_product_type',$data);
    
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
        $data['product_type']=$request->product_type;

        DB::table('product_type')->where('id',$id)->update($data);

       return redirect()->route('product-type.index')->with('success','Product Type updated successfully.');

    

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

        DB::table('product_type')->whereIn('id',$delete_id)->delete();

        return redirect()->route('product-type.index')->with('success','Product Type deleted successfully.');
    }
}