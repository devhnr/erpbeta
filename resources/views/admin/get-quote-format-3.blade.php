<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ERP-Quotation</title>
</head>
<style>
    .accept-success-msg {
    text-align: center;
    background: green;
    color: #fff;
    padding: 10px;
}
</style>
@if ($message = Session::get('success'))
<div class="alert alert-success alert-dismissible fade show accept-success-msg" style="{{ $acceptQuoteStyle }}">
    <strong>Success!</strong> {{ $message }}
</div>
@endif
<body>
    <div style="width: 100%;">
        <!-- Header Section -->

        <div style="width: 100%;display: inline-block;">
            <img src="{{ asset('public/admin/assets/img/logo.png') }}" style="width: 30%;float: right;" draggable="false">
        </div>
        <div class="quote" style="width: 100%;display: inline-block; text-align:right">

            @if($followup_data->accepted_quotation == 0)
            <a href="{{ route('request.accept', ['enquiry_id' => $followup_data->id, 'format_type' => 3]) }}" style="text-decoration: none;{{ $acceptQuoteStyle }}">
                <button type="button"
                        style="background-color: #f39739;
                            color: #fff;
                            padding: 10px 20px;
                            border: none;
                            border-radius: 5px;
                            cursor: pointer;
                            font-size: 16px;
                            margin-right: 25%;">
                    Accept Quotation
                </button>
            </a>
            @else
                <a href="javascript:void(0);" style="text-decoration: none;{{ $acceptQuoteStyle }}">
                    <button type="button"
                            style="background-color: #f39739;
                                color: #fff;
                                padding: 10px 20px;
                                border: none;
                                border-radius: 5px;
                                cursor: pointer;
                                font-size: 16px;
                                margin-right:45%;">
                        Quotation Accepted
                    </button>
                </a>
            @endif
            <h2 style="text-decoration: underline;color:black; margin:0;font-size: 40px;display: inline-grid;width:auto;">
                Quotation</h2>
        </div>


        <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px; margin-top: 25px;">
            <tr>
                <th style="border: 1px solid #ddd; padding: 10px; text-align: left; font-size: 14px; background-color: #0056b3; color: #fff;">TO</th>
                <td style="border: 1px solid #ddd; padding: 10px; text-align: left; font-size: 14px;">
                    @if (isset($clientName) && !empty($clientName))
                        {{ $clientName }}
                    @endif
                </td>
                @if (isset($followup_data->quote_id) && !empty($followup_data->quote_id))
                    <th style="border: 1px solid #ddd; padding: 10px; text-align: left; font-size: 14px; background-color: #0056b3; color: #fff;">Quotation</th>
                    <td style="border: 1px solid #ddd; padding: 10px; text-align: left; font-size: 14px;">{{ $followup_data->quote_id }}</td>
                @endif
            </tr>

            <tr>
                @if (isset($contactPerson) && !empty($contactPerson))
                    <th style="border: 1px solid #ddd; padding: 10px; text-align: left; font-size: 14px; background-color: #0056b3; color: #fff;">Contact Person</th>
                    <td style="border: 1px solid #ddd; padding: 10px; text-align: left; font-size: 14px;">{{ $contactPerson }}</td>
                @endif
                @if (isset($followup_data->quote_no) && !empty($followup_data->quote_no))
                    <th style="border: 1px solid #ddd; padding: 10px; text-align: left; font-size: 14px; background-color: #0056b3; color: #fff;">Enquiry No</th>
                    <td style="border: 1px solid #ddd; padding: 10px; text-align: left; font-size: 14px;">{{ $followup_data->quote_no }}</td>
                @endif
            </tr>

            <tr>
                @if (isset($customerEmail) && !empty($customerEmail))
                    <th style="border: 1px solid #ddd; padding: 10px; text-align: left; font-size: 14px; background-color: #0056b3; color: #fff;">Customer Email</th>
                    <td style="border: 1px solid #ddd; padding: 10px; text-align: left; font-size: 14px;">{{ $customerEmail }}</td>
                @endif
                @if (isset($followup_data->customer_email) && !empty($followup_data->customer_email))
                    <th style="border: 1px solid #ddd; padding: 10px; text-align: left; font-size: 14px; background-color: #0056b3; color: #fff;">Email</th>
                    <td style="border: 1px solid #ddd; padding: 10px; text-align: left; font-size: 14px;">{{ $followup_data->customer_email }}</td>
                @endif
            </tr>

            <tr>
                @if (isset($customerPhoneNo) && !empty($customerPhoneNo))
                    <th style="border: 1px solid #ddd; padding: 10px; text-align: left; font-size: 14px; background-color: #0056b3; color: #fff;">Customer Mobile</th>
                    <td style="border: 1px solid #ddd; padding: 10px; text-align: left; font-size: 14px;">{{ $customerPhoneNo }}</td>
                @endif
                @if (isset($clientPhoneNo) && !empty($clientPhoneNo))
                    <th style="border: 1px solid #ddd; padding: 10px; text-align: left; font-size: 14px; background-color: #0056b3; color: #fff;">Mobile</th>
                    <td style="border: 1px solid #ddd; padding: 10px; text-align: left; font-size: 14px;">{{ $clientPhoneNo }}</td>
                @endif
            </tr>

            <tr>
                <th style="border: 1px solid #ddd; padding: 10px; text-align: left; font-size: 14px; background-color: #0056b3; color: #fff;"></th>
                    <td style="border: 1px solid #ddd; padding: 10px; text-align: left; font-size: 14px;"></td>
                @if (isset($quotation_data->quotation_date) && !empty($quotation_data->quotation_date))
                    <th style="border: 1px solid #ddd; padding: 10px; text-align: left; font-size: 14px; background-color: #0056b3; color: #fff;">Date</th>
                    <td style="border: 1px solid #ddd; padding: 10px; text-align: left; font-size: 14px;" colspan="3">{{ date('d F Y', strtotime($quotation_data->quotation_date)) }}</td>
                @endif
            </tr>
            @if (isset($followup_data->move_type) && !empty($followup_data->move_type))
            @php
                    if($followup_data->move_type == "Move Date"){
                        $move_type = date('d F Y', strtotime($followup_data->move_date));
                    }elseif ($followup_data->move_type == "Move value") {
                        $move_type = $followup_data->move_value;
                    }else{
                        $move_type = "";
                    }
                @endphp
            <tr>
                <th style="border: 1px solid #ddd; padding: 10px; text-align: left; font-size: 14px; background-color: #0056b3; color: #fff;"></th>
                    <td style="border: 1px solid #ddd; padding: 10px; text-align: left; font-size: 14px;"></td>
                @if (isset($quotation_data->quotation_date) && !empty($quotation_data->quotation_date))
                    <th style="border: 1px solid #ddd; padding: 10px; text-align: left; font-size: 14px; background-color: #0056b3; color: #fff;">Moving
                            Date:</th>
                    <td style="border: 1px solid #ddd; padding: 10px; text-align: left; font-size: 14px;" colspan="3">{{ $move_type }}</td>
                @endif
            </tr>
            @endif
            <tr>
                <th style="border: 1px solid #ddd; padding: 10px; text-align: left; font-size: 14px; background-color: #0056b3; color: #fff;"></th>
                    <td style="border: 1px solid #ddd; padding: 10px; text-align: left; font-size: 14px;"></td>
                @if (isset($followup_data->prepared_by) && !empty($followup_data->prepared_by))
                    <th style="border: 1px solid #ddd; padding: 10px; text-align: left; font-size: 14px; background-color: #0056b3; color: #fff;">Prepared by</th>
                    <td style="border: 1px solid #ddd; padding: 10px; text-align: left; font-size: 14px;" colspan="3">{{ $followup_data->prepared_by }}</td>
                @endif
            </tr>
        </table>

        @if (isset($quotation_data->cover_letter_desc) && !empty($quotation_data->cover_letter_desc))
        <div class="incl2" style="font-size: 16px;margin-top:30px;">
                {!! html_entity_decode($quotation_data->cover_letter_desc) !!}
        </div>
        @endif

        <!-- Quotation Summary -->
        <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px; margin-top: 25px;">
            <tr>
                <th style="border: 1px solid #ddd; padding: 10px; text-align: left; font-size: 14px; background-color: #0056b3; color: #fff;">No.</th>
                <th style="border: 1px solid #ddd; padding: 10px; text-align: left; font-size: 14px; background-color: #0056b3; color: #fff;">Description</th>
                @if(isset($quotation_data) && $quotation_data->vat_charge == "1")
                <th style="border: 1px solid #ddd; padding: 10px; text-align: left; font-size: 14px; background-color: #0056b3; color: #fff;">Total</th>
                <th style="border: 1px solid #ddd; padding: 10px; text-align: left; font-size: 14px; background-color: #0056b3; color: #fff;">VAT (5%)</th>
                @endif
                <th style="border: 1px solid #ddd; padding: 10px; text-align: left; font-size: 14px; background-color: #0056b3; color: #fff;">Amount (AED)</th>
            </tr>
            <tr>
                <td style="border: 1px solid #ddd; padding: 10px; text-align: left; font-size: 14px;">1</td>
                <td style="border: 1px solid #ddd; padding: 10px; text-align: left; font-size: 14px;">{{ $followup_data->description ?? "" }}</td>
                @if(isset($quotation_data) && $quotation_data->vat_charge == "1")
                <td style="border: 1px solid #ddd; padding: 10px; text-align: left; font-size: 14px;">{{ isset($followup_data->prov_sum) ? number_format(($followup_data->selling_amount), 2) : '' }}</td>
                <td style="border: 1px solid #ddd; padding: 10px; text-align: left; font-size: 14px;">{{ isset($followup_data->prov_sum) ? number_format(($followup_data->selling_amount * 5 / 100), 2) : '' }}</td>
                @endif
                {{-- <td style="border: 1px solid #ddd; padding: 10px; text-align: left; font-size: 14px;">{{ $followup_data->grand_total ?? "0.00" }}</td> --}}


                <td style="border: 1px solid #ddd; padding: 10px; text-align: left; font-size: 14px;">{{ $followup_data->grand_total_with_vat ?? "0.00" }}</td>
            </tr>
        </table>
        <p style="font-size: 14px; line-height: 1.6; color: #333;"><strong style="color: #000;">Net Total (AED)</strong> {{ $followup_data->grand_total_with_vat ?? "0.00" }}</p>

        <!-- Shipment Information -->
        <!-- <h2 style="font-weight: bold; text-decoration: underline; margin-bottom: 10px; color: #0056b3;">Shipment Information</h2> -->
        <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
            <tr>
                <th colspan="2" class="text-center" style="border: 1px solid #ddd; padding: 10px; text-align: left; font-size: 14px; background-color: #0056b3; color: #fff;">Shipment Information</th>
            </tr>
            @if (isset($services_required) && !empty($services_required))
            <tr>
                <th style="border: 1px solid #ddd; padding: 10px; text-align: left; font-size: 14px; color: #000;">Service</th>
                <td style="border: 1px solid #ddd; padding: 10px; text-align: left; font-size: 14px;">{{ $services_required }}</td>
            </tr>
            @endif
            @if (isset($description_goods) && !empty($description_goods))
            <tr>
                <th style="border: 1px solid #ddd; padding: 10px; text-align: left; font-size: 14px; color: #000;">Description Of Goods</th>
                <td style="border: 1px solid #ddd; padding: 10px; text-align: left; font-size: 14px;">{{ $description_goods}}</td>
            </tr>
            @endif
            @if (isset($service_data) && !empty($service_data))
            <tr>
                <th style="border: 1px solid #ddd; padding: 10px; text-align: left; font-size: 14px; color: #000;">Service Type</th>
                <td style="border: 1px solid #ddd; padding: 10px; text-align: left; font-size: 14px;">{{ $service_data }}</td>
            </tr>
            @endif
            @if (isset($originFullAddress) && !empty($originFullAddress))
            <tr>
                <th style="border: 1px solid #ddd; padding: 10px; text-align: left; font-size: 14px; color: #000;">Origin Address</th>
                <td style="border: 1px solid #ddd; padding: 10px; text-align: left; font-size: 14px;">{{ $originFullAddress }}</td>
            </tr>
            @endif
            @if (isset($destinationFullAddress) && !empty($destinationFullAddress))
            <tr>
                <th style="border: 1px solid #ddd; padding: 10px; text-align: left; font-size: 14px; color: #000;">Destination Address</th>
                <td style="border: 1px solid #ddd; padding: 10px; text-align: left; font-size: 14px;">{{ $destinationFullAddress }}</td>
            </tr>
            @endif

            @if (isset($followup_data->est_time_to_complete) && !empty($followup_data->est_time_to_complete))
            <tr>
                <th style="border: 1px solid #ddd; padding: 10px; text-align: left; font-size: 14px; color: #000;">Est Time to Complete:</th>
                <td style="border: 1px solid #ddd; padding: 10px; text-align: left; font-size: 14px;">{{ $followup_data->est_time_to_complete }}</td>
            </tr>
            @endif
            @if (isset($followup_data->quote_vol) && !empty($followup_data->quote_vol))
            <tr>
                <th style="border: 1px solid #ddd; padding: 10px; text-align: left; font-size: 14px; color: #000;">Estimated Volume:</th>
                <td style="border: 1px solid #ddd; padding: 10px; text-align: left; font-size: 14px;">{{ $followup_data->quote_vol }}</td>
            </tr>
            @endif
            @if (isset($followup_data->shipment_type) && !empty($followup_data->shipment_type) && $followup_data->shipment_type != 0)
                @php
                    $shipment_type = Helper::shipment_type($followup_data->shipment_type);
                @endphp
            <tr>
                <th style="border: 1px solid #ddd; padding: 10px; text-align: left; font-size: 14px; color: #000;">Transport Mode:</th>
                <td style="border: 1px solid #ddd; padding: 10px; text-align: left; font-size: 14px;">{{ $shipment_type }}</td>
            </tr>
            @endif
        </table>


        <!-- Footer Section -->
        {{-- @if (isset($quotation_data->footer_desc) && !empty($quotation_data->footer_desc))
        <p style="font-size: 14px; line-height: 1.6; color: #333;">{!! html_entity_decode($quotation_data->footer_desc) !!}</p>
        @endif --}}
        @if (isset($quotation_data->footer_desc) && !empty($quotation_data->footer_desc))
        {!! html_entity_decode($quotation_data->footer_desc) !!}
        @endif

        {{-- <div class="incl2" style="font-size: 16px;">
            @if (isset($quotation_data->footer_desc) && !empty($quotation_data->footer_desc))
                {!! html_entity_decode($quotation_data->footer_desc) !!}
            @endif
        </div> --}}

        {{-- <div style="width: 100%;display: inline-block;">
            <p style="margin-left:27%;margin-top:50px;margin-bottom:10px;">
                <b>For : QUICKSERVE RELOCATIONS LLC -2024-25</b>
             </p>
            <img src="{{ asset('public/admin/assets/img/erp-sign.png') }}" style="width: 30%;float: right;margin-right:60px;" draggable="false">
            <p style="margin-left:65%;margin-top:21%;">Authorised Signatory</p>
        </div> --}}

    </div>
</body>
</html>
