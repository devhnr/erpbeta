<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Auth;

class MenPowerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['men_power_data']= DB::table('users')->where('role_id',15)->orderBy('id','desc')->get();
        return view('admin.list_men_power',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['surveyor_time_zone'] = DB::table('surveyor_time_zone')->orderBy('id','ASC')->get();
        $data['permission_data'] = DB::table('user_permissions')->orderBy('id','DESC')->get();
        // echo"<pre>";print_r($data['permission_data']);echo"</pre>";exit;
        return view('admin.add_men_power',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data['role_id'] = 15;
        $data['name'] = $request->surveyor_name;
        $data['user_name']=$request->user_name;
        $data['password']=Hash::make ($request->password);
        $data['email']=$request->email;
        $data['mobile'] = $request->surveyor_mobile;
        $data['surveyor_add'] = $request->surveyor_add;

        if(isset($request->time_zone) && !empty($request->time_zone)){
            $data['time_zone_id'] = implode(',',$request->time_zone);
        }


        $data['men_power'] = 1;

        // echo"<pre>";print_r($data);echo"</pre>";exit;
        DB::table('users')->insert($data);
        return redirect()->route('men-power.index')->with('success','Man Power has been Added Successfully');
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
        $data['menpower_data'] = DB::table('users')->where('id' , '=' , $id)->first();
        $data['surveyor_time_zone'] = DB::table('surveyor_time_zone')->orderBy('id','ASC')->get();
        $data['permission_data'] = DB::table('user_permissions')->orderBy('id','DESC')->get();
        return view('admin.edit_men_power',$data);
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
        $data['role_id']        = 15;
        $data['name']           = $request->surveyor_name;
        $data['user_name']      = $request->user_name;
        $data['email']          = $request->email;
        $data['mobile']         = $request->surveyor_mobile;
        $data['surveyor_add']   = $request->surveyor_add;

        if($request->time_zone != ''){
            $data['time_zone_id']   = implode(',',$request->time_zone);
        }else{
            $data['time_zone_id']   = NULL;
        }

        $data['men_power'] = 1;

        DB::table('users')->where('id',$id)->update($data);
        return redirect()->route('men-power.index')->with('success', 'Man Power has been Updated Successfully');
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
        DB::table('users')->whereIn('id',$delete_id)->delete();
        return redirect()->route('men-power.index')->with('success','Man Power has been Deleted Successfully');
    }
}
