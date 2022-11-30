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
        @lang('Edit invoice')
    </x-slot>

    <x-slot name="body">
        <div class="container">

            <div class=" mt-4">
                <div class="row mb-4">
                    <!-- <div class="col-sm-4 col-md-6">
                        <h4 class="mb-2">Search and add in RCN(s) to invoice</h4>

                        <div>
                            Note: (You can attach more than one RCN when creating an invoice)
                        </div>

                        <form class="ml-1" action="{{ route('admin.transactions.attach-invoice') }}" method="get"
                            novalidate="novalidate">
                            @csrf()

                            <input type="hidden" name="rcns" value="{{ request('rcns')}}" />

                            <div class="col-8 mt-4">
                                <div>
                                    <input type="text" name="rcn_no" class="form-control search-slt"
                                        placeholder="Search for rcn">
                                </div>
                            </div>

                            <div class="row ml-2 mt-4">
                                <div class="col-lg-3 col-md-3 col-sm-12 p-0">
                                    <button type="submit" class="btn btn-primary wrn-btn">add</button>
                                </div>
                            </div>
                        </form>
                    </div> -->
                    <div class="col-sm-4 solmd-4 mt-4">
                    <h4 class="mb-2 ml-3">RCN's attached to the invoice.</h4>
                        <ol>
                            @foreach($invoice->rcns as $rcn)
                                <li>{{$rcn->rcn_no}}  <button type=" submit"
                                        style="color: red;border: none;border-radius: 50%;margin-left: 20px;">x</button></li>                            
                            @endforeach
                        </ol>
                    </div>

                    <div class="col-sm-4 col-md-4 ml-4">
                        @if(request("rcns"))
                        <div class="mt-4">
                            @php $rcns = explode(",", request("rcns")) @endphp

                            @foreach ($rcns as $rcn)
                            @php $rcn_arr = explode(':', $rcn) @endphp
                            <div class="mb-2">
                                <form class="ml-1" action="{{ route('admin.transactions.attach-invoice') }}">
                                    <input name="clear" type="hidden" />
                                    <input name="rcns" value="{{ request('rcns')}}" type="hidden" />
                                    <input name="rcn_no" value="{{ $rcn }}" type="hidden" />

                                    <span class="">{{ $rcn_arr[0] }}</span>
                                    <button type=" submit"
                                        style="color: red;border: none;border-radius: 50%;margin-left: 20px;">x</button>
                                </form>
                            </div>
                            @endforeach
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- <hr /> -->

            <div class="col-sm-12 col-md-8">
                <form action="{{ route('admin.transactions.update-invoice', $invoice->id) }}" method="post" novalidate="novalidate">
                    @csrf()

                    <input type="hidden" name="rcns" value="{{ request('rcns')}}" />

                    <div class="row">
                        <div class="col-lg-5">
                            <label for="exampleFormControlInput1" class="form-label">Invoice amount (Exc. VAT)</label>
                            <input type="text" name="invoice_amount" value="{{@$invoice->invoice_amount}}" class="form-control search-slt"
                                placeholder="Invoice amount">
                        </div>

                        <div class="col-lg-5">
                            <label for="exampleFormControlInput1" class="form-label">Currency</label>
                            @include('backend.trx.currencies_partial')
                        </div>

                        <div class="col-lg-5 mt-4">
                            <label for="exampleFormControlInput1" class="form-label">Invoice number</label>
                            <input type="text" name="invoice_number" value="{{@$invoice->invoice_number}}" class="form-control search-slt"
                                placeholder="Invoice number">
                        </div>

                        <div class="col-lg-5 mt-4">
                            <label for="date">Invoice date </label>
                            <div class="datepicker input-group date" data-date-format="mm-dd-yyyy">
                                <input class="form-control" type="text" name="invoice_date" value="{{@$invoice->invoice_date}}" readonly />
                                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                            </div>
                        </div>
                        <div class="col-lg-5 mt-4">
                            <label for="creditNote" class="form-label">Credit Note</label>
                            <input type="text" name="credit_note" class="form-control search-slt" value="{{@$invoice->credit_note}}"
                                placeholder="Credit note">
                        </div>
                        <div class="col-lg-5 mt-4">
                            <label for="creditNoteAmount" class="form-label">Credit Note Amount</label>
                            <input type="number" name="credit_note_amount" class="form-control search-slt" value="{{@$invoice->credit_note_amount}}"
                                placeholder="Credit note amount">
                        </div>

                        <div class="col-lg-5 mt-4">
                            <div class="mb-3">
                                <label for="delivery_note" class="form-label">Delivery Note</label>
                                <textarea class="form-control"
                                    name="delivery_note">{{@$invoice->delivery_note}}</textarea>
                            </div>
                        </div>

                        <div class="col-lg-5 mt-4">
                            <label for="date">Delivery note date </label>
                            <div class="datepicker input-group date" data-date-format="mm-dd-yyyy">
                                <input class="form-control" type="text" name="dnote_date" value="{{@$invoice->dnote_date}}" readonly />
                                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                            </div>
                        </div>

                        <div class="col-lg-5 mt-4">
                            <label for="exampleFormControlInput1" class="form-label">Tracking number</label>
                            <input type="text" name="tracking_number" value="{{@$invoice->tracking_no}}" class="form-control search-slt"
                                placeholder="Tracking number">
                        </div>

                        <div class="col-lg-5 mt-3">
                            <label for="date">Tracking Date </label>
                            <div class="datepicker input-group date" data-date-format="mm-dd-yyyy">
                                <input class="form-control" type="text" name="tracking_date" value="{{@$invoice->tracking_date}}" readonly />
                                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                            </div>
                        </div>

                        <div class="col-lg-5 mt-4">
                            <label for="exampleFormControlInput1" class="form-label">File number</label>
                            <input type="text" name="file_number" value="{{@$invoice->file_number}}" class="form-control search-slt"
                                placeholder="File number">
                        </div>

                        <div class="col-lg-8 mt-3">
                            <div class="mb-3">
                                <label for="comments" class="form-label">Comments</label>
                                <textarea class="form-control" value="{{@$invoice->comments}}" name="comments"></textarea>
                            </div>
                        </div>
                        
                        <!-- @if(@$invoice->recoveryInvoice)
                        <div class="col-lg-8 mt-4">
                            <input type="checkbox" name="resend" value="resend" id="resend" required class="form-check-inpu"> Resend for Approval? <i>({{@$invoice->recoveryInvoice->approvalLogs->last()->user->name}})</i>
                        </div>
                        @endif -->
                        
                        @if(@$invoice->recoveryInvoice->approvalLogs)
                            <div class="col-lg-8 mt-4">
                                <div class="alert alert-danger">
                                <p>This resource is currently under approval process. Any edits, the document will be resent to <i><strong>{{App\Models\ApprovalLevel::APPROVAL_WEIGHTS[0]}} </strong></i> and begin reapproval. </p>
                                </div>
                            </div>
                        @endif
                        <div class="col-lg-8 mt-4">
                            <button type="submit" class="btn btn-primary wrn-btn">Update Invoice</button>
                        </div>
                    @if(@$invoice->recoveryInvoice->approvalLogs)
                        @php $code = @$invoice->recoveryInvoice->approvalLogs->last()->reason->id; @endphp
                        @if($code == 2 || $code == 4)
                            <div class="col-lg-4 mt-4">
                                <a href="{{route('admin.transactions.discard_invoice', $invoice->id)}}" class="btn btn-info wrn-btn">Discard & Reattach RCN's</a>
                            </div>
                        @endif
                    @endif

                       
                    </div>

                </form>
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