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
        @lang('Transfer invoice')
    </x-slot>

    <x-slot name="body">
        <div class="container">

            <!-- <div class=" mt-4">
                <div class="row mb-4">
                    <div class="col-sm-4 col-md-6">
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
            </div> -->

            <!-- <hr /> -->

            <div class="col-sm-12 col-md-8">
                <form action="{{ route('admin.transactions.post-invoice-transfer', $invoice->id) }}" method="post" novalidate="novalidate">
                    @csrf()

                    <input type="hidden" name="rcns" value="{{ request('rcns')}}" />

                    <div class="row">
                        <div class="col-lg-8 alert alert-info">
                            <label for="exampleFormControlInput1" class="form-label">The following invoice(s) will be transferred:-                        </label>                            
                            <table class="table table-borderless table-sm">
                                <thead>
                                    <tr>
                                        <th>Number</th>
                                        <th>Amount</th>
                                        <th>File #</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{{$invoice->invoice_number}}</td>
                                        <td>{{number_format($invoice->invoice_amount, 2)}}</td>
                                        <td>{{$invoice->file_number}}</td>
                                    </tr>
                                </tbody>
                            </table>
                           
                        </div>

                        <div class="col-lg-8 alert alert-danger">
                            @if($invoice->rcns)
                            <label for="exampleFormControlInput1" class="form-label">The following RCN(s) are attached to the invoice:-<br/>
                                <?php $count = 1; ?>
                                @foreach($invoice->rcns as $rcn)                                
                                    {{$count++}}. <strong>{{$rcn->rcn_no}}</strong> PO No. <strong>{{$rcn->purchase_order_no}}</strong> <br/>
                                @endforeach
                            </label>  
                            @else
                            <label for="exampleFormControlInput1" class="form-label">No RCN attached to this invoice.<br/>
                            @endif
                        </div>

                        <div class="col-lg-8 mt-3">
                            <label for="exampleFormControlInput1" class="form-label">Select User</label>
                            <select name="to_user_id" class="form-control">
                                <option value="">Select</option>
                                @foreach (App\Domains\Auth\Models\User::all() as $user)
                                <option value="{{ $user->id }}" {{ old("to_user_id")==$user->id
                                ? "selected" : ""}}>{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>   
                        
                        <div class="col-lg-8 mt-3">
                            <label for="exampleFormControlInput1" class="form-label">Department</label>
                            <select name="department_code" class="form-control">
                                <option value="">Select</option>
                                @foreach (App\Models\Department::all() as $dept)
                                <option value="{{ $dept->code }}" {{ old("department_code")==$dept->id
                                ? "selected" : ""}}>{{ $dept->name }} - {{$dept->code}} </option>
                                @endforeach
                            </select>
                        </div> 
                        <div class="col-lg-8 mt-3">
                            <div class="mb-3">
                                <label for="comments" class="form-label">Reason | Comments</label>
                                <textarea class="form-control"  value="{{ old('comments') }}" name="comments">{{ old('comments') }}</textarea>
                            </div>
                        </div>

                        @if(count($invoice->transfers) > 0 && $invoice->transfers->last()->to_user_id != $logged_in_user->id)
                            <div class="col-lg-8 mt-3 alert alert-danger">
                                <label for="" class="form-label">
                                    This invoice has been transferred from <strong>{{@$invoice->transfers->last()->sender->name}}</strong> to <strong>{{@$invoice->transfers->last()->recipient->name}}</strong>. with comments
                                    
                                    <span style="text-decoration: underline">{{@$invoice->transfers->last()->comments}}</span>                                 
                                    For further transfer, <strong>request the user to transfer it back.</strong>
                                </label>
                            </div>
                        @else
                            <div class="col-lg-8 mt-4">
                                <button type="submit" class="btn btn-primary wrn-btn">Transfer Invoice</button>
                            </div>
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