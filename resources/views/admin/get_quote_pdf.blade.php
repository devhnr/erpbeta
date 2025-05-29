<!doctype html>
<html>
<head>
    <title>ERP-Quotation</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        .accept-success-msg {
        text-align: center;
        background: green;
        color: #fff;
        padding: 10px;
    }
    </style>
    <style>
        table,th,td {
            border: 1px solid black;
            border-collapse: collapse;
        }
        p,
        ol {
            margin: 0
        }
    </style>
</head>

@if ($message = Session::get('success'))
<div class="alert alert-success alert-dismissible fade show accept-success-msg" style="{{ $acceptQuoteStyle }}">
    <strong>Success!</strong> {{ $message }}
</div>
@endif

<body>
    <div class="" style="width:100%">
        <div style="width: 100%;display: inline-block;">
            <img src="{{ asset('public/admin/assets/img/logo.png') }}" style="width: 30%;float: right;" draggable="false">
        </div>

        <div class="quote" style="width: 100%;display: inline-block; text-align:right">

            @if($followup_data->accepted_quotation == 0)
                <a href="{{ route('request.accept', ['enquiry_id' => $followup_data->id, 'format_type' => 1]) }}" style="text-decoration: none;{{ $acceptQuoteStyle }}">
                    <button type="button"
                            style="background-color: #f39739;
                                color: #fff;
                                padding: 10px 20px;
                                border: none;
                                border-radius: 5px;
                                cursor: pointer;
                                font-size: 16px;
                                margin-right:45%;">
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




        @if (isset($quotation_data->cover_letter_desc) && !empty($quotation_data->cover_letter_desc))
        <div class="incl2" style="font-size: 16px;margin-top:30px;">
                {!! html_entity_decode($quotation_data->cover_letter_desc) !!}
        </div>
        @endif



        <div style="margin: 34px 0;">
            <table style="width:100%">
                <tr>
                    <th rowspan="6"
                        style="text-align: left;padding: 0 0 40px 14px;font-weight: normal;vertical-align: top;padding-top: 18px;">
                        @if (isset($clientName) && !empty($clientName))
                           
                            <p style="margin-top: 0;margin-bottom: 5px;">To:&nbsp;{{$title_rank}} {{ $clientName }}
                                @if($followup_data->customer_type == 2)
                            @if (isset($contactPerson) && !empty($contactPerson))<br>
                                <label for="">Contact Person: </label> {{ $contactPerson }} @endif
                            </p>
                            <br />
                            @endif
                        @endif

                        @if($followup_data->customer_type == 2)
                            @if (isset($followup_data->address) && !empty($followup_data->address))
                                <p style="margin-top: 0;margin-bottom: 5px;">Address:&nbsp;{{ $followup_data->address ?? "" }}</p>
                            @endif
                        @else

                        @if (isset($followup_data->c_add) && !empty($followup_data->c_add))
                            <p style="margin-top: 0;margin-bottom: 5px;">Address:&nbsp;{{ $followup_data->c_add ?? "" }}</p>
                        @endif

                        @endif
                        



                        @if (isset($followup_data->customer_phone1) && !empty($followup_data->customer_phone1) ||
                            isset($followup_data->customer_phone2) && !empty($followup_data->customer_phone2)
                            )
                            <p style="margin-top: 0;margin-bottom: 5px;">
                                Phone 1:&nbsp;{{ $followup_data->customer_phone1 ?? "" }}</p>

                            @if (isset($followup_data->customer_phone2) && !empty($followup_data->customer_phone2))
                            <p style="margin-top: 0;margin-bottom: 5px;">
                                Phone 2:&nbsp;{{ $followup_data->customer_phone2 ?? "" }}</p>
                            @endif
                        @endif

                        @if (isset($followup_data->customer_email) && !empty($followup_data->customer_email))
                            <p style="margin-top: 0;margin-bottom: 5px;">Email ID:&nbsp;{{ $followup_data->customer_email ?? "" }}</p>
                        @endif

                        @if (isset($followup_data->f_name) && !empty($followup_data->f_name) ||
                             isset($followup_data->l_name) && !empty($followup_data->l_name) ||
                             isset($followup_data->c_email) && !empty($followup_data->c_email))
                            {{-- <br /> --}}
                            {{-- <p style="margin-top: 0;margin-bottom: 5px;">Customer Detiails : </p> --}}
                            @if (isset($followup_data->f_name) && !empty($followup_data->f_name) ||
                                isset($followup_data->l_name) && !empty($followup_data->l_name))
                                    {{-- <p style="margin-top: 0;margin-bottom: 5px;">
                                        Name: &nbsp;{{ $followup_data->f_name ?? "" }}&nbsp;
                                    @if(isset($followup_data->l_name) && !empty($followup_data->l_name)){{ $followup_data->l_name }} @endif</p> --}}
                            @endif
                            @if (isset($followup_data->c_email) && !empty($followup_data->c_email))
                                    <p style="margin-top: 0;margin-bottom: 5px;">
                                        Email ID: &nbsp;{{ $followup_data->c_email ?? "" }}&nbsp;
                                    </p>
                            @endif
                            @if (isset($followup_data->c_mobile) && !empty($followup_data->c_mobile))
                                <p style="margin-top: 0;margin-bottom: 5px;">
                                    Phone 1:&nbsp;{{ $followup_data->c_mobile ?? "" }}</p>

                                @if (isset($followup_data->c_phone) && !empty($followup_data->c_phone))
                                <p style="margin-top: 0;margin-bottom: 5px;">
                                    Phone 2:&nbsp;{{ $followup_data->c_phone ?? "" }}</p>
                                @endif
                            @endif
                        @endif

                    </th>
                    @if (isset($followup_data->quote_id) && !empty($followup_data->quote_id))
                        <td style="padding: 10px 0px 10px 10px;">Quotation No: {{ $followup_data->quote_id }} </td>
                    @endif
                </tr>
                   {{--  <tr>
                        <td style="padding: 10px 0px 10px 10px;">Date:
                                {{ date('d-m-y') }}
                        </td>
                    </tr> --}}
                @if (isset($surveyor) && !empty($surveyor))
                    <tr>
                        <td style="padding: 10px 0px 10px 10px;">Surveyor: {{ $surveyor }} </td>
                    </tr>
                @else
                    <tr>
                        <td style="padding: 10px 0px 10px 10px;">Surveyor: {{ 'N/A' }}</td>
                    </tr>
                @endif

                @if (isset($followup_data->s_date) && !empty($followup_data->s_date) && $followup_data->s_date != '0000-00-00' && $followup_data->s_date != '1970-01-01')
                    <tr>
                        <td style="padding: 10px 0px 10px 10px;">Survey Date:
                                {{ date('d-m-y', strtotime($followup_data->s_date)) }}
                        </td>
                    </tr>

                @endif

                @if (isset($quotation_data->quotation_date) && !empty($quotation_data->quotation_date))
                    <tr>
                        <td style="padding: 10px 0px 10px 10px;">Quotation
                            Date:{{ date('d-m-y', strtotime($quotation_data->quotation_date)) }}</td>
                    </tr>
                @endif

                @if (isset($followup_data->move_type) && !empty($followup_data->move_type))
                @php
                    if($followup_data->move_type == "Move Date"){
                        $move_type = date('d-m-y', strtotime($followup_data->move_date));
                    }elseif ($followup_data->move_type == "Move value") {
                        $move_type = $followup_data->move_value;
                    }else{
                        $move_type = "";
                    }
                @endphp
                    <tr>
                        <td style="padding: 10px 0px 10px 10px;">Moving
                            Date:{{ $move_type }}</td>
                    </tr>
                @endif

                @if (isset($followup_data->prepared_by) && !empty($followup_data->prepared_by))
                    <tr>
                        <td style="padding: 10px 0px 10px 10px;">Prepared by: {{ $followup_data->prepared_by }}</td>
                    </tr>
                @endif
            </table>
        </div>



        <div class="test">
            <table style="width:100%">
                <tr style="background: #0056b3;color: #FFFFFF !important;">
                    <th style="padding: 5px 0px 5px 0px;width:8%; color: #FFFFFF !important;">Sl No</th>
                    <th style="padding: 5px 0px 5px 0px;color: #FFFFFF !important;">Particulars</th>
                    @if(isset($quotation_data) && $quotation_data->vat_charge == "1")
                    <th style="padding: 5px 0px 5px 0px;color: #FFFFFF !important;width:14%;">Total</th>
                    <th style="padding: 5px 0px 5px 0px;color: #FFFFFF !important;width:14%;">VAT (5 %)</th>
                    @endif
                    <th style="padding: 5px 0px 5px 0px;color: #FFFFFF !important;width:17%;">Amount(AED)</th>
                </tr>
                <tr>
                    <td style="padding: 10px 0px 10px 10px;">{{ '1' }}</td>
                    <td style="padding: 10px 0px 10px 10px;">{{ $followup_data->description ?? "" }}</td>

                    @if(isset($quotation_data) && $quotation_data->vat_charge == "1")
                        <td style="padding: 10px;text-align: right;width:14%;">
                            {{ isset($followup_data->prov_sum) ? number_format(($followup_data->selling_amount), 2) : '' }}
                        </td>
                        <td style="padding: 10px;text-align: right;width:14%;">
                            {{ isset($followup_data->prov_sum) ? number_format(($followup_data->selling_amount * 5 / 100), 2) : '' }}
                        </td>
                    @endif

                    
                    {{-- <td style="padding: 10px; text-align: right;width:17%;">{{ $followup_data->grand_total ?? "0.00" }}</td> --}}
                    <td style="padding: 10px; text-align: right;width:17%;">{{ $followup_data->grand_total_with_vat ?? "0.00" }}</td>
                </tr>
            </table>
        </div>
        <div class="Shipment Information">
            <table style="width:100%;margin:34px 0px 40px 0px;">
                <tr style="background: #0056b3;color: #FFFFFF !important;">
                    <th colspan="2" style="padding: 10px 0px 10px 10px;color: #FFFFFF !important;text-align:center;">Shipment
                        Information</th>
                </tr>
                @if (isset($description_goods) && !empty($description_goods))
                    <tr>
                        <td style="padding: 10px 0px 10px 10px;">Description Of Goods:</td>
                        <td style="padding: 10px 0px 10px 10px;">
                                {{ $description_goods}}
                        </td>
                    </tr>
                @endif
                @if (isset($services_required) && !empty($services_required))
                    <tr>
                        <td style="padding: 10px 0px 10px 10px;">Service Required:</td>
                        <td style="padding: 10px 0px 10px 10px;">
                                {{ $services_required }}
                        </td>
                    </tr>
                @endif
                @if (isset($service_data) && !empty($service_data))
                    <tr>
                        <td style="padding: 10px 0px 10px 10px;">Service Type:</td>
                        <td style="padding: 10px 0px 10px 10px;">
                                {{ $service_data }}
                        </td>
                    </tr>
                @endif
                @if (isset($followup_data->value_1) && !empty($followup_data->value_1) || isset($followup_data->option_1) && !empty($followup_data->option_1))
                    <tr style="display: none;">
                        <td style="padding: 10px 0px 10px 10px;">Estimated Volume:</td>
                        <td style="padding: 10px 0px 10px 10px;">{{ $followup_data->value_1 ?? "" }} {{ $followup_data->option_1 ?? "" }}</td>
                    </tr>
                @endif
                @if (isset($originFullAddress) && !empty($originFullAddress))
                    <tr>
                        <td style="padding: 10px 0px 10px 10px;">Origin Address:</td>
                        <td style="padding: 10px 0px 10px 10px;">{{ $originFullAddress }}</td>
                    </tr>
                @endif
                @if (isset($destinationFullAddress) && !empty($destinationFullAddress))
                    <tr>
                        <td style="padding: 10px 0px 10px 10px;">Destination Address:</td>
                        <td style="padding: 10px 0px 10px 10px;">{{ $destinationFullAddress }}</td>
                    </tr>
                @endif
                @if (isset($followup_data->est_time_to_complete) && !empty($followup_data->est_time_to_complete))
                    <tr>
                        <td style="padding: 10px 0px 10px 10px;">Est Time to Complete:</td>
                        <td style="padding: 10px 0px 10px 10px;">{{ $followup_data->est_time_to_complete ?? "" }}</td>
                    </tr>
                @endif
                @if (isset($followup_data->quote_vol) && !empty($followup_data->quote_vol))
                    <tr>
                        <td style="padding: 10px 0px 10px 10px;">Estimated Volume:</td>
                        <td style="padding: 10px 0px 10px 10px;">{{ $followup_data->quote_vol ?? "" }}</td>
                    </tr>
                @endif
                @if (isset($followup_data->shipment_type) && !empty($followup_data->shipment_type) && $followup_data->shipment_type != 0)
                @php
                    $shipment_type = Helper::shipment_type($followup_data->shipment_type);
                @endphp
                    <tr>
                        <td style="padding: 10px 0px 10px 10px;">Transport Mode:</td>
                        <td style="padding: 10px 0px 10px 10px;">{{ $shipment_type ?? "" }}</td>
                    </tr>
                @endif

            </table>
        </div>
       {{--  <div class="incl" style="font-size: 20px;">
            <span><b>Price Includes:</b></span>
        </div> --}}
        <div class="incl2" style="font-size: 16px;">
            @if (isset($quotation_data->footer_desc) && !empty($quotation_data->footer_desc))
                {!! html_entity_decode($quotation_data->footer_desc) !!}
            @endif
        </div>


    </div>
    {{-- <div style="width: 100%;display: inline-block;">
        <p style="margin-left:40%;margin-top:50px;margin-bottom:10px;"><b>For : QUICKSERVE RELOCATIONS LLC -2024-25</b></p>
        <img src="{{ asset('public/admin/assets/img/erp-sign.png') }}" style="width: 30%;float: right;margin-right:60px;" draggable="false">
        <p style="margin-left:70%;margin-top:21%;">Authorised Signatory</p>
    </div> --}}
</body>

</html>
