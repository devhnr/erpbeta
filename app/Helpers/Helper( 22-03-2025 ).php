<?php

namespace App\Helpers;
use Illuminate\Support\Facades\DB;
use Session;
use App\Models\admin\VehiclesAssignOperation;
use App\Models\admin\Godown;
use App\Models\admin\MaterialStocks;
use App\Models\admin\MaterialAttribute;
use App\Models\admin\QuotationPackingMaterial;

class Helper{
	public static function categoryname(int $id){
		$result = DB::table('categories')->where('id',$id)->first();
		return $result->name;
	}
	public static function get_user_data(string $string)
    {
        $query = DB::table("users")->where("id",$string);
        if($query->count() > 0)
        {
            return $query->get()->first();
        } else
        {
            return false;
        }
    }
	public static function get_permission_data(string $string)
    {
        $query = DB::table("user_permissions")->where("id",$string);
        if($query->count() > 0)
        {
            return $query->get()->first();
        } else
        {
            return false;
        }
    }
	public static function user_role_name(int $id){
		$result = DB::table('user_permissions')->where('id',$id)->first();
        if($result !='' && isset($result)){
            return $result->cname;
        }else{
            echo "-";
        }
	}
    public static function packingmanagementname(int $id){
		$result = DB::table('pack_manages')->where('id',$id)->first();
        if($result !='' && isset($result)){
            return $result->name;
        }else{
            echo "-";
        }
	}
    public static function source_leadsname(int $id){
		$result = DB::table('source_leads')->where('id',$id)->first();
        if($result !='' && isset($result)){
            return $result->name;
        }else{
            echo "-";
        }
	}
    public static function service(?int $id) {
        if (is_null($id)) {
            return "-"; // Return a default value or handle the null case
        }
        $result = DB::table('services')->where('id', $id)->first();
        if ($result != '' && isset($result)) {
            return $result->name;
        } else {
            return "-"; // Use return instead of echo
        }
    }

    public static function salesmanname(int $id){
		$result = DB::table('users')->where('id',$id)->first();
        if($result !='' && isset($result)){
            return $result->name;
        }else{
            echo "-";
        }
	}
    public static function warehousename(int $id){
		$result = DB::table('warehouses')->where('id',$id)->first();
        if($result !='' && isset($result)){
            return $result->name;
        }
        else{
            echo "-";
        }
	}
    public static function warehouse_att(int $id){
		$result = DB::table('warehouse_attribute')->where('id',$id)->first();
        if($result !='' && isset($result)){
            return $result->position;
        }else{
            echo "-";
        }
	}
    public static function getWarehousePosition(int $id){
		$result = DB::table('warehouse_attribute')->where('warehouse_id',$id)->first();
        if($result !='' && isset($result)){
            return $result->position;
        }else{
            echo "-";
        }
	}
    public static function getWarehouseCbm(int $id){
		$result = DB::table('warehouse_attribute')->where('warehouse_id',$id)->first();
        if($result !='' && isset($result)){
            return $result->cbm;
        }else{
            echo "-";
        }
	}
    public static function getWarehouseArea_sqft(int $id){
		$result = DB::table('warehouse_attribute')->where('warehouse_id',$id)->first();
        if($result !='' && isset($result)){
            return $result->area_sqft;
        }else{
            echo "-";
        }
	}
    public static function getWarehouseCost_per_sqft(int $id){
		$result = DB::table('warehouse_attribute')->where('warehouse_id',$id)->first();
        if($result !='' && isset($result)){
            return $result->cost_per_sqft;
        }else{
            echo "-";
        }
	}
    public static function getWarehouseCost_per_cbm(int $id){
		$result = DB::table('warehouse_attribute')->where('warehouse_id',$id)->first();
        if($result !='' && isset($result)){
            return $result->cost_per_cbm;
        }else{
            echo "-";
        }
	}
    public static function countryname(int $country){
        $query = DB::table('countries')->where('id',$country)->first();
		if ($query !="") {
			return $query->country;
		} else {
			return '-';
		}
    }
    function numberToWords($num = '')
{
    $num    = ( string ) ( ( int ) $num );
    if( ( int ) ( $num ) && ctype_digit( $num ) )
    {
        $words  = array( );
        $num    = str_replace( array( ',' , ' ' ) , '' , trim( $num ) );
        $list1  = array('','one','two','three','four','five','six','seven',
            'eight','nine','ten','eleven','twelve','thirteen','fourteen',
            'fifteen','sixteen','seventeen','eighteen','nineteen');
        $list2  = array('','ten','twenty','thirty','forty','fifty','sixty',
            'seventy','eighty','ninety','hundred');
        $list3  = array('','thousand','million','billion','trillion',
            'quadrillion','quintillion','sextillion','septillion',
            'octillion','nonillion','decillion','undecillion',
            'duodecillion','tredecillion','quattuordecillion',
            'quindecillion','sexdecillion','septendecillion',
            'octodecillion','novemdecillion','vigintillion');
        $num_length = strlen( $num );
        $levels = ( int ) ( ( $num_length + 2 ) / 3 );
        $max_length = $levels * 3;
        $num    = substr( '00'.$num , -$max_length );
        $num_levels = str_split( $num , 3 );
        foreach( $num_levels as $num_part )
        {
            $levels--;
            $hundreds   = ( int ) ( $num_part / 100 );
            $hundreds   = ( $hundreds ? ' ' . $list1[$hundreds] . ' Hundred' . ( $hundreds == 1 ? '' : 's' ) . ' ' : '' );
            $tens       = ( int ) ( $num_part % 100 );
            $singles    = '';
            if( $tens < 20 ) { $tens = ( $tens ? ' ' . $list1[$tens] . ' ' : '' ); } else { $tens = ( int ) ( $tens / 10 ); $tens = ' ' . $list2[$tens] . ' '; $singles = ( int ) ( $num_part % 10 ); $singles = ' ' . $list1[$singles] . ' '; } $words[] = $hundreds . $tens . $singles . ( ( $levels && ( int ) ( $num_part ) ) ? ' ' . $list3[$levels] . ' ' : '' ); } $commas = count( $words ); if( $commas > 1 )
        {
            $commas = $commas - 1;
        }
        $words  = implode( ', ' , $words );
        $words  = trim( str_replace( ' ,' , ',' , ucwords( $words ) )  , ', ' );
        if( $commas )
        {
            $words  = str_replace( ',' , ' and' , $words );
        }
        return $words;
    }
    else if( ! ( ( int ) $num ) )
    {
        return 'Zero';
    }
    return '';
}

public static function agentname(int $id){
    $query = DB::table('agent_type')->where('id',$id)->first();
    if ($query !="") {
        return $query->agent_type;
    } else {
        return '-';
    }
}
public static function time_zonename(string $string) {
    $query = DB::table('surveyor_time_zone')->where('id', $string)->first();
    if ($query !== null) {
        return $query->time_zone;
    } else {
        return 0;
    }
}
public static function surveyorname(string $id) {
    $query = DB::table('surveyor')->where('id', $id)->first();
    if ($query !== null) {
        return $query->surveyor_name;
    } else {
        return '-';
    }
}
public static function surveytype(string $id) {
    $query = DB::table('surveyor_type')->where('id', $id)->first();
    if ($query !== null) {
        return $query->surveyor_type;
    } else {
        return '-';
    }
}

public static function getusername(int $userid)
    {
        $query = DB::table("users")->where("id",$userid);
        if($query->count() > 0)
        {
            return $query->value('name');
        } else
        {
            return false;
        }
    }

    public static function getOrganizationName(int $id){

        if (is_null($id)) {
            return '-';
        }
        $result = DB::table('agents')->where('id',$id)->value('company_name');
        if ($result !="") {
            return $result ?: '-';
        } else {
            return '-';
        }
    }
    public static function getOrganizationContactName(int $agent_attr_id){
        $result = DB::table('agents_attribute')->where('id',$agent_attr_id)->value('name');
        if ($result !="") {
            return $result;
        } else {
            return '-';
        }
    }

    public static function descriptionOfGoods(string $id) {
        $query = DB::table('goods_description')->where('id', $id)->first();
        if ($query !== null) {
            return $query->name;
        } else {
            return '-';
        }
    }
    public static function getDriverInfo(string $enquiryId, string $vehicleId, ?string $driverId = null) {

        $query = VehiclesAssignOperation::where('enquiry_id', $enquiryId)
                        ->where('vehicle_id', $vehicleId);
                        if (!is_null($driverId)) {
                            $query->where('driver_id', $driverId);
                        }
        $result = $query->first();
        return $result ?: (object) [
            'driver_mobile_no' => '',
            'no_of_trip' => '',
            'amount' => '',
            'time_zone_id' => '',  // Ensure time_zone_id exists to prevent errors
        ];
        /* if ($result !== null) {
            return $result ?? "";
        } else {
            return "";
        } */
    }

    public static function getGodownName(string $id) {
        $result = Godown::where('id', $id)->first();
        if ($result !== null) {
            return $result->name;
        } else {
            return '-';
        }
    }

    public static function getMaterialStocks(string $materialId,string $godownId) {

        $result = MaterialStocks::where('material_id',$materialId)->where('godown_id', $godownId)->orderBy('id',"DESC")->value('stock');
        return $result ?: (object) [
            'material_id' => '',
            'godown_id' => '',
            'stock' => ''
        ];
    }

    public static function getSumOfMaterialStocks(string $materialId) {
        $result = MaterialAttribute::where('material_id',$materialId)->sum('stock');
        return $result ?? 0.00;
    }
    

    public static function getTotalAllocateQty(string $enquiryId,string $materialId){
        $result = QuotationPackingMaterial::where('enquiry_id',$enquiryId)
                                          ->where('material_id',$materialId)
                                          ->sum('allocate');
        if($result == 0){
            return "";

        }else{
            return $result;
        }
        // return $result ?? "";
    }

    public static function getMaterialTotalCosts(string $enquiryId,string $materialId){
        $result = QuotationPackingMaterial::where('enquiry_id',$enquiryId)
                                          ->where('material_id',$materialId)
                                          ->sum('price_cost');
        if($result == 0){
            return "";
        }else{
            return $result;
        }
    }
    public static function getEnteredAllocat(string $enquiryId,string $materialId,string $godownId){
        $result = QuotationPackingMaterial::where('enquiry_id',$enquiryId)
                                          ->where('material_id',$materialId)
                                          ->where('godown_id',$godownId)
                                          ->value('allocate');
        if($result == 0){
            return '';
        }else{
            return $result;
        }
    }

    public static function getQuotationPackingMaterial(string $enquiryId,string $materialId){
        $result = QuotationPackingMaterial::where('enquiry_id',$enquiryId)
                                          ->where('material_id',$materialId)
                                          ->get();
        if ($result->isEmpty()) {
            return ""; // Return empty string if no records found
        } else {
            return $result; // Return the collection
        }
    }

    public static function getPackingMaterialPrice(string $materialId,string $godownId) {
        $result = MaterialAttribute::where('material_id',$materialId)->where('godown_id',$godownId)->value('price');
        return $result ?? 0.00;
    }
}
