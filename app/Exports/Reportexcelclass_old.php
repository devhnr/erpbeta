<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use DB;
class Reportexcelclass implements FromCollection, WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
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
    $sourceleadname = DB::table('source_leads')->where('id', $row->sourcelead_id)->value('name');

    $salesmanname = DB::table('users')->Where('id',$row->salesman_id)->value('name');

    // Use custom values if provided, otherwise use values from the data
    $values = $this->customValues ?? [
        $row->quote_no,
        $sourceleadname,
        $row->local_storage_export,
        $salesmanname,
        $row->inquiry_date,
        $row->move_date,
        $row->volume,
        $row->customer_name,
        $row->customer_email,
        $row->customer_phone,
        $row->origin,
        $row->destination,
        // Add more columns as needed
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