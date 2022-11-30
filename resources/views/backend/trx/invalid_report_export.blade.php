    <table class="table table-hover table-striped">
            <tr>
                <th>#</th>
                <th>
                    <span>Booking Date</span>
                </th>
                <th>
                    <span>Invoice Number</span>
                </th>
                <th>
                    <span>RCN(s)</span>
                </th>
                <th>File Number</th>
                <th>
                    <span>Transporter</span>
                </th>
                <th>
                    <span>Amount</span>
                </th>
                <th>
                    <span>Currency</span>
                </th>           
                <th>Notes.</th>     
                <th>
                    <span>
                        Status
                    </span>
                </th>
            </tr>
            @foreach($transactions as $trx)
            <tr>
                <td>
                    <div class="dropdown show">
                        <span>{{ $trx->id }}</span>
                    </div>
                </td>
                <td>
                    <span style="font-weight: 400">{{ \Carbon\Carbon::parse($trx->created_at)->format('d-m-Y')}} </span>
                </td>
                <td>
                    <span style="font-weight: 400">{{ $trx->invoice_number }}</span>
                </td>
                <td>
                    @if(count($trx->rcns) < 1)
                        <span class="badge badge-danger">No RCN</span>
                    @else
                        @foreach($trx->rcns as $rcn)
                            <span>{{$rcn->rcn_no}}</span> <br/>
                        @endforeach
                    @endif
                </td>
                <td>{{ $trx->file_number }}</td>
                <td>
                    <span style="color: gray">{{ @$trx->invoice->rcns[0]->carrierR->transporter_name }}</span>
                </td>
                <td>
                    <span style="font-weight: 400">{{ number_format($trx->invoice_amount, 2) }}</span>
                </td>
                <td>{{ @$trx->currency->symbol}} </td>
                <td>
                <span class="badge badge-danger">{{ @$trx->comments}}</span>
                </td>
                <!-- <td>
                    <span style="font-weight: 500">{{ $trx->level }}</span>
                </td> -->
                <!-- <td>{{ \Carbon\Carbon::parse($trx->created_at)->diffForHumans() }}</td> -->
                <td>
                    <a href="#" class="badge badge-info">{{$trx->status}}</a>    
                    @foreach($trx->rcns as $rcn)
                        @if(!$rcn->purchase_order_no)
                            {{$rcn->rcn_no}}<span class="badge badge-danger">No Purchase Number</span>
                        @endif
                    @endforeach
                </td>
            </tr>
            @endforeach
        </table>