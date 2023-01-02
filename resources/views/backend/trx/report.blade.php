@extends('backend.layouts.app')

@section('title', __('Invoice Reports'))

@push('after-styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css"
    integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.css" rel="stylesheet"
    type="text/css" />
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@section('breadcrumb-links')
{{-- @include('backend.auth.user.includes.breadcrumb-links')--}}
@endsection

@section('content')
<x-backend.card>
    <x-slot name="header">
        @lang('REPORT: FULLY APPROVED INVOICES')
    </x-slot>

    <x-slot name="headerActions">
            @if ($logged_in_user->can('admin.access.rcns.reports'))
                <x-utils.link icon="c-icon cil-plus" class="card-header-action" href="{{ url('admin/transactions/report?download=1') }}"
                    :text="__('Export')" />
            @endif

            <div class="modal fade" id="approveModal" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Invoice Final Processing Dialog</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">                           
                            <form method="POST"
                                action="{{ route('admin.transactions.approve-recovery-invoice', 1)}}">
                                @csrf()                                

                                <div class="form-group mt-4">
                                    <label for="date">Invoice Payment Date </label>
                                    <div class="datepicker input-group date" data-date-format="mm-dd-yyyy">
                                        <input class="form-control" type="text" name="invoice_date" value="{{ old('invoice_date') }}" readonly />
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-form-label">Comments:</label>
                                    <textarea class="form-control" name="date"></textarea>
                                </div>
                                <!-- <button type="submit" name="type" value="approve" class="btn btn-primary">FINALIZE</button>                                 -->
                            </form>
                        </div>
                    </div>
                </div>
            </div>
    </x-slot>

    <x-slot name="body">

        <div>
            <form action="{{ route('admin.transactions.report')}}" method="GET">
                @csrf
                <div class="row">
                    <div class="col-sm-3">
                        <div class="mb-3">
                            <input class="form-control" type="text" name="search"
                                placeholder="Search by: rcn no, shipper, carrier, tracking no">
                        </div>
                    </div>                  
                    <div class="col-sm-3">
                        <div>
                            <button type="submit" class="btn btn-primary">filter</button>
                            <button name="clear" type="input" value="true" class="btn btn-primary">clear</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="row">
            <div class="col-md-12">
                
                <table class="table table-hover table-striped table-sm">
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
                        <th>Age.(Days)</th>
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
                        <td>@foreach($trx->rcns as $rcn)
                                <span>{{@$rcn->department->name}}</span> <br/>
                            @endforeach</td>
                        <td>
                            <span style="font-weight: 500">{{ \Carbon\Carbon::parse(@$trx->recoveryInvoice->approvalLogs->last()->created_at)->format('d/m/Y') }}</span>
                        </td>
                        <td>{{ \Carbon\Carbon::parse($trx->created_at)->diffInDays(@$trx->recoveryInvoice->approvalLogs->last()->created_at) }}</td>
                        <td>
                            <a href="#" class="" style="text-transform: uppercase">&#9745</a>                 

                        </td>
                        <td>
                            <a href="{{ route('admin.recovery_invoice.print', $trx->recoveryInvoice->id)}}">
                            &#9851
                        </a>/ 
                        <a href="#" data-toggle="modal"
                            data-target="#approveModal">&#9931</a>
                    
                        </td>
                    </tr>
                    @endforeach
                </table>

            </div>
        </div>
        <div>
            {{ $transactions->links() }}
        </div>
        
    </x-slot>
</x-backend.card>
@endsection

@push("after-scripts")
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
    $('.').select2();
    });

    $(function () {
      $(".datepicker").datepicker({ 
            autoclose: true, 
            todayHighlight: true
      }).datepicker('update', new Date());
    });
</script>
<script>

</script>
@endpush