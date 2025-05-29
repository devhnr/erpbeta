<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;
use DB;



class ReportexcelclassWarehouse_sales_report implements FromCollection, WithMapping, WithHeadings
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
                 return $this->data;
             }
             public function map($row): array
         {
            //  echo"<pre>";print_r($row);echo"</pre>";exit;
             
            $warehousename = DB::table('warehouses')->where('id',$row->warehouse_id)->value('name');

            $salesmanname = DB::table('users')->Where('id',$row->salesperson_id)->value('name');

            $ware_att_data= DB::table('warehouse_attribute')->where('id',$row->warehouse_att_id)->first();
             
           
    
             // Use custom values if provided, otherwise use values from the data
             $values = $this->customValues ?? [
                 $warehousename,
                 $ware_att_data->position,
                 $ware_att_data->cbm,
                 $ware_att_data->area_sqft,
                 $ware_att_data->cost_per_sqft,
                 $ware_att_data->cost_per_cbm,
                 $row->ledgername,
                 $salesmanname,
                //  $row->customer_phone1,
                 $row->cbm,
                 $row->monthlycharge,
                 $row->insurance,
                 $row->vat,
                 $row->total,
                 $row->datein,
                 $row->dateout,
                 $row->duedate,
                 $row->invoicefromdate,
                 $row->invoicetodate,
                 $row->remarks,
                 $row->emailid,
         
                 // Add more columns as needed
             ];
             
    
         
        //     $keys = $this->getHeadings($row);
            
        //     $values = array_slice(array_merge($values, array_fill(0, count($keys) - count($values), null)), 0, count($keys));
     
        //  return array_combine($keys, $values);

        $result = $row->id * 2; // Example result calculation
        $customText = "Custom Text Here";
        array_splice($values, 2, 0, [$result, $customText]); // Insert result and custom text after 'name'

        $keys = $this->getHeadings($row);

        // Combine keys and values
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
    
    
    
 

