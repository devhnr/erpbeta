<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Route;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Image;
use PDF;
use Mail;
use App\Models\admin\Followup;
use App\Models\admin\Closingamount;
use App\Models\admin\Source_lead;
use App\Models\admin\Service;
use App\Models\admin\Duration;
use App\Models\admin\Frequency;
use App\Models\admin\Code;
use App\Models\admin\Supervisor as SupervisorAssign;
use App\Models\admin\MenPower as ManPowerAssign;
use App\Models\admin\Vehicale;
use App\Models\admin\VehicalAttribute;
use App\Models\admin\VehiclesAssignOperation;
use App\Models\admin\Materials;
use App\Models\admin\Godown;
use App\Models\admin\MaterialAttribute;
use App\Models\admin\MaterialStocks;
use App\Models\admin\QuotationPackingMaterial;
use App\Models\admin\OperationPackingMaterialReturn;
use App\Models\admin\UploadDocuments;
use App\Models\admin\CompanyAccountDetails;
use App\Models\admin\Invoice;

class ReceiptVoucherController extends Controller
{
    public function index(Request $request){
        // $startdate = $request->s_date;
        // $enddate = $request->e_date;
        // $salesmanname = $request->salesmanname;
        // $servicename = $request->servicename;
        // $user_data = Auth::user();
        // $query = DB::table('followups')->where('accept_reject',0);
        // if($user_data->role_id != 1 && $user_data->role_id != 7){
        //     $query = $query->where('salesman_id', $user_data->id);
        // }
        // if($user_data->role_id == 7){
        //     $query = $query->where('surveyor', $user_data->id);
        // }
        // if ($startdate !='')
        // {
        //     $query = $query->where('added_date', '>=', date('Y-m-d', strtotime($startdate)));
        // }
        // if ($enddate !='')
        // {
        //     $query = $query->where('added_date', '<=', date('Y-m-d', strtotime($enddate)));
        // }
        // $data['startdate'] =$startdate;
        // $data['enddate'] =$enddate;
        // if ($salesmanname !='')
        // {
        //     $query=$query->where('salesman_id', $salesmanname);
        // }
        // if ($servicename !='')
        // {
        //     $query=$query->where('service_id', $servicename);
        // }
        // $data['filter_salep_id'] = $salesmanname;
        // $data['filter_service_id'] = $servicename;
        // // $data['salesman_data'] = DB::table('users')->Where('role_id',7)->get();
        // $data['salesman_data'] = DB::table('users')->Where('id','!=', 1)->get();
        // $data['service_data'] = DB::table('services')->get();
        // $data['followup_status'] = DB::table('followup_status')->get();
        // $data['followup_data']= $query->where('enquiry_level','=',1)
        //                               ->where('survey_level','=',1)
        //                               ->where('costing_level', '=',1)
        //                               ->where('quote_level', '=',1)
        //                               ->where('accept_quote_level', '=',1)
        //                               ->where('job_order_level', '=',1)
        //                               ->where('operation_level', '=',1)
        //                               ->where('shipment_level', '=',1)
        //                               ->where('billing_level', '=',1)
        //                               ->where('closing_level', '=',1)
        //                               ->where('receipt_voucher_level', '=',0)
        //                               ->orderBy('id','DESC')
        //                               ->get();

         $data['moduleName'] = $this->getCurrentRouteName();
        // $data['currentRoute'] = Route::currentRouteName();
        $data['closing_data'] = Closingamount::orderBy('id','DESC')->get()->toArray();
       
        return view('admin.list_receipt_voucher', $data);
    }

    function getCurrentRouteName(){

        $moduleName = "";

        switch(Route::currentRouteName()){

            case "survey.index":
                $moduleName =  "Survey";
                break;
            case "costing.index":
                $moduleName =  "Costing";
                break;
            case "accepted-quotation.index":
                $moduleName =  "Accepted Quotation";
                break;
            case "job-order.index":
                $moduleName =  "Job Order";
                break;
            case "operation.index":
                $moduleName =  "Operation";
                break;
            case "shipment.index":
                $moduleName =  "Shipment";
                break;
            case "billing-invoice.index":
                $moduleName =  "Invoice";
                break;
            case "closing.index":
                $moduleName =  "Closing";
                break;
            case "receipt-voucher.index":
                $moduleName =  "Receipt Voucher";
                break;
            default:
                $moduleName =  "Unknown Module";
                break;
        }

        return $moduleName;
    }
}
