<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\admin\CompanyAccountDetails;

class CompanyAccountDetailController extends Controller
{
    public function edit($id){
        // echo $id;exit;
        // echo "<pre>";print_r($company_account_data);exit;
        $company_account_data = CompanyAccountDetails::findOrFail($id);
        return view('admin.company_account_detail',compact('company_account_data'));
    }

    public function update(Request $request, $id)
    {
        $accountDetail = CompanyAccountDetails::findOrFail($id);

        if(!empty($request->company_name)){
            $data['company_name']        = $request->company_name;
        }

        if(!empty($request->bank_name)){
            $data['bank_name']           = $request->bank_name;
        }
        
        if(!empty($request->account_holder_name)){
            $data['account_holder_name'] = $request->account_holder_name;
        }
        if(!empty($request->account_number)){
            $data['account_number']      = $request->account_number;
        }
        if(!empty($request->ifsc_code)){
            $data['ifsc_code']           = $request->ifsc_code;
        }
        if(!empty($request->branch_name)){
            $data['branch_name']         = $request->branch_name;
        }
        if(!empty($request->account_type)){
            $data['account_type']        = $request->account_type;
        }
        if(!empty($request->swift_code)){
            $data['swift_code']        = $request->swift_code;
        }
        if(!empty($request->iban)){
            $data['iban']        = $request->iban;
        }
        $accountDetail->update($data);

        return redirect()->route('companyAccountDetails.edit',$id)->with('success', 'Account details updated successfully.');
    }

}
