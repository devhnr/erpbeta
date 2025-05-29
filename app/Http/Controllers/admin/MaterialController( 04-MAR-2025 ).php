<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\admin\Materials;
use App\Models\admin\Godown;
use App\Models\admin\MaterialAttribute;

class MaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['materials_data'] = Materials::orderBy('id','desc')->get();
        return view('admin.list_material',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $data['godown_data'] = Godown::all();
        return view('admin.add_material',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         // echo "<pre>";print_r($request->all());echo "</pre>";exit;
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $materialLastId = Materials::create(['name'=> $request->name]);

        foreach($request->godown_id as $key => $value){

            if($request->price[$key] != "" && !empty($request->stock[$key])){

                $data['material_id'] = $materialLastId->id;
                $data['godown_id'] = $value;
                $data['stock'] = $request->stock[$key];
                $data['price'] = $request->price[$key];
                MaterialAttribute::create($data);
            }
        }
        return redirect()->route('materials.index')->with('success','Material Added Successfully');
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
    public function edit(Materials $material)
    {
        return view('admin.edit_material',compact('material'));
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
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $data['name'] = $request->name;
        Materials::find($id)->update($data);
        return redirect()->route('materials.index')->with('success','Material Updated Successfully');
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
        Materials::whereIn('id',$delete_id)->delete();
        return redirect()->route('materials.index')->with('success','Material deleted successfully.');
    }
}
