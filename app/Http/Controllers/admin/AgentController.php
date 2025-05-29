<?php
namespace App\Http\Controllers\admin;
use Illuminate\Support\Facades\Auth;
use App\Models\admin\Agent;
use App\Imports\AgentImport;
use Illuminate\Http\Request;
use App\Models\admin\Country;
use App\Models\admin\Service;
use App\Models\admin\Reference;
use App\Models\admin\Source_lead;
use App\Models\admin\IndustryType;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Response;
use App\Models\admin\ApprovedAgents;

class AgentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
  public function index(Request $request)
{

    $userdata = Auth::user();
    //echo "<pre>";print_r(auth::user()['name']);echo "</pre>";exit;
    $country = $request->countryname;
    $query = DB::table('agents');
    if($country != ''){
        $query = $query->where('country',$country);
    }
    
    if($userdata->role_id != 1){
        $query = $query->where('sales_person',$userdata->id);
    }

    $data['filter_country_id'] = $country;
    $data['country_data']=DB::table('countries')->get();
    $data['agent_data']  = $query->orderBy('id','DESC')->get();
     // Debugging
    //echo "<pre>";print_r($data['agent_data']);echo "</pre>";exit;
    // Fetch attributes for each agent
    $data['attribute_data'] = [];
    foreach ($data['agent_data'] as $agent) {
        $attributes = DB::table('agents_attribute')
            ->where('agent_id', '=', $agent->id)
            ->get()
            ->toArray();
    // Store attributes for each agent
    $data['attribute_data'][$agent->id] = $attributes;
    }
    return view('admin.list_agent', $data);
}
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        
        $data['agent_data'] = Agent::get();
        $data['country_data'] = Country::get();
        $data['branch_data']= DB::table('branch')->get();
        // $data['salesman_data']=DB::table('users')->Where('id','!=', 1)->get();
        $data['salesman_data']=DB::table('users')->Where('role_id','=', 7)->where('surveyor','=',NULL)->get();
        $data['agent_data'] = DB::table('agent_type')->get();
        $data['industry_type_data'] = IndustryType::all();
        $data['reference_data'] = Reference::all();
        $data['approved_agent_data'] = ApprovedAgents::all();
        return view('admin.add_agent',$data);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // echo "<pre>";print_r($request->all());echo "</pre>";exit;

        $data['agent_type']      = $request->agent_type;
        $data['company_name']      = $request->company_name;
        $data['url']      = $request->url;

        if($request->agent_type == 1){
            $data['industry_type']      = $request->company_role;
        }else{
            $data['industry_type']      = $request->industry_type;
        }

        $data['branch']      = $request->branch;
        $data['phone']      = $request->phone;
        $data['others']      = $request->others;
        $data['company_email']      = $request->company_email;
        $data['company_telephone']      = $request->company_telephone;
        $data['no_of_emp']      = $request->no_of_emp;
        $data['parent_company']     = $request->parent_company;
        $data['annual_revenue']      = $request->annual_revenue;
        $data['company_vat_num']      = $request->company_vat_num;

        $data['years_in_business']      = $request->years_in_business;
        if($request->toggleFields != ''){
            $data['toggleFields']      = '0';
        }else{
            $data['toggleFields']      = '1';
        }
        $data['address']      = $request->address;
        $data['address_for_arabic']      = $request->address_for_arabic;
        $data['country']      = $request->country;
        $data['state']      = $request->state;
        $data['city']      = $request->city;
        $data['z_code']      = $request->z_code;
        if($request->primary_add != ''){
            $data['primary_add']      = '0';
        }else{
            $data['primary_add']      = '1';
        }
        $data['state_code']      = $request->state_code;
        if($request->details != ''){
            $data['details']      = '0';
        }else{
            $data['details']      = '1';
        }
        $data['add_details']      = $request->add_details;
        $data['subsidiary']      = $request->subsidiary;
        $data['trn_no']      = $request->trn_no;
        if($request->contracts != ''){
            $data['contracts']      = '0';
        }else{
            $data['contracts']      = '1';
        }
        $data['name_contracts']      = $request->name_contracts;
        if($request->contact_fields != ''){
            $data['contact_fields']      = '0';
        }else{
            $data['contact_fields']      = '1';
        }
        if($request->bank_details != ''){
            $data['bank_details']      = '0';
        }else{
            $data['bank_details']      = '1';
        }
        $data['ac_title']      = $request->ac_title;
        $data['iban']      = $request->iban;
        $data['ac_num']      = $request->ac_num;
        $data['bic']      = $request->bic;
        $data['swift']      = $request->swift;
        $data['bank']      = $request->bank;
        $data['branch_code']      = $request->branch_code;
        $data['branch_name']      = $request->branch_name;
        if($request->acc_type != ''){
            $data['acc_type']      = '0';
        }else{
            $data['acc_type']      = '1';
        }
        $data['acc_type_name']      = $request->acc_type_name;
        if($request->tax_exception != ''){
            $data['tax_exception']      = '0';
        }else{
            $data['tax_exception']      = '1';
        }
        $data['tax_exception_name']      = $request->tax_exception_name;
        if($request->general_info != ''){
            $data['general_info']      = '0';
        }else{
            $data['general_info']      = '1';
        }
        if($request->RMC_agent != ''){
            $data['RMC_agent']      = '0';
        }else{
            $data['RMC_agent']      = '1';
        }
        $data['reference']      = $request->reference;
        $data['active_inactive']      = $request->active_inactive;
        $data['grade']      = $request->grade;
        // $data['sales_person']      = $request->sales_person;
        if($request->sales_person != ''){
            $data['sales_person']      = $request->sales_person;
        }else{
            $data['sales_person']      = '0';
        }
        $data['create_by']      = $request->create_by;
        $data['modified_by']      = $request->modified_by;
        $data['desc']      = $request->desc;
        if($request->credit_term != ''){
            $data['credit_term']      = '0';
        }else{
            $data['credit_term']      = '1';
        }
        $data['credit_desc']      = $request->credit_desc;
        $data['limit_aed']      = $request->limit_aed;
        $data['period_days']      = $request->period_days;

        /* Checkboxes value store condition */
        $data['trade_license'] = $request->trade_license != '' ? '0' : '1';
        $data['vat_certificate'] = $request->vat_certificate != '' ? '0' : '1';
        $data['eid'] = $request->eid != '' ? '0' : '1';
        $data['passport_visa_copies'] = $request->passport_visa_copies != '' ? '0' : '1';

        $data['trade_license_expiry_date']      = $request->trade_license_expiry_date ?? '0000-00-00';
        $data['eid_expiry_date']      = $request->eid_expiry_date ?? '0000-00-00';

        if ($request->file('trade_license_file') != '') {
            $trade_license_file = $request->file('trade_license_file');

            // Generate a unique filename
            $data['trade_license_file'] = time() . '_' . $trade_license_file->getClientOriginalName();

            // Define the destination path
            $destinationPath = public_path('upload/trade-license');

            // Move the uploaded trade_license_file to the specified path
            $trade_license_file->move($destinationPath, $data['trade_license_file']);

        }else{
            $data['trade_license_file'] = "";
        }

        if ($request->file('vat_certificate_file') != '') {
            $vat_certificate_file = $request->file('vat_certificate_file');

            // Generate a unique filename
            $data['vat_certificate_file'] = time() . '_' . $vat_certificate_file->getClientOriginalName();

            // Define the destination path
            $destinationPath = public_path('upload/vat-certificate');

            // Move the uploaded trade_license_file to the specified path
            $vat_certificate_file->move($destinationPath, $data['vat_certificate_file']);

        }else{
            $data['vat_certificate_file'] = "";
        }
        if ($request->file('eid_file') != '') {
            $eid_file = $request->file('eid_file');

            // Generate a unique filename
            $data['eid_file'] = time() . '_' . $eid_file->getClientOriginalName();

            // Define the destination path
            $destinationPath = public_path('upload/eid');

            // Move the uploaded trade_license_file to the specified path
            $eid_file->move($destinationPath, $data['eid_file']);

        }else{
            $data['eid_file'] = "";
        }
        if ($request->file('passport_visa_copies_file') != '') {
            $passport_visa_copies_file = $request->file('passport_visa_copies_file');

            // Generate a unique filename
            $data['passport_visa_copies_file'] = time() . '_' . $passport_visa_copies_file->getClientOriginalName();

            // Define the destination path
            $destinationPath = public_path('upload/passport-visa-copies');

            // Move the uploaded trade_license_file to the specified path
            $passport_visa_copies_file->move($destinationPath, $data['passport_visa_copies_file']);

        }else{
            $data['passport_visa_copies_file'] = "";
        }
        // echo "<pre>";print_r($data);echo"</pre>";exit;
        // $data->save();

        if($request->agent_type == 1){
            $organizeType = "AG";
        }elseif($request->agent_type == 3){
            $organizeType = "COR";
        }
        $currentYear = date('Y');
        $data['added_date'] = date("Y-m-d");
        $data['approved_agent_id']      = $request->approved_agent_id ?? 0;

        $userId = Auth::id();

        $data['created_by'] = $userId;
        $agent_id = DB::table('agents')->insertGetId($data);

        $agentidFormat = sprintf('%02d', $agent_id);
        $data_update['organization_id']  = "QSR-".$organizeType."-".$currentYear."-".$agentidFormat;
        DB::table('agents')->where('id',$agent_id)->update($data_update);

        // echo "<pre>";print_r($agent_id);echo"</pre>";exit;
        if (count($_POST['name']) > 0 && $_POST['name'] != '') {
            for ($i = 0; $i < count($_POST['name']); $i++) {
                if($_POST['name'][$i] != '')
                {
                    $content['agent_id'] = $agent_id;
                    $content['name'] = $_POST['name'][$i];
                    $content['email'] = $_POST['email'][$i];
                    $content['telephone'] = $_POST['telephone'][$i];
                    $content['role'] = $_POST['role'][$i];
                    $this->insert_attribute($content);
                }
            }
        }
        return redirect()->route('agent.index')->with('success','Organization added successfully.');
    }
    function insert_attribute($content)
    {
        $data['agent_id'] = $content['agent_id'];
        $data['name'] = $content['name'];
        $data['email'] = $content['email'];
        $data['telephone'] = $content['telephone'];
        $data['role'] = $content['role'];
        DB::table('agents_attribute')->insertGetId($data);
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
        $data['agent'] = DB::table('agents')->where('id' , '=' , $id)->first();
        $data['country_data'] = Country::get();
        $data['branch_data']= DB::table('branch')->get();
        $data['agent_data'] = DB::table('agent_type')->get();
        // $data['salesman_data']=DB::table('users')->Where('id','!=', 1)->get();
        $data['salesman_data']=DB::table('users')->Where('role_id','=', 7)->where('surveyor','=',NULL)->get();
        $data['attribute_data'] = DB::table('agents_attribute')
        ->select('*')
        ->where('agent_id', '=',$data['agent']->id)
        ->get()
        ->toArray();
        // echo'<pre>';
        // print_r($data['agent']);
        // echo '</pre>';exit;
        $data['industry_type_data'] = IndustryType::all();
        $data['reference_data'] = Reference::all();
        $data['approved_agent_data'] = ApprovedAgents::all();
        return view('admin.edit_agent',$data);
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
        // $data = Agent::find($id);
        // echo "<pre>";print_r($request->all());echo "</pre>";exit;
        $data['agent_type']        = $request->agent_type;
        $data['company_name']      = $request->company_name;
        $data['url']               = $request->url;

        if($request->agent_type == 1){
            $data['industry_type']      = $request->company_role;
        }else{
            $data['industry_type']      = $request->industry_type;
        }

        $data['branch']            = $request->branch;
        $data['phone']             = $request->phone;
        $data['others']            = $request->others;
        $data['company_email']     = $request->company_email;
        $data['company_telephone'] = $request->company_telephone;
        $data['no_of_emp']         = $request->no_of_emp;

        $data['annual_revenue']    = $request->annual_revenue;
        $data['parent_company']      = $request->parent_company;
        $data['company_vat_num']      = $request->company_vat_num;
        $data['approved_agent_id']      = $request->approved_agent_id ?? 0;

       /*  if($request->agent_type != 3){
            $data['p_o_c_full']      = $request->p_o_c_full;
            $data['p_o_c_position_title']      = $request->p_o_c_position_title;
            $data['company_role']      = $request->company_role;
            $data['approved_agent']      = $request->approved_agent;
            $data['approved_by']      = $request->approved_by;
            $data['company_payment_terms']      = $request->company_payment_terms;

            $data['bill_company_through']      = $request->bill_company_through;
            $data['client_source']      = $request->client_source;
             $data['head_office']       = $request->head_office;

        } */


        $data['years_in_business']      = $request->years_in_business;
        if($request->toggleFields != ''){
            $data['toggleFields']      = '0';
        }else{
            $data['toggleFields']      = '1';
        }
        $data['address']      = $request->address;
        $data['address_for_arabic']      = $request->address_for_arabic;
        $data['country']      = $request->country;
        $data['state']      = $request->state;
        $data['city']      = $request->city;
        $data['z_code']      = $request->z_code;
        if($request->primary_add != ''){
            $data['primary_add']      = '0';
        }else{
            $data['primary_add']      = '1';
        }
        $data['state_code']      = $request->state_code;
        if($request->details != ''){
            $data['details']      = '0';
        }else{
            $data['details']      = '1';
        }
        $data['add_details']      = $request->add_details;
        $data['subsidiary']      = $request->subsidiary;
        $data['trn_no']      = $request->trn_no;
        if($request->contracts != ''){
            $data['contracts']      = '0';
        }else{
            $data['contracts']      = '1';
        }
        $data['name_contracts']      = $request->name_contracts;
        if($request->contact_fields != ''){
            $data['contact_fields']      = '0';
        }else{
            $data['contact_fields']      = '1';
        }
        if($request->bank_details != ''){
            $data['bank_details']      = '0';
        }else{
            $data['bank_details']      = '1';
        }
        $data['ac_title']      = $request->ac_title;
        $data['iban']      = $request->iban;
        $data['ac_num']      = $request->ac_num;
        $data['bic']      = $request->bic;
        $data['swift']      = $request->swift;
        $data['bank']      = $request->bank;
        $data['branch_code']      = $request->branch_code;
        $data['branch_name']      = $request->branch_name;
        if($request->acc_type != ''){
            $data['acc_type']      = '0';
        }else{
            $data['acc_type']      = '1';
        }
        $data['acc_type_name']      = $request->acc_type_name;
        if($request->tax_exception != ''){
            $data['tax_exception']      = '0';
        }else{
            $data['tax_exception']      = '1';
        }
        $data['tax_exception_name']      = $request->tax_exception_name;
        if($request->general_info != ''){
            $data['general_info']      = '0';
        }else{
            $data['general_info']      = '1';
        }
        if($request->RMC_agent != ''){
            $data['RMC_agent']      = '0';
        }else{
            $data['RMC_agent']      = '1';
        }
        $data['reference']      = $request->reference;
        $data['active_inactive']      = $request->active_inactive;
        $data['grade']      = $request->grade;
        if($request->sales_person != ''){
            $data['sales_person']      = $request->sales_person;
        }else{
            $data['sales_person']      = '0';
        }
        $data['create_by']      = $request->create_by;
        $data['modified_by']      = $request->modified_by;
        $data['desc']      = $request->desc;
        if($request->credit_term != ''){
            $data['credit_term']      = '0';
        }else{
            $data['credit_term']      = '1';
        }
        $data['credit_desc']      = $request->credit_desc;
        $data['limit_aed']      = $request->limit_aed;
        $data['period_days']      = $request->period_days;

        /* Checkboxes value store condition */
        $data['trade_license'] = $request->trade_license != '' ? '0' : '1';
        $data['vat_certificate'] = $request->vat_certificate != '' ? '0' : '1';
        $data['eid'] = $request->eid != '' ? '0' : '1';
        $data['passport_visa_copies'] = $request->passport_visa_copies != '' ? '0' : '1';

        $data['trade_license_expiry_date']      = $request->trade_license_expiry_date ?? '0000-00-00';
        $data['eid_expiry_date']      = $request->eid_expiry_date ?? '0000-00-00';

        if ($request->file('trade_license_file') != '') {
            $trade_license_file = $request->file('trade_license_file');

            // Generate a unique filename
            $data['trade_license_file'] = time() . '_' . $trade_license_file->getClientOriginalName();

            // Define the destination path
            $destinationPath = public_path('upload/trade-license');

            // Move the uploaded trade_license_file to the specified path
            $trade_license_file->move($destinationPath, $data['trade_license_file']);

        }else{
            $data['trade_license_file'] = "";
        }

        if ($request->file('vat_certificate_file') != '') {
            $vat_certificate_file = $request->file('vat_certificate_file');

            // Generate a unique filename
            $data['vat_certificate_file'] = time() . '_' . $vat_certificate_file->getClientOriginalName();

            // Define the destination path
            $destinationPath = public_path('upload/vat-certificate');

            // Move the uploaded trade_license_file to the specified path
            $vat_certificate_file->move($destinationPath, $data['vat_certificate_file']);

        }else{
            $data['vat_certificate_file'] = "";
        }
        if ($request->file('eid_file') != '') {
            $eid_file = $request->file('eid_file');

            // Generate a unique filename
            $data['eid_file'] = time() . '_' . $eid_file->getClientOriginalName();

            // Define the destination path
            $destinationPath = public_path('upload/eid');

            // Move the uploaded trade_license_file to the specified path
            $eid_file->move($destinationPath, $data['eid_file']);

        }else{
            $data['eid_file'] = "";
        }
        if ($request->file('passport_visa_copies_file') != '') {
            $passport_visa_copies_file = $request->file('passport_visa_copies_file');

            // Generate a unique filename
            $data['passport_visa_copies_file'] = time() . '_' . $passport_visa_copies_file->getClientOriginalName();

            // Define the destination path
            $destinationPath = public_path('upload/passport-visa-copies');

            // Move the uploaded trade_license_file to the specified path
            $passport_visa_copies_file->move($destinationPath, $data['passport_visa_copies_file']);

        }else{
            $data['passport_visa_copies_file'] = "";
        }
        // $data->save();
        DB::table('agents')->where('id', $id)->update($data);
        if (count($_POST['name1']) > 0 && $_POST['name1'] != '') {
            for ($i = 0; $i < count($_POST['name1']); $i++) {
                if($_POST['name1'][$i] != ''){
                    $content['agent_id'] = $id;
                    $content['name'] = $_POST['name1'][$i];
                    $content['email'] = $_POST['email1'][$i];
                    $content['telephone'] = $_POST['telephone1'][$i];
                    $content['role'] = $_POST['role1'][$i];
                    $this->insert_attribute($content);
                }
            }
        }
        if ($request->nameu != '' && count($request->nameu) > 0 ) {
            for ($i = 0; $i < count($_POST['nameu']); $i++) {
                if($_POST['nameu'][$i] != ''){
                    $content['agent_id'] = $id;
                    $content['name'] = $_POST['nameu'][$i];
                    $content['email'] = $_POST['emailu'][$i];
                    $content['telephone'] = $_POST['telephoneu'][$i];
                    $content['role'] = $_POST['roleu'][$i];
                    $content['updateid1xxx'] = $_POST['updateid1xxx'][$i];
                    $this->update_attribute($content);
                }
            }
        }
        return redirect()->route('agent.index')->with('success','Organization updated successfully.');
    }
    function update_attribute($content){
        $data['agent_id'] = $content['agent_id'];
        $data['name'] = $content['name'];
        $data['email'] = $content['email'];
        $data['telephone'] = $content['telephone'];
        $data['role'] = $content['role'];
        DB::table('agents_attribute')->where('id', $content['updateid1xxx'])->update($data);
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
        DB::table('agents')->whereIn('id',$delete_id)->delete();
        DB::table('agents_attribute')->whereIn('agent_id',$delete_id)->delete();
        return redirect()->route('agent.index')->with('success','Organization deleted successfully.');
    }
    public function remove_agent_att (Request $request){
        $service = $request->agent_id;
        $id = $request->id;
        $result = DB::table('agents_attribute')->where('agent_id', '=',$service)->where('id', '=',$id)->delete();
        return redirect()->route('agent.edit',$service)->with('success','Agents Attribute has been deleted successfully');
    }
    public function agent_add_inq($agent_id, $attr_id){
        // echo $agent_id ." - ".$attr_id;exit;
        $data['agent_id']=$agent_id;
        $data['attr_id']=$attr_id;
        $data['company_name']=DB::table('agents')->where('id',$agent_id)->first();
        $data['sourcelead_data']= Source_lead::orderBy('id','DESC')->get();
        $data['service_data']= Service::orderBy('id','DESC')->get();
        $data['salesman_data']=DB::table('users')->Where('id','!=', 1)->get();
        $data['agents_attr']=DB::table('agents_attribute')->Where('id',$attr_id)->Where('agent_id',$agent_id)->first();
        return view('admin.add_followup',$data);
    }
    public function bulk_agent()
    {
        return view('admin.bulk_agent');
    }
    public function download()
    {
        $filePath = public_path('upload/excel/agent_format.xlsx');
        return Response::download($filePath, 'agent_format.xlsx');
    }
    public function upload(Request $request){
        //     echo'<pre>';
        // print_r($request->all());
        // echo '</pre>';exit;
        Excel::import(new AgentImport,$request->file('import_file'));
        return redirect()->route('agent.index')->with('success','Excel file uploaded successfully.');
    }

    public function is_approved_status(Request $request){
        $userid = Auth::user()['id'];
        $data['is_approved'] = $request->is_approved_value;
        $data['is_approved_by'] = $userid;
        $agent_id = $request->agent_id;
        DB::table('agents')->where('id',$agent_id)->update($data);
        return response()->json(['message' => 'TRUE']);
    }

    public function check_email_exits(Request $request){
        $email = $request->email;
        $result = DB::table('agents')->where('company_email',$email)->first();
        if($result !=""){
            return response()->json(['message' => 'EXITS']);
        }else{
            return response()->json(['message' => 'OK']);
        }

    }

    public function agent_detail($agent_id){
        $data['agent'] = DB::table('agents')->where('id' , '=' , $agent_id)->first();
        $data['country_data'] = Country::get();
        $data['branch_data']= DB::table('branch')->get();
        $data['agent_data'] = DB::table('agent_type')->get();
        $data['salesman_data']=DB::table('users')->Where('id','!=', 1)->get();
        $data['attribute_data'] = DB::table('agents_attribute')
        ->select('*')
        ->where('agent_id', '=',$data['agent']->id)
        ->get()
        ->toArray();
        // echo'<pre>';
        // print_r($data['agent']);
        // echo '</pre>';exit;
        $data['industry_type_data'] = IndustryType::all();
        $data['reference_data'] = Reference::all();
        $data['approved_agent_data'] = ApprovedAgents::all();
        return view('admin.agent-detail',$data);
    }
}
