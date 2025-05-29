<?php
namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
class Title_RankController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['title_rank']= DB::table('title_rank')->orderBy('id','desc')->get();

        return view('admin.list_title_rank',$data);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('admin.add_title_rank');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $data['title_rank'] = $request->title_rank;

        DB::table('title_rank')->insert($data);

        return redirect()->route('title_rank.index')->with('success','Title Rank Added Successfully');
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
        $data['title_rank'] = DB::table('title_rank')->where('id' , '=' , $id)->first();

       return view('admin.edit_title_rank',$data);
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
        $data['title_rank'] = $request->title_rank;

        DB::table('title_rank')->where('id',$id)->update($data);

        return redirect()->route('title_rank.index')->with('success', 'Title Rank Updated Successfully');
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
        DB::table('title_rank')->whereIn('id',$delete_id)->delete();
        return redirect()->route('title_rank.index')->with('success','Title Rank  Deleted Successfully');
    }
}