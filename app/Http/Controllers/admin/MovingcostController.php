<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\admin\Movingcost;
use DB;

class MovingcostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['user_data']=DB::table('movingcosts')->orderBy('id','DESC')->get();

        return view('admin.list_movingcost',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user_data['user_category'] = Movingcost::get();

        return view('admin.add_movingcost',$user_data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $data = new Movingcost;

        // $data->name =$request->name;

        // $data->save();
        $data['name'] = $request->input('name');

        $id = DB::table('movingcosts')->insertGetId($data);

        $get_expense_inquiry = DB::table('expense_inquiry')->groupBy('inquiry_id')->get();

        if(isset($get_expense_inquiry)){
            foreach($get_expense_inquiry as $get_expense_inquiry_data){
                 // echo "<pre>";print_r($get_expense_inquiry_data);echo"</pre>";
                 $data_ex['inquiry_id'] = $get_expense_inquiry_data->inquiry_id;
                 $data_ex['movingcost_id'] = $id;
                 $data_ex['movingcost_value'] = "0";
                 $data_ex['movingcost_name'] = $data['name'];

                 DB::table('expense_inquiry')->insertGetId($data_ex);
            }
        }   

       //exit;

        return redirect()->route('movingcost.index')->with('success','Movingcost added successfully.');
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

        $movingcost = DB::table('movingcosts')->Where('id' , '=' , $id)->first();

        return view('admin.edit_movingcost',compact('movingcost'));

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
        $data= Movingcost::find($id);

        $data->name = $request->name;

        $data->save();

        return redirect()->route('movingcost.index')->with('success','Movingcost updated successfully.');
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
      
    // Delete movingcost
    DB::table('movingcosts')->where('id', $delete_id)->delete();

    // Delete related expense_inquiry data
    DB::table('expense_inquiry')->where('movingcost_id', $delete_id)->delete();

    return redirect()->route('movingcost.index')->with('success','Movingcost deleted successfully.');
}

}