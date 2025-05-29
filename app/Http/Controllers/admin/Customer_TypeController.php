<?php
namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
class Customer_TypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['customer_type']= DB::table('customer_type')->orderBy('id','desc')->get();

        return view('admin.list_customer_type',$data);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('admin.add_customer_type');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $data['customer_type'] = $request->customer_type;

        DB::table('customer_type')->insert($data);

        return redirect()->route('customer_type.index')->with('success','Customer Type Added Successfully');
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
        $data['customer_type'] = DB::table('customer_type')->where('id' , '=' , $id)->first();

       return view('admin.edit_customer_type',$data);
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
        $data['customer_type'] = $request->customer_type;

        DB::table('customer_type')->where('id',$id)->update($data);

        return redirect()->route('customer_type.index')->with('success', 'Customer Type Updated Successfully');
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
        DB::table('customer_type')->whereIn('id',$delete_id)->delete();
        return redirect()->route('customer_type.index')->with('success','Customer Type  Deleted Successfully');
    }
}