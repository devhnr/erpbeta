<?php
namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\admin\Country;
use DB;
class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['branch_data']= DB::table('branch')->orderBy('id','desc')->get();

        return view('admin.list_branch',$data);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['country_data'] = DB::table('countries')->get();

        return view('admin.add_branch', $data);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data['country'] = $request->country;

        $data['branch'] = $request->branch;

        DB::table('branch')->insert($data);

        return redirect()->route('branch.index')->with('success','Branch Added Successfully');
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
        $data['branch'] = DB::table('branch')->where('id' , '=' , $id)->first();

        $data['country_data'] = Country::get();

       return view('admin.edit_branch',$data);
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
        $data['country'] = $request->country;
        $data['branch'] = $request->branch;

        DB::table('branch')->where('id',$id)->update($data);

        return redirect()->route('branch.index')->with('success', 'Branch Updated Successfully');
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
        DB::table('branch')->whereIn('id',$delete_id)->delete();
        return redirect()->route('branch.index')->with('success','Branch Deleted Successfully');
    }
}