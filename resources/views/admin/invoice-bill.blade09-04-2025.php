<!DOCTYPE html>
<html>
<head>
    <style>
        .customtable th, .customtable td {
            border: 1px solid #000;padding: 5px 8px;text-align: left;vertical-align: top;
        }
        /* .amount-section {width: 45%;float: left;padding: 10px;} */
       /*  .signature {
            text-align: right;
            font-weight: bold;
        } */
       /*  .clear {
            clear: both;
        } */
    </style>
</head>
<body>
    <div>   
        <img src="{{ asset('public/admin/assets/img/logo.png') }}" style="width: 30%;">
    </div>
    
    <p style="font-weight:bold;text-align:center;font-family:sans-serif;">TRN: TRN001</p>
    
    <table style="width: 100%; border-collapse: collapse;" class="customtable">
        <tr>
            <td rowspan="6" style="width: 40%; vertical-align: top; padding: 10px;border: 1px solid #000;text-align: left;vertical-align: top;font-family:sans-serif;">
                <p>Buyer: <strong>{{ $clientName }}</strong></p>
                <p>Emirates: {{ $city }}</p>
                <p>Country: {{ $country_name }}</p>
                <p>Place of Supply: {{ Helper::countryname($followup->desti_country).', '.$followup->desti_city }}</p>
            </td>
        </tr>
        <tr>
            {{-- <td style="border: 1px solid #000;text-align: left;vertical-align: top;font-family:sans-serif;">Invoice No: <strong>{{ $followup->order_number }}</strong></td> --}}
            <td style="border: 1px solid #000;text-align: left;vertical-align: top;font-family:sans-serif;">Buyer's order No: {{ $quotation_data->purchase_order_no }}</td>
            <td style="border: 1px solid #000;text-align: left;vertical-align: top;font-family:sans-serif;">Dated: <strong>{{ $invoice_date }}</strong></td>
        </tr>
        <tr>
            {{-- <td style="border: 1px solid #000;text-align: left;vertical-align: top;font-family:sans-serif;">Buyer's order No: {{ $quotation_data->purchase_order_no }}</td> --}}
            <td style="border: 1px solid #000;text-align: left;vertical-align: top;font-family:sans-serif;" colspan="2">Dated: 01/01/2023</td>
        </tr>
        <tr>
            <td style="border: 1px solid #000;text-align: left;vertical-align: top;font-family:sans-serif;">Supplier's Ref:</td>
            <td style="border: 1px solid #000;text-align: left;vertical-align: top;font-family:sans-serif;">Mode/Terms of Payment:</td>
        </tr>
        <tr>
            <td colspan="2" style="border: 1px solid #000;text-align: left;vertical-align: top;padding-bottom: 40px;font-family:sans-serif;">Terms of Delivery</td>
        </tr>
    </table>
    
    <table style="border-collapse: collapse; width: 100%;font-family:sans-serif;" class="customtable">
        <tr>
            <th style="border: 1px solid #000;padding: 5px 8px;text-align: left;vertical-align: top;">SI No</th>
            <th style="border: 1px solid #000;padding: 5px 8px;text-align: left;vertical-align: top;">Description of Services</th>
            <th style="border: 1px solid #000;padding: 5px 8px;text-align: left;vertical-align: top;">Quantity</th>
            <th style="border: 1px solid #000;padding: 5px 8px;text-align: left;vertical-align: top;">Rate</th>
            <th style="border: 1px solid #000;padding: 5px 8px;text-align: left;vertical-align: top;">Per</th>
            <th style="border: 1px solid #000;padding: 5px 8px;text-align: left;vertical-align: top;">Amount</th>

            @if(isset($invoice_data) && $invoice_data->vat_charge == 1)
                <th style="border: 1px solid #000;padding: 5px 8px;text-align: left;vertical-align: top;">VAT %</th>
            @endif
        </tr>
        @php
            $total_amount = 0;
            $totalQty = 0;
            $totalAmtMargin = 0;
            $vat_charge_amount = 0;
        @endphp
        @if(isset($costing_attribute) && !empty($costing_attribute) && count($costing_attribute) > 0)
            @foreach($costing_attribute as $key => $costing)
            @php
                $margin = $costing->total * $followup->margin_percent / 100;
                $totalAmtMargin = $costing->total + $margin;
                $totalQty += $costing->qty;

                if(isset($invoice_data) && $invoice_data->vat_charge == 1){
                    $vat_charge = $totalAmtMargin * 5 / 100;
                    $totalAmtMargin = $totalAmtMargin + $vat_charge;
                    $vat_charge_amount += $vat_charge;
                }

                $total_amount += $totalAmtMargin;
            @endphp
            <tr>
                <td style="border: 1px solid #000;padding: 5px 8px;text-align: left;vertical-align: top;">{{ $key + 1 }}</td>
                <td style="border: 1px solid #000;padding: 5px 8px;text-align: left;vertical-align: top;">{{ $costing->code }}</td>
                <td style="border: 1px solid #000;padding: 5px 8px;text-align: left;vertical-align: top;">{{ $costing->qty }}</td>
                <td style="border: 1px solid #000;padding: 5px 8px;text-align: left;vertical-align: top;">{{ number_format($totalAmtMargin,2) }}</td>
                <td style="border: 1px solid #000;padding: 5px 8px;text-align: left;vertical-align: top;">{{ ucfirst($costing->unit) }}</td>
                <td style="border: 1px solid #000;padding: 5px 8px;text-align: left;vertical-align: top;">{{ number_format($totalAmtMargin,2)  }}</td>
                @if(isset($invoice_data) && $invoice_data->vat_charge == 1)
                    <td style="border: 1px solid #000;padding: 5px 8px;text-align: left;vertical-align: top;">5%</td>
                @endif
            </tr>
            @endforeach
        @else 
            <tr>
                <td style="border: 1px solid #000;padding: 5px 8px;text-align: left;vertical-align: top;">{{ '1' }}</td>
                <td style="border: 1px solid #000;padding: 5px 8px;text-align: left;vertical-align: top;">{{ $followup->description }}</td>
                <td style="border: 1px solid #000;padding: 5px 8px;text-align: left;vertical-align: top;">{{ $totalQtyUnchecked }}</td>
                <td style="border: 1px solid #000;padding: 5px 8px;text-align: left;vertical-align: top;">{{ number_format($followup->prov_sum,2) }}</td>
                <td style="border: 1px solid #000;padding: 5px 8px;text-align: left;vertical-align: top;">{{ "-" }}</td>
                <td style="border: 1px solid #000;padding: 5px 8px;text-align: left;vertical-align: top;">{{ number_format($followup->grand_total,2) }}</td>
                @if(isset($invoice_data) && $invoice_data->vat_charge == 1)
                    <td style="border: 1px solid #000;padding: 5px 8px;text-align: left;vertical-align: top;">5%</td>
                @endif
            </tr>
        @endif
        @php
            if($totalQty == 0){
                $totalQty = $totalQtyUnchecked;
                $total_amount = round($followup->grand_total);
            }

            if(isset($invoice_data) && $invoice_data->vat_charge == 1 && $vat_charge_amount == 0){
                    $vat_charge_amount = $followup->selling_amount * 5 / 100;
            }
        @endphp
        <tr>
            <td style="border: 1px solid #000;padding: 5px 8px;text-align: left;vertical-align: top;" style="font-weight:bold;" colspan="2">Total</td>
            <td style="border: 1px solid #000;padding: 5px 8px;text-align: left;vertical-align: top;" style="font-weight:bold;">{{ $totalQty }}</td>
            <td style="border: 1px solid #000;padding: 5px 8px;text-align: left;vertical-align: top;" colspan="3" class="bold text-left">AED {{ number_format($followup->grand_total,2) }}</td>
            @if(isset($invoice_data) && $invoice_data->vat_charge == 1)
                <td></td>
            @endif
        </tr>
    </table>
    
    <div style="border: 1px solid #000;padding: 5px;font-family:sans-serif;">
        <div style="width:35%;float: left;padding: 10px;font-size: 13px;">
            <p style="margin:0px">Amount Chargeable (in words)</p>
            <p style="font-weight:bold;margin:0px">UAE Dirham {{ $total_amount_word }} (AED {{ round($total_amount) }})</p>
            
            @if (isset($invoice_data) && $invoice_data->vat_charge == 1) <!--  VAT Charge -->
                <p style="margin:0px;">VAT Amount (in words)</p>
                <p style="font-weight:bold;margin:0px">UAE Dirham {{ $vat_amount_word }} ({{ round($vat_charge_amount) }})</p>
            @endif
        </div>
        
        <div style="width: 50%;float: left;padding: 10px;margin:0px;">
            <p style="font-weight:bold;text-align: right;margin:0px;font-size: 13px;">E. & O.E.</p>
            @if(isset($invoice_data) && $invoice_data->vat_charge == 1 && count($costing_attribute) > 0)
            <table style="width:300px;margin-left:225px;font-family:sans-serif;">
                <tr>
                    <th style="border-bottom: 1px solid #000;">VAT %</th>
                    <th style="border-bottom: 1px solid #000;">Assessable Value</th>
                    <th style="border-bottom: 1px solid #000;">Tax Amount</th>
                </tr>

                @if(isset($costing_attribute) && !empty($costing_attribute) && $costing_attribute !="")
                @php
                    $total_amount = 0;
                    $totalQty = 0;
                    $totalAmtMargin = 0;
                    $vat_amount = 0;
                @endphp
                @foreach($costing_attribute as $key => $costing)
                @php
                    $margin = $costing->total * $followup->margin_percent / 100;
                    $totalAmtMargin = $costing->total + $margin;
                    $totalQty += $costing->qty;

                    if(isset($invoice_data) && $invoice_data->vat_charge == 1){
                        $vat_amount = $totalAmtMargin * 5 / 100;
                    }

                    $total_amount += $totalAmtMargin;
                @endphp
                <tr>
                    <td style="border-bottom: 1px solid #000;">5%</td>
                    <td style="border-bottom: 1px solid #000;">{{ number_format($totalAmtMargin,2) }}</td>
                    <td style="border-bottom: 1px solid #000;">{{ number_format($vat_amount,2) }}</td>
                </tr>
                @endforeach
                @endif
            </table>
            @endif
        </div>
        <div style="width: 40%;float: left;padding: 10px;font-size: 13px;margin:0px;">
            <p style="margin:0px;font-weight:bold;">Company's Bank Details</p>
            <p style="margin:0px;">A/c Holder's Name: <b>QUICKSERVE RELOCATIONS LLC</b></p>

            <p style="margin:0px;">Bank Name: <b>Abu Dhabi Commercial Bank</b></p>
            <p style="margin:0px;">A/c No.: <b>12089334920001</b></p>
            <p style="margin:0px;">IBAN: <b>AE640030012089334920001</b></p>
            <p style="margin:0px;">Branch & SWIFT Code: <b>257 - MALL OF THE EMIRATES ? DUBAI & ADCBAEAA</b></p>

            <p style="margin:0px;text-decoration:underline;"><b>Declaration</b></p>
            <p>We declare that this invoice shows the actual price of the goods described and that all particulars are true and correct.</p>

            
        </div>
        <div style="width: 50%;float: left;padding: 10px;text-align: right;">
            <p style="font-weight:bold;margin:0px">For: QUICKSERVE RELOCATIONS LLC</p>
            <img src="{{ asset('public/admin/assets/img/erp-sign.png') }}" alt="logo" draggable="false" style="width: 190px;height: 111px;">
            <p style="font-weight:bold;margin-top:20px;">Authorised Signatory</p>
        </div>
        <div style="clear: both;"></div>
    </div>
</body>
</html>
