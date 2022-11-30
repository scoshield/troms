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

            <div class=" mt-1">
                <div class="row mb-4">                    
                    <div class="col-sm-4 solmd-4 mt-1">
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
                        <div class="mt-1">
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


                    <div class="row">
                        <div class="col-lg-10">
                            <label for="exampleFormControlInput1" class="form-label">Invoice amount (Exc. VAT): <strong>{{$invoice->currency->symbol}} {{number_format(@$invoice->invoice_amount, 2)}}</strong></label>
                            
                        </div>

                        <div class="col-lg-10">
                            <label for="exampleFormControlInput1" class="form-label">Currency: {{$invoice->currency->name}}</label>
                        </div>

                        <div class="col-lg-10 mt-1">
                            <label for="exampleFormControlInput1" class="form-label">Invoice number: <strong>{{@$invoice->invoice_number}}</strong></label>
                            
                        </div>

                        <div class="col-lg-10 mt-1">
                            <label for="date">Invoice date: <strong>{{@$invoice->invoice_date}}</strong> </label>
                            
                        </div>
                        <div class="col-lg-10 mt-1">
                            <label for="creditNote" class="form-label">Credit Note: <strong>{{@$invoice->credit_note}}</strong></label>
                            
                        </div>
                        <div class="col-lg-10 mt-1">
                            <label for="creditNoteAmount" class="form-label">Credit Note Amount: <strong>{{$invoice->currency->symbol}} {{number_format(@$invoice->credit_note_amount, 2)}}</strong></label>
                           
                        </div>

                        <div class="col-lg-10 mt-1">
                            <div class="">
                                <label for="delivery_note" class="form-label">Delivery Note: <strong>{{@$invoice->delivery_note}}</strong></label>
                                
                            </div>
                        </div>

                        <div class="col-lg-10 mt-1">
                            <label for="date">Delivery note date: <strong>{{@$invoice->dnote_date}}</strong> </label>
                            
                        </div>

                        <div class="col-lg-10 mt-1">
                            <label for="exampleFormControlInput1" class="form-label">Tracking number: <strong>{{@$invoice->tracking_no}}</strong></label>
                            
                        </div>

                        <div class="col-lg-10 mt-1">
                            <label for="date">Tracking Date: <strong>{{@$invoice->tracking_date}}</strong> </label>
                            
                        </div>

                        <div class="col-lg-10 mt-1">
                            <label for="exampleFormControlInput1" class="form-label">File number: <strong>{{@$invoice->file_number}}</strong></label>
                            
                        </div>

                        <div class="col-lg-8 mt-3">
                            <div class="mb-3">
                                <label for="comments" class="form-label">Comments: <strong>{{@$invoice->comments}}</strong></label>
                               
                            </div>
                        </div>                        
                        
                        <div class="col-lg-9 mt-1">
                            <div class="alert alert-info">
                            @if($invoice->status == 'pending') <span class="badge badge-info">Pending</span>@elseif($invoice->status == 'approved') <span class="badge badge-success">Approved</span>@else <span class="badge badge-danger">Rejected</span>@endif
                            </div>
                        </div>
                        @if($logged_in_user->can('admin.access.rcns.edit_invoice'))
                            <div class="col-lg-4 mt-1">
                                <a  href="{{ route('admin.transactions.edit_invoice', $invoice->id) }}" class="btn btn-primary wrn-btn">Edit Invoice</a>
                            </div>
                        @endif
                        @if($logged_in_user->can('admin.access.rcns.invoice_reject'))
                            @if($invoice->status != 'rejected')
                                <div class="col-lg-4 mt-1">
                                    <a  href="{{ route('admin.transactions.invoice_reject', $invoice->id) }}" class="btn btn-danger wrn-btn">Reject Invoice</a>
                                </div>
                            @else
                                <div class="col-lg-4 mt-1">
                                    <button  href="#" class="btn btn-danger wrn-btn" disabled>Rejected</button>
                                </div>
                            @endif
                        @endif
                        @if(@$invoice->recoveryInvoice->approvalLogs)
                            @php $code = @$invoice->recoveryInvoice->approvalLogs->last()->reason->id; @endphp
                            @if($code == 2 || $code == 4)
                                <div class="col-lg-4 mt-1">
                                    <a href="{{route('admin.transactions.discard_invoice', $invoice->id)}}" class="btn btn-info wrn-btn">Discard & Reattach RCN's</a>
                                </div>
                            @endif
                        @endif

                       
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