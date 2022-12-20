


        <table class="table table-hover table-striped table-sm">
            <tr>
                <th>#</th>
                <th>Rejected Date</th>
                <th>Invoice. no.</th>
                <th>Transporter</th>
                <th>File No.</th>
                <th>RCN's</th>
                <th>Rec. Invoice No.</th>
                <th>Rec. Invoice Amount</th>
                <th>Invoice Amount</th>
                <th>Rejected by</th>
                <th>Status</th>
                <th>Reason Code</th>
                <th>Comment</th>
            </tr>
            @foreach($recovery_invoices as $recovery_invoice)
            <tr @if($recovery_invoice->level == @auth()->user()->approvalLevel->weight && $recovery_invoice->status != 'approved') style="background-color: #00ff3233;" @endif>
                <td>
                    
                </td>
                <td>{{ Carbon\Carbon::parse($recovery_invoice->approvalLogs->last()->created_at)->format('d/m/Y')}}</td>
                <td>{{ @$recovery_invoice->invoice->invoice_number }}</td>
                <td>
                    @foreach(@$recovery_invoice->invoice->rcns as $rcn)
                            {{ @$rcn->shipperR->name }}
                    @endforeach
                </td>
                <td>{{ @$recovery_invoice->invoice->file_number }}</td>
                <td>
                    @foreach(@$recovery_invoice->invoice->rcns as $rcn)
                    {{ @$rcn->rcn_no }}
                    @endforeach
                </td>
                <td>{{ $recovery_invoice->invoice_number }}</td>
                
                <td>{{ @$recovery_invoice->invoice->currency->symbol }} {{ number_format(@$recovery_invoice->invoice->invoice_amount, 2) }}</td>
                <td>{{ @$recovery_invoice->currency->symbol }} {{ number_format(@$recovery_invoice->invoice_amount, 2) }}</td>
                <td>{{ $recovery_invoice->approvalLogs->last()->user->name }}</td>
                <td>
                    @if($recovery_invoice->status == App\Models\RecoveryInvoiceStatus::APPROVED)
                    <a href="#" class="badge badge-primary">Approved</a>
                    @elseif($recovery_invoice->status == App\Models\RecoveryInvoiceStatus::PARTIALLY_APPROVED)
                    <a href="#" class="badge badge-success">Partially approved</a>
                    @elseif($recovery_invoice->status == App\Models\RecoveryInvoiceStatus::REJECTED)
                    <a href="#" class="badge badge-danger">Rejected</a>
                    @endif
                </td>                
                <td>@if(@$recovery_invoice->approvalLogs->last()){{@$recovery_invoice->approvalLogs->last()->reason->code}}@endif</td>
                <td></td>
            </tr>
            @endforeach
        </table>
        