<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use DB;

class ReportexcelclassMaterial implements FromCollection, WithMapping, WithHeadings
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
        //echo"<pre>";print_r($row);echo"</pre>";exit;
         // $sourceleadname = DB::table('source_leads')->where('id', $row->sourcelead_id)->value('name');
     
         $materialname = DB::table('pack_manages')->where('id', $row->packge_manage_id)->value('name');

         //echo"<pre>";print_r($materialname);echo"</pre>";exit;
     
         $values = $this->customValues ?? [
             $materialname,
             $row->qty,
             $row->date
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


