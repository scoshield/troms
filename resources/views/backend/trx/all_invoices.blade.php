@extends('backend.layouts.app')

@section('title', __('Invoices'))

@section('breadcrumb-links')
{{-- @include('backend.auth.user.includes.breadcrumb-links')--}}
@endsection

@section('content')
<x-backend.card>
    <x-slot name="header">
        @lang('Invoices')
    </x-slot>

    <x-slot name="headerActions">
        <x-utils.link icon="c-icon cil-plus" class="card-header-action" href="{{request()->fullUrlWithQuery(['download'=>1])}}"
            :text="__('Export')" />
    </x-slot>

    <x-slot name="body">
        <div>
            <form action="{{ route('admin.transactions.invoices-report')}}" method="GET">
                @csrf
                <div class="row">
                    <div class="col-sm-3">
                        <div class="mb-3">
                            <input class="form-control" type="text" name="search"
                                placeholder="Search by:  invoice_number, tracking no">
                        </div>
                    </div>

                    <div class="col-sm-3">
                        <select class=" js-states form-control" name="status">
                            <option value="Select">Filter by status</option>
                            <option value="0">Pending</option>
                            <option value="1">Recovery Invoice Attached</option>                          
                        </select>
                    </div>

                    <div class="col-sm-3">
                        <div>
                            <button type="submit" class="btn btn-primary">filter</button>
                            <button name="clear" type="input" value="true" class="btn btn-primary">clear</button>
                        </div>
                    </div>

                    <div class="col-sm-2">
                        <select class="js-states form-control" onchange="window.location = this.options[this.selectedIndex].value" name="limit">
                            <option value="{{request()->fullUrlWithQuery(['limit'=>20])}}">20</option>
                            <option value="{{request()->fullUrlWithQuery(['limit'=>100])}}">100</option>
                            <option value="{{request()->fullUrlWithQuery(['limit'=>250])}}">250</option>                          
                            <option value="{{request()->fullUrlWithQuery(['limit'=>500])}}">500</option>                          
                            <option value="{{request()->fullUrlWithQuery(['limit'=>1000])}}">All</option>                          
                        </select>
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
            @foreach($invoices as $invoice)
            <tr @if($invoice->level == @auth()->user()->approvalLevel->weight && $invoice->status != 'approved') style="background-color: #00ff3233;" @endif>
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
                        @if($invoice->recoveryInvoice)
                            <a class="dropdown-item"
                                href="{{ route('admin.rcns.recovery-invoices.view', $invoice->recoveryInvoice->id )}}">Record Trail
                            </a> 
                        @else
    
                        @endif
                        </div>
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
                    @php $level = @$invoice->recoveryInvoice->level @endphp
                    @if($level)
                        {{ App\Models\ApprovalLevel::APPROVAL_WEIGHTS[@$level] }}
                    @else
                        Clerk
                    @endif

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
        <div>
            {{ $invoices->withQueryString()->links() }}
        </div>
    </x-slot>
</x-backend.card>
@endsection