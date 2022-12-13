<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Invoice # - {{ $recovery_invoice->invoice_number }}</title>
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

            opacity: 20%;

            /** Your watermark should be behind every content**/
            z-index: -1000;
        }

        th, td{
            padding: 4px 2px;
            text-align: left;
        }
        hr {
            border: 1px solid black;
            margin: 10px 0px;
        }
        
        table, th, td {
            border: 0.1px solid black;
            border-collapse: collapse;
            font-size: 12px;
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
        <?php $invoice = $recovery_invoice->invoice ?>
        
        @if($recovery_invoice->status == 'approved')
            <div style="background-color: #7ad97d94; padding: 10px; 20px;">
                <h3  style="text-align: center; font-size: 20px; text-shadow: 1px 1px 1px #000; margin: 0px;">TROM TRANSPORTER'S INVOICE FULLY VALIDATED FORM</h3>
                <h5 class="font-weight-bold mt-4" style="text-decoration: underline; text-align: center; font-size: 24px; margin: 0px;">APPROVAL FORM ID: {{@$invoice->id}}{{Carbon\Carbon::parse($recovery_invoice->invoice_date)->format("Ymd")}}</h5>
            </div>
        @else
        <div style="background-color: #d97a9494; padding: 10px; 20px;">
            <h3  style="text-align: center; font-size: 20px; text-shadow: 1px 1px 1px #000; margin: 0px;">TROM TRANSPORTER'S INVOICE PARTIALLY VALIDATED FORM</h3>
            <h5 class="font-weight-bold mt-4" style="text-decoration: underline; text-align: center; font-size: 24px; margin: 0px;">INVOICE ID: {{@$invoice->id}}</h5>
    
        </div>
        @endif
        <div class="wrapper">        
            <table style="width: 100%; border: none;">
                <tbody>
                    <tr>
                        <td style="width: 56%; border: none;">
                            <table style="width: 100%;">
                                <tbody>
                                    <tr>
                                        <th>CUSTOMER</th>
                                        <td>{{@$invoice->rcns[0]->consigneeR->name}}</td>
                                    </tr>
                                    <tr>
                                        <th>CONSIGNEE</th>
                                        <td>{{@$invoice->rcns[0]->consigneeR->name}}</td>
                                    </tr>
                                    <tr>
                                        <th>TRANSPORTER</th>
                                        <td>{{@$invoice->rcns[0]->carrierR->transporter_name}}</td>
                                    </tr>
                                    <tr>
                                        <th>TRACKING FILE NUMBER</th>
                                        <td>{{@$invoice->rcns[0]->tracking_no}}</td>
                                    </tr>
                                    <tr>
                                        <th>P.O NUMBER</th>
                                        <td>{{@$invoice->rcns[0]->purchase_order_no}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                        <td style="width: 4%; border: none;"></td>
                        <td style="width: 40%; border: none;">
                        <table style="width: 100%;">
                <tbody>
                <tr>
                    <th>LOADING COUNTRY</th>
                    <td>{{@$invoice->rcns[0]->agent->name}}</td>
                </tr>
                <tr>
                    <th>LOADING PLACE</th>
                    <td>{{@$invoice->rcns[0]->agent->name}}</td>
                </tr>
                <tr>
                    <th>UNLOADING PLACE</th>
                    <td>{{@$invoice->rcns[0]->destination->name}}</td>
                </tr>
                <tr>
                    <th>DEPARTMENT</th>
                    <td>{{@$invoice->rcns[0]->department_code}}</td>
                </tr>
                <tr>
                    <th>BRANCH</th>
                    <td></td>
                </tr>
                </tbody>
            </table></td>
                    </tr>
                </tbody>
            </table>    
            
            <hr/>
            <div style="width: 100%;">
            <h5 class="font-weight-bold mt-4" style="text-decoration: underline">RCN DETAILS</h5>
                        <table style="width: 100%">
                            <thead>
                                <tr>
                                    <th>DATE</th>
                                    <th>RCN NO.</th>
                                    <th>TRUCK</th>
                                    <th>CARRIER CONTACT</th>
                                    <th>AMOUNT</th>
                                    <th>CURRENCY</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach (@$invoice->rcns as $rcn)
                                <tr>
                                    <td>{{$rcn->date ? Carbon\Carbon::parse($rcn->date)->format('m-d-Y') : 'NA'}}</td>
                                    <td><a href="{{ route('admin.transactions.view', $rcn->id) }}">
                                        <span class="">{{ $rcn->rcn_no }}</span>
                                    </a></td>
                                    <td>{{$rcn->vehicleR->number}} - {{$rcn->vehicleR->trailer}}</td>
                                    <td>{{$rcn->carrierR->name}}</td>
                                    <td>@if($rcn->amount)<span class="font-weight-bold">{{ number_format($rcn->amount , 2)
                                        }}</span>@endif</td>
                                    <td>{{@$invoice->currency->name}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
            </div>
                        <h5 class="font-weight-bold mt-4" style="text-decoration: underline">INVOICE DETAILS</h5>
                        <table style="width: 100%">
                            <tr>
                                <th>INV. DATE</th>
                                <td>{{
                                Carbon\Carbon::parse($invoice->invoice_date)->format('F d Y') }}</td>
                                <th>INV. NO</th>
                                <td>{{ $invoice->invoice_number }}</td>
                                <th>INV. AMOUNT</th>
                                <td>{{ number_format($invoice->invoice_amount) }}</td>
                            </tr>
                            <tr>
                                <th>CREDIT NOTE DATE</th>
                                <td> {{ $invoice->credit_note ? Carbon\Carbon::parse($invoice->invoice_date)->format('F d Y') : 'NA'}} </td>
                                <th>CREDIT NOTE. NO</th>
                                <td>{{ $invoice->credit_note ? $invoice->credit_note : 'NA' }}</td>
                                <th>CREDIT NOTE. AMOUNT</th>
                                <td>{{ $invoice->credit_note_amount ? $invoice->credit_note_amount : 'NA' }}</td>
                            </tr>
                            <tr>
                                <th>RECOVERY INVOICE</th>
                                <td>{{
                                Carbon\Carbon::parse($recovery_invoice->invoice_date)->format('F d Y') }}</td>
                                <th>REC. INV. NO</th>
                                <td>{{ $recovery_invoice->invoice_number }}</td>
                                <th>REC. INV. AMOUNT</th>
                                <td>{{ number_format($recovery_invoice->invoice_amount) }}</td>
                            </tr>
                        </table>
                        <h5 class="font-weight-bold mt-4" style="text-decoration: underline">APPROVAL LOGS</h5>
                        <table style="width: 100%">
                            <thead>
                            <tr>
                                <th>DATE</th>
                                <th>ROLE</th>
                                <th>NAME</th>
                                <th>TYPE</th>
                                <th>COMMENTS</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($recovery_invoice->approvalLogs as $log)
                                <tr @if(@$log->type == 'rejected') style="background-color: #ffd8d8;" @endif>
                                    <td>{{ $log->created_at->format('Y-M-d H:i')}}</td>
                                    <td>{{
                                App\Models\ApprovalLevel::APPROVAL_WEIGHTS[@$log->weight] }}</td>
                                    <td>{{ @$log->user->name }}</td>
                                    <td><span style="text-transform: capitalize">{{$log->type}}</span></td>
                                    <td>{{ $log->comments }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
    </div>
    @if($recovery_invoice->status == 'approved')
    <div style="width: 100%">
        <?php $qrcode = $invoice->id.''.Carbon\Carbon::parse($recovery_invoice->invoice_date)->format("Ymd"); ?>
        <table style="width: 100%; border: none; margin-top: 40px;">
                <tbody>
                    <tr>
                        <td style="width: 100%; border: none;"></td>
                        <td style="width: 100%; border: none;"><?php echo '<img src="data:image/png;base64,'. Milon\Barcode\Facades\DNS1DFacade::getBarcodePNG($qrcode, 'C128', 3, 33, array(1,1,1), true) .'" alt="Barcode"  />'?></td>
                        <td style="width: 100%; border: none;"></td>
                    </tr>
                </tbody>
        </table>
    </div>
    @endif

    <div id="footer">
        <!-- <table style="width: 100%">
            <tbody>
                <tr>
                    <td>BOLLORE</td>
                    <td style="text-align: right">For more, please contact Bollore support at +254712345678</td>
                </tr>
            </tbody>
        </table> -->
    </div>
</body>

</html>