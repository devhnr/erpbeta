<?php



namespace App\Http\Controllers\admin;



use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Models\User;

use App\Models\admin\UserPermission;

use Illuminate\Support\Facades\Hash;

use DB;





class Admin_userController extends Controller

{

    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function index()

    {

        $data['user_data'] = DB::table('users')->orderBy('id','DESC')->get();           

        return view('admin.list_admin_user',$data);

    }



    /**

     * Show the form for creating a new resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function create()

    {



        $user_data['user_category'] =UserPermission::get(); 

                      

        // $user_data['user_category'] =DB::table('users')->get();               

        return view('admin.add_admin_user',$user_data);

    }



    /**

     * Store a newly created resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @return \Illuminate\Http\Response

     */

    public function store(Request $request)

    {

       



        $data =new User;

        $data->role_id      = $request->user_id;

        $data->name      = $request->name;

        $data->user_name      = $request->user_name;

        $data->email      = $request->email;

        $data->password      = Hash::make($request->password);     

        $data->mobile      = $request->mobile;      

        

        

        $data->save();



      

        

        return redirect()->route('adminuser.index')->with('success','User added successfully.');

    }



    /**

     * Display the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function show()

    {

     

    }



    /**

     * Show the form for editing the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function edit($id)

    {     

        $adminuser = DB::table('users')->where('id' , '=' , $id)->first();       

        $data['user_category'] = DB::select('select * from user_permissions');

        return view('admin.edit_admin_user',compact('adminuser'),$data);

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

       

        

        $data = User::find($id);

        $data->role_id      = $request->user_id;

        $data->name      = $request->name;

        $data->user_name      = $request->user_name;

        $data->email      = $request->email;

        // $data->password      = $request->password;   
        if($request->password != ''){
            $data->password      = Hash::make($request->password);
        }
          

        $data->mobile      = $request->mobile; 

        

       

        

        

        $data->save();



        



        return redirect()->route('adminuser.index')->with('success','User Updated Successfully.');

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

        return redirect()->route('adminuser.index')->with('success','User Deleted Successfully.');

    }

}