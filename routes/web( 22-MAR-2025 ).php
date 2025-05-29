<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\admin\HomeController;
use App\Http\Controllers\admin\AgentController;
use App\Http\Controllers\admin\BranchController;
use App\Http\Controllers\admin\SurveyController;
use App\Http\Controllers\admin\CountryController;
use App\Http\Controllers\admin\ServiceController;
use App\Http\Controllers\admin\DurationController;
use App\Http\Controllers\admin\FollowupController;
use App\Http\Controllers\admin\SurveyorController;
use App\Http\Controllers\admin\FrequencyController;
use App\Http\Controllers\admin\ReferenceController;
use App\Http\Controllers\admin\Admin_userController;
use App\Http\Controllers\admin\Title_RankController;
use App\Http\Controllers\admin\Enquiry_ModeController;
use App\Http\Controllers\admin\IndustryTypeController;
use App\Http\Controllers\admin\Product_TypeController;
use App\Http\Controllers\admin\Storage_ModeController;
use App\Http\Controllers\admin\Storage_TypeController;
use App\Http\Controllers\admin\ApprovedAgentController;
use App\Http\Controllers\admin\Customer_TypeController;
use App\Http\Controllers\admin\Survey_assignController;
use App\Http\Controllers\admin\Surveyor_TypeController;
use App\Http\Controllers\admin\UserPermissionController;
use App\Http\Controllers\admin\ServiceRequiredController;
use App\Http\Controllers\admin\Source_of_ContactController;
use App\Http\Controllers\admin\Surveyor_TimeZoneController;
use App\Http\Controllers\admin\DescriptionofgoodsController;
use App\Http\Controllers\admin\MovingcostController;
use App\Http\Controllers\admin\CbmController;
use App\Http\Controllers\admin\Cbm_pricingController;
use App\Http\Controllers\admin\ShipmentTypeController;
use App\Http\Controllers\admin\QouteController;
use App\Http\Controllers\admin\CodeController;
use App\Http\Controllers\admin\JobOrderController;
use App\Http\Controllers\admin\AcceptedQuotationController;
use App\Http\Controllers\admin\SupervisorController;
use App\Http\Controllers\admin\OperationController;
use App\Http\Controllers\admin\MenPowerController;
use App\Http\Controllers\admin\VehicaleController;
use App\Http\Controllers\admin\GodownController;
use App\Http\Controllers\admin\MaterialController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;


// Route::get('/', function () {
//     return view('welcome');
// });

/*------Front routes start ------*/




/*------End Front routes start ------*/

Route::get('/config-cache', function() {
    Artisan::call('config:cache');
    Artisan::call('cache:clear');
    Artisan::call('view:clear');
    Artisan::call('optimize:clear');
    return 'Config cache cleared';
});



// Route::get('/admin', function () {
//     return view('admin.dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');


Route::get('/', function () {
    return view('admin.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/admin', function () {
    // echo "Welcome Admin";exit;
    if (Auth::user()->surveyor == 1) {
        // echo "Welcome Surveyor!";exit;
        return view('admin.surveyordashboard');
    } else {
        return view('admin.dashboard');
    }
})->middleware(['auth', 'verified'])->name('admin.dashboard');

Route::resource('/folllowup_date', '\App\Http\Controllers\admin\HomeController');



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('/adminuser', '\App\Http\Controllers\admin\Admin_userController');
    Route::get('/admin/delete_admin', [Admin_userController::class, 'destroy'])->name('delete_admin');

    Route::resource('/userpermission', '\App\Http\Controllers\admin\UserPermissionController');
    Route::get('delete_permission', [UserPermissionController::class, 'delete_permission'])->name('delete_permission');
     Route::get('destroyPermission', [UserPermissionController::class, 'destroyPermission'])->name('destroyPermission');


     Route::resource('/country', '\App\Http\Controllers\admin\CountryController');
     Route::get('/admin/delete_country', [CountryController::class,'destroy'])->name('delete_country');

     Route::resource('/customer_type', '\App\Http\Controllers\admin\Customer_TypeController');
     Route::get('/admin/delete_customer_type', [Customer_TypeController::class,'destroy'])->name('delete_customer_type');

     Route::resource('/title_rank', '\App\Http\Controllers\admin\Title_RankController');
     Route::get('/admin/delete_title_rank', [Title_RankController::class,'destroy'])->name('delete_title_rank');

     Route::resource('/storage_type', '\App\Http\Controllers\admin\Storage_TypeController');
     Route::get('/admin/delete_storage_type', [Storage_TypeController::class,'destroy'])->name('delete_storage_type');

     Route::resource('/storage_mode', '\App\Http\Controllers\admin\Storage_ModeController');
     Route::get('/admin/delete_storage_mode', [Storage_ModeController::class,'destroy'])->name('delete_storage_mode');

     Route::resource('/product-type', '\App\Http\Controllers\admin\Product_TypeController');
     Route::get('/admin/delete_product-type', [Product_TypeController::class,'destroy'])->name('delete-product-type');

     Route::resource('/source-of-contact', '\App\Http\Controllers\admin\Source_of_ContactController');
     Route::get('/admin/delete-source-of-contact', [Source_of_ContactController::class,'destroy'])->name('delete-source-of-contact');

     Route::resource('/enquiry_mode', '\App\Http\Controllers\admin\Enquiry_ModeController');
     Route::get('/admin/delete_enquiry_mode', [Enquiry_ModeController::class,'destroy'])->name('delete_enquiry_mode');

     Route::resource('/service', '\App\Http\Controllers\admin\ServiceController');
     Route::get('/admin/delete_service', [ServiceController::class,'destroy'])->name('delete_service');

     Route::resource('/description-of-goods', '\App\Http\Controllers\admin\DescriptionofgoodsController');
     Route::get('/admin/delete-description-of-goods', [DescriptionofgoodsController::class,'destroy'])->name('delete-description-of-goods');

     Route::resource('/services-required', '\App\Http\Controllers\admin\ServiceRequiredController');
     Route::get('/admin/delete-services-required', [ServiceRequiredController::class,'destroy'])->name('delete-services-required');

     Route::resource('/branch', '\App\Http\Controllers\admin\BranchController');
     Route::get('/admin/delete_branch', [BranchController::class,'destroy'])->name('delete_branch');

     Route::resource('/surveyor', '\App\Http\Controllers\admin\SurveyorController');
     Route::get('/admin/delete_surveyor', [SurveyorController::class,'destroy'])->name('delete_surveyor');

     Route::post('surveyor_check_mail', 'App\Http\Controllers\admin\SurveyorController@surveyor_check_mail');
     Route::post('surveyor_edit_check_mail', 'App\Http\Controllers\admin\SurveyorController@surveyor_edit_check_mail');

     Route::resource('/surveyor_time_zone', '\App\Http\Controllers\admin\Surveyor_TimeZoneController');
     Route::get('/admin/delete_surveyor_time_zone', [Surveyor_TimeZoneController::class,'destroy'])->name('delete_surveyor_time_zone');

     Route::post('/surveyor_time_selected', [FollowupController::class, 'getTimeZones']);

     Route::resource('/surveyor_type', '\App\Http\Controllers\admin\Surveyor_TypeController');
     Route::get('/admin/delete_surveyor_type', [Surveyor_TypeController::class,'destroy'])->name('delete_surveyor_type');

     Route::resource('/survey_assign', '\App\Http\Controllers\admin\Survey_assignController');
     Route::get('/admin/survey_assign', [Survey_assignController::class,'index'])->name('survey_assign');

     Route::resource('/agent', '\App\Http\Controllers\admin\AgentController');
     Route::get('/admin/delete_agent', [AgentController::class,'destroy'])->name('delete_agent');
     Route::get('remove_agent_att/{agent_id}/{id}', [AgentController::class, 'remove_agent_att'])->name('remove_agent_att');
     Route::get('add_new_inq/{agent_id}/{attr_id}', [AgentController::class, 'agent_add_inq'])->name('add_new_inq');


     Route::match (['get','post'],'agent_filter','App\Http\Controllers\admin\AgentController@index')->name('agent_filter');

     Route::get('/download-agent', 'App\Http\Controllers\admin\AgentController@download')->name('download.agent');

     Route::get('bulk_agent', 'App\Http\Controllers\admin\AgentController@bulk_agent')->name('bulk_agent');

     Route::post('upload', 'App\Http\Controllers\admin\AgentController@upload')->name('upload');

    //  Route::get('costing/{id}', [FollowupController::class, 'costing'])->name('followup.costing');
    //  Route::post('costing_information', '\App\Http\Controllers\admin\FollowupController@costing_information')->name('costing_information');


     Route::get('survey_info/{id}', [FollowupController::class, 'survey_info'])->name('followup.survey_info');
     Route::post('survey_information', '\App\Http\Controllers\admin\FollowupController@survey_information')->name('survey_information');

     Route::resource('/followup', '\App\Http\Controllers\admin\FollowupController');
     Route::get('/admin/delete_followup', [FollowupController::class,'destroy'])->name('delete_followup');

     Route::post('/followup_data', [FollowupController::class,'followup_data'])->name('followup_data');
     Route::post('/followup_data', [FollowupController::class,'followup_data'])->name('followup_data');
     Route::get('admin/enquiry-detail/{enquiry_id}',[FollowupController::class,'enquiry_detail'])->name('enquiry.detail');

     Route::match (['get','post'],'/followup-filter','App\Http\Controllers\admin\FollowupController@index')->name('followup-filter');

     Route::post('get_quote', '\App\Http\Controllers\admin\FollowupController@get_quote')->name('get_quote');

    Route::get('get_quote_pdf/{id}', [FollowupController::class, 'get_quote_pdf'])->name('followup.get_quote_pdf');

    Route::get('repeated_inq/{id}', [FollowupController::class, 'repeated_inq'])->name('followup.repeated_inq');

    Route::post('add_repeated_inq', [FollowupController::class, 'add_repeated_inq'])->name('followup.add_repeated_inq');

    Route::get('/surveyor_form/{id}', '\App\Http\Controllers\admin\FollowupController@surveyor_form')->name('surveyor_form');

    Route::get('/luggage_item', '\App\Http\Controllers\admin\FollowupController@luggage_item')->name('luggage_item');

    Route::get('/selected_items', '\App\Http\Controllers\admin\FollowupController@selected_items')->name('selected_items');

    Route::post('/item_form_data', '\App\Http\Controllers\admin\FollowupController@item_form_data')->name('item_form_data');

    Route::post('followup_form', '\App\Http\Controllers\admin\FollowupController@followup_form');

    Route::post('status_change', '\App\Http\Controllers\admin\FollowupController@status_change');

    Route::get('filter_data', '\App\Http\Controllers\admin\FollowupController@filter_data');

    Route::get('get_quote_form/{id}', [FollowupController::class, 'get_quote_form'])->name('followup.get_quote_form');

    Route::post('get_quote', '\App\Http\Controllers\admin\FollowupController@get_quote')->name('get_quote');


    Route::post('/contact-details-agent', [FollowupController::class,'agent_att_data'])->name('contact-person.agent');
    Route::post('/contact-person-detail', [FollowupController::class,'get_contact_person_details'])->name('contact-person-detail');


    Route::post('/agent_att_data_replace', [FollowupController::class,'agent_data_assign'])->name('agent_att_data_replace');

    Route::resource('/industry-type', '\App\Http\Controllers\admin\IndustryTypeController');
    Route::get('/admin/delete-industry-type', [IndustryTypeController::class,'destroy'])->name('industry-type.delete');

    Route::resource('/reference', '\App\Http\Controllers\admin\ReferenceController');
    Route::get('/admin/delete-reference', [ReferenceController::class,'destroy'])->name('reference.delete');

    Route::resource('/approved-agents', '\App\Http\Controllers\admin\ApprovedAgentController');
    Route::get('/admin/delete-approved-agent', [ApprovedAgentController::class,'destroy'])->name('approved-agent.delete');

    Route::resource('/frequencies', '\App\Http\Controllers\admin\FrequencyController');
    Route::get('/admin/delete-frequencies', [FrequencyController::class,'destroy'])->name('frequencies.delete');


    Route::resource('/durations', '\App\Http\Controllers\admin\DurationController');
    Route::get('/admin/delete-durations', [DurationController::class,'destroy'])->name('durations.delete');

    Route::post('approve-status', '\App\Http\Controllers\admin\AgentController@is_approved_status');
    Route::post('check-email-exits', '\App\Http\Controllers\admin\AgentController@check_email_exits');
    Route::get('agent-detail/{agent_id}',[AgentController::class,'agent_detail'])->name('agent-detail');

    // Survey Module
    Route::get('/admin/survey', '\App\Http\Controllers\admin\SurveyController@index')->name('survey.index');
    Route::get('admin/survey/edit/{id}/', [SurveyController::class, 'edit'])->name('survey.edit');
    Route::put('admin/survey/{id}', [SurveyController::class, 'update'])->name('survey.update');
    Route::get('admin/survey-detail/{survey_id}',[FollowupController::class,'enquiry_detail'])->name('survey.detail');

    // Costing Module
    Route::get('/admin/costing', '\App\Http\Controllers\admin\SurveyController@costing_listing')->name('costing.index');
    Route::get('admin/costing-add/{id}', [SurveyController::class, 'costing'])->name('costing.add');
    Route::post('costing-info', '\App\Http\Controllers\admin\SurveyController@costing_information')->name('costing.info');
    Route::get('admin/costing-detail/{costing_id}',[FollowupController::class,'enquiry_detail'])->name('costing.detail');
    Route::get('costing-remove/{enquiry_id}/{id}', [SurveyController::class, 'costing_remove'])->name('costing.remove');
    Route::post('costing-similar-rate', [SurveyController::class,'similar_rate'])->name('costing.similar-rate');
    Route::post('costing-add-similar-rate', [SurveyController::class,'store_similar_rate'])->name('costing.add-similar-rate');
    


    // Qoute Module
    Route::get('/admin/quotation', '\App\Http\Controllers\admin\QouteController@index')->name('quote.index');
    Route::get('admin/quotation-detail/{quote_id}',[FollowupController::class,'enquiry_detail'])->name('quote.detail');
    Route::get('admin/quotation-add/{id}', [QouteController::class, 'quotation_store'])->name('quotation.add');
    Route::get('admin/customer-mail/{id}', [QouteController::class, 'customer_mail'])->name('customer.mail');
    Route::post('qoutation-store', [QouteController::class, 'qoutation_store'])->name('qoutation.store');
    Route::post('mail-format-type', [QouteController::class, 'mail_format_type'])->name('mail-format-type');
    Route::post('send-quotation-mail', [QouteController::class, 'send_quotation_mail'])->name('send-quotation-mail');
    Route::get('quote-costing-remove/{enquiry_id}/{id}', [QouteController::class, 'quote_costing_remove'])->name('quote.costing.remove');

    Route::get('admin/revise-request/{id}', [QouteController::class, 'revise_request'])->name('revise.request');

    Route::post('/accept-quotation-admin', [QouteController::class, 'accept_quotation_byadmin'])->name('accept-quotation.byadmin');

    Route::post('ckeditor/upload', [QouteController::class, 'upload'])->name('ckeditor.upload');

    Route::get('quotation-download', [QouteController::class, 'quotation_download'])->name('qoutation.download');


    // Accepted Quotation Module
    Route::resource('accepted-quotation', '\App\Http\Controllers\admin\AcceptedQuotationController');
    Route::post('accept-status-change', [AcceptedQuotationController::class, 'accept_status_change'])->name('accept-status-change');


    // Job Order Module
    Route::resource('job-order', '\App\Http\Controllers\admin\JobOrderController');
    Route::post('/job-order-contact-person', [JobOrderController::class,'agent_att_job_order'])->name('contact-person.job_order');
    Route::post('/get-agent-person-details', [JobOrderController::class,'get_contact_person_details'])->name('get-contact-person.detail');

    // Code Module
    Route::resource('/codes', '\App\Http\Controllers\admin\CodeController');
    Route::get('/admin/delete-codes', [CodeController::class,'destroy'])->name('codes.delete');


    // Operation Module
    Route::resource('/operation', '\App\Http\Controllers\admin\OperationController');
    Route::get('admin/operation-detail/{quote_id}',[FollowupController::class,'enquiry_detail'])->name('operation.detail');
    Route::post('/check-supervisor-date', [OperationController::class, 'checkDate'])->name('checkSupervisorDate');
    Route::post('/check-manpower-date', [OperationController::class, 'checkManPowerDate'])->name('checkManPowerDate');
    Route::get('admin/add-man-power/{id}', [OperationController::class, 'edit_man_power'])->name('man-power.edit');
    Route::get('admin/add-vehicles/{id}', [OperationController::class, 'edit_vehicles'])->name('operation-vehicles.edit');
    Route::patch('/man-power-update/{id}', [OperationController::class, 'update_man_power'])->name('man-power.update');
    Route::patch('/operation-vehicle-update/{id}', [OperationController::class, 'update_vehicle'])->name('operation-vehicle.update');
    Route::get('/get-driver-info', [OperationController::class, 'getDriverInfo'])->name('get.driver.info');
    Route::post('/update-driver', [OperationController::class, 'updateDriver'])->name('update.driver');
    Route::post('/check-vehicle-date', [OperationController::class, 'checkVehicleDate'])->name('checkVehicleDate');

    // Operation Packing Material
    Route::get('admin/add-packing-material/{id}', [OperationController::class, 'edit_packing_material'])->name('operation-packing.edit');
    Route::post('warehouse-allocate', [OperationController::class,'warehouse_allocate'])->name('warehouse.allocate');
    Route::post('warehouse-return', [OperationController::class,'warehouse_return'])->name('warehouse.return');


    // Supervisor
    Route::resource('/supervisor', '\App\Http\Controllers\admin\SupervisorController');
    Route::get('/admin/delete_supervisor', [SupervisorController::class,'destroy'])->name('delete_supervisor');

    // Men Power
    Route::resource('/men-power', '\App\Http\Controllers\admin\MenPowerController');
    Route::get('/admin/delete_men_power', [MenPowerController::class,'destroy'])->name('men-power.delete');

     /*
      * Vehicales Master
      */
    Route::resource('/vehicles', '\App\Http\Controllers\admin\VehicaleController');
    Route::get('/delete-vehicles', [VehicaleController::class, 'destroy'])->name('vehicles.destroy');
    Route::get('remove-vehicle-attribute/{vehicle_id}/{id}', [VehicaleController::class, 'remove_vehicle_attribute'])->name('vehicle-attribute.delete');

    /*
      * Godown Master
      */
      Route::resource('/godowns', '\App\Http\Controllers\admin\GodownController');
      Route::get('/delete-godowns', [GodownController::class, 'destroy'])->name('godowns.destroy');


    /*
      * MAterial Master
      */
      Route::resource('/materials', '\App\Http\Controllers\admin\MaterialController');
      Route::get('/delete-materials', [MaterialController::class, 'destroy'])->name('materials.destroy');
      Route::post('material-stock-store', [MaterialController::class, 'material_stock_store'])->name('material-stock.store');


      // Operation Labels
    Route::get('admin/add-label/{id}', [OperationController::class, 'edit_label'])->name('operation-lable.edit');
    Route::get('admin/preview-label/{id}', [OperationController::class, 'preview_label'])->name('label.preview');
    Route::post('toggle-label', [OperationController::class, 'show_label'])->name('toggle.label');


    // Operation Upload Documents
    Route::get('admin/add-documents/{id}', [OperationController::class, 'edit_documents'])->name('operation-documents.edit');
    Route::patch('upload-documents/{id}', [OperationController::class, 'upload_documents'])->name('upload.documents');
    Route::get('/download-document/{id}', [OperationController::class, 'download_document'])->name('download.document');

    Route::get('delete-documents/{id}', [OperationController::class, 'delete_documents'])->name('delete.documents');

    Route::get('admin/get-report/{id}', [OperationController::class, 'get_report'])->name('get-reports');
    Route::get('admin/client-care-report/{id}', [OperationController::class, 'client_care_report_download'])->name('client-care-report.download');
    Route::get('admin/job-cost-report/{id}', [OperationController::class, 'job_cost_report'])->name('job-cost-report.download');

    /* Route::post('/toggle-label', function (Request $request) {
        Session::put('show_label', $request->show);
        return response()->json(['show' => $request->show]);
    })->name('toggle.label'); */



    Route::resource('/movingcost', '\App\Http\Controllers\admin\MovingcostController');
    Route::get('/admin/delete_movingcost', [MovingcostController::class,'destroy'])->name('delete_movingcost');

    Route::resource('/shipment-type', '\App\Http\Controllers\admin\ShipmentTypeController');
    Route::get('/admin/delete-shipment-type', [ShipmentTypeController::class,'destroy'])->name('delete-shipment-type');

    Route::resource('/cbm', '\App\Http\Controllers\admin\CbmController');
    Route::get('/admin/delete_cbm', [CbmController::class,'destroy'])->name('delete_cbm');

    Route::resource('/cbm-pricing', '\App\Http\Controllers\admin\Cbm_pricingController');
    Route::get('/admin/delete-cbm-pricing', [Cbm_pricingController::class,'destroy'])->name('delete-cbm-pricing');

    Route::post('/admin/cbm_pricing_store', [Cbm_pricingController::class,'cbm_pricing_store'])->name('cbm_pricing_store');

});

Route::get('/accept-quotation/{enquiry_id}/{format_type}', [QouteController::class, 'accept_quotation'])->name('accept.quotation');
Route::get('/request-accept/{enquiry_id}/{format_type}', [QouteController::class, 'request_accepted'])->name('request.accept');

Route::get('/logout', [\App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

require __DIR__.'/auth.php';
