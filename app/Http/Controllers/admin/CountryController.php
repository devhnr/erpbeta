<?php



namespace App\Http\Controllers\admin;



use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Models\admin\Country;



class CountryController extends Controller

{

    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function index()

    {

        $data['country_data']=Country::orderBy('id','desc')->get();

        return view('admin.list_country',$data);

    }



    /**

     * Show the form for creating a new resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function create()

    {

        return view('admin.add_country');

    }



    /**

     * Store a newly created resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @return \Illuminate\Http\Response

     */

    public function store(Request $request)

    {

        $country= new Country;

        $country->country=$request->country;

        

        $country->save();

        return redirect()->route('country.index')->with('success','Country Added Successfully');

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

    public function edit(Country $country)

    {

       return view('admin.edit_country',compact('country'));

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

        $country = Country::find($id);

        $country->country     = $request->country;

       

        $country->save();



        return redirect()->route('country.index')->with('success', 'Country Updated Successfully');

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

      

        Country::whereIn('id',$delete_id)->delete();

        return redirect()->route('country.index')->with('success','Country Deleted Successfully');

    }

}