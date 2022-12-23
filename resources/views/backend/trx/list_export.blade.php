

        <table class="table table-hover table-striped">
            <tr>
                <th>#</th>
                <th>
                    <span>RCN Number</span><br />
                    <span>Vehicle</span>
                </th>
                <th>
                    <span>Agent Departure</span><br />
                    <span>Agent Destination</span>
                </th>
                <th>
                    <span>Carrier</span><br />
                    <span>Shipper</span>
                </th>
                <th>
                    <span>Consignee</span><br />
                    <span>Tracking no</span>
                </th>
                <th>
                    <span>Invoice</span><br />
                </th>
                <th>
                    <span>Quantity</span><br />
                    <span>Weight</span>
                </th>
                <th>
                    <span>Status</span><br />
                    <span>Source</span>
                </th>
            </tr>
            @foreach($transactions as $trx)
            <tr>
                <td>
                    
                    <span>{{ $trx->id }}</span>
                        
                    
                </td>
                <td>
                    <span style="font-weight: 500">{{ $trx->rcn_no }}</span><br />
                    <span style="color: gray">{{ @$trx->vehicleR->number }}</span><br />
                </td>
                <td>
                    <span style="font-weight: 500">{{ @$trx->agent->name }}</span><br />
                    <span style="color: gray">{{ @$trx->destination->name }}</span><br />
                </td>
                <td>
                    <span style="font-weight: 500">{{ @$trx->carrierR->name }}</span><br />
                    <span style="color: gray">{{ @$trx->shipperR->name }}</span><br />
                </td>
                <td>
                    <span style="font-weight: 500">{{ $trx->consigneeR->name }}</span><br />
                    <span style="color: gray">{{ @$trx->tracking_no }}</span><br />
                </td>
                <td>
                    <span style="font-weight: 500">@if($trx->invoice_id) <span class="badge badge-success">Consumed</span>@else <span class="badge badge-danger">Not Consumed</span>@endif</span><br />
                </td>
                <td>
                    <span style="font-weight: 500">{{ $trx->quantity }}</span><br />
                    <span style="color: gray">{{ @$trx->weight }}</span><br />
                </td>
                <td>
                    @if($trx->status == App\Models\Transaction::$PENDING)
                    <a href="#" class="badge badge-info">Pending</a>
                    @elseif($trx->status == App\Models\Transaction::$AMOUNT_NOT_EQUAL)
                    <a href="#" class="badge badge-danger">Invoice mismatch</a>
                    @elseif($trx->status == App\Models\Transaction::$INVOICE_MATCHED)
                    <a href="#" class="badge badge-success">Invoice matched</a>
                    @elseif($trx->status == App\Models\Transaction::$INVOICE_ATTACHED)
                    <a href="#" class="badge badge-primary">Invoice attached</a>
                    @elseif($trx->status == App\Models\Transaction::$APPROVED)
                    <a href="#" class="badge badge-primary">Approved</a>
                    @elseif($trx->status == App\Models\Transaction::$PARTIALLY_APPROVED)
                    <a href="#" class="badge badge-primary">Partially Approved</a>
                    @endif

                    <br />
                    @if ($trx->source_type == App\Models\Transaction::$SOURCE_TYPE_UPLOADED || $trx->source_type ==
                    "Uploaded")
                    <a href="#" class="text-danger font-bold">upload</a>
                    @else
                    <a href="#" class="text-success font-bold">manual</a>
                    @endif

                </td>
            </tr>
            @endforeach
        </table>

        