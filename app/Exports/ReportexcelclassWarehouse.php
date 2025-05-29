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
    //  
         

        $ware_att_data = DB::table('warehouse_attribute')->where('warehouse_id', $row->warehouse_id)->get();

        

       $ware_manage_data = DB::table('warehouse_managements')
                        // ->where('id',$row->warehouse_manage_id)
                        ->where('warehouse_id',$row->ware_id)
                        ->where('warehouse_att_id', $row->id)
                        ->whereDate('dateout', '>=', now()->toDateString())
                        ->get();

         $warehouse = DB::table('warehouses')->where('id', $row->ware_id)->value('name');


        //  echo"<pre>";print_r($row);echo"</pre>";exit;

         if(isset($ware_manage_data) && $ware_manage_data != ''){
            $class = 'fillup';
        }else{
            $class = 'blank';
        }

        if ($ware_manage_data->isNotEmpty()) {
            $cbm= $row->cbm;
            foreach ($ware_manage_data as $data) {
                $ledgername = $data->ledgername;
                $emailid = $data->emailid;
                $datein = $data->datein;
                $duedate = $data->duedate;
        
                // Handle each row here
            }
        } else {
            $cbm='-';
            $ledgername = '-';
            $emailid = '-';
            $datein = '-';
            $duedate = '-';
        }
        

          


        //  $salePersonname = DB::table('users')->where('id', $row->salesperson_id)->value('name');

         
     
         $values = $this->customValues ?? [
            $warehouse,
            $row->position,
            $cbm,
            $ledgername,
            $emailid,
            $datein,
            // $row->dateout,
            $duedate,
           
         ];
            // echo"<pre>";print_r($values);echo"</pre>";exit;
         
     
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