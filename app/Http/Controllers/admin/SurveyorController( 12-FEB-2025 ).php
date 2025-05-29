<?php
namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Auth;
class SurveyorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['surveyor_data']= DB::table('users')->where('role_id',7)->where('surveyor',1)->orderBy('id','desc')->get();
        return view('admin.list_surveyor',$data);
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

        return view('admin.add_surveyor',$data);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //echo"<pre>";print_r($request->all());echo"</pre>";exit;
        $data['role_id'] = 7;
        $data['name'] = $request->surveyor_name;
        $data['user_name']=$request->user_name;
        $data['password']=Hash::make ($request->password);
        $data['email']=$request->email;
        $data['mobile'] = $request->surveyor_mobile;
        $data['surveyor_add'] = $request->surveyor_add;
        $data['time_zone_id'] = implode(',',$request->time_zone);

        $data['surveyor'] = 1;

        // echo"<pre>";print_r($data);echo"</pre>";exit;
        DB::table('users')->insert($data);
        return redirect()->route('surveyor.index')->with('success','Surveyor Added Successfully');
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
        $data['surveyor'] = DB::table('users')->where('id' , '=' , $id)->first();

        $data['surveyor_time_zone'] = DB::table('surveyor_time_zone')->orderBy('id','ASC')->get();

        $data['permission_data'] = DB::table('user_permissions')->orderBy('id','DESC')->get();

        //  echo"<pre>";print_r($data['surveyor']);echo"</pre>";exit;


       return view('admin.edit_surveyor',$data);
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
        // echo"<pre>";print_r($request->all());echo"</pre>";exit;

        $data['role_id']=$request->hidden_role_id;
        $data['name'] = $request->surveyor_name;
        $data['user_name']=$request->user_name;
        $data['email'] = $request->email;
        $data['mobile'] = $request->surveyor_mobile;
        $data['surveyor_add'] = $request->surveyor_add;

        if($request->time_zone != ''){
        $data['time_zone_id'] = implode(',',$request->time_zone);
        }else{
            $data['time_zone_id'] = NULL;
        }

        // echo"<pre>";print_r($data);echo"</pre>";exit;

        DB::table('users')->where('id',$id)->update($data);

        return redirect()->route('surveyor.index')->with('success', 'Surveyor Updated Successfully');
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
        return redirect()->route('surveyor.index')->with('success','Surveyor Deleted Successfully');
    }
    function surveyor_check_mail(){

        $email = $_POST['email']; // Replace with the email you want to search for

        $result = DB::table('users')
            ->select('*')
            ->where('email', $email)
            ->first();

        if ($result) {
            return 1;
        } else {
            return 0;
        }

            echo $result;
    }
    function surveyor_edit_check_mail(){

        $email = $_POST['email'];
        $id = $_POST['id'];

        $result = DB::table('users')
            ->select('*')
            ->where('email', $email)
            ->where('id', '!=', $id) // Exclude user with ID 1
            ->first();

        if ($result) {
            return 1;
        } else {
            return 0;
        }

            echo $result;
    }
}
