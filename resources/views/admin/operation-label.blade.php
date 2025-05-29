<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Label</title>
    <style>
        .label-container {
                display: inline-block; /* Arrange labels in a row */
                background: white;
                padding: 5px; /* Adjust padding */
                border: 1px solid #ccc;
                width: 76mm; /* Fixed width */
                height: 50mm; /* Fixed height */
                font-family: Arial, sans-serif;
                margin: 5px; /* Add space between labels */
                box-sizing: border-box; /* Ensure padding doesn't affect size */
                overflow: hidden; /* Prevent content overflow */
                text-align: center; /* Center content */
            }

            .label-container h2 {
                font-size: 16px; /* Adjust title size */
                margin: 5px 0;
            }

            .label-container p, 
            .label-container h6 {
                font-size: 12px; /* Adjust text size */
                margin: 3px 0;
            }

            .box-number {
                font-size: 16px; /* Adjust box number size */
                font-weight: bold;
            }

            /* Ensure labels print correctly */
            @media print {
                .label-container {
                    page-break-inside: avoid;
                }
            }

        .label p {
            margin: 5px 0;
        }
        .bold {
            font-weight: bold;
        }
        .box-number {
            font-size: 20px;
            font-weight: bold;
        }
    </style>
</head>
<body>

    <div class="label-container">
        @if($labelName !="" && !empty($labelName))
            <h2>{{ $labelName }}</h2>
        @endif
        
        @if($labelDescription !="" && !empty($labelDescription))
            <p>{{ $labelDescription }}</p>
        @endif

        @if($originCity !="" && !empty($originCity) || $destiCity !="" && !empty($destiCity))
            <h6>{{ $originCity }} To {{ $destiCity }}</h6>
        @endif

        @if($productType !="" && !empty($productType) || $goodsType !="" && !empty($goodsType))
            <h6>{{ $productType }}, {{ $goodsType }}</h6>
        @endif
        
        @if($shipmentDate !="" && !empty($shipmentDate))
            <p>Shipment in date <span class="bold">{{ \Carbon\Carbon::parse($shipmentDate)->format('d.m.Y') }}</span></p>
        @endif

        @if($labelNumber !="" && !empty($labelNumber))
            <p>Item/Box No – <span class="box-number">{{ $labelNumber }}</span></p>
        @endif

        <p>{{ $labelFooter }}</p>
    </div>

</body>
</html>
