@extends('backend.layouts.app')

@section('title', __('Upload/Manage RCNs'))

@section('breadcrumb-links')
{{-- @include('backend.auth.user.includes.breadcrumb-links')--}}
@endsection

@push("after-styles")
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.css" rel="stylesheet"
    type="text/css" />
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush
@section('content') <x-backend.card>
    <x-slot name="header">
        <span style="background: rgb(121, 44, 44); color: white; padding: 5px">@lang('Update Recovery invoice')</span>
    </x-slot>

    <x-slot name="body">
        <div class="container">

            <div class="row mt-4">
                <div class="col-sm-12 col-md-6">
                    <form action="{{ route('admin.invoices.attach_recovery_invoice', $invoice->id) }}" method="post"
                        novalidate="novalidate" id="invoice-form">
                        @csrf()

                        <div class="col-lg-8">
                            <label for=" exampleFormControlInput1" class="form-label">Currency</label>
                            @include('backend.trx.currencies_partial')
                        </div>

                        <div class="col-lg-8 mt-4">
                            <label for="exampleFormControlInput1" class="form-label">Recovery invoice amount</label>
                            <input type="text" name="invoice_amount" class="form-control search-slt"
                                placeholder="Invoice amount">
                        </div>

                        <div class="col-lg-8 mt-4">
                            <label for="exampleFormControlInput1" class="form-label">Recovery invoice number</label>
                            <input type="text" name="invoice_number" class="form-control search-slt"
                                placeholder="Invoice number">
                        </div>

                        <div class="col-lg-8 mt-4">
                            <label for="date">Invoice date </label>
                            <div class="datepicker input-group date" data-date-format="mm-dd-yyyy">
                                <input class="form-control" type="text" name="invoice_date" readonly />
                                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                            </div>
                        </div>
                        <div class="col-lg-8 mt-4">
                            <input type="checkbox" name="pod_available" value="1" id="rcns" class="form-check-inpu"> POD available in edoc file
                        </div>
                        <div class="col-lg-8 mt-4">
                            <input type="radio" name="ein_available" value="1" id="rcns" class="form-check-inpu"> EIR available in edoc file
                        </div>
                        <div class="col-lg-8 mt-4">
                            <input type="radio" name="ein_available" value="0" id="rcns" class="form-check-inpu"> EIR N/A
                        </div>
                        <div class="col-lg-8 mt-4">
                            <div class="mb-3">
                                <label for="comments" class="form-label">Comments</label>
                                <textarea class="form-control" value="{{ old('comments') }}" name="comments"></textarea>
                            </div>
                        </div>
                        <input type="hidden" name="type" id="type"  />                        
                    </form>

                    <div class="row">
                        @if($invoice->recoveryInvoice && $invoice->recoveryInvoice->invoice_number != 0)
                        <div class="col-lg-6 mt-4 alert alert-danger">
                            <p class="text-center">The recovery invoice is already attached. To update, request <strong><i>{{$invoice->recoveryInvoice->approvalLogs->last()->user->name}} </i></strong> to send it back for editing.</p>
                        </div>
                        @else
                        <div class="col-lg-6 mt-4">
                            <button type="submit" name="type" value="submit" class="btn btn-primary wrn-btn" onclick="event.preventDefault(); document.getElementById('type').value='submit'; document.getElementById('invoice-form').submit();">Update Recovery Invoice</button>
                        </div>
                        @endif

                        @if($logged_in_user->can('admin.access.rcns.invoice_reject'))
                            @if($invoice->status != 'rejected')
                                <div class="col-lg-4 mt-4">
                                    <button type="submit" name="type" value="reject" class="btn btn-danger wrn-btn" onclick="event.preventDefault(); document.getElementById('type').value='reject'; document.getElementById('invoice-form').submit();">Reject Invoice</button>
                                    <!-- <input type="submit" name="type" value="Reject Invoices" class="btn btn-danger wrn-btn" /> -->
                                    <!-- <a  href="{{ route('admin.transactions.invoice_reject', $invoice->id) }}" class="btn btn-danger wrn-btn">Reject Invoice</a> -->
                                </div>
                            @else
                                <div class="col-lg-4 mt-4">
                                    <button  href="#" class="btn btn-danger wrn-btn" disabled>Rejected</button>
                                </div>
                            @endif
                        @endif
                        </div>
                </div>
                <div class="col-sm-12 col-md-6">
                    <h4 class="mb-2 font-weight-bold">Invoice Details</h4>

                    <div class="row mt-4">
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-sm-12 col-md-6">
                                    <span class="font-weight-bold">Number:</span>
                                    <span>:</span>
                                    <span>{{ $invoice->invoice_number }}</span>
                                </div>

                                <div class="col-sm-12 col-md-6">
                                    <span class="font-weight-bold">Amount:</span>
                                    <span>:</span>
                                    <span>{{ @$invoice->currency->symbol . " " . number_format($invoice->invoice_amount)
                                        }}</span>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12 col-md-6">
                                    <span class="font-weight-bold">Date:</span>
                                    <span>:</span>
                                    <span>{{ $invoice->created_at->format("d/m/y")}}</span>
                                </div>

                                <div class="col-sm-12 col-md-6">
                                    <span class="font-weight-bold">User: </span>
                                    <span>:</span>
                                    <span>{{ @$invoice->user->name }}</span>
                                </div>
                            </div>
                                        <hr/>
                            @if(@$invoice->credit_note_amount)
                            <div class="row">
                                <div class="col-sm-12 col-md-6">
                                    <span class="font-weight-bold">Credit Note</span>
                                    <span>:</span>
                                    <span>{{ $invoice->credit_note}}</span>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <span class="font-weight-bold">Amount</span>
                                    <span>:</span>
                                    <span>{{ $invoice->credit_note_amount}}</span>
                                </div>
                            </div>
                            <hr/>
                            @endif

                            <div>
                                <h6 class="mb-2 font-weight-bold">RCN(s)</h6>

                                @foreach ($invoice->rcns as $rcn)
                                <div>
                                    <span class="">{{ $rcn->rcn_no }}</span> :
                                    @if($rcn->amount)
                                        <span class="font-weight-bold">{{ number_format($rcn->amount , 2)  }}</span>
                                    @endif
                                    <span>
                                        @if($rcn->status == App\Models\Transaction::$PENDING)
                                            <a href="#" class="badge badge-info">Pending</a>
                                        @elseif($rcn->status == App\Models\Transaction::$AMOUNT_NOT_EQUAL)
                                            <a href="#" class="badge badge-danger">Invoice mismatch</a>
                                        @elseif($rcn->status == App\Models\Transaction::$INVOICE_MATCHED)
                                            <a href="#" class="badge badge-success">Invoice matched</a>
                                        @elseif($rcn->status == App\Models\Transaction::$INVOICE_ATTACHED)
                                            <a href="#" class="badge badge-primary">Invoice attached</a>
                                        @elseif($rcn->status == App\Models\Transaction::$APPROVED)
                                            <a href="#" class="badge badge-primary">Approved</a>
                                        @elseif($rcn->status == App\Models\Transaction::$PARTIALLY_APPROVED)
                                            <a href="#" class="badge badge-primary">Partially Approved</a>
                                        @endif
                                    </span>                                    
                                </div>
                                @endforeach
                                <div>
                                <h6 class="mt-4 mb-2"><strong>File Number:</strong>  <span>{{@$invoice->file_number}}</span> </h6>
                                </div>
                            </div>

                            <div class="mt-4">
                                <h6 class="mb-2 font-weight-bold">Comments</h6>

                                <div>
                                    {{ $invoice->comments}}
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
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