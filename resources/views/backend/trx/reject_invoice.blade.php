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
        @lang('Reject Invoice')
    </x-slot>
    <x-slot name="body">
        <div class="container">     
            <div class="col-sm-12 col-md-8">
                <form action="{{ route('admin.transactions.approve-recovery-invoice', $invoice->id) }}" method="post" novalidate="novalidate">
                    @csrf()

                    <input type="hidden" name="type" value="reject" />

                    <div class="row">                       

                        <div class="col-lg-5">
                            <label for="exampleFormControlInput1" class="form-label">Reason Code</label>
                            <select class="form-control" name="reason_code" id="reason_code">
                                <option value="" disabled selected>Select</option>
                                @foreach (App\Models\ReasonCode::all() as $key)
                                    <option value="{{ $key->id }}"> {{ $key->code }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <!-- <div class="row">
                        <div class="col-lg-5 mt-4">
                            <input type="checkbox" name="edit_fields[]" value="1" id="rcns" class="form-check-inpu"> Update RCN Details
                        </div>
                    </div>  
                    <div class="row">
                        <div class="col-lg-5 mt-4">
                            <input type="checkbox" name="edit_fields[]" value="2" id="rcns" class="form-check-inpu"> Update Invoice
                        </div>
                    </div>  
                    <div class="row">
                        <div class="col-lg-5 mt-4">
                            <input type="checkbox" name="edit_fields[]" value="3" id="rcns" class="form-check-inpu"> Update Recovery Invoice
                        </div>
                    </div> -->
                    <div class="row">
                        <div class="col-lg-5 mt-4">
                            <input type="checkbox" name="status" value="cancelled" id="rcns" class="form-check-inpu"> Cancel Invoice
                        </div>
                    </div>   
                    <div class="row">                        
                        <div class="col-lg-5 mt-4">
                            <div class="mb-3">
                                <label for="comments" class="form-label">Comments</label>
                                <textarea class="form-control"
                                    name="comments"></textarea>
                            </div>
                        </div>                                         
                    </div>
                    <div class="row">
                        <div class="col-lg-8 mt-4">
                            <button type="submit" name="type" value="reject"  class="btn btn-danger wrn-btn">Submit</button>
                        </div>
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