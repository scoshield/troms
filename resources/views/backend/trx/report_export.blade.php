<table>
    <tr>
        <th>#</th>
        <th>
            <span>Booking Date</span>
        </th>
        <th>
            <span>Invoice Number</span>
        </th>
        <th>Invoice Date</th>
        <th>
            <span>RCN(s)</span>
        </th>
        <th>P.O Number</th>
        <th>File Number</th>
        <th>Rec. Invoice No.</th>
        <th>
            <span>Transporter</span>
        </th>
        <th>
            <span>Amount</span>
        </th>
        <th>
            <span>Currency</span>
        </th>
        <th>
            <span>Department</span>
        </th>
        <th>Approval Date</th>
        <th>Age.</th>
        <th>
            <span>
                Status
            </span>
        </th>
        <th>Paid On (Date)</th>
    </tr>
    @foreach($transactions as $trx)
    <tr>
        <td>
            <div class="dropdown show">
                <span>{{ $trx->id }}</span>
            </div>
        </td>
        <td>
            <span style="font-weight: 400">{{ \Carbon\Carbon::parse($trx->created_at)->format('d/m/Y')}} </span>
        </td>
        <td>
            <span style="font-weight: 400">{{ $trx->invoice_number }}</span>
        </td>
        <td>
            <span style="font-weight: 400">{{ \Carbon\Carbon::parse($trx->invoice_date)->format('d/m/Y')}} </span>
        </td>
        <td>
            @foreach($trx->rcns as $rcn)
                <span>{{$rcn->rcn_no}}</span> <br/>
            @endforeach
        </td>
        <td>
            @foreach($trx->rcns as $rcn)
                <span>{{$rcn->purchase_order_no}}</span> <br/>
            @endforeach
        </td>
        <td>
            <span style="font-weight: 400">{{ $trx->file_number }}</span>
        </td>
        <td>
            <span style="font-weight: 400">{{ @$trx->recoveryInvoice->invoice_number }}</span>
        </td>
        <td>
            @foreach($trx->rcns as $rcn)
                <span>{{@$rcn->carrierR->transporter_name}}</span> <br/>
            @endforeach
        </td>
        <td>
            <span style="font-weight: 400">{{ number_format($trx->invoice_amount, 2) }}</span>
        </td>
        <td>
            <span style="font-weight: 400">{{ @$trx->currency->symbol}}</span>                    
        </td>
        <td>
            @foreach($trx->rcns as $rcn)
                <span>{{@$rcn->department->name}}</span> <br/>
            @endforeach
        </td>
        <td>
            <span style="font-weight: 500">{{ \Carbon\Carbon::parse(@$trx->recoveryInvoice->approvalLogs->last()->created_at)->format('d/m/Y') }}</span>
        </td>
        <td>{{ \Carbon\Carbon::parse($trx->created_at)->diffInDays(@$trx->recoveryInvoice->approvalLogs->last()->created_at) }}</td>
        <td>
            <a href="#" class="badge badge-info" style="text-transform: uppercase">{{@$trx->recoveryInvoice->status}}</a>                 

        </td>
    </tr>
    @endforeach
</table>
