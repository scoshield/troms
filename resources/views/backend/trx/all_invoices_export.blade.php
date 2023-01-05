<table class="table table-hover table-striped table-sm">
            <tr>
                <th>#</th>
                <th>Booking Date</th>
                <th>Invoice. no.</th>
                <th>Invoice Date.</th>
                <th>RCN's</th>
                <th>File No.</th>
                <th>Transporter</th>
                <th>Amount</th>
                <th>Currency</th>
                <th>Department</th>
                <th>Level</th>
                <th>Period</th>
                <th>Status</th>
            </tr>
            @foreach($invoices as $invoice)
            <tr @if($invoice->level == @auth()->user()->approvalLevel->weight && $invoice->status != 'approved') style="background-color: #00ff3233;" @endif>
                <td>
                    <div class="dropdown show">
                        <span>{{ $loop->iteration }}</span>                        
                    </div>
                </td>
                <td>{{ Carbon\Carbon::parse(@$invoice->created_at)->format('d/m/Y')}}</td>
                <td>{{ @$invoice->invoice_number }}</td>
                <td>{{ Carbon\Carbon::parse(@$invoice->invoice_date)->format('d/m/Y')}}</td>
                <td>
                    @foreach(@$invoice->rcns as $rcn)
                            {{ $rcn->rcn_no }}
                    @endforeach
                </td>
                <td>{{ $invoice->file_number }}</td>
                <td>
                    @foreach(@$invoice->rcns as $rcn)
                            {{ $rcn->carrierR->transporter_name }}
                    @endforeach</td>
                <td>{{ number_format(@$invoice->invoice_amount, 2) }}</td>
                <td>{{ @$invoice->currency->symbol }}</td>
                <td>
                        @foreach(@$invoice->rcns as $rcn)
                            {{ @$rcn->department->name }} <br/>
                        @endforeach
                </td>
                <td>
                    @php $level = @$invoice->level @endphp
                    {{ App\Models\ApprovalLevel::APPROVAL_WEIGHTS[@$level] }}

                </td>
                <td>{{Carbon\Carbon::parse($invoice->created_at)->diffForHumans()}}</td>
                <td>
                    @if(@$invoice->recoveryInvoice->status == App\Models\RecoveryInvoiceStatus::APPROVED)
                    <a href="#" class="badge badge-primary">Approved</a>
                    @elseif(@$invoice->recoveryInvoice->status == App\Models\RecoveryInvoiceStatus::PARTIALLY_APPROVED)
                    <a href="#" class="badge badge-success">Partially approved</a>
                    @elseif(@$invoice->recoveryInvoice->status == App\Models\RecoveryInvoiceStatus::REJECTED)
                    <a href="#" class="badge badge-success">Rejected</a>
                    @else
                     <p class="badge badge-danger">Not attached</p>
                    @endif
                </td>                
            </tr>
            @endforeach
        </table>