<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use DB;

class ReportexcelclassWarehouse implements FromCollection, WithMapping, WithHeadings
{

    
        protected $data;
         protected $customHeadings;
         protected $customValues;
     
             public function __construct($data, $customHeadings, $customValues)
         {  
             $this->data = $data;
             $this->customHeadings = $customHeadings;
             $this->customValues = $customValues;
         }
     
         public function collection()
         {     
            // echo'<pre>';
            // print_r($this->data);
            // echo'</pre>';exit;
             return $this->data;
         }
         public function map($row): array
     {
    //    echo"<pre>";print_r($row);echo"</pre>";
         

        $ware_att_data = DB::table('warehouse_attribute')->where('warehouse_id', $row->ware_id)->first();
        //echo"<pre>";print_r($ware_att_data);echo"</pre>";


        $ware_manage_data = DB::table('warehouse_managements')
        ->where('warehouse_id', $row->ware_id)
        ->where('warehouse_att_id', $row->id)
        ->first();

         $warehouse = DB::table('warehouses')->where('id', $row->ware_id)->value('name');
        // echo"<pre>";print_r($ware_manage_data);echo"</pre>";exit;

        if($ware_manage_data != ''){
          $ledgername = $ware_manage_data->ledgername;
          $emailid = $ware_manage_data->emailid;
          $datein = $ware_manage_data->datein;
          $duedate = $ware_manage_data->duedate;
        }else{
          $ledgername = '-';
          $emailid = '-';
          $datein = '-';
          $duedate = '-';
        }

          


        //  $salePersonname = DB::table('users')->where('id', $row->salesperson_id)->value('name');

         //echo"<pre>";print_r($materialname);echo"</pre>";exit;
     
         $values = $this->customValues ?? [
            $warehouse,
            $row->position,
            $row->cbm,
            $ledgername,
            $emailid,
            $datein,
            // $row->dateout,
            $duedate,
           
         ];

         
     
         // Ensure both keys and values arrays have the same number of elements
         $keys = $this->getHeadings($row);
         $values = array_slice(array_merge($values, array_fill(0, count($keys) - count($values), null)), 0, count($keys));
     
         return array_combine($keys, $values);
     }
     
     public function headings(): array
     {
         // Use custom headings if provided, otherwise use default headings
         return $this->customHeadings ?? ($firstRow ? $this->getHeadings($firstRow) : []);
     }
     
     
         protected function getHeadings($row): array
         {
             // This method ensures that headings are consistent with the values
             return $row ? array_keys(get_object_vars($row)) : [];
         }
        
     

}