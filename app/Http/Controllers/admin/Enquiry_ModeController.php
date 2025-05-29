<?php
namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
class Enquiry_ModeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['enquiry_mode']= DB::table('enquiry_mode')->orderBy('id','desc')->get();

        return view('admin.list_enquiry_mode',$data);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('admin.add_enquiry_mode');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $data['enquiry_mode'] = $request->enquiry_mode;

        DB::table('enquiry_mode')->insert($data);

        return redirect()->route('enquiry_mode.index')->with('success','Enquiry Mode Added Successfully');
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
        $data['enquiry_mode'] = DB::table('enquiry_mode')->where('id' , '=' , $id)->first();

       return view('admin.edit_enquiry_mode',$data);
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
        $data['enquiry_mode'] = $request->enquiry_mode;

        DB::table('enquiry_mode')->where('id',$id)->update($data);

        return redirect()->route('enquiry_mode.index')->with('success', 'Enquiry Mode Updated Successfully');
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
        DB::table('enquiry_mode')->whereIn('id',$delete_id)->delete();
        return redirect()->route('enquiry_mode.index')->with('success','Enquiry Mode Deleted Successfully');
    }
}