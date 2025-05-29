<?php
namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
class Surveyor_TypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['surveyor_type_data']= DB::table('surveyor_type')->orderBy('id','desc')->get();

        return view('admin.list_surveyor_type',$data);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('admin.add_surveyor_type');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       
        $data['surveyor_type'] = $request->surveyor_type;

        DB::table('surveyor_type')->insert($data);

        return redirect()->route('surveyor_type.index')->with('success','Surveyor Type Added Successfully');
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
        $data['surveyor_type'] = DB::table('surveyor_type')->where('id' , '=' , $id)->first();

       return view('admin.edit_surveyor_type',$data);
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
        $data['surveyor_type'] = $request->surveyor_type;

        DB::table('surveyor_type')->where('id',$id)->update($data);

        return redirect()->route('surveyor_type.index')->with('success', 'Surveyor Type Updated Successfully');
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
        DB::table('surveyor_type')->whereIn('id',$delete_id)->delete();
        return redirect()->route('surveyor_type.index')->with('success','Surveyor Type Deleted Successfully');
    }
}