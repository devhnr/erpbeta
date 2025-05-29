<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use DB;



class ReportexcelclassSales implements FromCollection, WithMapping, WithHeadings
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
             
            // echo"<pre>";print_r($row);echo"</pre>";exit;

              $servicename = DB::table('services')->where('id', $row->service_id)->value('name');
         
              
             $salesmanname = DB::table('users')->Where('id',$row->salesman_id)->value('name');

             
            $expence_data = DB::table('expense_inquiry')->where('inquiry_id',$row->id)->orderBy('movingcost_id','DESC')->get();

            // echo"<pre>";print_r($expence_data);echo"</pre>";exit;
            
            $material_data = DB::table('material_inquiry')->where('inquiry_id',$row->id)->orderBy('pack_manage_id','DESC')->get();
            
        
            $expence_count = 0;
            
                 if(count($expence_data) > 0 && $expence_data != '')
                 {
                     foreach($expence_data as $expence_data_new){
                         $expence_count +=$expence_data_new->movingcost_value;
                        //  $expence_value = $expence_data_new->movingcost_value;
                     }
                 }


             $material_data = DB::table('material_inquiry')->where('inquiry_id',$row->id)->get();

             $material_count = 0;
            
             if(count($material_data) > 0 && $material_data != '')
             {
                 foreach($material_data as $material_data_new){
                     $material_count +=$material_data_new->pack_manage_value;
                    //  $expence_value = $expence_data_new->movingcost_value;
                 }
             }





                 $quote_data = DB::table('followups')->where('id',$row->id)->get();

                 $quote_count = 0;

                if(count($quote_data) > 0 && $quote_data != ''){
                    
                    foreach($quote_data as $quote_data_new){
                        $quote_count +=$quote_data_new->total_amount;
                    }

                }

                $value = array();
                if(count($expence_data) > 0 && $expence_data != '')
                {
                    $value = array();
                    foreach($expence_data as $expence_data_new){
                    // $expence_count +=$expence_data_new->movingcost_value;
                        //  $expence_value = $expence_data_new->movingcost_value;

                        $value[] = $expence_data_new->movingcost_value;
                    }
                   
                }

                $value_new = implode(",",$value);
                $value_array = explode(",", $value_new);

                $material_value = array();
                if(count($material_data) > 0 && $material_data != '')
                

                {
                    $material_value = array();
                    foreach($material_data as $material_data_new){
                    // $expence_count +=$expence_data_new->movingcost_value;
                        //  $expence_value = $expence_data_new->movingcost_value;

                        
                           $material_value[] = $material_data_new->pack_manage_value;
                        
                    }

                }

                $get_quote_att_sum = DB::table('get_quote_attribute')
									->where('inquiry_id', $row->id)
									->sum('amount');

                if(isset($get_quote_att_sum)){
					$total_vat = $quote_count - $get_quote_att_sum;
				}else{
					$total_vat = 0;
				}
				
				
				

                $value_new = implode(",",$material_value);
                $material_value_array = explode(",", $value_new);

                //  echo"<pre>";print_r($value_array);echo"</pre>";
            
                $total_profit =  $quote_count - $expence_count - $material_count - $total_vat;
				
				

				//echo"<pre>";print_r($followup);echo"</pre>";
				
				

				$actual_sales_cost = $quote_count - $total_vat;
       
    
             // Use custom values if provided, otherwise use values from the data
             $values = $this->customValues ?? [
                 $row->quote_no,
                // $sourceleadname,
                 $servicename,
                 $salesmanname,
                 // $row->inquiry_date,
                 // $row->move_date,
                 // $row->volume,
                 $row->customer_name,
                // $row->customer_email,
                 $row->customer_phone1,
                 // $row->origin,
                 // $row->destination,
                // $follow_up_date,
                //  $row->follow_up_date_new,
                //  $row->next_follow_up_date,
                //  $row->remarks
                $quote_count !== '' ? strval($quote_count) : '',
                $total_vat !== '' ? strval($total_vat) : '',
                $actual_sales_cost !== '' ? strval($actual_sales_cost) : '',
                $expence_count !== '' ? strval($expence_count) : '',
                $total_profit,
                $material_count !== '' ? strval($material_count) : '',
                // $expence_value,
                
    
                  
            
              
         
                 // Add more columns as needed
             ];
    
         
             // Ensure both keys and values arrays have the same number of elements
             $mergedArray = array_merge($values, $value_array);
             
            // echo"<pre>";print_r($mergedArray);echo"</pre>";exit;


             $keys = $this->getHeadings($row);
             $values = array_slice(array_merge($mergedArray, array_fill(0, count($keys) - count($values), null)), 0, count($keys));
         
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
    
    
    
 

