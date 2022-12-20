@extends('backend.layouts.app')

@section('title', __('Upload/Manage RCNs'))

@section('breadcrumb-links')
{{-- @include('backend.auth.user.includes.breadcrumb-links')--}}
@endsection

@section('content')

<x-backend.card>
    <x-slot name="header">
        @lang('View Transaction')
    </x-slot>

    @if ($logged_in_user->hasAllAccess())
    <x-slot name="headerActions">

        @if($transaction->status != App\Models\Transaction::$APPROVED && ($transaction->transactionInvoice &&
        $transaction->status != App\Models\Transaction::$AMOUNT_NOT_EQUAL) )
        <a>
            <button class="btn btn-sm btn-success" data-toggle="modal"
                data-target="#approveModal{{$transaction->id}}">@lang("Approve")</button>
        </a>
        @endif


        <a href="{{ route('admin.transactions.print', $transaction->id)}}">
            <button class="btn btn-sm btn-primary">@lang("Print")</button>
        </a>
    </x-slot>
    @endif

    <x-slot name="body">

        <div>
            <div class="row">
                @if (@$transaction->transactionInvoice)
                <div class="col-sm-3">
                    <div class="mb-4">
                        <h6>Attached Invoice Amount: {{
                            @$transaction->transactionInvoice->invoice_amount }}</h4>
                    </div>
                </div>
                @endif
                <div class="col-sm-3">
                    <div class="mb-4">
                        <h6>COM : {{ auth()->user()->name }}</h4>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="mb-4">
                        <h6>RCN Amount: {{
                            $transaction->amount }}</h4>
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="mb-4">
                        <h6>Status: @if($transaction->status == App\Models\Transaction::$PENDING)
                            <a href="#" class="badge badge-info">Info</a>
                            @elseif($transaction->status == App\Models\Transaction::$AMOUNT_NOT_EQUAL)
                            <a href="#" class="badge badge-danger">Invoice mismatch</a>
                            @elseif($transaction->status == App\Models\Transaction::$INVOICE_MATCHED)
                            <a href="#" class="badge badge-success">Invoice amount matched</a>
                            @elseif($transaction->status == App\Models\Transaction::$INVOICE_ATTACHED)
                            <a href="#" class="badge badge-primary">Invoice attached</a>
                            @elseif($transaction->status == App\Models\Transaction::$APPROVED)
                            <a href="#" class="badge badge-primary">Approved</a>
                            @elseif($transaction->status == App\Models\Transaction::$PARTIALLY_APPROVED)
                            <a href="#" class="badge badge-primary">Partially Approved</a>
                            @elseif (!$transaction->transactionInvoice)
                            <a href="#" class="badge badge-warning">No invoice attached</a>
                            @endif
                        </h6>
                    </div>
                </div>
            </div>
        </div>

        <div id="printableArea">
            <style>
                .border {
                    1px solid black !important;
                }
            </style>

            <div class="wrapper">
                <div class="row">
                    <div class="col-sm-2">No: {{ $transaction->id }}</div>
                    <div class="col-sm-8 border">
                        <div class="d-flex justify-content-around">
                            <div class="">
                                <div>ROAD CONSIGNEMNT NOTE - NUMBER: <span class="font-weight-bold">{{
                                        $transaction->rcn_no
                                        }}</span>
                                </div>
                            </div>
                            <div class="">
                                <div>P.O. - NUMBER: <span class="font-weight-bold">{{ $transaction->purchase_order_no
                                        }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-2 text-right">
                        BOLLORE

                        <!-- {{ $transaction }} -->
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-sm-12 col-md-3">
                        <h5 class="underline"><u>Agent At Departure</u></h5>

                        {{-- <div>
                            <div>BOLLORE TRANSPORT & LOGISTICS</div>
                            <div>LIMITED, AIRPORT NORTH ROAD, EMB</div>
                            <div>PIN P000069983U, P.O. BOX 465</div>
                            <div>NAIROBI</div>
                            <div>KENYA</div>
                        </div> --}}
                    </div>
                    <div class="col-sm-12 col-md-3">
                        <h5 class="underline"><u>Agent At Destination</u></h5>
                        {{-- <div>
                            <div>BOLLORE TRANSPORT & LOGISTICS</div>
                            <div>LIMITED, AIRPORT NORTH ROAD, EMB</div>
                            <div>PIN P000069983U, P.O. BOX 465</div>
                            <div>NAIROBI</div>
                            <div>KENYA</div>
                        </div> --}}

                    </div>
                    <div class="col-sm-12 col-md-3">
                        <h5 class="underline"><u>Carrier</u></h5>
                        <div>{{ @$transaction->carrierR->name }}</div>
                    </div>
                    <div class="col-sm-12 col-md-3">
                        <div>
                            <span class="font-weight-bold">Place of loading</span>
                            <span>:</span>
                            <span>{{ @$transaction->uploadTrx->loading_place }}</span>
                        </div>
                        <div>
                            <span class="font-weight-bold">Loading date</span>
                            <span>:</span>
                            <span>{{ @$transaction->uploadTrx->loading_date }}</span>
                        </div>
                        <div>&nbsp;</div>
                        <div class="row">
                            <div class="col-sm-6">
                                <span class="font-weight-bold">Vehicle</span>
                                <span>:</span>
                                <span>{{@$transaction->vehicleR->number}}</span>
                            </div>
                            <div class="col-sm-6">
                                <span class="font-weight-bold">Trailer</span>
                                <span>:</span>
                                <span>{{@$transaction->vehicleR->trailer}}</span>
                            </div>
                        </div>
                        <div>
                            <span class="font-weight-bold">Owner</span>
                            <span>:</span>
                            <span>{{@$transaction->consigneeR->name}}</span>
                        </div>
                        <div>
                            <span class="font-weight-bold">DRIVER</span>
                            <span>:</span>
                            <span> {{ $transaction->carrierR->name }} </span>
                        </div>
                    </div>
                </div>

                <div class="content-wrapper border mt-4">
                    <div class="d-flex justify-content-around border">
                        <div class="row">
                            <div class="font-weight-bold">TOTAL QUANTITY</div>
                            <div class="pl-4"> 1 </div> <!-- TODO: fix this spacing -->
                        </div>
                        <div class="row">
                            <div class="font-weight-bold">TOTAL WEIGHT</div>
                            <div class="pl-4">{{@$transaction->weight}}</div> <!-- TODO: fix this spacing -->
                        </div>
                    </div>

                    <div class="tabular-content">
                        <table class="table d">
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
                                    <td>{{ $transaction->tracking_no}}</td>
                                    <td>{{ $transaction->marks }}</td>
                                    <td>{{ $transaction->description }}</td>
                                    <td>{{ $transaction->qty }}</td>
                                    <td>{{ $transaction->cargo_type }}</td>
                                    <td>{{ $transaction->weight }}</td>
                                    <td>{{ $transaction->consigneeR->name }}</td>
                                    <td>{{ $transaction->shipper }}</td>
                                </tr>
                            </tbody>
                        </table>

                        <div class="row p-2">
                            <div class="col-sm-3">
                                <div>
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

                                    <div class="d-flex justify-content-between">
                                        <div class="font-weight-bold">Customs Declaration #:</div>
                                        <div>:</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-9">
                                <div class="text-center">
                                    <div>NAIROBI</div>
                                    <div>KENYA</div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-sm-6">
                                        <div class="border p-2">
                                            <h5>Take in charge by the carrier : </h5>
                                            <div class="pl-3">
                                                We, the undersigned have received the above goods in good
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
                                                            <div style="border-bottom: 1px dotted black; width: 80%">
                                                                &nbsp;
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div style="border-bottom: 1px dotted black; width: 80%">
                                                                &nbsp;
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div style="border-bottom: 1px dotted black; width: 80%">
                                                                &nbsp;
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div style="border-bottom: 1px dotted black; width: 80%">
                                                                &nbsp;
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div style="border-bottom: 1px dotted black; width: 80%">
                                                                &nbsp;
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="border p-2">
                                            <h5>Delivery at consignee : </h5>
                                            <div class="pl-3">
                                                We, the undersigned have received the above goods in good
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
                                                            <div style="border-bottom: 1px dotted black; width: 80%">
                                                                &nbsp;
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div style="border-bottom: 1px dotted black; width: 80%">
                                                                &nbsp;
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div style="border-bottom: 1px dotted black; width: 80%">
                                                                &nbsp;
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div style="border-bottom: 1px dotted black; width: 80%">
                                                                &nbsp;
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div style="border-bottom: 1px dotted black; width: 80%">
                                                                &nbsp;
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="border mt-3">
                    <div class="row p-2">
                        <div class="col-sm-6">
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
                        </div>
                        <div class="col-sm-6">
                            <div class="border p-4 ">
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
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </x-slot>

</x-backend.card>
@endsection