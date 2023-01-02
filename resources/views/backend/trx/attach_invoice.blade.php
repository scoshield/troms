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
        @lang('Add invoice') 
    </x-slot>
    <x-slot name="body">
        <div class="container">

            <div class=" mt-4">
                <div class="row mb-4">
                    <div class="col-sm-4 col-md-6">
                        <h4 class="mb-2">Search and add in RCN(s) to invoice</h4>

                        <div>
                            Note: (You can attach more than one RCN when creating an invoice) 
                            <!-- The invoices can be attached more than one. -->
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

            <hr />

            <form action="{{ route('admin.transactions.save-invoice', 1) }}" method="post" novalidate="novalidate">
                @csrf()
                <div class="row">
                <div class="col-sm-8 col-md-8">

                    <input type="hidden" name="rcns" value="{{ request('rcns')}}" />

                    <div class="row">
                        <div class="col-lg-5">
                            <label for="exampleFormControlInput1" class="form-label">Invoice amount (Exc. VAT)</label>
                            <input type="text" name="invoice_amount" class="form-control search-slt"
                                placeholder="Invoice amount" value="{{ old('invoice_amount') }}">
                        </div>

                        <div class="col-lg-5">
                            <label for="exampleFormControlInput1" class="form-label">Currency</label>
                            <select name="currency" class="form-control">
                            @foreach (App\Models\Currency::all() as $currency)
                                <option value="{{ $currency->id }}" @if($currency->name == 'KES') selected @endif @if(old('currency') == $currency->id) selected @endif)>{{ $currency->name }}</option>
                            @endforeach
                            </select>
                        </div>

                        <div class="col-lg-5 mt-4">
                            <label for="exampleFormControlInput1" class="form-label">Invoice number</label>
                            <input type="text" name="invoice_number" value="{{ old('invoice_number') }}" class="form-control search-slt"
                                placeholder="Invoice number">
                        </div>

                        <div class="col-lg-5 mt-4">
                            <label for="date">Invoice date </label>
                            <div class="datepicker input-group date" data-date-format="mm-dd-yyyy">
                                <input class="form-control" type="text" name="invoice_date" value="{{ old('invoice_date') }}" readonly />
                                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                            </div>
                        </div>
                        <div class="col-lg-5 mt-4">
                            <label for="creditNote" class="form-label">Credit Note</label>
                            <input type="text" name="credit_note" value="{{ old('credit_note') }}" class="form-control search-slt"
                                placeholder="Credit note">
                        </div>
                        <div class="col-lg-5 mt-4">
                            <label for="creditNoteAmount" class="form-label">Credit Note Amount</label>
                            <input type="number" name="credit_note_amount" value="{{ old('credit_note_amount') ? old('credit_note_amount') : number_format(0, 2) }}" class="form-control search-slt"
                                placeholder="Credit note amount">
                        </div>

                        <div class="col-lg-5 mt-4">
                            <div class="mb-3">
                                <label for="delivery_note" class="form-label">Delivery Note</label>
                                <textarea class="form-control" value="{{ old('delivery_note') }}"
                                    name="delivery_note"></textarea>
                            </div>
                        </div>

                        <div class="col-lg-5 mt-4">
                            <label for="date">Delivery note date </label>
                            <div class="datepicker input-group date" data-date-format="mm-dd-yyyy">
                                <input class="form-control" type="text" name="dnote_date" value="{{ old('dnote_date') }}" readonly />
                                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                            </div>
                        </div>

                        <div class="col-lg-5 mt-4">
                            <label for="exampleFormControlInput1" class="form-label">Tracking number</label>
                            <input type="text" name="tracking_number" value="{{ old('tracking_number') }}" class="form-control search-slt"
                                placeholder="Tracking number">
                        </div>

                        <div class="col-lg-5 mt-3">
                            <label for="date">Tracking Date </label>
                            <div class="datepicker input-group date" data-date-format="mm-dd-yyyy">
                                <input class="form-control" type="text" name="tracking_date" value="{{ old('tracking_date') }}" readonly />
                                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                            </div>
                        </div>

                        <div class="col-lg-5 mt-4">
                            <label for="exampleFormControlInput1" class="form-label">File number</label>
                            <input type="text" name="file_number" value="{{ old('file_number') }}" class="form-control search-slt"
                                placeholder="File number">
                        </div>                       

                        <div class="col-lg-10 mt-3">
                            <div class="mb-3">
                                <label for="comments" class="form-label">Comments</label>
                                <textarea class="form-control" value="{{ old('comments') }}" name="comments"></textarea>
                            </div>
                        </div>

                        <div class="col-lg-8 mt-4">
                            <button type="submit" class="btn btn-primary wrn-btn">Add invoice</button>
                        </div>
                    </div>

                </div>
                
                @if(request("status"))
                <div class="col-sm-4 mt-4 alert alert-warning">
                    <label for="exampleFormControlInput1" class="form-label">Transporter</label>
                    <select name="transporter" class="form-control search-slt">
                        <option value="" selected>Select Transporter</option>
                        @foreach(App\Models\Carrier::orderBy('transporter_name', 'asc')->get() as $trx)
                            <option value="{{$trx->id}}">{{$trx->transporter_name}}</option>
                        @endforeach
                    </select>
                        <!-- placeholder="Transporter Name"> -->
                </div>

                @endif
                </div>
            </form>
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