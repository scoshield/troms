
        <table class="table table-hover table-striped">
            <tr>
                <th>#</th>
                <th>Invoice No</th>
                <th>Invoice Amt.</th>
                <th>Invoice Date</th>
                <th>
                    File No.
                </th>
                <th>RCN(s)</th>
                <th>Recovery Invoice</th>
                <th>Status</th>
                <th>Dept.</th>
            </tr>
            @foreach($invoices as $invoice)
            
                <tr>
                    <td>
                        <div class="dropdown show">
                            <span>{{ $loop->iteration }}</span>
                            
                        </div>
                    </td>
                    <td>{{ $invoice->invoice_number }}</td>
                    <td>{{$invoice->currency->symbol}} {{ number_format($invoice->invoice_amount, 2) }}</td>
                    <td>{{ $invoice->invoice_date }}</td>
                    <td>
                        {{ $invoice->file_number }}
                    </td>
                    <td>
                        @if(count($invoice->rcns) > 0)
                            @foreach($invoice->rcns as $rcn)
                                <span>{{$rcn->rcn_no}} </span> (@if(!$rcn->purchase_order_no)) <span class="badge badge-danger">No P.O No</span> @else {{$rcn->purchase_order_no}} @endif)<br/>
                            @endforeach
                        @else
                        <span class="badge badge-danger">No RCN</span>
                        @endif
                    </td>
                    <td>@if($invoice->recoveryInvoice && @$invoice->recoveryInvoice->invoice_number != 0) {{@$invoice->recoveryInvoice->invoice_number}} @else <span class="badge badge-danger">Not Attached</span>@endif</td>
                    <td>@if($invoice->status == 'pending') <span class="badge badge-info">Pending</span>@elseif($invoice->status == 'approved') <span class="badge badge-success">Approved</span>@else <span class="badge badge-danger">Rejected</span>@endif</td>
                    <td>
                        @foreach(@$invoice->rcns as $rcn)
                            {{ @$rcn->department->name }} <br/>
                        @endforeach
                        @if(count(@$invoice->rcns) == 0) <span class="badge badge-danger">No Department</span> @endif
                    </td>
                </tr>
                
                @endforeach
        </table>