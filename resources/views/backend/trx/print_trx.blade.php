<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Transaction - {{ $transaction->rcn_no }}</title>
    <style>
        * {
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif.
        }

        div {
            font-size: 13px;
        }

        #watermark {
            position: fixed;

            bottom: 5.5cm;
            left: 10cm;

            /** Change image dimensions**/
            width: 8cm;
            height: 8cm;

            /** Your watermark should be behind every content**/
            z-index: -1000;
        }

        #footer {
            bottom: 0;
            position: fixed;
            width: 100%;
            font-size: 12px;
            color: gray;
        }
    </style>
</head>

<body @yield('body-styles') style="{{ isset($is_interim) && $is_interim ? $interimStyle : '' }}">
    <div id="watermark">
        <img src="data:image/png;base64,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"
            height="100%" width="100%" />
    </div>


    <div id="printableArea">
        <style>
            .border {
                1px solid black !important;
            }
        </style>

        <div class="wrapper">
            <table style="width: 100%">
                <tbody>
                    <tr>
                        <td style="padding-right: 20px">No: {{ $transaction->id }}</td>
                        <td style="text-align: center; border: 1px solid black; padding: 0 30px;">
                            <table style="width: 100%">
                                <tbody>
                                    <tr>
                                        <td style="text-align: left">
                                            <div>
                                                ROAD CONSIGNEMNT NOTE - NUMBER: <b>{{
                                                    $transaction->rcn_no
                                                    }}</b>
                                            </div>
                                        </td>
                                        <td style="text-align: right">
                                            <div>
                                                P.O. - NUMBER: <b class="font-weight-bold">{{ $transaction->tracking_no
                                                    }}</b>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                        <td style="padding-left: 20px">
                            BOLLORE
                        </td>
                    </tr>
                </tbody>
            </table>

            <table style="width: 100%">
                <tbody>
                    <tr>
                        <td>
                            <h3 class="underline"><u>Agent At Departure</u></h3>

                            {{-- <div>
                                <div>BOLLORE TRANSPORT & LOGISTICS</div>
                                <div>LIMITED, AIRPORT NORTH ROAD, EMB</div>
                                <div>PIN P000069983U, P.O. BOX 465</div>
                                <div>NAIROBI</div>
                                <div>KENYA</div>
                            </div> --}}
                        </td>
                        <td>
                            <h3 class="underline"><u>Agent At Destination</u></h3>
                            {{-- <div>
                                <div>BOLLORE TRANSPORT & LOGISTICS</div>
                                <div>LIMITED, AIRPORT NORTH ROAD, EMB</div>
                                <div>PIN P000069983U, P.O. BOX 465</div>
                                <div>NAIROBI</div>
                                <div>KENYA</div>
                            </div> --}}
                        </td>
                        <td>
                            <h3 class="underline"><u>Carrier</u></h3>
                            <div> {{ @$transaction->carrierR->name }} </div>                            
                        </td>
                        <td>
                            <div>
                                <span style="font-weight: bold">Place of loading</span>
                                <span>:</span>
                                <span>{{ @$transaction->uploadTrx->loading_place }}</span>
                            </div>
                            <div>
                                <span style="font-weight: bold">Loading date</span>
                                <span>:</span>
                                <span>{{ @$transaction->uploadTrx->loading_date }}</span>
                            </div>
                            {{-- <div>
                                <span style="font-weight: bold">Place of delivery</span>
                                <span>:</span>
                                <span>KE ONXNAIROBI AREA</span>
                            </div> --}}
                            <div>&nbsp;</div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <span style="font-weight: bold">Vehicle</span>
                                    <span>:</span>
                                    <span>{{@$transaction->vehicleR->number}}</span>
                                </div>
                                <div class="col-sm-6">
                                    <span style="font-weight: bold">Trailer</span>
                                    <span>:</span>
                                    <span>{{@$transaction->vehicleR->trailer}}</span>
                                </div>
                            </div>
                            <div>
                                <span style="font-weight: bold">Owner</span>
                                <span>:</span>
                                <span>{{@$transaction->consigneeR->name}}</span>
                            </div>
                            <div>
                                <span style="font-weight: bold">DRIVER</span>
                                <span>:</span>
                                <span>{{ $transaction->carrierR->name }}</span>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>

            <div style="border: 1px solid gray; margin-top: 30px;">
                <table style="width: 100%; border: 1px solid gray">
                    <tbody>
                        <tr>
                            <td style="text-align: center">
                                <span style="font-weight: bold">TOTAL QUANTITY</span>
                                <span style="padding-left: 20px"> 1 </span>
                            </td>
                            <td style="text-align: center">
                                <span style="font-weight: bold">TOTAL WEIGHT</span>
                                <span style="padding-left: 20px">{{@$transaction->weight}}</span>
                            </td>
                        </tr>
                    </tbody>
                </table>


                <div class="tabular-content">
                    <table style="width: 100%">
                        <thead>
                            <tr>
                                <th>TRACKING NBR</th>
                                <th>MARKS & NUMBERS</th>
                                <th>CARGO DESCRIPTION</th>
                                <th>QTY</th>
                                <th>CARGO TYPE</th>
                                <th>WEIGHT</th>
                                <th>CONSIGNEE & Reference</th>
                                <th>SHIPPER</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="text-align: center">{{ $transaction->tracking_no}}</td>
                                <td style="text-align: center">{{ $transaction->marks }}</td>
                                <td style="text-align: center">{{ $transaction->description }}</td>
                                <td style="text-align: center">{{ $transaction->qty }}</td>
                                <td style="text-align: center">{{ $transaction->cargo_type }}</td>
                                <td style="text-align: center">{{ $transaction->weight }}</td>
                                <td style="text-align: center">{{ $transaction->consigneeR->name }}</td>
                                <td style="text-align: center">{{ $transaction->shipper }}</td>
                            </tr>
                        </tbody>
                    </table>

                    <div>
                        <table style="width: 100%">
                            <tbody>
                                <tr>
                                    <td style="width: 20%">
                                        <div style="text-align: center">
                                            <img src="data:image/png;base64, {!! $qrcode !!}">
                                        </div>
                                        <div class="mb-2">
                                            @if ($transaction->source_type == App\Models\Transaction::$SOURCE_TYPE_UPLOADED
                                            ||
                                            $transaction->source_type ==
                                            "Uploaded")
                                            {!! QrCode::size(200)->generate($transaction->rcn_no . "|" .
                                            $transaction->vehicleR->name . "|") !!}
                                            @else
                                            {!! DNS1D::getBarcodeHTML('4546435345', 'UPCA',3,100) !!}
                                            @endif

                                        </div>

                                        <table style="width: 100%">
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <div class="font-weight-bold">Customs Declaration #:</div>
                                                    </td>
                                                    <td style="text-align: right">
                                                        <div>:</div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                    <td style="width: 80%">
                                        <table>
                                            <tbody>
                                                <tr>
                                                    <td colspan="2" style="text-align: center">
                                                        <div>
                                                            <div>NAIROBI</div>
                                                            <div>KENYA</div>
                                                            <div>&nbsp;</div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr style="padding-top: 20px">
                                                    <td>
                                                        <div style="border: 1px solid gray; padding: 0 5px;">
                                                            <h3>Take in charge by the carrier : </h3>
                                                            <div style="padding-left: 5px;">
                                                                We, the undersigned have received the above goods in
                                                                good
                                                                condition
                                                            </div>
                                                            <table style="width: 100%" class="mb-2">
                                                                <thead>
                                                                    <tr>
                                                                        <th>
                                                                            <span>Date</span><br />
                                                                            <span>dd/mm/yy</span><br />
                                                                        </th>
                                                                        <th>
                                                                            <span>Time</span><br />
                                                                            <span>hh::mm</span><br />
                                                                        </th>
                                                                        <th>
                                                                            Name
                                                                        </th>
                                                                        <th>
                                                                            Signature (over rubber stamp)
                                                                        </th>
                                                                        <th>
                                                                            Driver
                                                                        </th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td>
                                                                            <div
                                                                                style="border-bottom: 1px dotted black; width: 80%">
                                                                                &nbsp;
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div
                                                                                style="border-bottom: 1px dotted black; width: 80%">
                                                                                &nbsp;
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div
                                                                                style="border-bottom: 1px dotted black; width: 80%">
                                                                                &nbsp;
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div
                                                                                style="border-bottom: 1px dotted black; width: 80%">
                                                                                &nbsp;
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div
                                                                                style="border-bottom: 1px dotted black; width: 80%">
                                                                                &nbsp;
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div style="border: 1px solid gray; padding: 0 5px;">
                                                            <h3>Delivery at consignee : </h3>
                                                            <div style="padding-left: 5px;">
                                                                We, the undersigned have received the above goods in
                                                                good
                                                                condition
                                                            </div>
                                                            <table style="width: 100%;" class="mb-2">
                                                                <thead>
                                                                    <tr>
                                                                        <th>
                                                                            <span>Date</span><br />
                                                                            <span>dd/mm/yy</span><br />
                                                                        </th>
                                                                        <th>
                                                                            <span>Time</span><br />
                                                                            <span>hh::mm</span><br />
                                                                        </th>
                                                                        <th>
                                                                            Name
                                                                        </th>
                                                                        <th>
                                                                            Signature (over rubber stamp)
                                                                        </th>
                                                                        <th>
                                                                            Visa/Stamp
                                                                        </th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td>
                                                                            <div
                                                                                style="border-bottom: 1px dotted black; width: 80%">
                                                                                &nbsp;
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div
                                                                                style="border-bottom: 1px dotted black; width: 80%">
                                                                                &nbsp;
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div
                                                                                style="border-bottom: 1px dotted black; width: 80%">
                                                                                &nbsp;
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div
                                                                                style="border-bottom: 1px dotted black; width: 80%">
                                                                                &nbsp;
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div
                                                                                style="border-bottom: 1px dotted black; width: 80%">
                                                                                &nbsp;
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>


                </div>
            </div>

            <div style="border: 1px solid gray; margin-top: 20px">
                <table style="width: 100%; padding-bottom: 10px">
                    <tbody>
                        <tr>
                            <td style="padding-left: 10px">
                                <h4 class="mb-2">REMARKS & INSTRUCTIONS</h4>

                                <div>
                                    DELIVER TO CLIENT: 
                                </div>
                                <div>&nbsp;</div>
                                <div>
                                    
                                </div>
                                <div>&nbsp;</div>
                                <div>
                                    SEAL 
                                </div>
                            </td>
                            <td>
                                <div style="border: 2px solid gray; padding: 10px 20px;">
                                    <div class="row">
                                        <div class="col-sm-3">Invoice #: </div>
                                        <div class="col-sm-9">
                                            <div style="border-bottom: 1px dotted black; width: 80%">&nbsp;
                                            {{ @$transaction->transactionInvoice->invoice_number}}
                                            </div>
                                        </div>
                                    </div>
                                    <div>&nbsp;</div>
                                    <div>&nbsp;</div>
                                    <div class="row">
                                        <div class="col-sm-3">Purchase Order #: </div>
                                        <div class="col-sm-9">
                                            <div style="border-bottom: 1px dotted black; width: 80%">&nbsp;
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>

            </div>
        </div>
    </div>

    <div id="footer">
        <table style="width: 100%">
            <tbody>
                <tr>
                    <td>BOLLORE</td>
                    <td style="text-align: right">This is a system generated document. Time {{ date('Y-m-d H:i:s')}}</td>
                </tr>
            </tbody>
        </table>
    </div>
</body>

</html>