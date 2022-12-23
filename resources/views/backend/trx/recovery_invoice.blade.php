@extends('backend.layouts.app')

@section('title', __('Recovery Invoices'))

@section('breadcrumb-links')
{{-- @include('backend.auth.user.includes.breadcrumb-links')--}}
@endsection

@section('content')
<x-backend.card>
    <x-slot name="header">
        @lang('Recovery Invoices')
    </x-slot>
    <x-slot name="headerActions">
        <x-utils.link icon="c-icon cil-plus" class="card-header-action" href="{{ url('admin/rcns/recovery-invoices?download=1') }}"
            :text="__('Export')" />
    </x-slot>

    <x-slot name="body">
        <div>
            <form action="{{ route('admin.rcns.recovery-invoices')}}" method="GET">
                @csrf
                <div class="row">
                    <div class="col-sm-3">
                        <div class="mb-3">
                            <input class="form-control" type="text" name="search"
                                placeholder="Search by:  invoice_number, tracking no">
                        </div>
                    </div>

                    @if(!(request()->has('rejected') && request('rejected')))
                    <!-- <div class="col-sm-2">
                        <select class=" js-states form-control" name="status">
                            <option value="Select">Filter by status</option>
                            <option value="pending">Pending</option>
                            <option value="approved">Approved</option>
                            <option value="partially_approved">Partially approved</option>
                            <option value="rejected">Rejected</option>
                        </select>
                    </div> -->
                    @endif

                    <div class="col-sm-3">
                        <div>
                            <button type="submit" class="btn btn-primary">filter</button>
                            <button name="clear" type="input" value="true" class="btn btn-primary">clear</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>


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
                            @if($logged_in_user->hasAllAccess() || $logged_in_user->can('admin.access.rcns.transfer_invoice'))
                                <a class="dropdown-item"
                                    href="{{ route('admin.transactions.transfer_invoice', $recovery_invoice->invoice->id) }}">
                                    Transfer Invoice
                                </a>
                            @endif
                        </div>
                    </div>
                </td>
                <td>{{ Carbon\Carbon::parse(@$recovery_invoice->invoice->created_at)->format('d/m/Y')}}</td>
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
                <td>
                        @foreach(@$recovery_invoice->invoice->rcns as $rcn)
                            {{ @$rcn->department->name }} <br/>
                        @endforeach
                </td>
                <td>
                    @php $level = @$recovery_invoice->level @endphp
                    {{ App\Models\ApprovalLevel::APPROVAL_WEIGHTS[@$level] }}

                </td>
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
        <div>
            {{ $recovery_invoices->links() }}
        </div>
    </x-slot>
</x-backend.card>
@endsection