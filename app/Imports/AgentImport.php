<?php

namespace App\Imports;
use Carbon\Carbon;
use App\Imports\AgentImport; 
use App\Models\admin\Agent;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use DB;
class AgentImport implements ToCollection,WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {   
       
        // $firstRow = true; // Flag to check if it's the first row
       
        foreach ($rows as $row) 
        {    
            
            $country = DB::table('countries')
            ->where('country', $row['country'])
            ->value('id');

            if($country == ''){
                $country_id = 0;
            }else{
                $country_id = $country;
            }
            $validValues = ['active', 'inactive'];
          
            if (in_array($row['activeinactive'], $validValues)) {
                $activeInactiveValue = $row['activeinactive'];
            } else {
                $activeInactiveValue = '';
            }


          $data = [
                        'agent_type' => 1,
                        'company_name' => $row['company_name'],
                        'p_o_c_full' => $row['poc_full'],
                        'p_o_c_position_title' => $row['poc_positiontitle'],
                        'company_email' => $row['company_email'],
                        'company_telephone' => $row['company_telephone'],
                        'country' => $country_id,
                        'company_city' => $row['company_city'],
                        'company_role' =>$row['company_roles'],   
                        'active_inactive' => $activeInactiveValue,
                        'approved_agent' => $row['approved_agent'],
                        'approved_by' => $row['approved_by'],
                        'company_payment_terms' => $row['company_payment_terms'],
                        'company_vat_num' => $row['company_vat_num'],
                        'bill_company_through' => $row['bill_company_through'],
                        'client_source' => $row['client_source'],
                        'company_address' => $row['company_address'],
                        'parent_company' => $row['parent_company'],
                        'years_in_business' => $row['years_in_business']
            ];
   
            
        
        if ($data['company_email'] != '') {

            if (Agent::where('company_email', $data['company_email'])->exists()) {
               // echo "here";exit;
            $agent_id = Agent::where('company_email', $data['company_email'])->pluck('id')->first();
         
            $checkAttribute = DB::table('agents_attribute')
                            ->where('agent_id', $agent_id)
                            ->where('email', $row['email'])
                            ->where('telephone', $row['telephone'])
                            ->value('id');

            
            $data_att = [
                'agent_id'=>$agent_id,
                'name' => $row['name'],
                'email' => $row['email'],
                'telephone' => $row['telephone'],
                'role' => $row['role']
            ];
                    //   echo'<pre>';print_r($checkAttribute);echo'</pre>';exit;

            if($checkAttribute == ''){
                DB::table('agents_attribute')->insert($data_att);
            }else{
                DB::table('agents_attribute')->where('id',$checkAttribute)->update($data_att);
            }

            DB::table('agents')->where('id',$agent_id)->update($data);

            }else{

                $agent_id = DB::table('agents')->insertGetId($data);


                $data_att = [
                    'agent_id'=>$agent_id,
                    'name' => $row['name'],
                    'email' => $row['email'],
                    'telephone' => $row['telephone'],
                    'role' => $row['role']
                ];

                DB::table('agents_attribute')->insert($data_att);
            }
            
        }

    }
}
}
