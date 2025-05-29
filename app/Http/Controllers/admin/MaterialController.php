<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\admin\Materials;
use App\Models\admin\Godown;
use App\Models\admin\MaterialAttribute;
use App\Models\admin\MaterialStocks;

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
            'in' => 'required|string',
        ]);

        $materialLastId = Materials::create([
            'name'=> $request->name,
             'materal_def'=>$request->in,
        ]);

        foreach($request->godown_id as $key => $value){

            if($request->price[$key] != "" && !empty($request->stock[$key])){

                $data['material_id'] = $materialLastId->id;
                $data['godown_id'] = $value;
                $data['stock'] = $request->stock[$key];
                $data['price'] = $request->price[$key];
                MaterialAttribute::create($data);
                MaterialStocks::create(['material_id' => $materialLastId->id, 'godown_id' => $value, 'stock' => $request->stock[$key]]);
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
        $material = Materials::with('attributes')->find($material->id);
        $data['MaterialAttribute'] = MaterialAttribute::where('material_id',$material->id)->get();
        $data['godown_data'] = Godown::whereNotIn('id', MaterialAttribute::where('material_id', $material->id)->pluck('godown_id'))->get();
        $data['material_stock'] = MaterialStocks::where('material_id',$material->id)->orderBy('id',"DESC")->value('stock');
        // echo "<pre>";print_r($material);echo "</pre>";exit;
        return view('admin.edit_material',compact('material'),$data);
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
            'in' => 'required|string',

        ]);

       $data = Materials::find($id);
       $data->name = $request->name;
       $data->materal_def = $request->in;
        $data->save();
        
    

        // for the update date
        if(!empty($request->update_id) && count($request->update_id) > 0){
            foreach ($request->update_id as $key => $updateId) {
                if (!empty($request->priceu[$key])) {
                    MaterialAttribute::where('id', $updateId)->update([
                        'godown_id' => $request->godown_idu[$key],
                        'price' => $request->priceu[$key],
                        'stock' => $request->stocku[$key],
                    ]);
                }
            }
        }

        // for the new data
        if(!empty($request->godown_id) && count($request->godown_id) > 0){

            foreach($request->godown_id as $key => $value){

                if($request->price[$key] != "" || !empty($request->stock[$key])){
    
                    $data['material_id'] = $id;
                    $data['godown_id'] = $value;
                    $data['stock'] = $request->stock[$key] ?? "";
                    $data['price'] = $request->price[$key] ?? "0.00";
                    MaterialAttribute::create($data);
                }
            }
        }
        
        return redirect()->route('materials.index')->with('success','Material Updated Successfully');
    }

    public function material_stock_store(Request $request)
    {

        
        $materialId = $request->material_id;
        $godownId = $request->godown_id;
        $newStock = $request->stock;
    
        // Fetch the latest stock entry
        $existingStock = MaterialAttribute::where('material_id', $materialId)
                            ->where('godown_id', $godownId)
                            ->orderBy('id', "DESC")
                            ->value('stock');

        // If there's no existing stock, assume it's 0
        $existingStock = $existingStock ?? 0;
    
        // Add new stock to existing stock
        $updatedStock = $existingStock + $newStock;
    
        // Update Material Attribute stock
        MaterialAttribute::where('id', $request->material_attribute_id)->update([
            'stock' => $updatedStock
        ]);
    
        // Insert the new stock record
        MaterialStocks::create([
            'material_id' => $materialId,
            'godown_id' => $godownId,
            'stock' => $newStock
        ]);
    
        return redirect()->route('materials.edit', $materialId)->with('success', 'Material Stock Updated Successfully');
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
