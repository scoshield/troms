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
            @foreach($recovery_invoices as $recovery_invoice)
            <tr @if($recovery_invoice->level == @auth()->user()->approvalLevel->weight && $recovery_invoice->status != 'approved') style="background-color: #00ff3233;" @endif>
                <td>
                    <div class="dropdown show">
                        <span>{{ $loop->iteration }}</span>
                        <a class="btn  dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                                xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 302 302"
                                style="enable-background:new 0 0 302 302;" xml:space="preserve">
                                <g>
                                    <rect y="36" width="302" height="30" />
                                    <rect y="236" width="302" height="30" />
                                    <rect y="136" width="302" height="30" />
                                </g>
                            </svg>
                        </a>

                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <a class="dropdown-item"
                                href="{{ route('admin.rcns.recovery-invoices.view', $recovery_invoice->id )}}">View
                            </a>
                        </div>
                    </div>
                </td>
                <td>{{ Carbon\Carbon::parse(@$recovery_invoic->invoice->created_at)->format('d/m/Y')}}</td>
                <td>{{ @$recovery_invoice->invoice->invoice_number }}</td>
                <td>{{ Carbon\Carbon::parse(@$recovery_invoice->invoice->invoice_date)->format('d/m/Y')}}</td>
                <td>
                    @foreach(@$recovery_invoice->invoice->rcns as $rcn)
                            {{ $rcn->rcn_no }}
                    @endforeach
                </td>
                <td>{{ $recovery_invoice->invoice->file_number }}</td>
                <td>
                    @foreach(@$recovery_invoice->invoice->rcns as $rcn)
                            {{ $rcn->shipperR->name }}
                    @endforeach</td>
                <td>{{ number_format(@$recovery_invoice->invoice->invoice_amount, 2) }}</td>
                <td>{{ @$recovery_invoice->invoice->currency->symbol }}</td>
                <td>Dept</td>
                <td>{{ @$recovery_invoice->approvalLogs->last()->weight }}</td>
                <td>{{Carbon\Carbon::parse($recovery_invoice->invoice->created_at)->diffForHumans()}}</td>
                <td>
                    @if($recovery_invoice->status == App\Models\RecoveryInvoiceStatus::APPROVED)
                    <a href="#" class="badge badge-primary">Approved</a>
                    @elseif($recovery_invoice->status == App\Models\RecoveryInvoiceStatus::PARTIALLY_APPROVED)
                    <a href="#" class="badge badge-success">Partially approved</a>
                    @elseif($recovery_invoice->status == App\Models\RecoveryInvoiceStatus::REJECTED)
                    <a href="#" class="badge badge-success">Rejected</a>
                    @endif
                </td>                
            </tr>
            @endforeach
        </table>
