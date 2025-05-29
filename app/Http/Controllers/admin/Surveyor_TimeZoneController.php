<?php
namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
class Surveyor_TimeZoneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $data['surveyor_time_zone']= DB::table('surveyor_time_zone')->orderBy('id','desc')->get();

        return view('admin.list_surveyor_time_zone',$data);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.add_surveyor_time_zone');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       
        $data['time_zone'] = $request->time_zone;

        DB::table('surveyor_time_zone')->insert($data);

        return redirect()->route('surveyor_time_zone.index')->with('success','Surveyor Time Zone Added Successfully');
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
        $data['surveyor_time_zone'] = DB::table('surveyor_time_zone')->where('id' , '=' , $id)->first();

       return view('admin.edit_surveyor_time_zone',$data);
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
       $data['time_zone'] = $request->time_zone;

        DB::table('surveyor_time_zone')->where('id',$id)->update($data);

        return redirect()->route('surveyor_time_zone.index')->with('success', 'Surveyor Time Zone Updated Successfully');
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

        DB::table('surveyor_time_zone')->whereIn('id',$delete_id)->delete();

        return redirect()->route('surveyor_time_zone.index')->with('success','Surveyor Time Zone Deleted Successfully');
    }
}